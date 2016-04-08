<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this->sess->check_session(array('close' => true,'tipo' => 'admin'));

		$this->cskw = 'produto';
		$this->ckw = 'produtos';
		$this->kw = 'produtos';
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
	}

	function detalhes($id = null, $pag = null) {
		if(!$pag) {
			redirect("admin/$this->kw/detalhes/$id/dados_gerais");
			return;
		}

		$data['item'] = $pagdata['item'] = $item = $this->obj->get_by_id($id);
		if(!$item) {
			$this->_go_home();
			return;
		}

		$data['redirect'] = $this->_get_redirect();

		if($pag == 'dados_gerais') {
			$this->data['footer_files'] = array('backend/includes/tinymce_js');
		} else if($pag == 'categorias') {
			$this->load->model('categorias_model','cat');
			$pagdata['grupos'] = $this->cat->get_all(array('nivel' => 'grupo', 'tipo' => $this->kw));

			//lógica javascript
			$data['footer_files'][] = "backend/includes/categorias_js";

			//repopulação de dados
			$pagdata['produto_categorias'] = $this->obj->get_categorias(array('produto' => $item->id, 'as_array' => true));
		}

		$data['msg'] = $this->sess->get_msg();

		$data['pag'] = $this->load->view("backend/$this->kw/$pag",$pagdata,true);

		$this->_render("backend/$this->kw/detalhes",$data);
	}

	function filtros() {
		$queryarr = array();

		$queryarr['nome'] = $this->input->post('nome');

		$querystr = build_query($queryarr);

		redirect("admin/$this->kw/home/$querystr");
	}

}

?>
