<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gera_senha extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index($senha = null) {
		//die();
		
		if($senha == null) {
			$senha = substr(md5(microtime()),0,8);
		}
		
		$salt = $this->config->item('static_salt');
		$dynamic = microtime();
		
		echo "Senha: $senha <br />";
		echo "Senha encriptada: " . sha1($dynamic . $senha . $salt);
		echo '<br />';
		echo "salt dinamico: " . $dynamic;
	}
}

?>