<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Erro extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index() {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		
		if($this->uri->segment(1) == 'admin') {
			$this->_render('backend/erro',array());
		} else {
			$this->_render('frontend/erro',array());
		}
	}
}

?>