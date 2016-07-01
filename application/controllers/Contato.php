<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','<br>');

		$this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
		$this->form_validation->set_rules('telefone', 'Telefone', 'trim');
		$this->form_validation->set_rules('mensagem', 'Mensagem', 'trim|required|max_length[1024]');

		if($this->form_validation->run()) {
			$emdata['nome'] = $this->input->post('nome');
			$emdata['email'] = $email = $this->input->post('email');
			$emdata['telefone'] = $this->input->post('telefone');
			$emdata['mensagem'] = $this->input->post('mensagem');

			//$to = $this->config->item('email_contato');
			$to = 'contato@guilhermemuller.com.br'; //email para testes
			$subject = 'Contato através do site';

			$email_params = array('to' => $to
								 ,'template' => 'contato'
								 ,'reply_to' => $email
								 ,'subject' => $subject
								 //,'preview' => true
								 ,'content' => $emdata
							);
			$send = $this->_send_mail($email_params);

			if(!$send) {
				redirect('contato/falha');
			} else {
				redirect('contato/sucesso');
			}

            return;
		}

        //carregamento da página
        $cod = $this->uri->segment(1,'home');

        $this->load->model('paginas_model','pag');
        $data['pagina'] = $pagina = $this->pag->get_by_cod($cod);

        $title = $this->config->item('site_title');

        $data['meta_desc'] = "$pagina->titulo - $title";
        $this->_set_title($pagina->titulo);

        $this->_render('frontend/contato/contato',$data);
	}

	function sucesso() {
		$cod = $this->uri->segment(1,'home');

		$this->load->model('paginas_model','pag');
		$data['pagina'] = $pagina = $this->pag->get_by_cod($cod);

		$title = $this->config->item('site_title');
		$this->_set_title($pagina->titulo);

		$this->_render('frontend/contato/sucesso',$data);
	}

	function falha() {
		$cod = $this->uri->segment(1,'home');

		$this->load->model('paginas_model','pag');
		$data['pagina'] = $pagina = $this->pag->get_by_cod($cod);

		$title = $this->config->item('site_title');
		$this->_set_title($pagina->titulo);

		$this->_render('frontend/contato/falha',$data);
	}

}

?>
