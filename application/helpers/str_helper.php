<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function simplify($str, $nospaces = false, $limit = 0) {
	$str = utf8_decode($str);
	
	if($nospaces) {
		$str = str_replace(' ','',$str);
	}
	
	$str = strtolower($str);
	
	if($limit > 0) {
		$str = substr($str,0,$limit);
	}
	
	$comacentos = utf8_decode('áéíóúàèìòùâêîôûãõäëïöüçÃÇÉÍÓÕÁÂÊÔÚ');
	$semacentos = 'aeiouaeiouaeiouaoaeioucaciooaaeou';
	$str = strtr($str,$comacentos,$semacentos);	
	
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

/* End of file str_helper.php */
/* Location: ./system/application/helpers/str_helper.php */
