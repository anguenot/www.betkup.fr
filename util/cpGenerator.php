<?php
include_once('./simple_html_dom.php');
define('PATH_TO_FILE', '../apps/frontend/modules/account/data');

$temps_debut = microtime(true);
echo 'Start at : '.date('H:i:s', $temps_debut)."\n";

init();

$temps_fin = microtime(true);
echo "\n\n";
echo 'End at : '.date('H:i:s', $temps_fin)."\n";
echo 'Temps d\'execution : '.round($temps_fin - $temps_debut, 4);
echo "\n";

function getCitiesFromFile() {
	
	$file = PATH_TO_FILE."/comsimp2011.csv";
	$handle = fopen($file, 'r') or die("Cannot open ".$file);
	$cities = array();
	
	$i=0;
	while($line=fgetcsv($handle,filesize($file), ';', '"'))
	{
		//Escape the first line
		if($i != 0) {
			$cities[$i-1] = array(
				'department' => $line[3], 
				'inseecom' => $line[4],
				'prefix' => str_replace(array('(', ')'), '', $line[8]),
				'name' => $line[9]
			);
		}
		$i++;
	}
	fclose($handle);
	return $cities;
}

function init() {
	
	$cities = getCitiesFromFile();
	writeCpFile(mergeCpCityName($cities));
}

function formatNameToFind($string) {
	return str_replace(array('-', 'SAINT ', 'SAINTE ', "'"), array(' ', 'ST ', 'STE ', ' '), $string);
}

function writeCpFile($infos) {
	$file = PATH_TO_FILE."/communes.csv";
	$handle = fopen($file, 'w') or die("Cannot open ".$file);
	
	$numberLines = count($infos);
	
	$i=0;
	$j=0;
	print_r("\n");
	foreach($infos as $values) {
		fputs($handle, $values);
		fputs($handle,"\n");
		
		$i++;
		$j++;
		if($i == 5000) {
			print_r($j.'/'.$numberLines.' cities writen.'."\n");
			$i=0;
		}
	}
	
	fclose($handle);
}

function buildCpArray($html, $cp = array()) {
	
	if($html->find('table[rules=ALL]', 0) !== null) {
	foreach($html->find('table[rules=ALL]') as $element) {
		$i=0;
		if($element->find('tr td table tbody tr td', 0) !== null) {
		foreach($element->find('tr td table tbody tr td') as $td) {
	    	$cp[$i] = array();
	    	if($td->find('div', 0) !== null) {
				foreach($td->find('div') as $div) {
		    		array_push($cp[$i], str_replace(' ', '', $div->plaintext));
		    	}
	    	}
	    	$i++;
	    }
		}
	}
	}
	return $cp;
}

function buildCityName($html, $cityName = array()) {
	if($html->find('table[rules=ALL]', 0) !== null) {
	foreach($html->find('table[rules=ALL]') as $element) { 
		$i=0;
		$j=0;
		if($element->find('td', 0) !== null) {
		foreach($element->find('td') as $td) {
			$cityName[$j] = array();
			if($td->find('div[align=center]', 0) !== null) {
			foreach($td->find('div[align=center]') as $div) {
				$name = explode('&nbsp;', $div->plaintext);
				
				if(preg_match('#[a-zA-Z]#i', $name[0])) {
					if($i>1) {
						array_push($cityName[$j], $name[0]);
						$j++;
					}
					$i++;
				}
			}
			}
		}
		}
	}
	}
	return $cityName;
}

function mergeCpCityName($cities) {
	$mergedArray = array();
	$numberLines = count($cities);
	
	$n=0;
	$j=0;
	foreach($cities as $city) {
	
		if($city['prefix'] == "") {
			$commune = formatNameToFind($city['name']);
		} else {
			$commune = formatNameToFind(str_replace("'", "", $city['prefix']).' '.$city['name']);
		}
		$critere = 'CP';
		
		$data = array(
			'txtCP' => str_replace(array('A', 'B'), '0', $city['department']),
			'txtCommune' => $commune,
			'selCritere' => $critere
		);
		
		$url = "http://www.laposte.fr/sna/rubrique.php3?id_rubrique=59&recalcul=oui";
		
		$params = array('http' => array( 
			'method' => 'POST', 
			'content' => http_build_query($data)
		));
		
		$ctx = @stream_context_create($params);
		if($html = @file_get_html($url, false, $ctx)) {
		
		$cpList = buildCpArray($html);
		$nameList = buildCityName($html);
		
		foreach($cpList as $key => $cp) {
			asort($cp);
			foreach($cp as $i => $value) {
				$cityName = formatNameToFind($city['name']);
				if($city['prefix'] != '') {
					$cityName = str_replace("'", "", $city['prefix']).' '.formatNameToFind($city['name']);
				}
				if($cityName == $nameList[$key][0]) {
					$mergedArray[] = '"'.$nameList[$key][0].'";"'.$value.'";"'.$city['department'].$city['inseecom'].'"';
					echo 'Save '.$nameList[$key][0].' ('.$city['department'].$city['inseecom'].' => '.$value.')'."\n";
					$j++;
				}
			}
		}
		
		$n++;
		if($n == 500) {
			print_r("\n".$j.'/'.$numberLines.' cities saved in array.'."\n\n");
			$n=0;
		}
		
		$html->clear();
    	unset($html);
		}
	}
	print_r($j.'/'.$numberLines.' cities saved in array.'."\n");
	return $mergedArray;
}
?>
