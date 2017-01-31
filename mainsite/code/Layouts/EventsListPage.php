<?php
use SaltedHerring\Debugger;
use SaltedHerring\Grid;

class EventsListPage extends Page
{
    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'EventsPerPage'     =>  'Int'
    );

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = array(
        'Events'            =>  'Event'
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        if ($this->Events()->exitst()) {
            $fields->addFieldsToTab(
                'Root.Events',
                Grid::make('Events', 'Events', $this->Events(), false)
            );
        }
        return $fields;
    }

}

class EventsListPage_Controller extends Page_Controller
{

}
