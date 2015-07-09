<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Session','sess');
		$this->sess->check_session(array('close' => true,'level' => 'admin'));
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index() {
		$this->_render('backend/home',$data);
	}
}

?>