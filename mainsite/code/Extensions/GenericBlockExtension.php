<?php
use SaltedHerring\Debugger;

class GenericBlockExtension extends DataExtension
{
    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'GreyBackground'    =>  'Boolean',
        'PagePosition'      =>  'Varchar(16)'
    );

    /**
     * Default sort ordering
     * @var string
     */
    private static $default_sort = array(
        'SortOrder'         =>  'ASC',
        'ID'                =>  'ASC'
    );

    /**
     * Define the default values for all the $db fields
     * @var array
     */
    private static $defaults = array(
        'PagePosition'      =>  'after-content'
    );

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
     private static $summary_fields = array(
 		'BlockType',
 		'Title',
 		'PagePosition',
 		'Published'
 	);

    /**
     * Update Fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        if (!$fields->fieldByName('Options')) {
			$fields->insertBefore(RightSidebar::create('Options'), 'Root');
	    }
        $fields->addFieldsToTab(
            'Options',
            array(
                DropdownField::create(
                    'PagePosition',
                    'Position on page',
                    array(
                        'before-content'    =>  'Before page content',
                        'after-content'     =>  'After page content'
                    )
                ),
                CheckboxField::create(
                    'GreyBackground',
                    'use grey background colour'
                ),
                CheckboxField::create(
                    'addPaddingTop',
                    'add "padding-top" class to block wrapper'
                ),
                CheckboxField::create(
                    'addPaddingBottom',
                    'add "padding-bottom" class to block wrapper'
                )
            )
        );
        return $fields;
    }

    public function getExtraClasses()
    {
        $classes = '';
        if ($this->owner->addPaddingTop) {
            $classes .= ' padding-top';
        }

        if ($this->owner->addPaddingBottom) {
            $classes .= ' padding-bottom';
        }

        if ($this->owner->addMarginTop) {
            $classes .= ' margin-top';
        }

        if ($this->owner->addMarginBottom) {
            $classes .= ' margin-bottom';
        }

        if ($this->owner->GreyBackground) {
            $classes .= ' bg-grey';
        }

        if ($this->owner->frontendEditable()) {
            $classes .= ' edit-mode';
        }

        if ($this->owner->hasField('ColumnLayout') && !empty($this->owner->ColumnLayout)) {
            $classes .= (' ' . $this->owner->ColumnLayout);
        }

        if ($this->owner->hasField('Parallaxing') && !empty($this->owner->Parallaxing)) {
            $classes .= (' parallax-window');
        }

        return $classes;
    }
}
