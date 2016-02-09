<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct() {
		parent::__construct();

		//pr($this->session->userdata());
		//die();

		$this->sess->check_session(array('close' => true,'tipo' => 'admin'));
	}
	
	function index() {
		$this->_set_title("Home");
		$this->_render('backend/home');
	}
}

?>