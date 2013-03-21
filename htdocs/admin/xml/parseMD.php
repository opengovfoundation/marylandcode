<?php
	file_put_contents('error.log', '');

	date_default_timezone_set('America/New_York');
	ini_set("log_errors", 1);
	ini_set("error_log", "error.log");

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

	function parseSec($legisSec, $level, &$parent){
		$structure = array('section', 'subsection', 'paragraph', 'subparagraph');
		
		foreach($legisSec->$structure[$level] as $child){
			if($child->text != null){
				$newSec = $parent->addChild('section', $child->text);
			}else{
				$newSec = $parent->addChild('section');
			}
			$newSec->addAttribute('prefix', $child->enum);
			
			if(isset($structure[$level + 1]) && $child->$structure[$level+1] != null){
				parseSec($child, $level + 1, $newSec);
			}
			
		}
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
			
			//Title Unit Structure
			$unit = $structure->addChild('unit');
			$unit->addAttribute('label', 'title');
			$unit->addAttribute('identifier', $infoArray[0]);
			$unit->addAttribute('order_by', '');
			$unit->addAttribute('level', '1');
			
			//Chapter Unit Structure
			$unit2 = $structure->addChild('unit');
			$unit2->addAttribute('label', 'chapter');
			$unit2->addAttribute('identifier', $infoArray[1]);
			$unit2->addAttribute('order_by', '');
			$unit2->addAttribute('level', '2');
			
			$section_number = $law->addChild('section_number', $infoArray[0] . '-' . $infoArray[1]);
			$catch_line = $law->addChild('catch_line', '');
			
			if($section->text != null){
				$text = $law->addChild('text', $section->text);
			}else{
				$text = $law->addChild('text');
			}
			
			
			parseSec($section, 1, $text);
			
			$newFilename = $infoArray[0] . '-' . $infoArray[1] . '.clean.xml';
			$law->asXML($newFilename);
			exec("xmllint -format $newFilename -output $newFilename");
		}
	}


