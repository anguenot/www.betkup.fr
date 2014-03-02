<?php

/**
 * Data definitions.
 *
 * <p/>
 *
 * Note, Betkup.fr does not leverage any SQL database or any kind of persistant storage.
 *
 * <p/>
 *
 * This data are mostly used in forms.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: data.class.php 6430 2012-11-08 13:27:27Z jmasmejean $
 */
class Data {

	const PATH_ACCOUNT_DATA = '/account/data';

	/**
	 * Get the searching terms for kup search
	 * 
	 * @return array
	 */
	static function searchTerms() {

		$searchTerms = array(
            sfConfig::get('app_kup_search_params_sports') => array(
                'ALL' => array('name' => 'text_search_terms_search_all', 'value' => '*', 'image' => ''),
				'SOCCER' => array('name' => 'text_search_terms_search_soccer', 'value' => 'Soccer', 'image' => 'kup/search/pictoFootmini.png'),
				'RUGBY' => array('name' => 'text_search_terms_search_rugby', 'value' => 'Rugby',  'image' => 'kup/search/pictoRugbymini.png'),
                'BASKET' => array('name' => 'text_search_terms_search_basket', 'value' => 'Basket',  'image' => 'kup/search/pictoBasketmini.png'),
				'F1' => array('name' => 'text_search_terms_search_f1', 'value' => 'F1', 'image' => 'kup/search/pictoF1mini.png'),
				'TENNIS' => array('name' => 'text_search_terms_search_tennis', 'value' => 'tennis', 'image' => 'kup/search/pictoTennismini.png'),
				'CYCLING' => array('name' => 'text_search_terms_search_cycling', 'value' => 'cycling', 'image' => 'kup/search/pictoCyclingmini.png')
		),
            sfConfig::get('app_kup_search_params_stake') => array(
                sfConfig::get('app_params_type_stake_all') => array('name' => 'text_search_terms_search_all2', 'value' => '*', 'image' => ''),
                sfConfig::get('app_params_type_stake_free') => array('name' => 'text_search_terms_search_free', 'value' => 'FREE',  'image' => ''),
				sfConfig::get('app_params_type_stake_freerolls') => array('name' => 'text_search_terms_search_freerolls', 'value' => 'FREEROLLS',  'image' => ''),
				sfConfig::get('app_params_type_stake_payable') => array('name' => 'text_search_terms_search_payable', 'value' => 'GAMBLING_FR',  'image' => '')
		),
            sfConfig::get('app_kup_search_params_status') => array(
                sfConfig::get('app_params_type_duration_all') => array('name' => 'text_search_terms_search_all2', 'value' => 'ALL',  'image' => ''),
				sfConfig::get('app_params_type_duration_in_progress') => array('name' => 'text_search_terms_search_on_going', 'value' => 'ON_GOING',  'image' => ''),
				sfConfig::get('app_params_type_duration_in_comming') => array('name' => 'text_search_terms_search_opened', 'value' => 'CREATED',  'image' => ''),
				sfConfig::get('app_params_type_duration_closed') => array('name' => 'text_search_terms_search_closed', 'value' => 'ALL_CLOSED',  'image' => '')
		),
            sfConfig::get('app_kup_search_params_sorting') => array(
                sfConfig::get('app_params_type_sorting_start_date') => array('name' => 'text_search_terms_search_start_date',  'value' => 'start_date', 'image' => ''),
                sfConfig::get('app_params_type_sorting_jackpot') => array('name' => 'text_search_terms_search_jackpot',  'value' => 'jackpot', 'image' => ''),
				sfConfig::get('app_params_type_sorting_participants') => array('name' => 'text_search_terms_search_participants', 'value' => 'participants',  'image' => ''),
				sfConfig::get('app_params_type_sorting_kup_duration') => array('name' => 'text_search_terms_search_length',  'value' => 'length', 'image' => '')
		),
			sfConfig::get('app_kup_search_params_other') => array(
				'withRoomKups' => array('name' => 'text_search_terms_search_public',  'value' => 'withRoomKups', 'image' => ''),
				'removeValidatedfor' => array('name' => 'text_search_terms_search_user_kups',  'value' => 'removeValidatedFor', 'image' => '')
			)
		);
		return $searchTerms;
	}
	
