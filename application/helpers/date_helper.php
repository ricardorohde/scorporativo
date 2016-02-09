<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_date_diff($date1, $date2, $format = 'days') {
	$diff = strtotime($date2) - strtotime($date1);
	$diff_days = round($diff/60/60/24);

	return $diff_days;
}

function get_weekday($timestamp = null) {
	if ($timestamp) {
		$str = date('l',$timestamp);
	} else {
		$str = date('l');
	}
	
	switch($str) {
		
		case "Monday":
		$str = "segunda-feira";
		break;
		
		case "Tuesday":
		$str = "terça-feira";
		break;
		
		case "Wednesday":
		$str = "quarta-feira";
		break;
		
		case "Thursday":
		$str = "quinta-feira";
		break;
		
		case "Friday":
		$str = "sexta-feira";
		break;
		
		case "Saturday":
		$str = "sábado";
		break;
		
		case "Sunday":
		$str = "domingo";
		break;
		
		default:
		return $str;
		break;
	
	}
	
	return $str;
}

function get_month($timestamp) {
	if($timestamp) {
		$str = date('F', $timestamp);
	} else {
		$str = date('F');
	}
	
	switch($str) {
		
		case "January":
		$str = "janeiro";
		break;
		
		case "February":
		$str = "fevereiro";
		break;
		
		case "March":
		$str = "março";
		break;
		
		case "April":
		$str = "abril";
		break;
		
		case "May":
		$str = "maio";
		break;
		
		case "June":
		$str = "junho";
		break;
		
		case "July":
		$str = "julho";
		break;
		
		case "August":
		$str = "agosto";
		break;
		
		case "September":
		$str = "setembro";
		break;
		
		case "October":
		$str = "outubro";
		break;
		
		case "November":
		$str = "novembro";
		break;
		
		case "December":
		$str = "dezembro";
		break;
		
		default:
		return $str;
		break;
	
	}
	
	return $str;
}

function get_short_month($timestamp) {
	if($timestamp) {
		$str = date('F',$timestamp);
	} else {
		$str = date('F');
	}
	
	switch($str) {
		
		case "January":
		$str = "jan";
		break;
		
		case "February":
		$str = "fev";
		break;
		
		case "March":
		$str = "mar";
		break;
		
		case "April":
		$str = "abr";
		break;
		
		case "May":
		$str = "mai";
		break;
		
		case "June":
		$str = "jun";
		break;
		
		case "July":
		$str = "jul";
		break;
		
		case "August":
		$str = "ago";
		break;
		
		case "September":
		$str = "set";
		break;
		
		case "October":
		$str = "out";
		break;
		
		case "November":
		$str = "nov";
		break;
		
		case "December":
		$str = "dez";
		break;
		
		default:
		return $str;
		break;
	
	}
	
	return $str;
}

function sql_to_date($datestr) {
	if(empty($datestr)) {
		return false;
	}
	$str = substr($datestr,0,10);
	$adate = array_reverse(explode('-',$str));
	$str = implode('/',$adate);
	
	return $str;
}

function sql_to_datetime($datestr) {
	if(empty($datestr)) {
		return false;
	}
	$str = date('d/m/Y H:i:s',strtotime($datestr));
	
	return $str;
}

function date_to_sql($datestr) {
	if(empty($datestr)) {
		return false;
	}
	$str = substr($datestr,0,10);
	$adate = array_reverse(explode('/',$str));
	$str = implode('-',$adate);
	
	return $str;
}

function date_to_sql2($datestr) {
	if(empty($datestr)) {
		return false;
	}
	$str = substr($datestr,0,10);
	$dia = substr($datestr,0,2);
	$mes = substr($datestr,2,2);
	$ano = substr($datestr,4);

	$str = "$ano-$mes-$dia";
	
	return $str;
}

/* End of file date_helper.php */
/* Location: ./application/helpers/date_helper.php */
