<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Paginas extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		$this->sess->check_session(array('close' => true,'tipo' => 'admin'));
		
		$this->cskw = 'página';
		$this->ckw = 'páginas';
		$this->kw = 'paginas';
		$this->artigo = 'a';
		$this->um = 'uma';
		$this->nenhum = 'nenhuma';
		
		$this->load->model(ucfirst($this->kw).'_model','obj');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','<br>');
		
		//$this->output->enable_profiler(TRUE);
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
	
	function _formsetup() {
		$this->data['paginas']	 = $this->obj->get_all();
		$this->data['footerfiles'][] = 'backend/includes/tinymce_js';
		
		$this->form_validation->set_rules('mae', 'Página mãe', 'trim');
		$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('editavel', 'Editável', 'trim');
		$this->form_validation->set_rules('menu', 'Menu', 'trim');
		$this->form_validation->set_rules('submenu', 'Submenu', 'trim');
		$this->form_validation->set_rules('codigo', 'Código', 'trim|required');
		$this->form_validation->set_rules('titulo', 'Título', 'trim|required');
		$this->form_validation->set_rules('texto', 'Texto', 'trim');
		$this->form_validation->set_rules('ativo', 'Ativa', 'required');
		
		if($this->acao == 'alterar') {
			$this->form_validation->set_value_default('mae',$this->object->mae);
			$this->form_validation->set_value_default('nome',$this->object->nome);
			$this->form_validation->set_value_default('editavel',$this->object->editavel);
			$this->form_validation->set_value_default('menu',$this->object->menu);
			$this->form_validation->set_value_default('submenu',$this->object->submenu);
			$this->form_validation->set_value_default('codigo',$this->object->codigo);
			$this->form_validation->set_value_default('titulo',$this->object->titulo);
			$this->form_validation->set_value_default('texto',$this->object->texto);
			$this->form_validation->set_value_default('ativo',$this->object->ativo);
		}
	}

	function filtros() {
		$queryarr = array();

		$queryarr['menu'] = $this->input->post('menu');

		$querystr = build_query($queryarr);
		
		redirect("admin/$this->kw/home/$querystr");
	}
}

?>