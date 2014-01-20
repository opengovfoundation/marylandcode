<?php

if(!defined('INCLUDE_PATH'))
{
	define('INCLUDE_PATH', '../../includes/');
}

require_once INCLUDE_PATH . 'config.inc.php';
require_once INCLUDE_PATH . 'functions.inc.php';

class MarylandTitleParser
{
	public $filename = './data/titles.csv';
	public $title_path = 'Table';
	public $database;

	public function __construct()
	{
		$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT);
		$this->database = new PDO( PDO_DSN, PDO_USERNAME, PDO_PASSWORD, $options );

		ini_set("auto_detect_line_endings", true);
	}

	public function parse()
	{
		$this->update_sections();
	}

	public function update_sections()
	{
		$fh = fopen($this->filename, 'r');
		if(!$fh) {
			throw new Exception('Couldn\'t open file.');
		}

		// Read our title line
		$headings = fgetcsv($fh);

		$statement = $this->database->prepare('UPDATE laws SET catch_line = :catch_line WHERE section = :section');

		while(($row = fgetcsv($fh)) !== FALSE)
		{
			// Trim trailing space and periods.
			$row[0] = trim($row[0], " \t\n\r\0\x0B.");

			// Replace non-ascii characters in title.
			$row[2] = preg_replace('/[^(\x20-\x7F)]*/','', $row[2]);

			print 'Updating ' . $row[0] . ' -> "' .
				$row[2] . "\"\n";

			$result = $statement->execute(array(
				':catch_line' => $row[2],
				':section' => $row[0]));

			if($result === FALSE)
			{

				$error = array();
				if ( $statement->errorCode() )
				{
					$error['Statement Code'] = $statement->errorCode();
				}
				if ( $statement->errorInfo() )
				{
					$error['Statement Info'] = $statement->errorInfo();
				}
				if ( $this->database->errorCode() )
				{
					$error['Database Code'] = $this->database->errorCode();
				}
				if ( $this->database->errorInfo() )
				{
					$error['Database Info'] = $this->database->errorInfo();
				}
				$error['Query String'] = $statement->queryString;

				throw new Exception( print_r($error, TRUE) );
			}

		}
	}

/* The XML we're getting from Word is awful.  Droping all of this and using CSV. */
// 	public function get_content($filename)
// 	{
//
//
// 		/*
// 		 * Store the contents of the file as a string.
// 		 */
// 		$xml = file_get_contents($this->filename);
//
// 		/*
// 		 * Convert the XML into an object.
// 		 */
//
// 		try {
// 			$content= new SimpleXMLElement($xml);
// 		}
// 		catch(Exception $e) {
// 			/*
// 			 * If we can't convert to XML, try cleaning the data first.
// 			 */
// 			if(class_exists('tidy', false)) {
// 				$tidy_config = array('input-xml' => true);
// 				$tidy = new tidy();
// 				$tidy->parseString($xml, $tidy_config, 'utf8');
// 				$tidy->cleanRepair();
//
// 				$xml = (string) $tidy;
// 			}
// 			elseif(exec('which tidy')) {
// 				exec('tidy -xml '.$filename, $output);
// 				$xml = join('', $output);
// 			}
// 			$content = new SimpleXMLElement($xml);
// 		}
//
// 		return $content;
// 	}
//
// 	public function get_titles($filename)
// 	{
// 		$data = $this->get_content($filename);
//
// 		/*
// 		 * Our columns appear in a particular order
// 		 * The columns need to be titled (in any order):
// 		 * "Code", "Link", "Original", "Code Section", "Catch Title"
// 		 */
// 		$columns = array();
// 		$structures = array();
// 		$sections = array();
//
// 		//var_dump($xml);
// 		foreach($data->Worksheet->Table->Row as $row)
// 		{
// 			/*
// 			 * If our columns aren't setup, this is our first pass
// 			 * so we'll set them up now.
// 			 */
// 			if(!count($columns))
// 			{
// 				$i = 1;
// 				foreach($row->Cell as $cell)
// 				{
// 					$data = (string) $cell->Data;
//
// 					if(strlen($data))
// 					{
// 						$column = strtolower(str_replace(' ', '_', $data));
// 						$columns[$i] = $column;
// 					}
// 					$i++;
// 				}
// 				var_dump($columns);
// 			}
// 			else
// 			{
// 				$record = array();
// 				$i = 1;
// 				foreach($row->Cell as $cell)
// 				{
//
// 					$data = (string) $cell->Data;
//
// 					if(count($cell->attributes('ss', TRUE)))
// 					{
// 						if(isset($cell->attributes('ss', TRUE)->Index))
// 						{
// 							$i = (int) $cell->attributes('ss', TRUE)->Index;
// 						}
// 					}
//
// 					// $attrs = $cell->xpath('@ss:Index');
// // 					if(count($attrs) > 0)
// // 					{
// // 						$index = $attrs[0];
// // 					}
// //
// // 					var_dump($index->{'@attributes'});
//
// 					if(strlen($data))
// 					{
// 						$record[ $columns[$i] ] = $data;
// 					}
// 					$i++;
// 				}
//
//
// 				/*
// 				 * If we have a structure.
// 				 */
// 				if (isset($record['Input.Identifier']) && isset($record['Answer.summary']))
// 				{
// 					$structures[] = $record;
// 				}
// 				/*
// 				 * If we have a section
// 				 */
// // 				elseif (isset($record['code_section']) && isset($record['original']))
// // 				{
// // 					$sections[] = $record;
// // 				}
//
// 			}
// 		}
// 		return array($structures, $sections);
// 	}

}



$parser = new MarylandTitleParser();
$parser->parse();

?>