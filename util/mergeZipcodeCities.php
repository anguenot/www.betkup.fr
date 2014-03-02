<?php

define('PATH_TO_FILE', '../apps/frontend/modules/account/data');

function getZipCodeFromFile() {
	
	$file = PATH_TO_FILE."/communes.csv";
	$handle = fopen($file, 'r') or die("Cannot open ".$file);
	$zipCode = array();
	
	$i=0;
	while($line=fgetcsv($handle,filesize($file), ';', '"'))
	{
		$zipCode[$i] = array(
			'name' => $line[0],
			'zipcode' => $line[1],
			'inseecode' => $line[2]
		);
		$i++;
	}
	
	fclose($handle);
	
	return $zipCode;
}

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

function getDepartmentsFromFile() {
	
	$departments = array();
	
	$file = PATH_TO_FILE."/depts2011.csv";
	$handle = fopen($file, 'r') or die("Cannot open ".$file);
		
	$i=0;
	while($line=fgetcsv($handle,filesize($file), ';', '"'))
	{
		//Escape the first line
		if($i != 0) {
			$departments["'".$line[1]."'"] = $line[4];
		}
		$i++;
	}
	fclose($handle);
	
	return $departments;
}

function searchDepartmentName($search, $departments) {
	$matching = '';
	
	foreach($departments as $departmentId => $departmentName) {
		
		if(preg_match('#'.$search.'#i', $departmentId)) {
			$matching = $departmentName;
			break;
		}
	}
	
	return $matching;
}

function searchByZipCode($zipcode, $insee = false, $zipCodes) {
	$matching = array();
	
	foreach ($zipCodes as $index => $codes) {
		
		// Searching by insee code
		if($insee) {
			if(preg_match('#'.$zipcode.'#i', $codes['inseecode'])) {
				array_push($matching, $codes['zipcode']);
			}
		// Searching by zip code
		} else if(!$insee) {
			if(preg_match('#'.$zipcode.'#i', $codes['zipcode'])) {
				array_push($matching, $codes['inseecode']);
			}
		}
	}
	asort($matching, SORT_NUMERIC);
	
	return $matching;
}

function mergeCitiesZipCode() {
	$cityZipCode = array();
	
	$cities = getCitiesFromFile();
	$zipCodes = getZipCodeFromFile();
	$departments = getDepartmentsFromFile();
	
	$numberLines = count($zipCodes);
	
	$i=0;
	$j=0;
	$n=0;
	foreach($cities as $city) {
		$zipCode = searchByZipCode($city["department"].$city["inseecom"], true, $zipCodes);
		foreach($zipCode as $zipcode) {
			$cityZipCode[$j]['name'] = $city["name"];
			$cityZipCode[$j]['zipcode'] = $zipcode;
			$cityZipCode[$j]['inseecode'] = $city["department"].$city["inseecom"];
			$cityZipCode[$j]['departmentId'] = $city["department"];
			$cityZipCode[$j]['departmentName'] = searchDepartmentName($city["department"], $departments);
			$cityZipCode[$j]['prefix'] = $city["prefix"];
			$j++;
		}
		$n++;
		$i++;
		if($n == 1000) {
			print_r($i.'/'.$numberLines.' cities saved in array.'."\n");
			$n=0;
		}
	}
	
	return $cityZipCode;
}

function writeFile($infos) {
	
	$file = PATH_TO_FILE."/mergedCitiesZipCode.csv";
	$handle = fopen($file, 'w') or die("Cannot open ".$file);
	
	$numberLines = count($infos);
	
	$i=0;
	$j=0;
	print_r("\n");
	foreach($infos as $values) {
		fputs($handle, '"'.$values['name'].'";"'.$values['departmentId'].'";"'.$values['departmentName'].'";"'.$values['zipcode'].'";"'.$values['inseecode'].'";"'.$values['prefix'].'"');
		fputs($handle,"\n");
		
		$i++;
		$j++;
		if($i == 5000) {
			print_r($j.'/'.$numberLines.' cities write.'."\n");
			$i=0;
		}
	}
	
	fclose($handle);
}

function init() {
	writeFile(mergeCitiesZipCode());
}

$temps_debut = microtime(true);
echo 'Start at : '.date('H:i:s', $temps_debut)."\n";

init();

$temps_fin = microtime(true);
echo "\n\n";
echo 'End at : '.date('H:i:s', $temps_fin)."\n";
echo 'Temps d\'execution : '.round($temps_fin - $temps_debut, 4);
echo "\n";
?>
