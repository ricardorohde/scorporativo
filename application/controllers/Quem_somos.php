<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quem_somos extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$cod = $this->uri->segment(1,'home');
		
		$this->load->model('Paginas_model','pag');
		$data['pagina'] = $pagina = $this->pag->get_by_cod($cod);
		
		$title = $this->config->item('site_title');
		
		$data['metadesc'] = "$pagina->titulo - $title";
		$this->_set_title($pagina->titulo);
		
		$this->_render("frontend/$cod",$data);
	}
	
}

?>