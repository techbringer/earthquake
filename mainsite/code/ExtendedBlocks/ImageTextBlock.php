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
        'ExtraContent'      =>  'HTMLText',
        'ColumnLayout'      =>  'Varchar(16)',
        'SplitContent'      =>  'Boolean',
        'ImageFullHeight'   =>  'Boolean'
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
        $fields->addFieldsToTab(
            'Options',
            array(
                DropdownField::create(
                    'ColumnLayout',
                    'Layout',
                    array(
                        'image-left'    =>  'Image left',
                        'image-right'   =>  'Image right'
                    )
                )->setEmptyString('- select one -'),
                CheckboxField::create(
                    'SplitContent',
                    'Split content text in 2 columns'
                )
            )
        );
        return $fields;
    }

    public function getPaddingTop()
    {
        $proportion = 0;
        if (!empty($this->ImageID)) {
            $width = $this->Image()->Width;
            $height = $this->Image()->Height;
            $r = $width < $height ? $height / $width : $width / $height;
            $proportion = number_format($r * 100, 2);
        }

        return $proportion . '%';
    }
}
