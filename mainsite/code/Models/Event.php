<?php
use SaltedHerring\Debugger;

class Event extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'Date'          =>  'Date',
        'Content'       =>  'HTMLText',
        'Parallaxing'   =>  'Boolean',
        'MinHeight'     =>  'Varchar(16)'
    );

    private static $defaults = array(
        'Parallaxing'   =>  true,
        'MinHeight'     =>  '40vh'
    );

    /**
     * Default sort ordering
     * @var string
     */
    private static $default_sort = array(
        'Date'          =>  'DESC'
    );

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = array(
        'Title',
        'Date'
    );

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = array(
        'ListPage'  =>  'EventsListPage',
        'Image'     =>  'Image'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        if (!$fields->fieldByName('Options')) {
			$fields->insertBefore(RightSidebar::create('Options'), 'Root');
	    }
        $fields->addFieldsToTab(
            'Options',
            array(
                CheckboxField::create(
                    'Parallaxing',
                    'use parallaxing effect'
                ),
                TextField::create(
                    'MinHeight',
                    'Minimum height'
                )
            )
        );
        $fields->removeByName('ListPageID');
        $fields->fieldByName('Root.Main.Date')->setConfig('showcalendar', 1);

        return $fields;
    }

    /**
     * Event handler called before writing to the database.
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $parent = EventsListPage::get()->first();
        $this->ListPageID = $parent->ID;
    }

    public function Title()
    {
        return $this->getTitle();
    }

    public function getTitle()
    {
        return $this->Date;
    }

    public function forTemplate()
    {
        return $this->renderWith('Event');
    }
}
