<?php
	file_put_contents('error.log', '');

	date_default_timezone_set('America/New_York');
	ini_set("log_errors", 1);
	ini_set("error_log", "error.log");

	/* Functions */

	function charReplace($string){
		$map = array(
					'&numsp;' =>	' ',
					'&numsp' => ' ',
					'&ndash;' =>	'-',
					'&percnt;' => '%',
					'&ldquo;' => '"',
					'&rdquo;' => '"',
					'&lowbar;' => '_',
					'&squ;' => '',
					'&rsquo;' => '\'',
					'&lsquo;' => '\'',
					'&sect;' => '§',
					'&ensp;' => ' ',
					'&emsp;' => ' ',
					'&deg;' => '°',
					'&mdash;' => '-',
					'&' => '&amp;'
				);
		foreach($map as $from => $to){
			$string = str_replace($from, $to, $string);
		}
		return $string;
	}

	function parseSec($legisSec, $level, &$parent, &$catch_line){
		$structure = array('section', 'subsection', 'paragraph', 'subparagraph', 'sub-subparagraph', 'sub-sub-paragraph');
		
		foreach($legisSec->$structure[$level] as $child){
			if($child->text != null && $child->text != ''){
				$newSec = $parent->addChild('section', $child->text);
				if($catch_line[0] == ''){
					$catch_line[0] = substr($child->text, 0, 100) . '...';
				}
			}else{
				$newSec = $parent->addChild('section');
			}
			$newSec->addAttribute('prefix', htmlspecialchars($child->enum));
			
			if(isset($structure[$level + 1]) && $child->$structure[$level+1] != null){
				parseSec($child, $level + 1, $newSec, $catch_line);
			}
			
		}
	}
	
	function parseTitles($filepath){
		if(($handle = fopen($filepath, 'r')) !== FALSE){
			$titles = array();

			while(($row = fgetcsv($handle)) !== FALSE){
				$titles[$row[0]] = $row[1];
			}

			fclose($handle);

			return $titles;
		}else{
			throw new Exception("Couldn't open file name csv for reading.");
		}
	}
	
	/* End Functions */
	
	/* Start Execution */
	$titles = array();
	
	try{
		$titles = parseTitles('article-titles.csv');
	}catch(Exception $e){
		echo $e->getMessage();
		exit;
	}
	

	foreach(glob('../original/*.xml') as $filename){

		$basename = str_replace('.xml', '', $filename);
		
		$xml = file_get_contents($filename);
		$xml = charReplace($xml);
		try{
			$legis = new SimpleXMLElement($xml);
		}catch (Exception $e){
			if(class_exists('tidy', false)) {
				$tidy_config = array('input-xml' => true);
				$tidy = new tidy();
				$tidy->parseString($xml, $tidy_config, 'utf8');
				$tidy->cleanRepair();

				$xml = (string) $tidy;
			}
			elseif(exec('which tidy')) {
				exec('tidy -xml '.$filename, $output);
				$xml = join('', $output);
			}
			$legis = new SimpleXMLElement($xml);
		}
		
		foreach($legis->article->section as $section){
			$section_id = $section->attributes()->id;
			$infoArray = preg_split('@:@', $section_id, NULL, PREG_SPLIT_NO_EMPTY);
			if(count($infoArray) > 2){
				$infoArray[1] = array_pop($infoArray);
			}
 			
			//Create law element
			$law = new SimpleXMLElement('<law></law>');
			
			//Create structure element
			$structure = $law->addChild('structure');
			
			//Article Unit Structure
			if(isset($titles[$infoArray[0]])){
				$unit = $structure->addChild('unit', htmlspecialchars($titles[$infoArray[0]]));
			}else{
				throw new Exception("\n --Unable to get title for unit $infoArray[0] --\n");
			}
			
			$unit->addAttribute('label', 'article');
			$unit->addAttribute('identifier', $infoArray[0]);
			
			if(preg_match_all('@([0-9]+)@', $infoArray[0], $matches)){
				if(count($matches) > 2){
					echo $infoArray[0] . "\n";
					echo count($matches) . "\n";
					print_r($matches);
				}
			}
			
			if(!isset($matches[0][0])){
				$unit->addAttribute('order_by', $infoArray[0]);
			}else{
				$unit->addAttribute('order_by', $matches[0][0]);
			}
			
			$unit->addAttribute('level', '1');
			
			
			
			
			$section_number = $law->addChild('section_number', $infoArray[0] . '-' . $infoArray[1]);
			$catch_line = $law->addChild('catch_line', '');
			$section_order = explode('-', $infoArray[1]);
			$section_order = array_pop($section_order);
			$order_by = $law->addChild('order_by', $section_order);
			
			if($section->text != null && $section->text != ''){
				if($law->catch_line == ''){
					$law->catch_line[0] = substr($section->text, 0, 100) . "...";
				}
				$text = $law->addChild('text', $section->text);
			}else{
				$text = $law->addChild('text');
			}
			
			parseSec($section, 1, $text, $catch_line);
			
			$newFilename = $infoArray[0] . '-' . $infoArray[1] . '.clean.xml';
			$law->asXML($newFilename);
			exec("xmllint -format $newFilename -output $newFilename");
			
			if($catch_line[0] == '' || $catch_line[0] == null){
				print_r($catch_line);
				print_r($law->catch_line);
				echo "Error with catch line for $section_number\n";
				exit;
			}
		}
	}


