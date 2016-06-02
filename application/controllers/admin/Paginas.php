<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paginas extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this->sess->check_session('admin');

		$this->cskw = 'página';
		$this->ckw = 'páginas';
		$this->kw = 'paginas';
		$this->artigo = 'a';
		$this->um = 'uma';
		$this->nenhum = 'nenhuma';

		$this->load->model(ucfirst($this->kw).'_model','obj');
	}

	function home($filtros = null) {
		//busca
		$this->data['filtros'] = $filtros;

		$vars = parse_query($filtros);
		$this->args = $vars;

		if(!isset($vars['menu'])) $vars['menu'] = null;

		$this->data['busca'] = $vars;
		$this->args['parents'] = 1;
		//end busca

		$this->template['crud_home'] = "backend/$this->kw/home";
		parent::home();
	}

	function _form_set_rules() {
		$this->data['paginas']	 = $this->obj->get_all();
		$this->data['footer_files'][] = 'backend/includes/tinymce_js';
		
		$this->form_validation->set_rules('mae', 'Página mãe', 'trim');
		$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('editavel', 'Editável', 'trim');
		$this->form_validation->set_rules('menu', 'Menu', 'trim');
		$this->form_validation->set_rules('submenu', 'Submenu', 'trim');
		$this->form_validation->set_rules('codigo', 'Código', 'trim|required');
		$this->form_validation->set_rules('titulo', 'Título', 'trim|required');
		$this->form_validation->set_rules('texto', 'Texto', 'trim');
		$this->form_validation->set_rules('ativo', 'Ativa', 'required');		
	}

	function _form_set_defaults() {
		$this->form_validation->set_value_default('mae',$this->item->mae);
		$this->form_validation->set_value_default('nome',$this->item->nome);
		$this->form_validation->set_value_default('editavel',$this->item->editavel);
		$this->form_validation->set_value_default('menu',$this->item->menu);
		$this->form_validation->set_value_default('submenu',$this->item->submenu);
		$this->form_validation->set_value_default('codigo',$this->item->codigo);
		$this->form_validation->set_value_default('titulo',$this->item->titulo);
		$this->form_validation->set_value_default('texto',$this->item->texto);
		$this->form_validation->set_value_default('ativo',$this->item->ativo);
	}

	function filtros() {
		$queryarr = array();

		$queryarr['menu'] = $this->input->post('menu');

		$querystr = build_query($queryarr);

		redirect("admin/$this->kw/home/$querystr");
	}
}

?>
