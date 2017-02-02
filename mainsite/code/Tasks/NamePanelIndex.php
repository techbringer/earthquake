<?php
use SaltedHerring\Debugger;
class NamesImporter extends BuildTask
{
    protected $title = 'Names Importer - panel index';
    protected $description = 'Import names panel index from CSV file';
    protected $enabled = true;
    public function run($request)
    {
        // $people = Person::get();
        // foreach ($people as $person) {
        //     $person->write();
        // }
        // return;
        if ( $request->isGet() ){
            print '<form enctype="multipart/form-data" method="post">';
            print '  <input type="file" name="CsvFile" id="CsvFile" />';
            print '  <input type="submit" name="doUpload" id="doUpload" value="Upload" />';
            print '</form>';
        } elseif ( $request->isPost() ) {
            if ($_FILES['CsvFile']['type'] != 'application/vnd.ms-excel' && $_FILES['CsvFile']['type'] != 'text/csv') {
                print '<h2>Wrong file type. Must be csv file</h2>';
                print '<p><a href="/dev/tasks/MemberImpoter">Try again</a></p>';
                die;
            }

            $file = fopen($_FILES['CsvFile']['tmp_name'], 'r+');
            $lines = array();
            while( ($row = fgetcsv($file)) !== FALSE ) {
                $lines[] = $row;
            }

            // Debugger::inspect($lines);
            /*
            [0] => English
            [1] => Native
            */
            if (!is_array($lines[0])) {
                print '<h2>Wrong CSV format</h2>';
                print '<p><a href="/dev/tasks/NamesImpoter">Try again</a></p>';
                die;
            }

            $n = 0;
            for ($i = 1; $i < count($lines); $i++){
                $english = $lines[$i][0];
                $idx = $lines[$i][1];
                $english = strtolower(trim($english));
                $person = Person::get()->filter(array('English' => $english))->first();

                if (!empty($person)) {
                    Debugger::inspect($idx, false);
                    $person->bypassSlag = true;
                    $person->PanelIndex = $idx;
                    $person->write();
                    $n++;
                } else {
                    Debugger::inspect('can\'t find ' . $english, false);
                }

            }


            print '<p>'.$n.' name(s) imported</p>';
            print '<p><a href="/dev/tasks/NamesImpoter">Import another CSV file</a></p>';
        }
    }
}
