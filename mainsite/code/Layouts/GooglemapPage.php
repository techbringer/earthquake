<?php

use SaltedHerring\Debugger;

class GooglemapPage extends Page
{
    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'Address'       =>  'Text',
        'Latitude'      =>  'Varchar(32)',
        'Longitude'     =>  'Varchar(32)',
        'ZoomRate'      =>  'Decimal'
    );

    /**
     * Define the default values for all the $db fields
     * @var array
     */
    private static $defaults = array(
        'ZoomRate'      =>  '18'
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        if ($api = Config::inst()->get('GoogleAPIs', 'Map')) {
            $fields->addFieldToTab(
                'Root.Main',
                LiteralField::create('GoogleMapAPI', '<h2>API: ' . $api . '</h2>'),
                'Title'
            );
        } else {
            $fields->addFieldToTab(
                'Root.Main',
                LiteralField::create('GoogleMapAPI', '<h2>Please define Google API in your config.yml file</h2>'),
                'Title'
            );
        }

        $fields->addFieldsToTab(
            'Root.Location',
            array(
                TextField::create('Address'),
                TextField::create('Latitude'),
                TextField::create('Longitude'),
                TextField::create('ZoomRate')
            )
        );
        return $fields;
    }
}

class GooglemapPage_Controller extends Page_Controller
{

}
