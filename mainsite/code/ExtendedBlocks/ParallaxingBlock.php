<?php
use SaltedHerring\Debugger;

class ParallaxingBlock extends Block
{
    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'Parallaxing'   =>  'Boolean',
        'MinHeight'     =>  'Varchar(16)',
        'Proportional'  =>  'Boolean'
    );
    /**
     * Define the default values for all the $db fields
     * @var array
     */
    private static $defaults = array(
        'Parallaxing'   =>  true,
        'MinHeight'     =>  '40vh'
    );
    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = array(
        'Image'         =>  'Image'
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
                CheckboxField::create(
                    'Parallaxing',
                    'use parallaxing effect'
                ),
                TextField::create(
                    'MinHeight',
                    'Minimum height'
                ),
                CheckboxField::create(
                    'Proportional',
                    'Height proportionally adaptive'
                )->setDescription('Make sure you turn off parallaxing option')
            )
        );
        return $fields;
    }

    public function getStyles()
    {
        $style = '';
        if (!empty($this->MinHeight) || !empty($this->ImageID)) {
            $style = ' style="';
            if (!empty($this->Proportional)) {
                $proportion = 0;
                if (!empty($this->ImageID)) {
                    $width = $this->Image()->Width;
                    $height = $this->Image()->Height;
                    $r = $width < $height ? $width / $height : $height / $width;
                    $proportion = number_format($r * 100, 2);
                }
                $style .= ('padding-top: ' . $proportion . '%; background-size: 100% auto; ');
            } elseif (!empty($this->MinHeight)) {
                $style .= ('min-height: ' . $this->MinHeight . '; ');
            }

            if (!empty($this->ImageID)) {
                $url = $this->Image()->URL;
                if ($this->Image()->Width > 3000) {
                    $url = $this->Image()->setWidth(3000)->URL;
                }

                $style .= ('background-image: url(' . $url . '); ');
            }
            $style .= '"';
        }

        return $style;
    }
}
