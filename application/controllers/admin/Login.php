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
		$erro = '';

		$this->form_validation->set_rules('login','Login','trim|strtolower|required');
		$this->form_validation->set_rules('senha','Senha','trim|required');
		
		if($this->form_validation->run()) {
			$tipo = 'admin';

			if($this->auth->check_credentials($tipo)) {
				$this->auth->do_login(array('tipo' => $tipo, 'redirect' => $redirect));
				return true;
			} else {
				$erro = 'Usuário ou senha inválidos.';
			}
		} else {
			if($this->sess->check_session('admin', array('close' => false))) {
				redirect('admin/home');
				return;
			}
		}

		$data['erro'] = $erro;
		$data['msg'] = $this->sess->get_msg();
		
		$this->_render('backend/login',$data);
	}
	
	function logout() {
		//$this->session->sess_destroy();
		$this->sess->close('admin', array('redirect' => false));
		redirect("admin/login/logout_pag");
	}

	function logout_pag() {
		$this->_render('backend/logout');
	}
}

?>