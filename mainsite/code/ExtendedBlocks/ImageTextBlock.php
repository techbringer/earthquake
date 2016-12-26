<?php
use SaltedHerring\Debugger;

class ImageTextBlock extends Block
{
    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'Content'           =>  'HTMLText',
        'ColumnLayout'      =>  'Varchar(16)'
    );

    /**
     * Define the default values for all the $db fields
     * @var array
     */
    private static $defaults = array(
        'ColumnLayout'      =>  'image-left'
    );

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = array(
        'Image'     =>  'Image'
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab(
            'Options',
            DropdownField::create(
                'ColumnLayout',
                'Layout',
                array(
                    'image-left'    =>  'Image left',
                    'image-right'   =>  'Image right'
                )
            )->setEmptyString('- select one -')
        );
        return $fields;
    }
}
