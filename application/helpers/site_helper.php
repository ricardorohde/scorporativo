<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function find_active($needle, $args = null) {
	$haystack = null;
	$only_class = false;

	if(is_array($args)) {
		extract($args);
	} else {
		$haystack = $args;
	}

	if(!$haystack) {
		if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO']) {
			$haystack = $_SERVER['PATH_INFO'];
		} else if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) {
			$haystack = $_SERVER['QUERY_STRING'];
		} else if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']) {
			$haystack = $_SERVER['REQUEST_URI'];
		} else {
			$haystack = $_SERVER['PHP_SELF'];
		}
	}

	//print $haystack;

	if(strstr($haystack,$needle)) {
		if($only_class) {
			return 'ativo';
		} else {
			return 'class="ativo"';
		}
	}
}

function build_query($queryarr = array()) {
	if(!is_array($queryarr)) {
		return '';
	}

	$querystr = '';
	$i = 1;
	foreach($queryarr as $key=>$row) {
		$querystr .= "$key|$row";
		if($i < count($queryarr)) {
			$querystr .= "|";
		}
	}

	return $querystr;
}

function parse_query($querystr = null) {
	if(!$querystr) {
		return array();
	}

	//resolve problema no chrome
	$querystr = limpa(urldecode($querystr));
	//print $querystr;

	$array = explode('|',$querystr);
	$count = count($array);

	if(!$array || $count == 1) {
		return array();
	}

	$result = array();
	for($i = 0; $i < $count; $i++) {
		if(isset($array[$i])) {
			$name = $array[$i];
		} else {
			$name = null;
		}
		if(isset($array[$i+1])) {
			$value = urldecode($array[$i+1]);
		} else {
			$value = null;
		}
		if($name == null || $value == null) {
			continue;
		}

		$result[$name] = $value;

		$i++;
	}
	//print_r($result);

	return $result;
}

function limpa($str, $args = array()) {
	$str = utf8_decode($str);

	$remove = array(',','/','?','.','\\','<','>','%',':',';');
	$str = str_replace($remove,'',$str);

	return $str;
}

// útil para debug simples
// ideia do César Kohl
function pr($str) {
	print "<pre>";
	print_r($str);
	print "</pre>";

	return;
}
