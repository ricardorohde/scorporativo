<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Session_model extends MY_Model {

	function __construct() {
		parent::__construct();

		// inicia array de sessões, caso não exista
		$sessoes = $this->session->userdata('sessoes');
		if(!$sessoes) {
			$sessoes = array(
				'admin' => array('logado' => false),
				'cliente' => array('logado' => false)
			);
		}
		$this->session->set_userdata('sessoes', $sessoes);
	}
	
	// args:
	// $close: true/false
	// $tipo: string
	function check_session($args = array()) {
		//pr($this->session->userdata());
		//die();

		$sessoes = $this->session->userdata('sessoes');

		extract($args);

		if(!isset($tipo) || !$sessoes) {
			exit('Tipo não especificado.');
		}
		
		if(!isset($sessoes[$tipo]['id'])) {
			//die('erro14');
			return false;
		}

		$usuario_id = $sessoes[$tipo]['id'];
		//echo "userid: $usuario_id<br>";
		//die();

		if(!is_numeric($usuario_id)) {
			if($close) {
				//die('erro8');
				$this->close(array('redirect' => true,'tipo' => $tipo));
			} else {
				//die('erro3');
				return false;
			}
		}
		
		$user_ip = $_SERVER['REMOTE_ADDR'];
		$sessao_tipo = $sessoes[$tipo]['tipo'];
		$sessao_logado = $sessoes[$tipo]['logado'];
		
		if($sessao_logado != TRUE) {
			if($close) {
				//die('erro9');
				$this->close(array('redirect' => true, 'tipo' => $tipo));
			} else {
				//die('erro1');
				return false;
			}
		}
		
		if($tipo == 'admin') {
			$query = $this->db->query("SELECT * FROM {$this->_prefix}adm WHERE id=$usuario_id");
		} else {
			$query = $this->db->query("SELECT * FROM {$this->_prefix}usuarios WHERE id=$usuario_id");
		}
		
		if($query->num_rows() != 1) {
			if($close) {
				//die('erro10');
				$this->close(array('redirect' => true, 'tipo' => $tipo));
			} else {
				//die('erro2');
				return false;
			}
		}
		$row = $query->row();
		
		if ($sessao_logado != TRUE || $sessao_tipo != $tipo) {
			if($close) {
				//die('erro13');
				$this->close(array('redirect' => true, 'tipo' => $tipo));
			} else {
				//die('erro6');
				return false;
			}
		} else {
			return true;
		}
		
		//die('erro7');
		return false;
	}
	
	// args:
	// $redirect: string
	// $tipo: string
	function close($args = array()) {
		// default values
		$tipo = 'cliente';
		$redirect = true;

		extract($args);
		
		// apaga só a sessão relevante
		$sessoes = $this->session->userdata('sessoes');
		$sessoes[$tipo] = array('logado' => false);

		$this->session->set_userdata('sessoes',$sessoes);
		//$this->session->sess_destroy();
		
		if($redirect) {
			$end = substr($this->uri->uri_string(),0);
			$end = str_replace('/','|',$end);
			
			$this->session->set_userdata('msg','Por favor, faça o login para acessar esta página.');
			
			if($tipo == 'cliente') {
				redirect("sessoes/login/$end");
			} else {
				redirect("$tipo/login/index/$end");
			}
		}
	}
	
}

?>