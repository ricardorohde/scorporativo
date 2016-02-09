<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		$this->sess->check_session(array('close' => true,'tipo' => 'admin'));
		
		$this->cskw = 'categoria';
		$this->ckw = 'categorias';
		$this->kw = 'categorias';
		$this->artigo = 'a';
		$this->um = 'uma';
		$this->nenhum = 'nenhuma';
		
		$this->load->model(ucfirst($this->kw).'_model','obj');
	}
	
	function home($filtros = null) {
		//busca
		$vars = parse_query($filtros);

		if(!isset($vars['nivel'])) $vars['nivel'] = 'grupo';

		$this->args = $vars;
		$this->data['busca'] = $vars;
		//end busca

		$this->data['grupos'] = $this->obj->get_all(array('nivel' => 'grupo'));

		$this->template['crud_home'] = "backend/$this->kw/home";
		parent::home();
	}
	
	function _form_set_rules() {
		$this->data['grupos'] = $this->obj->get_all(array('nivel' => 'grupo'));
		$this->data['linhas'] = $this->obj->get_all(array('nivel' => 'linha'));
		$this->data['categorias'] = $this->obj->get_all(array('nivel' => 'categoria'));
		
		$nivel = $this->input->post('nivel');

		$this->form_validation->set_rules('nome', 'Nome', 'trim|required|min_length[2]|max_length[60]');
		$this->form_validation->set_rules('tipo', 'Tipo', 'required');
		$this->form_validation->set_rules('nivel', 'Nível', 'required');
		if($nivel != 'grupo') {
			$this->form_validation->set_rules('mae', 'Subcategoria de', 'numeric|required');	
		} else {
			$this->form_validation->set_rules('mae', 'Subcategoria de', 'numeric');
		}
		
		$this->form_validation->set_rules('ativo', 'Ativa?', 'numeric');
	}

	function _form_set_defaults() {
		$this->form_validation->set_value_default('nome',$this->item->nome);
		$this->form_validation->set_value_default('tipo',$this->item->tipo);
		$this->form_validation->set_value_default('nivel',$this->item->nivel);
		$this->form_validation->set_value_default('mae',$this->item->mae);
		$this->form_validation->set_value_default('ativo',$this->item->ativo);
	}

	function filtros() {
		$queryarr = array();

		$queryarr['mae'] = $this->input->post('mae');

		$querystr = build_query($queryarr);
		
		redirect("admin/$this->kw/home/$querystr");
	}
}

?>