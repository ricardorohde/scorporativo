<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this->sess->check_session(array('close' => true,'tipo' => 'admin'));

		$this->cskw = 'cliente';
		$this->ckw = 'clientes';
		$this->kw = 'clientes';
		$this->artigo = 'o';
		$this->um = 'um';
		$this->nenhum = 'nenhum';

        $this->load->model(ucfirst($this->kw).'_model','obj');
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
		$this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|required|callback__check_email');
		if($this->acao == 'novo') {
			$this->form_validation->set_rules('senha', 'Senha', 'trim|required');
			$this->form_validation->set_rules('senha_conf', 'Confirmação de senha', 'trim|required|matches[senha]');
		} else {
			$this->form_validation->set_rules('senha', 'Senha', 'trim');
			$this->form_validation->set_rules('senha_conf', 'Confirmação de senha', 'trim|matches[senha]');
		}
		$this->form_validation->set_rules('ativo', 'ativo', 'required');
	}

	function _form_set_defaults() {
		$this->form_validation->set_value_default('nome',$this->item->nome);
		$this->form_validation->set_value_default('email',$this->item->email);
		$this->form_validation->set_value_default('ativo',$this->item->ativo);
	}

	function filtros() {
		$queryarr = array();

		$queryarr['nome'] = $this->input->post('nome');

		$querystr = build_query($queryarr);

		redirect("admin/$this->kw/home/$querystr");
	}

	function _check_email($str) {
		if($this->obj->check_duplicates(array('field' => 'email','table' => 'usuarios','str' => $str))) {
			if($this->acao == 'alterar') {
				$usuario = $this->obj->get_by_id($this->item->id);
				if($usuario->email == $str) {
					//apenas estamos alterando o mesmo usuário, portanto não tem problema
					return true;
				}
			} else {
				$this->form_validation->set_message('_check_email','Já existe um usuário com este E-mail.');
				return false;
			}
		} else {
			return true;
		}
		
		return true;
	}

}

?>
