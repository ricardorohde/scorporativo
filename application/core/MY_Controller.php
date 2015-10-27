<?php defined('BASEPATH') OR exit('No direct script access allowed');

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

		//Session model
		$this->load->model("Session_model",'sess');

		if($this->sess->check_session(array('close' => false, 'tipo' => 'admin'))
		   && $this->uri->segment(1) == 'admin') {
			//ADM defaults
			$this->template = array();
			$this->template['crud_home'] = 'templates/backend/crud_home';
			$this->template['crud_form'] = 'templates/backend/crud_form';
			$this->template['crud_reordenar'] = 'templates/backend/crud_reordenar';
			$this->template['crud_imagens_home'] = 'templates/backend/crud_imagens_home';
			$this->template['crud_imagens_form'] = 'templates/backend/crud_imagens_form';

			// carrega helper de validation e biblioteca form validation
			$this->load->helper('validation');
			$this->load->library('form_validation');

			$this->args = array();
		}
    }

	function _set_title($value, $args = array()) {
		$complete = true;

		extract($args);

		$title = $value;
		if($this->uri->segment(1) == 'admin') {
			$config_title = "Administrativo";
		} else {
			$config_title = $this->config->item('site_title');
		}

		if(isset($complete) && $complete == true) {
			if(isset($inverse) && $inverse == true) {
				$title = $config_title . ' &ndash; ' . $title;
			} else {
				$title .= ' &ndash; ' . $config_title;
			}
		}

		$this->data['site_title'] = $title;
	}

	function _render($page = null, $data = array(), $template = null) {
		if($this->uri->segment(1) != 'admin') {
			//pegamos as seções
			$this->load->model('Paginas_model','pag');
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
	
	/**
	 * Página index padrão para área administrativa
	 *
	 * Apenas redireciona para a home da seção atual
	 *
	 * @return	void
	 */
	function index() {
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		redirect('admin/'.$this->kw.'/home');
	}
	
	/**
	 * Página home padrão para área administrativa
	 *
	 * Pega todos os registros segundo $this->args, que pode
	 * ser passado pela classe filha
	 *
	 * @return	void
	 */
	function home() {
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		$data['entries'] = $this->obj->get_all($this->args);
		$data['current'] = $this->obj->current;
		$data['per_page'] = $this->obj->per_page;

		if(isset($this->obj->total_rows)) {
			$config = $this->_set_pagination($this->obj->total_rows, $this->obj->per_page);
			$this->pagination->initialize($config);
		}

		$data['total_rows'] = $this->obj->total_rows;
		$data['msg'] = $this->session->userdata('msg');
		$this->session->unset_userdata('msg');

		$this->_render($this->template['crud_home'],$data);
	}

	function gerenciar($acao = 'novo',$id = null) {		
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		if($acao != 'novo' && $acao != 'alterar') {
			$this->_go_home();
			return false;
		}

		if($acao == 'alterar' && ($id == null || !is_numeric($id))) {
			$this->session->set_userdata('msg', 'Id d'.$this->artigo.' '.$this->cskw.' inválida.');
			$this->_go_home();
			return false;
		}

		if($acao == 'alterar') {
			$this->item_id = $id;
			$this->item = $this->obj->get_by_id($id);
		}

		$this->acao = $acao;

		$this->_form_setup();

		$data['redirect'] = $redirect = $this->_get_redirect();

		if ($this->form_validation->run()) {
			$this->load->model('Upload','up');
			$this->load->model('Imagens','img');

			$adata = array();

			if($acao == 'novo') {
				if($id = $this->obj->add($adata)) {
					$this->session->set_userdata('msg', ucfirst($this->cskw).' cadastrad'.$this->artigo.' com sucesso!');
				} else {
					$this->session->set_userdata('msg', 'Erro ao cadastrar '.$this->artigo.' '.$this->cskw.' '. mysql_error());
				}
			} else {
				if($this->obj->upt($adata,$id)) {
					$this->session->set_userdata('msg', ucfirst($this->cskw).' alterad'.$this->artigo.' com sucesso!');
				} else {
					$this->session->set_userdata('msg', 'Nada foi alterado. '.mysql_error());
				}
			}

			if(method_exists($this,'detalhes')) {
				redirect("admin/$this->kw/detalhes/$id");
				return;
			}

			if(!empty($redirect)) {
				redirect($redirect);
			} else {
				$this->_go_home();
			}
		}

        $data['msg'] = $this->session->userdata('msg');
        $this->session->unset_userdata('msg');

        $data['acao'] = $this->acao;
        $data['id'] = $id;
        $this->_render($this->template['crud_form'],$data);
	}

    function upt($pag = null) {
        if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		if(!$pag) {
			die('página não especificada');
		}

		$func = 'upt_'.$pag;

		if($this->obj->$func()) {
			$this->session->set_userdata('msg','Dados atualizados.');
		} else {
			$this->session->set_userdata('msg','Nenhuma informação alterada.');
		}

		$this->_go_back();
	}

    function reordenar($filtros = null) {
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

        $data['redirect'] = $this->_get_redirect();

		$vars = parse_query($filtros);
		$this->args = $vars;

		$data['entries'] = $this->obj->get_all($this->args);

		//carrega reorder.js
		$data['footer_files'][] = 'backend/includes/reordenar_js';

		$this->_render($this->template['crud_reordenar'],$data);
	}

	function excluir($id = null) {
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		if(empty($id) || !isset($this->obj)) {
			return false;
		}

		if($this->obj->excluir($id)) {
			$this->session->set_userdata('msg', ucfirst($this->cskw).' excluíd'.$this->artigo.'.');
		} else {
			$this->session->set_userdata('msg', 'Erro ao excluir '.$this->artigo.' '.$this->cskw.'. '.mysql_error());
		}

		$this->_go_back();
	}

	function excluir_varios() {
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
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
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		$data['redirect'] = $this->_get_redirect();

		$data['item'] = $this->obj->get_by_id($id);
		if(isset($data['item']->nome)) {
			$data['nome'] = $data['item']->nome;
		} else if(isset($data['item']->codigo)) {
			$data['nome'] = $data['item']->codigo;
		} else if(isset($data['item']->empresa)) {
			$data['nome'] = $data['item']->empresa;
		} else if(isset($data['item']->titulo)) {
			$data['nome'] = $data['item']->titulo;
		}

		$this->args['id'] = $id;
		$this->args['tipo'] = $this->cskw;

		$data['imagens'] = $this->obj->get_imagens($this->args);

		$data['msg'] = $this->session->userdata('msg');
		$this->session->unset_userdata('msg');

		//carrega imagens.js
		$data['footer_files'][] = 'backend/includes/reordenar_js';

		$this->_render($this->template['crud_imagens_home'], $data);
	}

	function gerenciar_imagem($acao = 'novo', $item_id = null, $imagem_id = null) {
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		if(!is_numeric($item_id)) {
			$this->_go_home();
			return false;
		}

		$this->acao = $acao;

		$this->form_validation->set_rules('imagem','Imagem','trim');
		$this->form_validation->set_rules('legenda','Legenda','trim');
		$this->form_validation->set_rules('link','Link','trim|prep_url');
		$this->form_validation->set_rules('categoria','Categoria','trim');

		if($acao == 'alterar') {
			$data['imagem'] = $imagem = $this->obj->get_imagem($imagem_id);
			$this->form_validation->set_value_default('legenda',$imagem->legenda);
			$this->form_validation->set_value_default('link',$imagem->link);
			$this->form_validation->set_value_default('categoria',$imagem->categoria_id);
		}

		$data['redirect'] = $this->_get_redirect();

		if ($this->form_validation->run() == FALSE) {
			$item = $this->obj->get_by_id($item_id);
			$data['item'] = $item;
			if(isset($data['item']->nome)) {
				$data['nome'] = $data['item']->nome;
			} else if(isset($data['item']->codigo)) {
				$data['nome'] = $data['item']->codigo;
			} else if(isset($data['item']->empresa)) {
				$data['nome'] = $data['item']->empresa;
			} else if(isset($data['item']->titulo)) {
				$data['nome'] = $data['item']->titulo;
			}
			$data['acao'] = $this->acao;

			$data['msg'] = $this->session->userdata('msg');
			$this->session->unset_userdata('msg');

			$this->_render($this->template['crud_imagens_form'],$data);
		} else {
			$this->load->model('Imagens','img');
			$this->load->model('Upload','up');

			$adata = array();
			$adata['a1'] = $this->up->upload();
			//$data['a2'] = $this->up->upload('imagem2');

			if($acao == 'novo') {
				if($this->obj->add_imagem($adata,$item_id)) {
					$this->session->set_userdata('msg', 'Imagem cadastrada com sucesso!');
				} else {
					$this->session->set_userdata('msg', 'Houve um erro ao cadastrar a imagem.');
				}
			} else {
				if($this->obj->add_imagem($adata,$item_id,true,$imagem_id)) {
					$this->session->set_userdata('msg', 'Imagem alterada com sucesso!');
				} else {
					$this->session->set_userdata('msg', 'Houve um erro ao alterar a imagem.');
				}
			}

			redirect("admin/$this->kw/imagens/$item_id");
		}
	}

	function excluir_imagem($id, $destructive = 'true') {
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		if($this->obj->excluir_imagens(array('id' => $id,'destructive' => $destructive))) {
			$this->session->set_userdata('msg', 'Imagem excluída.');
		} else {
			$this->session->set_userdata('msg', 'Erro ao excluir a imagem: '.mysql_error());
		}

		$this->_go_back();
	}

    function get_json() {
        if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		$resultados = array();
		$item = $this->input->post('item');

		$args['nome'] = $item;
		$busca = $this->obj->getAll($args);

		if(!$busca) {
			$json = json_encode($resultados);
		} else {
			foreach($busca as $row) {
				$resultados[] = array('label' => $row->nome, 'value' => $row->id);
			}
			$json = json_encode($resultados);
		}

		echo $json;
	}

	function _get_redirect($args = array()) {
		extract($args);

		//lógica para pegar a última página acessada pelo cliente. Porém, não pode ser de partes específicas do admin
		if(isset($_SERVER['HTTP_REFERER'])) {
			$referer = $_SERVER['HTTP_REFERER'];

			if(!strstr($referer,"$this->kw/detalhes") && !strstr($referer,"$this->kw/imagens") && !strstr($referer,"$this->kw/adicionar_imagem") && !strstr($referer,"$this->kw/alterar_imagem") && !strstr($referer,"$this->kw/adicionar") && !strstr($referer,"$this->kw/alterar")) {
				$redirect = $referer;
			} else {
				$sessreferer = $this->session->userdata('adm_referer');
				if(!$sessreferer) {
					if($this->session->userdata('tipo') == 'admin') {
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
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
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
			$this->_go_home();
			return false;
		}

		redirect($referrer);
	}

	function reordenar_imagens() {
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		echo $this->obj->reordenar_imagens();
	}

	function reordenar_ajax() {
		if(!$this->sess->check_session(array('close' => false, 'tipo' => 'admin'))) {
			return false;
		}

		echo $this->obj->reordenar();
	}

	//////////////////////////////////

	function _send_mail($params) {
		$reply_to = $this->config->item('email_principal');
		$from = 'noreply@'.$this->config->item('dominio');
		$from_name = $this->config->item('site_title');
		$preview = false;
		$debug = false;
		$content = array();
		$base = 'emails/template';

		extract($params);

		if($debug) {
			print "Params: ";
			print_r($params);
		}

		$this->load->library('email');

		$this->email->from($from, $from_name);
		$this->email->to($to);
		if(!empty($replyto)) {
			$this->email->reply_to($reply_to);
		}
		if(isset($cc)) {
			$this->email->cc($cc);
		}
		if(isset($bcc)) {
			$this->email->bcc($bcc);
		}
		if(isset($attach)) {
			$this->email->attach($attach);

			if($debug) {
				print "Anexado(s) arquivo(s): ";
				print_r($attach);
			}
		}

		$data['content'] = $this->load->view('emails/'.$template,$content,true);
		$msg = $this->load->view($base,$data,true);

		if($preview) {
			die($msg);
		}

		$this->email->subject($subject);
		$this->email->message($msg);

		if($debug) {
			$send = $this->email->send(false);
		} else {
			$send = $this->email->send();
		}

		if($debug) {
			echo $this->email->print_debugger();
			die();
		}

		$this->email->clear();

		return $send;
	}

}

?>
