<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userlog extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->sess->check_session('admin');
		
		$this->cskw = 'usuário';
		$this->ckw = 'usuários';
		$this->kw = 'userlog';
		$this->artigo = 'o';
		$this->um = 'um';
		$this->nenhum = 'nenhum';
		
		$this->load->model(ucfirst($this->kw).'_model','obj');
	}
	
	function home() {
		$this->template['crud_home'] = "backend/$this->kw/home";
		
		parent::home();
	}
	
}

?>