<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Alterar_senha extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this->sess->check_session(array('close' => true,'tipo' => 'admin'));

		$this->kw = 'alterar_senha';

		//$this->output->enable_profiler(TRUE);
	}

	function index() {
		$this->load->model('Usuarios_adm_model','obj');

		$usuario = $this->session->userdata('usuario');
		$this->object = $this->obj->get_by_login($usuario);

		$this->form_validation->set_rules('senha','Senha','required|alpha_dash');
		$this->form_validation->set_rules('senha_conf','Confirme a Senha','required|matches[senha]|alpha_dash');

		if ($this->form_validation->run()) {
			if($this->obj->upt(array(), $usuario)) {
				$this->session->set_userdata('msg', 'Senha alterada com sucesso!');
			} else {
				$this->session->set_userdata('msg', 'Erro ao alterar a senha.');
			}
            $data['erro'] = false;
		} else {
            $data['erro'] = true;
        }

		$data['msg'] = $this->session->userdata('msg');
		$this->session->unset_userdata('msg');

		$this->_render('backend/alterar_senha',$data);
	}

}

?>