	/**
	 * Get the searching terms for room search
	 * 
	 * @return array
	 */
	static function searchTermsRoom() {
		$sports = Data::searchTerms();
		$searchTerms = array(
            sfConfig::get('app_kup_search_params_sports') => $sports[sfConfig::get('app_kup_search_params_sports')],
			sfConfig::get('app_kup_search_params_sorting') => array(
                'ACTIVE_KUPS' => array('name' => 'text_search_terms_room_search_active_kups',  'value' => 'active_kups', 'image' => ''),
                'AMOUNT_STAKE' => array('name' => 'text_search_terms_room_search_amount_stake',  'value' => 'amount_stake', 'image' => ''),
				'MEMBERS' => array('name' => 'text_search_terms_room_search_members', 'value' => 'members',  'image' => ''),
				'CREATION_DATE' => array('name' => 'text_search_terms_room_search_create_date',  'value' => 'creation_date', 'image' => '')
			),
			"CATEGORY" => array(
				'ALL' => array('name' => 'text_search_terms_room_search_category_all',  'value' => '*', 'image' => ''),
				'SUPPORTERS' => array('name' => 'text_search_terms_room_search_supporters',  'value' => 'supporters', 'image' => ''),
				'ENEMY' => array('name' => 'text_search_terms_room_search_enemy',  'value' => 'enemy', 'image' => ''),
				'COLLEAGUE' => array('name' => 'text_search_terms_room_search_colleague',  'value' => 'colleague', 'image' => ''),
				'FANS' => array('name' => 'text_search_terms_room_search_fans',  'value' => 'fans', 'image' => ''),
				'STUDENT' => array('name' => 'text_search_terms_room_search_student',  'value' => 'student', 'image' => ''),
				'OFFICIAL' => array('name' => 'text_search_terms_room_search_official',  'value' => 'official', 'image' => ''),
			),
			"ACCESS" => array(
				'PRIVATE' => array('name' => 'text_search_terms_room_search_private',  'value' => 'private', 'image' => ''),
				'PUBLIC' => array('name' => 'text_search_terms_room_search_public',  'value' => 'public', 'image' => ''),
			)
		);
		return( $searchTerms );
	}

	/**
	 * List of zipCode for contry FRANCE
	 * @return array zipcode[index] = array('0' => zipcode, '1' => inseecode)
	 */
	static function zipCode() {
		$cacheKey = 'zipCodeList';
		$zipCode = array();
		$cachedZipCode =  sfMemcache::getInstance()->get($cacheKey, array());
		if(empty($cachedZipCode)) {
			
			$file = sfConfig::get('sf_app_module_dir').Data::PATH_ACCOUNT_DATA."/communes.csv";
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
			// Save to memcache
			sfMemcache::getInstance()->set($cacheKey, $zipCode);
		} else {
			$zipCode = $cachedZipCode;
		}

		return $zipCode;
	}

	/**
	 * List of cities in FRANCE
	 * @return array:
	 */
	static function cities() {
		$cacheKey = 'cityList';
		$cities = array();

		$cachedCities =  sfMemcache::getInstance()->get($cacheKey, array());
		if(empty($cachedCities)) {

			$file = sfConfig::get('sf_app_module_dir').Data::PATH_ACCOUNT_DATA."/comsimp2011.csv";
			$handle = fopen($file, 'r') or die("Cannot open ".$file);

			$i=0;
			while($line=fgetcsv($handle,filesize($file), ';', '"'))
			{
				//Escape the first line
				if($i != 0) {
					$cities[$i-1] = array(
						'department' => $line[3],
						'inseecom' => $line[4],
						'name' => $line[9]
					);
				}
				$i++;
			}
			fclose($handle);

			// Save to memcache
			sfMemcache::getInstance()->set($cacheKey, $cities);
		} else {
			$cities = $cachedCities;
		}

		return $cities;
	}

	/**
	 * List of department for country FRANCE
	 * @return array:
	 */
	static function departments() {
		$cacheKey = 'departmentList';
		$departments = array();

		$cachedDepartments =  sfMemcache::getInstance()->get($cacheKey, array());
		if(empty($cachedDepartments)) {
			$file = sfConfig::get('sf_app_module_dir').Data::PATH_ACCOUNT_DATA."/depts2011.csv";
			$handle = fopen($file, 'r') or die("Cannot open ".$file);

			$i=0;
			while($line=fgetcsv($handle,filesize($file), ';', '"'))
			{
				//Escape the first line
				if($i != 0) {
					$departments[$line[1]] = $line[4];
				}
				$i++;
			}
			fclose($handle);

			// Save to memcache
			sfMemcache::getInstance()->set($cacheKey, $departments);
		} else {
			$departments = $cachedDepartments;
		}

		asort($departments);

		return $departments;
	}

