<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Minha_conta extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('Session_model','sess');
		$this->sess->checkSession(array('close' => true,'level' => 'cliente'));
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index() {
		redirect('minha_conta/home');
	}

	function home() {
		$userid = $this->session->userdata('id');

		$this->load->model('clientes_model','cli');
		$data['cliente'] = $this->cli->getById($userid);

		$data['msg'] = $this->session->userdata('msg');
		$this->session->unset_userdata('msg');
		
		$this->_settitle("Minha Conta");

		$this->_render('frontend/minha_conta/home',$data);
	}

	function cadastro() {
		$cliid = $this->session->userdata('id');

		$this->acao = 'alterar';
		$data['acao'] = $this->acao;
		$this->load->model('clientes_model','cli');

		$cliente = $this->cli->getById($cliid);

		$this->load->library('form_validation','','val');
		$this->val->set_error_delimiters('','<br>');		

		$this->val->set_rules('nome', 'Nome', 'trim|required|max_length[250]');
		$this->val->set_rules('email', 'E-mail', 'trim|required|valid_email|max_length[250]|callback__checkemail');
		$this->val->set_rules('senha', 'Senha', 'trim|min_length[4]|max_length[250]');
		$this->val->set_rules('senhaconf', 'Confirmação de Senha', 'matches[senha]|max_length[250]');

		//repopulação
		$this->val->set_value_default('nome',$cliente->nome);
		$this->val->set_value_default('email',$cliente->email);

		if($this->val->run()) {
			if($this->cli->upt($cliid)) {
				$this->session->set_userdata('msg', 'Cadastro alterado com sucesso.');
			} else {
				$this->session->set_userdata('msg', 'Erro ao alterar o cadastro. Por favor, contate-nos para que possamos resolver o problema.');
			}

			redirect('minha_conta');			
			return;
		} else {
			$data['metadesc'] = "Cadastre-se";
			$this->_settitle("Alterar Cadastro");
		}

		$this->_render('frontend/minha_conta/cadastro', $data);
	}

}

?>