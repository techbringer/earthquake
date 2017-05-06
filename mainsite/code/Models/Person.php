<?php
use SaltedHerring\Debugger;
use SaltedHerring\Utilities;
class Person extends DataObject
{
    public $bypassSlag      =   false;
    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'English'           =>  'Varchar(256)',
        'EthnicScript'      =>  'Varchar(256)',
        'Slag'              =>  'Varchar(256)',
        'x'                 =>  'Int',
        'y'                 =>  'Int',
        'width'             =>  'Int',
        'height'            =>  'Int',
        'inRow'             =>  'Int',
        'PanelIndex'        =>  'Int',
        'RightToLeft'       =>  'Boolean'
    );

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = array(
        'PanelIndex'        =>  'Panel index',
        'English'           =>  'English',
        'EthnicScript'      =>  'Ethnic script'
    );

    public function Title()
    {
        $english = str_replace('née', '<span class="force-lower">née</span>', $this->English);
        $english = str_replace(' de ', ' <span class="force-lower">d</span>e ', $english);
        return $english . (!empty($this->EthnicScript) ? (' <span class="non-english' . ($this->RightToLeft ? ' rtl' : '') . '">' . $this->EthnicScript . '</span>'): '');
    }

    public function getTitle()
    {
        return $this->Title();
    }

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab(
            'Root.Main',
            OptionsetField::create(
                'inRow',
                'in Row',
                array(
                    '1'     =>  'Row 1',
                    '2'     =>  'Row 2',
                    '3'     =>  'Row 3',
                    '4'     =>  'Row 4'
                )
            )
        );
        return $fields;
    }

    /**
     * Event handler called before writing to the database.
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if (empty($this->height)) {
            $this->height = 60;
        }
        if (empty($this->bypassSlag)) {
            //$this->Slag = Utilities::SlagGen('Person', $this->Title, $this->ID);
        }

        if (!empty($this->inRow)) {
            switch ($this->inRow)
            {
                case 1:
                    $this->y = 35;
                    break;
                case 2:
                    $this->y = 100;
                    break;
                case 3:
                    $this->y = 165;
                    break;
                case 4:
                    $this->y = 230;
                    break;
                default:
                    $this->y = null;
            }
        }
    }

    public function getRect()
    {
        return array(
            'x'         =>  $this->x,
            'y'         =>  $this->y,
            'width'     =>  $this->width,
            'height'    =>  $this->height
        );
    }

    public function format()
    {
        return array(
            'title'     =>  $this->Title(),
            'slag'      =>  $this->Slag,
            'rect'      =>  $this->getRect()
        );
    }

    public function Found()
    {
        return !empty($this->x) && !empty($this->width) && !empty($this->y) && !empty($this->height) && !empty($this->inRow);
    }
}
