<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->load->model('Slideshow_model','sli');
		$data['slides'] = $this->sli->get_imagens();
		
		$title = $this->config->item('site_title');
		
		$data['meta_desc'] = $title;
		$this->_set_title($title,array('complete' => false, 'invert' => true));
		
		$this->_render('frontend/home',$data);
	}

	function grid_test() {
		$this->_render('frontend/grid_test');
	}
	
}

?>