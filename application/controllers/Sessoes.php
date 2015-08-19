<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sessoes extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Auth','auth');
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index() {
		redirect('sessoes/login');
	}

	function login($redirect = null) {
		if($this->sess->check_session(array('close' => false, 'tipo' => 'cliente'))) {
			redirect('minha_conta');
			return;
		}

		$data = array();
		
		$this->load->library('form_validation','','val');
		$this->val->set_error_delimiters('','<br>');
		
		$this->val->set_rules('login','E-mail','trim|required|max_length[200]');
		$this->val->set_rules('senha','Senha','trim|required|max_length[200]');
		
		if ($this->val->run() == FALSE) {
			
		} else {
			if($this->auth->checkCredentials()) {
				$this->auth->doLogin(array('redirect' => $redirect));
				return true;
			} else {
				$data['erro'] = 'Usuário ou senha inválidos.';
			}
		}
		
		$this->_render('frontend/sessoes/login',$data);
	}
	
	function logout() {
		$this->sess->close(array('redirect' => false));
		
		$this->_render('frontend/sessoes/logout');
	}

	function recuperar_conta() {
		$this->load->library('form_validation','','val');
		$this->val->set_error_delimiters('','<br>');

		$this->val->set_rules('email', 'E-mail', 'trim|valid_email|required|callback__checkcadastro');

		if($this->val->run()) {
			$cdata['email'] = $email = $this->input->post('email');
			$data = date('Y-m-d');
			$salt = $this->config->item('static_salt');

			$key = sha1($data . $email . $salt);

			$cdata['link'] = site_url("sessoes/cadastrar_senha/$key");

			$emailparams = array('to' => $email
								//,'preview' => true
								,'subject' => "Recuperação de senha da sua conta"
								,'template' => "usuario_recupera_senha"
								,'cdata' => $cdata
								);
			$this->_sendmail($emailparams);

			redirect("sessoes/recuperar_conta_sucesso");
			
			return;	
		}

		$this->_render('frontend/sessoes/recuperar_conta');
	}

	function recuperar_conta_sucesso() {
		$this->_render('frontend/sessoes/recuperar_sucesso');
	}

	function recuperar_conta_falha() {
		$this->_render('frontend/sessoes/recuperar_falha');
	}

	function cadastrar_senha($key) {
		if(!$key) {
			redirect('cadastrar_senha_falha');
			return;
		}

		$this->load->library('form_validation','','val');
		$this->val->set_error_delimiters('','<br>');

		$this->val->set_rules('email', 'E-mail', 'trim|valid_email|required|callback__checkcadastro');
		$this->val->set_rules('senha', 'Senha', 'trim|required|minlength[4]');
		$this->val->set_rules('senhaconf', 'Confirmação de Senha', 'trim|required|matches[senha]|minlength[4]');

		if($this->val->run()) {
			$email = $this->input->post('email');
			$data = date('Y-m-d');
			$salt = $this->config->item('static_salt');

			$keyconf = sha1($data . $email . $salt);

			if($keyconf != $key) {
				redirect('cadastrar_senha_falha');
				return;
			}

			$this->load->model('clientes_model','cli');
			$cliente = $this->cli->getByEmail($email);

			if(!$cliente) {
				redirect('cadastrar_senha_falha');
				return;
			}

			$cdata['nome'] = $cliente->nome;
			$cdata['email'] = $email;

			//altera a senha
			if($this->cli->uptSenha($cliente->id)) {
				$emailparams = array('to' => $email
									//,'preview' => true
									,'subject' => "Recuperação de senha da sua conta"
									,'template' => "usuario_senha_alterada"
									,'cdata' => $cdata
									);
				$this->_sendmail($emailparams);

				redirect("sessoes/cadastrar_senha_sucesso");
			} else {
				redirect('cadastrar_senha_falha');
				return;	
			}
		}

		$this->_render('frontend/sessoes/cadastrar_senha');
	}

	function cadastrar_senha_sucesso() {
		$this->_render('frontend/sessoes/cadastrar_senha_sucesso');
	}

	function cadastrar_senha_falha() {
		$this->_render('frontend/sessoes/cadastrar_senha_falha');
	}

	function _checkcadastro($str) {
		$email = $str;
		$query = $this->db->query("SELECT id FROM {$this->_prefix}clientes WHERE email='$str'");
		if($query->num_rows() < 1) {
			$this->val->set_message('_checkcadastro','Não encontramos um cadastro com este e-mail. Entre em contato conosco para resolver este problema.');
			return false;
		} else {
			return true;
		}
	}
}

?>