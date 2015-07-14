<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		$this->sess->check_session(array('close' => true,'tipo' => 'admin'));
		
		$this->cskw = 'usuário';
		$this->ckw = 'usuários';
		$this->kw = 'usuarios';
		$this->artigo = 'o';
		$this->um = 'um';
		$this->nenhum = 'nenhum';
		
		$this->load->model(ucfirst($this->kw).'_adm_model','obj');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','<br>');
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function home($filtros = null) {
		//busca
		$vars = parse_query($filtros);
		$this->args = $vars;

		if(!isset($vars['nome'])) $vars['nome'] = null;
		
		$this->data['busca'] = $vars;
		//end busca
		
		$this->template['crud_home'] = "backend/$this->kw/home";
		parent::home();
	}
	
	function _formsetup() {		
		$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('login', 'Login', 'trim|required|alpha_dash|callback__check+login');
		$this->form_validation->set_rules('senha', 'Senha', 'trim|required');
		$this->form_validation->set_rules('senhaconf', 'Confirmação de Senha', 'trim|required|matches[senha]');
		//$this->form_validation->set_rules('ativo', 'Ativo', 'required');
		
		if($this->acao == 'alterar') {
			$this->form_validation->set_value_default('nome',$this->object->nome);
			$this->form_validation->set_value_default('login',$this->object->login);
			//$this->form_validation->set_value_default('ativo',$this->object->ativo);
		}
	}

	function filtros() {
		$queryarr = array();

		$queryarr['nome'] = $this->input->post('nome');
		
		$querystr = build_query($queryarr);
		
		redirect("admin/$this->kw/home/$querystr");
	}

	function _check_login($str) {
		if($this->obj->check_duplicates(array('field' => 'login','table' => 'adm','str' => $str))) {
			if($this->acao == 'alterar') {
				$usuario = $this->obj->get_by_id($this->object->id);
				if($usuario->login == $str) {
					//apenas estamos alterando o mesmo usuário, portanto não tem problema
					return true;
				}
			} else {
				$this->form_validation->set_message('_check_login','Já existe um usuário com este Login.');
				return false;
			}
		} else {
			return true;
		}
		
		return true;
	}
	
}

?>