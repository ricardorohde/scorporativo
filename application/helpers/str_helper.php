<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function simplify($str, $nospaces = false, $limit = 0) {
	//$str = utf8_decode($str);
	//echo $str . '<br>';

	if($nospaces) {
		$str = str_replace(' ','',$str);
	}
	//echo $str . '<br>';

	$str = mb_strtolower($str);
	//echo $str . '<br>';

	if($limit > 0) {
		$str = substr($str,0,$limit);
	}
	//echo $str . '<br>';

	$replacement = array('á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
						 'â' => 'a', 'ê' => 'e', 'î' => 'i', 'ô' => 'o', 'û' => 'u',
						 'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o', 'ü' => 'u',
						 'ã' => 'a', 'õ' => 'o',
						 'ç' => 'c');
	foreach($replacement as $i=>$u) {
        $str = mb_eregi_replace($i,$u,$str);
    }

	return $str;
}

function remove_pronouns($str, $nospaces = false) {
	$str = str_replace(' de ',' ',$str);
	$str = str_replace(' do ',' ',$str);
	$str = str_replace(' dos ',' ',$str);
	$str = str_replace(' das ',' ',$str);
	$str = str_replace(' para ',' ',$str);
	$str = str_replace(' em ',' ',$str);
	$str = str_replace(' com ',' ',$str);

	if($nospaces) {
		$str = str_replace(' ','',$str);
	}

	return $str;
}

function like_str($str) {
	if(empty($str)) {
		return false;
	}

	$searchstr = '';

	$skw = addslashes(removepronouns(simplify($str,false,60)));
	$skw = utf8_encode($skw);

	//print "SKW: $skw <br />";

	if(strpos($str,' ')) {
		$akw = explode(' ',$skw);
		$searchstr = array();

		foreach($akw as $value) {
			$value = trim($value);
			if(empty($value)) {
				continue;
			}
			//$value = treatplurals($value)
			$searchstr[] = $value . '%';
		}

		$searchstr = '%' . implode('',$searchstr);

	} else {
		//$skw = treatplurals($skw);
		$searchstr = '%' . $skw . '%';
	}

	return $searchstr;
}

function lc($str) {
	return mb_convert_case($str, MB_CASE_LOWER);
}

function tc($str) {
	return mb_convert_case($str, MB_CASE_TITLE);
}

function uc($str) {
	return mb_convert_case($str, MB_CASE_UPPER);
}

/* End of file str_helper.php */
/* Location: ./system/application/helpers/str_helper.php */
