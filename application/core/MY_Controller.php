<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
    function __construct()
    {
		parent::__construct();
		$this->data = array();
		$this->site_lang = 'pt';

		//Meta Defaults
		$this->data['meta_desc'] = '';
		$this->data['meta_robots'] = 'index, follow';
		$this->data['meta_lang'] = 'pt-BR';
		$this->data['site_lang'] = $this->site_lang;

		//Other Defaults
		$this->data['head_files'] = array();
		$this->data['footer_files'] = array();
		$this->data['head_code'] = '';
		$this->data['footer_code'] = '';
		$this->_prefix = $this->config->item('_prefix');
		
		//Título padrão
		$this->data['site_title'] = $this->config->item('site_title');
		
		if($this->session->userdata('logged') && $this->session->userdata('level') == 'admin') {
			//ADM defaults
			$this->template = array();
			$this->template['crud_home'] = 'templates/backend/crud_home';
			$this->template['crud_form'] = 'templates/backend/crud_form';
			$this->template['crud_imagens_home'] = 'templates/backend/crud_imagens_home';
			$this->template['crud_imagens_form'] = 'templates/backend/crud_imagens_form';
			
			$this->args = array();
		}
    }
	
	function _set_title($value, $args = array()) {
		$complete = true;
		
		extract($args);

		$title = $value;
		if(isset($complete) && $complete == true) {
			if(isset($inverse) && $inverse == true) {
				$title = $this->config->item('site_title') . ' &ndash; ' . $title;
			} else {
				$title .= ' &ndash; ' . $this->config->item('site_title');
			}
		}

		$this->data['site_title'] = $title;
	}
	
	function _render($page = null, $data = array(), $template = null) {
		if($this->uri->segment(1) != 'admin') {
			//pegamos as seções
			$this->load->model('Paginas','pag');
			$this->data['secoesmenu'] = $this->pag->get_all(array('ativo' => 1, 'menu' => 1));
			
			$this->data['rodapeesq'] = $this->pag->get_by_cod('rodapeesq');
			$this->data['rodapedir'] = $this->pag->get_by_cod('rodapedir');
			//fim
		}
		
		$this->data = array_merge($this->data,$data);
		
		$barpos = strpos($page,'/');
		$keyword = substr($page,0,$barpos);
		
		$this->data['rendered_page'] = $this->load->view($page,$this->data,true);
		
		if($template == null) {
			$template = $keyword;
		}
		if($template == 'templates') {
			$template = 'backend';
		}
		
		$this->load->view('templates/'.$template, $this->data);
	}
	
	function _set_pagination($total_rows, $per_page = 20) {
		$this->load->library('pagination');
		
		$asegs = $this->uri->segment_array();

		$uri = '';
		foreach($asegs as $seg) {
			if(strstr($seg,'p-')) {
				continue;
			}
			$uri .= $seg.'/';
		}
		
		$config['base_url'] = site_url() .'/'. $uri;
		$config['total_rows'] = $total_rows;
		$config['uri_segment'] = $this->uri->total_segments();
		$config['per_page'] = $per_page;
		
		return $config;
	}
	
	//páginas ADM
	
	function index() {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}
		
		redirect('admin/'.$this->kw.'/home');
	}
	
	function home() {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}
		
		$data['entries'] = $this->obj->getAll($this->args);
		$data['current'] = $this->obj->current;
		$data['perpage'] = $this->obj->perpage;
		
		if(isset($this->obj->totalrows)) {		
			$config = $this->_setpagination($this->obj->totalrows, $this->obj->perpage);
			$this->pagination->initialize($config);
		}
		
		$data['totalrows'] = $this->obj->totalrows;
		$data['msg'] = $this->session->userdata('msg');		
		$this->session->unset_userdata('msg');
		
		$this->_render($this->template['crud_home'],$data);
	}
	
	function gerenciar($acao = 'novo',$id = null) {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}
		
		if($acao != 'novo' && $acao != 'alterar') {
			$this->_gohome();
			return false;
		}
		
		if($acao == 'alterar' && ($id == null || !is_numeric($id))) {
			$this->session->set_userdata('msg', 'Id d'.$this->artigo.' '.$this->cskw.' inválida.');
			$this->_gohome();
			return false;
		}
		
		if($acao == 'alterar') {
			$this->itemId = $id;
			$this->object = $this->obj->getById($id);
		}
		
		$this->acao = $acao;
		
		$this->_formsetup();
		
		$data['redirect'] = $this->_getredirect();
		
		if ($this->val->run() == FALSE) {
			$data['msg'] = $this->session->userdata('msg');
			$this->session->unset_userdata('msg');
			
			$data['acao'] = $this->acao;
			$data['id'] = $id;
			$this->_render($this->template['crud_form'],$data);
		} else {
			$this->load->model('upload_model','up');
			$this->load->model('imagens_model','img');
			
			$adata = array();
			
			if($acao == 'novo') {
				if($id = $this->obj->add_adm($adata)) {
					$this->session->set_userdata('msg', ucfirst($this->cskw).' cadastrad'.$this->artigo.' com sucesso!');
				} else {
					$this->session->set_userdata('msg', 'Erro ao cadastrar '.$this->artigo.' '.$this->cskw.' '. mysql_error());
				}
			} else {			
				if($this->obj->add_adm($adata,$id)) {
					$this->session->set_userdata('msg', ucfirst($this->cskw).' alterad'.$this->artigo.' com sucesso!');
				} else {
					$this->session->set_userdata('msg', 'Nada foi alterado. '.mysql_error());
				}
			}
			
			if(function_exists('detalhes')) {
				redirect("admin/$this->kw/detalhes/$id");
				return;
			}
			
			if(!empty($redirect)) {
				redirect($redirect);
			} else {
				$this->_gohome();
			}
		}
	}
	
	function del($id = null) {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}

		if(empty($id) || !isset($this->obj)) {
			return false;
		}
		
		if($this->obj->del($id)) {
			$this->session->set_userdata('msg', ucfirst($this->cskw).' excluíd'.$this->artigo.'.');
		} else {
			$this->session->set_userdata('msg', 'Erro ao excluir '.$this->artigo.' '.$this->cskw.'. '.mysql_error());
		}
		
		$this->_goback();
	}

	function del_varios() {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}

		$selecionados = $this->input->post('selecionados');

		if(is_array($selecionados)) {
			foreach($selecionados as $row) {
				$this->obj->del($row);
			}

			echo "Itens excluídos.";
		} else {
			echo "Nenhum item para excluir.";
		}
	}
	
	function imagens($id = null) {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}

		if(empty($id) || !isset($this->obj)) {
			
		}

		$data['redirect'] = $this->_getredirect();

		$data['o'] = $this->obj->getById($id);
		if(isset($data['o']->nome)) {
			$data['nome'] = $data['o']->nome;
		} else if(isset($data['o']->codigo)) {
			$data['nome'] = $data['o']->codigo;
		} else if(isset($data['o']->empresa)) {
			$data['nome'] = $data['o']->empresa;
		} else if(isset($data['o']->titulo)) {
			$data['nome'] = $data['o']->titulo;
		}

		$this->args['id'] = $id;
		$this->args['tipo'] = $this->cskw;

		$data['imagens'] = $this->obj->getimagens($this->args);
		
		$data['msg'] = $this->session->userdata('msg');
		$this->session->unset_userdata('msg');
		
		//carrega imagens.js
		$data['footerfiles'] = array('backend/includes/imagens_js');

		$this->_render($this->template['crud_imagens_home'], $data);
	}
	
	function gerenciar_foto($acao = 'novo', $iditem = null, $idfoto = null) {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}
		
		if(!is_numeric($iditem)) {
			$this->_gohome();
			return false;
		}
		
		$this->load->library('form_validation','','val');
		$this->acao = $acao;
		
		$this->val->set_error_delimiters('', '<br>');
		$this->val->set_rules('imagem','Foto','');
		$this->val->set_rules('legenda','Legenda','');
		$this->val->set_rules('link','Link','prep_url');
		$this->val->set_rules('categoria','Categoria','');
		
		if($acao == 'alterar') {
			$data['foto'] = $this->obj->getFotoById($idfoto);
			$this->val->set_value_default('legenda',$data['foto']->legenda);
			$this->val->set_value_default('link',$data['foto']->link);
			$this->val->set_value_default('categoria',$data['foto']->categoria_id);
		}
		
		$data['redirect'] = $this->_getredirect();
		
		if ($this->val->run() == FALSE) {
			$o = $this->obj->getById($iditem);
			$data['o'] = $o;
			if(isset($data['o']->nome)) {
				$data['nome'] = $data['o']->nome;
			} else if(isset($data['o']->codigo)) {
				$data['nome'] = $data['o']->codigo;
			} else if(isset($data['o']->empresa)) {
				$data['nome'] = $data['o']->empresa;
			} else if(isset($data['o']->titulo)) {
				$data['nome'] = $data['o']->titulo;
			}
			$data['acao'] = $this->acao;

			$data['msg'] = $this->session->userdata('msg');
			$this->session->unset_userdata('msg');
			
			$this->_render($this->template['crud_imagens_form'],$data);
		} else {
			$this->load->model('imagens_model','img');
			$this->load->model('upload_model','up');
			$adata = array();
			$adata['a1'] = $this->up->upload();
			//$data['a2'] = $this->up->upload('imagem2');
			
			if($acao == 'novo') {
				if($this->obj->add_foto($adata,$iditem)) {
					$this->session->set_userdata('msg', 'Foto cadastrada com sucesso!');
				} else {
					$this->session->set_userdata('msg', 'Houve um erro ao cadastrar a foto.');
				}
			} else {
				if($this->obj->add_foto($adata,$iditem,true,$idfoto)) {
					$this->session->set_userdata('msg', 'Foto alterada com sucesso!');
				} else {
					$this->session->set_userdata('msg', 'Houve um erro ao alterar a foto.');
				}
			}
			
			redirect("admin/$this->kw/imagens/$iditem");
		}
	}
	
	function del_imagem($id, $destructive = 'true') {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}
		
		if($this->obj->delimgs(array('id' => $id,'destructive' => $destructive))) {
			$this->session->set_userdata('msg', 'Foto excluída.');
		} else {
			$this->session->set_userdata('msg', 'Erro ao excluir a foto: '.mysql_error());
		}
		
		$this->_goback();
	}
	
	function _get_redirect($args = array()) {

		extract($args);

		//lógica para pegar a última página acessada pelo cliente. Porém, não pode ser de partes específicas do admin
		if(isset($_SERVER['HTTP_REFERER'])) {
			$referer = $_SERVER['HTTP_REFERER'];
			
			if(!strstr($referer,"$this->kw/detalhes") && !strstr($referer,"$this->kw/imagens") && !strstr($referer,"$this->kw/addfoto") && !strstr($referer,"$this->kw/adicionar") && !strstr($referer,"$this->kw/alterar")) {
				$redirect = $referer;
			} else {
				$sessreferer = $this->session->userdata('adm_referer');
				if(!$sessreferer) {
					if($this->session->userdata('level') == 'admin') {
						$redirect = site_url("admin/$this->kw");
					} else {
						$redirect = site_url("$this->kw");
					}
				} else {
					$redirect = $sessreferer;
				}
			}
		} else {
			$redirect = site_url("admin/$this->kw");
		}

		$this->session->set_userdata('adm_referer',$redirect);

		return $redirect;
	}

	function _go_home() {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}
		
		if(isset($this->kw)) {
			redirect("admin/$this->kw");
		} else {
			redirect("admin/home");
		}
	}
	
	function _go_back() {
		if(isset($_SERVER['HTTP_REFERER'])) {
			$referrer = $_SERVER['HTTP_REFERER'];
		} else {
			$this->_gohome();
			return false;
		}
		
		redirect($referrer);		
	}
	
	function reorder_imagens() {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}
		
		echo $this->obj->reorder_imagens();
	}
	
	function reorder($filtros = null) {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}

		$vars = parse_query($filtros);
		$this->args = $vars;

		$data['entries'] = $this->obj->get_all($this->args);

		//carrega reorder.js
		$data['footerfiles'] = array('backend/includes/reorder_js');
		
		$this->_render("backend/$this->kw/reordenar",$data);
	}
	
	function reorder_ajax() {
		if(!$this->session->userdata('logged') || $this->session->userdata('level') != 'admin') {
			return false;
		}

		echo $this->obj->reorder();
	}
	
	//////////////////////////////////
	
	function _send_mail($params) {
		$replyto = $this->config->item('email_principal');
		$from = 'noreply@'.$this->config->item('dominio');
		$fromname = $this->config->item('site_title');
		$preview = false;
		$cdata = array();
		$base = 'emails/template';
		
		extract($params);
		
		$this->load->library('email');
		
		$this->email->from($from, $fromname);
		$this->email->to($to);
		if(!empty($replyto)) {
			$this->email->reply_to($replyto);
		}
		if(isset($cc)) {
			$this->email->cc($cc);
		}
		if(isset($bcc)) {
			$this->email->bcc($bcc);
		}
		if(isset($attach)) {
			$this->email->attach($attach);
		}
		
		$data['content'] = $this->load->view('emails/'.$template,$cdata,true);
		$msg = $this->load->view($base,$data,true);
		
		if($preview) {
			die($msg);
		}
		
		$this->email->subject($subject);
		$this->email->message($msg);
		$send = $this->email->send();
		
		$this->email->clear();
		
		return $send;
	}
	
}

?>