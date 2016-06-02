<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slideshow extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this->sess->check_session('admin');

		$this->cskw = 'slide';
		$this->ckw = 'slides';
		$this->kw = 'slideshow';
		$this->artigo = 'o';
		$this->um = 'um';
		$this->nenhum = 'nenhum';

		$this->load->model(ucfirst($this->kw).'_model','obj');
	}

	function index() {
		redirect("admin/$this->kw/imagens");
	}

	function home() {
		redirect("admin/$this->kw/imagens");
	}

	function imagens($id = null) {
		$this->template['crud_imagens_home'] = "backend/$this->kw/home";
		$this->data['tipo'] = 'imagens';

		parent::imagens();
	}

	function gerenciar_imagem($acao = 'novo', $item_id = 0, $foto_id = null) {
		$this->template['crud_imagens_form'] = "backend/$this->kw/form";

		parent::gerenciar_imagem($acao,$item_id,$foto_id);
	}
}

?>
