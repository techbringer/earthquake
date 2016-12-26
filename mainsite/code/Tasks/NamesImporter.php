<?php
use SaltedHerring\Debugger;
class NamesImpoter extends BuildTask
{
	protected $title = 'Names Importer';
	protected $description = 'Import names from CSV file';
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
            if ($_FILES['CsvFile']['type'] != 'application/vnd.ms-excel') {
				print '<h2>Wrong file type. Must be csv file</h2>';
				print '<p><a href="/dev/tasks/MemberImpoter">Try again</a></p>';
				die;
			}

			$file = fopen($_FILES['CsvFile']['tmp_name'], 'r+');
			$lines = array();
			while( ($row = fgetcsv($file)) !== FALSE ) {
				$lines[] = $row;
			}
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
                $native = $lines[$i][1];

                $english = strtolower(trim($english));
                $native = strtolower(trim($native));

                $person = new Person();
                $person->English = $english;
                Debugger::inspect($english . ' | ' . $native, false);
                if ($native != 'nonative') {
                    $person->EthnicScript = $native;
                }

                $person->write();
                $n++;
			}


			print '<p>'.$n.' name(s) imported</p>';
			print '<p><a href="/dev/tasks/NamesImpoter">Import another CSV file</a></p>';
        }
    }
}
