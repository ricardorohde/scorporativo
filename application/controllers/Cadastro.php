<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cadastro extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index() {

		$this->load->model('session_model','sess');
		//se a pessoa já está logada, passar para a parte de minha conta
		if($this->sess->check_session(array('close' => false, 'tipo' => 'cliente'))) {
			redirect('minha_conta');
			return;
		}

		$this->acao = 'novo';
		$data['acao'] = $this->acao;
		$this->load->model('clientes_model','cli');

		$this->load->library('form_validation','','val');
		$this->val->set_error_delimiters('','<br>');		

		$this->val->set_rules('nome', 'Nome', 'trim|required|max_length[250]');
		$this->val->set_rules('email', 'E-mail', 'trim|required|valid_email|max_length[250]|callback__checkemail');
		$this->val->set_rules('emailconf', 'Confirmação de E-mail', 'required|matches[email]|max_length[250]');
		$this->val->set_rules('senha', 'Senha', 'trim|required|min_length[4]|max_length[250]');
		$this->val->set_rules('senhaconf', 'Confirmação de Senha', 'required|matches[senha]|max_length[250]');
		$this->val->set_rules('naopreencher', 'Spam', '');

		if($this->val->run()) {
			$spam = $this->input->post('naopreencher');
			if($spam) {
				echo "spam";
				return false;
			}

			if($this->cli->add()) {
				$email = $this->input->post('email');
				//faz login do cliente
				$this->load->model('auth_model','auth');
				$this->auth->doLogin(array('tipo' => 'cliente', 'user' => $email, 'redirect' => false));

				redirect('cadastro/sucesso');
			} else {
				redirect('cadastro/falha');
			}
			
			return;
		} else {
			$data['metadesc'] = "Cadastre-se";
			$this->_set_title("Cadastre-se");
		}

		$this->_render('frontend/cadastro/cadastro', $data);
	}

	function sucesso() {
		$this->_set_title('Cadastre-se');
		$this->_render('frontend/cadastro/sucesso');
	}
	
	function falha() {
		$this->_set_title('Cadastre-se');
		$this->_render('frontend/cadastro/falha');
	}

	function _checkemail($str) {
		if($this->cli->check_duplicates(array('field' => 'email','table' => 'usuarios','str' => $str))) {
			if($this->acao == 'alterar') {
				$usuario = $this->cli->get_by_id($this->object->id);
				if($usuario->email == $str) {
					//apenas estamos alterando o mesmo usuário, portanto não tem problema
					return true;
				}
			} else {
				$linklogin = site_url('sessoes/login');
				$this->val->set_message('_checkemail','Já existe um usuário com este E-mail. Caso já tenha cadastro no site, <a href="'.$linklogin.'">faça o login aqui</a>.');
				return false;
			}
		} else {
			return true;
		}
		
		return true;
	}

}

?>