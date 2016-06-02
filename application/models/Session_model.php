<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_model extends MY_Model {

	function __construct() {
        parent::__construct();

        // inicia array de sessões, caso não exista
		$sessoes = $this->get_value('sessoes');
		if(!$sessoes) {
			$sessoes = array(
				'admin' => array('logado' => false),
				'cliente' => array('logado' => false)
			);
		}
		$this->set_value('sessoes', $sessoes);
    }
	
	// args:
	// $close: true/false
	// $tipo: string
	function check_session($tipo = 'cliente', $args = array()) {
		//pr($this->session->userdata());
		//die();

		// defaults
		$close = true;

		$sessoes = $this->get_value('sessoes');

		extract($args);

		if(!isset($tipo) || !$sessoes) {
			exit('Tipo não especificado.');
		}
		
		if(!isset($sessoes[$tipo]['id'])) {
			if($close) {
				//die('erro14');
				$this->close($tipo, array('redirect' => true));
			} else {
				//die('erro15');
				return false;
			}
		}

		$usuario_id = $sessoes[$tipo]['id'];
		//echo "userid: $usuario_id<br>";
		//die();

		if(!is_numeric($usuario_id)) {
			if($close) {
				//die('erro8');
				$this->close($tipo, array('redirect' => true));
			} else {
				//die('erro3');
				return false;
			}
		}
		
		$user_ip = $_SERVER['REMOTE_ADDR'];
		$sessao_tipo = $sessoes[$tipo]['tipo'];
		$sessao_logado = $sessoes[$tipo]['logado'];
		
		if($sessao_logado !== TRUE) {
			if($close) {
				//die('erro9');
				$this->close($tipo, array('redirect' => true));
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
				$this->close($tipo, array('redirect' => true));
			} else {
				//die('erro2');
				return false;
			}
		}
		$row = $query->row();
		
		if ($sessao_logado != TRUE || $sessao_tipo != $tipo) {
			if($close) {
				//die('erro13');
				$this->close($tipo, array('redirect' => true));
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
	
	function get_value($key, $tipo = 'geral') {
		if(!$key) {
			return '';
		}

		if($tipo == 'geral') {
			// pega da 'raiz' da sessão
			$value = $this->session->userdata($key);
		} else {
			// pega do grupo apropriado
			$sessoes = $this->session->userdata('sessoes');

			if(!isset($sessoes[$tipo][$key])) {
				return '';
			}

			$value = $sessoes[$tipo][$key];
		}

		return $value;
	}

	function set_value($key, $value, $tipo = 'geral') {
		if($tipo == 'geral') {
			// coloca na 'raiz' da sessao
			$this->session->set_userdata($key, $value);
		} else {
			// coloca no grupo apropriado
			$sessoes = $this->session->userdata('sessoes');
			$sessoes[$tipo][$key] = $value;

			$this->session->set_userdata('sessoes', $sessoes);
		}
	}

	function del_value($key, $tipo = 'geral') {
		if($tipo == 'geral') {
			// deleta na 'raiz' da sessão
			$this->session->unset_userdata($key);
		} else {
			// pega do grupo apropriado
			$sessoes = $this->session->userdata('sessoes');
			if(!isset($sessoes[$tipo][$key])) {
				return;
			}
			unset($sessoes[$tipo][$key]);
			$this->session->set_userdata('sessoes', $sessoes);
		}
	}

	function get_msg() {
		$msg = $this->get_value('msg');
		$this->del_value('msg');

		return $msg;
	}

	function set_msg($value) {
		$this->set_value('msg', $value);
	}

	//args:
	//$redirect: string
	//$dest: string
	function close($tipo = 'cliente', $args = array()) {
		// default values
		$redirect = true;

		extract($args);
		
		// apaga só a sessão relevante
		$sessoes = $this->get_value('sessoes');
		$sessoes[$tipo] = array('logado' => false);

		//$this->session->sess_destroy();
		$this->set_value('sessoes', $sessoes);
		
		if($redirect) {
			$end = substr($this->uri->uri_string(),0);
			$end = str_replace('/','|',$end);
			
			$this->set_msg('Por favor, faça o login para acessar esta página.');
			
			if($tipo == 'cliente') {
				redirect("sessoes/login/$end");
			} else {
				redirect("$tipo/login/index/$end");
			}
		}
	}
	
}

?>