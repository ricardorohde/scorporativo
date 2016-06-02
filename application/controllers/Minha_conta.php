<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Minha_conta extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->sess->check_session();

		$sessoes = $this->session->userdata('sessoes');
		$this->sessao_dados = $sessoes['cliente'];
	}
	
	function index() {
		redirect('minha_conta/home');
	}

	function home() {
		$usuario_id = $this->sessao_dados['id'];

		$this->load->model('clientes_model','cli');
		$data['cliente'] = $this->cli->get_by_id($usuario_id);

		$data['msg'] = $this->sess->get_msg();
		
		$this->_set_title("Minha Conta");

		$this->_render('frontend/minha_conta/home',$data);
	}

	function cadastro() {
		$cliente_id = $this->sessao_dados['rel_id'];

		$this->acao = 'alterar';
		$data['acao'] = $this->acao;
		$this->load->model('clientes_model','cli');

		$cliente = $this->cli->get_by_id($cliente_id);

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','<br>');

		$this->form_validation->set_rules('nome', 'Nome', 'trim|required|max_length[250]');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|max_length[250]|callback__checkemail');
		$this->form_validation->set_rules('senha', 'Senha', 'trim|min_length[4]|max_length[250]');
		$this->form_validation->set_rules('senhaconf', 'Confirmação de Senha', 'matches[senha]|max_length[250]');

		if($this->form_validation->run()) {
			if($this->cli->upt($cliente_id)) {
				$this->sess->set_msg('Cadastro alterado com sucesso.');
			} else {
				$this->sess->set_msg('Erro ao alterar o cadastro. Por favor, contate-nos para que possamos resolver o problema.');
			}

			redirect('minha_conta');			
			return;
		}

		// repopulação
		$this->form_validation->set_value_default('nome',$cliente->nome);
		$this->form_validation->set_value_default('email',$cliente->email);

		$data['meta_desc'] = "Cadastre-se";
		$this->_set_title("Alterar Cadastro");

		$this->_render('frontend/minha_conta/cadastro', $data);
	}

}

?>