<?php
use SaltedHerring\Utilities as Utilities;
use SaltedHerring\Debugger;
class Page extends SiteTree
{
	// private static $db = array(
	// 	'UseTemplate'		=>	'Varchar(255)'
	// );

    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'HideTitle'         =>  'Boolean'
    );

    private static $extensions = array(
        'BlockinPage'
    );

	private static $has_one = array(
        'RedirectTo'        =>  'Page'
	);

	// public function getCMSFields() {
	// 	$fields = parent::getCMSFields();
	// 	$fields->addFieldToTab(
	// 		'Root.Main',
	// 		DropdownField::create(
	// 			'UseTemplate',
	// 			'Template',
	// 			TemplateChooser::get_templates()
	// 		)->setEmptyString('- default -')
	// 	);
	// 	return $fields;
	// }

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        if (!$fields->fieldByName('Options')) {
			$fields->insertBefore(RightSidebar::create('Options'), 'Root');
	    }
        $fields->addFieldToTab(
            'Options',
            DropdownField::create(
                'RedirectToID',
                'Redirect to page',
                Page::get()->sort(array('Title' => 'ASC'))->map('ID', 'Title')
            )->setEmptyString('- no redirectoin -')
        );

        if (!empty($this->RedirectToID)) {
            $fields->removeByName('Content');
        }

        return $fields;
    }

}

class Page_Controller extends ContentController
{
    protected static $extensions = array(
		'SiteJSControllerExtension',
        'PrintBlocks'
	);

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array ();

	public function init() {
		parent::init();

        if (!empty($this->RedirectToID)) {
            $target = SiteTree::get()->byID($this->RedirectToID);
            if (!empty($target)) {
                $to = $target->Link();
                if (!empty($to)) {
                    $this->redirect($to, 301);
                }
            }
        }


		$this->initJS();
		// Note: you should use SS template require tags inside your templates
		// instead of putting Requirements calls here.  However these are
		// included so that our older themes still work
		/*
Requirements::themedCSS('reset');
		Requirements::themedCSS('layout');
		Requirements::themedCSS('typography');
		Requirements::themedCSS('form');
*/
	}

	protected function getSessionID() {
		return session_id();
	}

	protected function getHTTPProtocol() {
		$protocol = 'http';
		if (isset($_SERVER['SCRIPT_URI']) && substr($_SERVER['SCRIPT_URI'], 0, 5) == 'https') {
			$protocol = 'https';
		} elseif (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
			$protocol = 'https';
		}
		return $protocol;
	}

	protected function getCurrentPageURL() {
		return $this->getHTTPProtocol().'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}

	public function MetaTags($includeTitle = true) {
		$tags = parent::MetaTags();

		/**
		 * Find title & replace with MetaTitle (if it exists).
		 * */
		$title = '/(\<title\>)(.*)(\<\/title\>)/';
		preg_match($title, $tags, $matches);

		if (count($matches) > 0) {
			if ($this->MetaTitle) {
				$tags = preg_replace($title, '$1' . $this->MetaTitle . '$3', $tags);
			}
		}

		$charset = ContentNegotiator::get_encoding();
		$tags .= "<meta http-equiv=\"Content-type\" content=\"text/html; charset=$charset\" />\n";
		if($this->MetaKeywords) {
			$tags .= "<meta name=\"keywords\" content=\"" . Convert::raw2att($this->MetaKeywords) . "\" />\n";
		}
		if($this->ExtraMeta) {
			$tags .= $this->ExtraMeta . "\n";
		}

		if($this->URLSegment == 'home' && SiteConfig::current_site_config()->GoogleSiteVerificationCode) {
			$tags .= '<meta name="google-site-verification" content="'
					. SiteConfig::current_site_config()->GoogleSiteVerificationCode . '" />\n';
		}

		// prevent bots from spidering the site whilest in dev.
		if(!Director::isLive()) {
			$tags .= "<meta name=\"robots\" content=\"noindex, nofollow, noarchive\" />\n";
		}

		$this->extend('MetaTags', $tags);

		return $tags;
	}

	public function getTheTitle() {
		return Convert::raw2xml(($this->MetaTitle) ? $this->MetaTitle : $this->Title);
	}

	public function getBodyClass() {
		return Utilities::sanitiseClassName($this->singular_name(),'-');
	}

	// public function index()
	// {
	// 	$request = $this->Request;
	// 	if (!empty($this->UseTemplate)) {
	// 		return $this->renderWith(array($this->UseTemplate, 'Page'));
	// 	}
	// 	return $this->renderWith('Page');
	// }

    public function getNameRect()
    {
        $request = $this->request;
        if ($key = $request->getVar('id')) {
            $person = Person::get()->byID($key);
            return !empty($person) ? json_encode($person->getRect()) : null;
        }

        if ($key = $request->getVar('name')) {
            $person = Person::get()->filter(array('Slag' => $key))->first();
            return !empty($person) ? json_encode($person->getRect()) : null;
        }


        return null;
    }

    public function getGoogleAPI($api_name)
    {
        return Config::inst()->get('GoogleAPIs', $api_name);
    }

    public function getContentTop()
    {
        return $this->getMyBlocks()->filter(array('PagePosition' => 'before-content'));
    }

    public function getContentBottom()
    {
        return $this->getMyBlocks()->filter(array('PagePosition' => 'after-content'));
    }

    public function MultiLanguageEnabled()
    {
        return SiteConfig::current_site_config()->EnableMultiLanguage;
    }

    public function getHome($locale)
    {
        $locale = str_replace('-', '_', $locale);
        if ($home = HomePage::get()->first()) {
            if ($page = $home->getTranslation($locale)) {
                $link = $page->Link();
                return !empty($link) ? $link : '/';
            }
        }
        return '/';
    }

}
