<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Auth_model','auth');
		$this->load->library('Form_validation');

		//pr($this->session->userdata());
	}
	
	function index($redirect = null) {
		$this->form_validation->set_rules('login','Login','trim|strtolower|required');
		$this->form_validation->set_rules('senha','Senha','trim|required');
		
		if($this->form_validation->run()) {
			$tipo = 'admin';

			if($this->auth->check_credentials($tipo)) {
				$this->auth->do_login(array('tipo' => $tipo, 'redirect' => $redirect));
				return true;
			} else {
				$data['erro'] = 'Usuário ou senha inválidos.';
			}
		} else {
			if($this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
				redirect('admin/home');
				return;
			}
		}
		
		$data['msg'] = $this->sess->get_msg();
		
		$this->_render('backend/login',$data);
	}
	
	function logout() {
		$this->sess->close(array('redirect' => false));
		
		$this->_render('backend/logout');
	}
}

?>