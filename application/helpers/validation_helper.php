<?php  defined('BASEPATH') OR exit('No direct script access allowed');

function check_select($db_value, $field_value) {
	if($db_value == $field_value) {
		return "selected";
	} else {
		return '';
	}
}

function check_checkbox($db_value, $field_value) {
	if($db_value == $field_value) {
		return "checked";
	} else {
		return '';
	}
}

function check_radio($db_value, $field_value) {
	if($db_value == $field_value) {
		return "checked";
	} else {
		return '';
	}
}

function is_valid_phone($telefone, $com_ddd = true) {
	$regTel = '/^(\(?0?[1-9][0-9]\)?)\s?-?[0-9]{4}\s?\-?\s?[0-9]{4}$/';

	if(preg_match($regTel,$telefone)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function is_valid_date($date) {
	$array = explode('/',$date);
	if(count($array) != 3) {
		return false;
	}
	if(!checkdate($array[1],$array[0],$array[2])) {
		return false;
	} else {
		return true;
	}
}

function is_valid_cpf($str) {
	if(empty($str) || strlen($str) != 11 || !is_numeric($str)) {
		return false;
	}

	$valido = false;

	$str = preg_replace("/[\.-]/", "", $str);

	for($i = 0; $i <= 9; $i++) {
		if($str == str_repeat($i , 11)) {
			$valido = false;
		}
	}

	if (strlen($str) != 11 || !is_numeric($str) || $str == "12345678909" ) {
		$valido = false;
	}

	$res = _soma(10, $str);
	$dig1 = _pega_digito($res);
	$res2 = _soma(11, $str.$dig1);
	$dig2 = _pega_digito($res2);

	if($str{9} != $dig1 || $str{10} != $dig2) {
		$valido = false;
	} else {
		$valido = true;
	}

	if (!$valido) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function _soma($num, $cpf) {
	$j = 0;
	$res = "";
	for($i = $num; $i >= 2; $i--){
		$res += ($i * $cpf{$j});
		$j++;
	}

	return $res;
}

function _pega_digito($res) {
	$dig = $res % 11;
	$dig = $dig < 2 ? $dig = 0 : $dig = 11 - $dig;
	return $dig;
}

function is_valid_cnpj($str) {
	$str = preg_replace( "@[./-]@", "", $str );

	if( strlen($str) <> 14 or !is_numeric($str)) {
		return false;
	}

	$k = 6;
	$soma1 = "";
	$soma2 = "";

	for($i = 0; $i < 13; $i++) {
		$k = $k == 1 ? 9 : $k;
		$soma2 += ( $str{$i} * $k );
		$k--;

		if($i < 12) {
			if($k == 1) {
				$k = 9;
				$soma1 += ( $str{$i} * $k );
				$k = 1;
			} else {
				$soma1 += ( $str{$i} * $k );
			}
		}
	}

	$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
	$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

	if($str{12} == $digito1 and $str{13} == $digito2) {
		return true;
	} else {
		return false;
	}
}

/* End of file validation_helper.php */
/* Location: ./system/application/helpers/validation_helper.php */
