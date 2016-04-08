<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends MY_Model {

	function __construct() {
        parent::__construct();
    }
	
	function check_credentials($tipo = 'cliente') {
		$login = strtolower(trim($this->input->post('login')));
		$senha = trim($this->input->post('senha'));
		
		if($tipo == 'admin') {
			$str = "SELECT login, nome, senha, salt, ativo
					FROM {$this->_prefix}adm
					WHERE login='$login'";
		} else {
			$str = "SELECT rel_id, email, senha, ativo, salt
					FROM {$this->_prefix}usuarios
					WHERE email='$login' AND tipo='$tipo'";
		}
		$query = $this->db->query($str);
		
		// login não existe
		if($query->num_rows() != 1) {
			return false;
		}

		$row = $query->row();
		// verifica se usuário está bloqueado ou não
		if(!$row->ativo) {
			// cadastro bloqueado
			$this->session->set_userdata('erro','Seu cadastro está bloqueado.');
			return false;
		}
		
		$static_salt = $this->config->item('static_salt');
		$hashed_password = sha1($row->salt.$senha.$static_salt);

		if($hashed_password !== $row->senha) {
			$this->session->set_userdata('erro','Usuário ou senha inválidos.');
			return false;
		} else {
			// login com sucesso
			return true;
		}
	}
	
	// args:
	// $redirect: string
	function do_login($args = array()) {
		$tipo = 'cliente'; // padrão

		// pega array de sessões
		$sessoes = $this->session->userdata('sessoes');

		extract($args);
		
		$usuario = $this->input->post('login');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		//salvamos no access log
		$data['ip'] = $ip;
		$data['usuario'] = $usuario;
		$this->db->insert('acessos',$data);
		
		// pega dados básicos do usuário
		if($tipo == 'admin') {
			$str = "SELECT nome, id
					FROM {$this->_prefix}adm
					WHERE login='$usuario'";
		} else {
			$str = "SELECT nome, id, rel_id, email, tipo
					FROM {$this->_prefix}usuarios
					WHERE email='$usuario' AND tipo='$tipo'";
		}
		$query = $this->db->query($str);
		$row = $query->row();
		$query->free_result();
		//
		
		// parâmetros base da sessão
		$sessao_conteudo = array(
						'nome' => $row->nome,
						'id' => $row->id,
						'usuario' => $usuario,
						'tipo' => $tipo,
						'timestamp' => strtotime('now'),
						'logado' => true
						);
		//
		
		if($tipo != 'admin') {
			$sessao_conteudo['rel_id'] = $row->rel_id;
			$sessao_conteudo['email'] = $row->email;
			$sessao_conteudo['tipo'] = $row->tipo;

			// se não for admin, pegamos último acesso também
			$query = $this->db->query("SELECT data_cadastro FROM {$this->_prefix}acessos WHERE usuario='$usuario' ORDER BY data_cadastro DESC LIMIT 1");
			if($query->num_rows() > 0) {
				$row = $query->row();
				$query->free_result();

				$sessao_conteudo['ultimo_acesso'] = $row->data_cadastro;
			} else {
				$sessao_conteudo['ultimo_acesso'] = null;
			}
		}
						
		//pr($sessao_conteudo);
		
		// coloca conteúdo na sessão
		$sessoes[$tipo] = $sessao_conteudo;
		$this->session->set_userdata('sessoes', $sessoes);

		//pr($this->session->userdata());
		
		if(isset($redirect)) {
			if($redirect == false) {
				return;
			} else {
				$redirect = urldecode($redirect);
				$to = str_replace('|','/',$redirect);
				redirect($to);
			}			
		} else {
			if($tipo == 'cliente') {
				redirect("minha_conta");
			} else {
				redirect("$tipo/home");
			}
		}
	}
	
	// args:
	// tipo: string
	// usuario: string
	function is_blocked($args = array()) {
		extract($args);

		if(!isset($tipo) || !isset($usuario)) {
			return false;
		}
		
		if($tipo == 'admin') {
			$query = $this->db->query("SELECT ativo FROM {$this->_prefix}adm WHERE login='$usuario'");
		} else {
			$query = $this->db->query("SELECT ativo FROM {$this->_prefix}usuarios WHERE email='$usuario'");
		}
		
		// login não existe
		if($query->num_rows() != 1) {
			return false;
		}
		
		$row = $query->row();
		
		if(!$row->ativo) {
			// usuário bloqueado
			return true;
		} else {
			// usuário desbloqueado
			return false;
		}
	}	
}

?>