	/**
	 * List of country
	 * @return array
	 */
	static function ISOCountries() {
		$cacheKey = 'ISOCountriesList';
		$countries = array();

		$cachedISOCountries =  sfMemcache::getInstance()->get($cacheKey, array());
		if(empty($cachedISOCountries)) {
			//5, 8
			$file = sfConfig::get('sf_app_module_dir').Data::PATH_ACCOUNT_DATA."/pays2011.csv";
			$handle = fopen($file, 'r') or die("Cannot open ".$file);

			$i=0;
			while($line=fgetcsv($handle,filesize($file), ';', '"'))
			{
				//Escape the first line
				if($i != 0) {
					$countries[$line[8]] = $line[5];
				}
				$i++;
			}
			fclose($handle);

			// Save to memcache
			sfMemcache::getInstance()->set($cacheKey, $countries);
		} else {
			$countries = $cachedISOCountries;
		}

		asort($countries);

		return $countries;
	}

	static function citiesZipcodeMerged() {

		$cacheKey = 'cities_zipcode_list';
        $citiesZipcode =  sfMemcache::getInstance()->get($cacheKey, array());
		if(empty($citiesZipcode)) {

			$file = sfConfig::get('sf_app_module_dir').Data::PATH_ACCOUNT_DATA."/mergedCitiesZipCode.csv";
			$handle = fopen($file, 'r') or die("Cannot open ".$file);

			$i=0;
			while($line=fgetcsv($handle,filesize($file), ';', '"'))
			{
				$citiesZipcode[$i] = array(
					'name' => $line[0],
					'departmentId' => $line[1],
					'departmentName' => $line[2],
					'zipcode' => $line[3],
					'inseecode' => $line[4]
				);
				$i++;
			}
			fclose($handle);

			// Save to memcache
            if(!empty($citiesZipcode)) {
			    sfMemcache::getInstance()->set($cacheKey, $citiesZipcode, 0, 0);
            }
		}

		return $citiesZipcode;
	}

	/**
	 * Search by enter city name function to find matching city list and matching departments
	 * @param string $cityName
	 * @return array $matching
	 */
	static function searchByCityName($cityName) {

		$matching = array();
		$citiesZipcode = Data::citiesZipcodeMerged();
        $cleanCityName = preg_replace(array('# #', "#^-?.'#", '#\(.*\)?#', '#-$#'), array('-', "", "", "", "", ""), $cityName);
        $formatedCityName = Data::remove_accents($cleanCityName);

		$i=0;
		foreach($citiesZipcode as $city) {
			if(preg_match("#^".$formatedCityName.".*$#Umi", $city['name'])) {
				$matching[$i]['name'] = $city['name'];
				$matching[$i]['departmentId'] = $city['departmentId'];
				$matching[$i]['departmentName'] = $city['departmentName'];
				$matching[$i]['zipcode'] = $city['zipcode'];
				$matching[$i]['inseecode'] = $city['inseecode'];
				$i++;
			}
		}

		return $matching;
	}

	static function remove_accents($str, $charset='utf-8')
	{
	    $str = htmlentities($str, ENT_NOQUOTES, $charset);

	    $str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
	    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // for ligatures '&oelig;'
	    $str = preg_replace('#&[^;]+;#', '', $str); // delete other caracters

	    return $str;
	}

	static function ribLimit() {

		$ribLimit = array();

		$ribLimit["1000"] = '1000';
		$ribLimit["500"] = '500';
		$ribLimit["200"] = '200';
		$ribLimit["100"] = '100';
		$ribLimit["1"] = 'Autre montant';

		return($ribLimit);

	}

	static function getPreselectedCBAmount() {

		$amountLimit = array();

		$amountLimit["10"] = '10 €';
		$amountLimit["20"] = '20 €';
		$amountLimit["30"] = '30 €';
		$amountLimit["50"] = '50 €';
		$amountLimit["1"] = 'Autre montant';

		return($amountLimit);

	}

}