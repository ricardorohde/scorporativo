<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct() {
		parent::__construct();

		//$sdata = $this->session->all_userdata();
		//die(print_r($sdata));

		$this->sess->check_session(array('close' => true,'tipo' => 'admin'));
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index() {
		$this->_set_title("Home");
		$this->_render('backend/home');
	}
}

?>