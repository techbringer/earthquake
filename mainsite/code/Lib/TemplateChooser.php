<?php
use SaltedHerring\Debugger;

class TemplateChooser
{
    public static function get_templates()
    {
        $template_dir = ROOT . '/htdocs/themes/default/templates/Layout';
        $files = scandir($template_dir);
        $templates = array();
        foreach ($files as $file) {
            if (strpos($file, '.ss') !== false) {
                $file = str_replace('.ss', '', $file);
                $templates[$file] = $file;
            }
        }
        return $templates;
    }
}
