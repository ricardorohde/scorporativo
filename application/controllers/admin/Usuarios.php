<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this->sess->check_session('admin');

		$this->cskw = 'usuário';
		$this->ckw = 'usuários';
		$this->kw = 'usuarios';
		$this->artigo = 'o';
		$this->um = 'um';
		$this->nenhum = 'nenhum';

		$this->load->model(ucfirst($this->kw).'_adm_model','obj');
	}

	function home($filtros = null) {
		//busca
		$this->data['filtros'] = $filtros;
		
		$vars = parse_query($filtros);
		
		if(!isset($vars['nome'])) $vars['nome'] = null;

		$this->args = $vars;
		$this->data['busca'] = $vars;
		//end busca

		$this->template['crud_home'] = "backend/$this->kw/home";
		parent::home();
	}

	function _form_set_rules() {
		$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('login', 'Login', 'trim|required|alpha_dash|callback__check_login');
		$this->form_validation->set_rules('senha', 'Senha', 'trim|required');
		$this->form_validation->set_rules('senhaconf', 'Confirmação de Senha', 'trim|required|matches[senha]');
	}

	function _form_set_defaults() {
		$this->form_validation->set_value_default('nome',$this->item->nome);
		$this->form_validation->set_value_default('login',$this->item->login);
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
				$usuario = $this->obj->get_by_id($this->item->id);
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
