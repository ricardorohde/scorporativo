<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends MY_Model {

	function __construct() {
        parent::__construct();
    }
	
	function check_credentials($tipo = 'cliente') {
		$login = strtolower(trim($this->input->post('login')));
		$senha = trim($this->input->post('senha'));
		
		if($tipo == 'admin') {
			$str = "SELECT login, nome, senha, salt
					FROM {$this->_prefix}adm
					WHERE login='$login'";
		} else {
			$str = "SELECT rel_id, email, senha, ativo
					FROM {$this->_prefix}usuarios
					WHERE (email='$login' OR login='$login') AND tipo='$tipo'";
		}
		$query = $this->db->query($str);
		
		//login não existe
		if($query->num_rows() != 1) {
			return false;
		}
		
		if($tipo == 'admin') {
			$row = $query->row();
			$static_salt = $this->config->item('static_salt');
			$hashed_password = sha1($row->salt.$senha.$static_salt);

			if($hashed_password === $row->senha) {
				//login com sucesso
				return true;
			} else {
				//senha inválida
				return false;
			}
		} else {
			$row = $query->row();

			//verifica se usuário está bloqueado ou não
			if($row->ativo == '0') {
				//cadastro bloqueado
				$this->session->set_userdata('erro','Seu cadastro está bloqueado.');
				return false;
			}

			$static_salt = $this->config->item('static_salt');
			$hashed_password = sha1($row->salt.$senha.$static_salt);

			if($hashed_password !== $row->senha) {
				$this->session->set_userdata('erro','Usuário ou senha inválidos.');
				return false;
			} else {
				//login com sucesso
				return true;
			}
		}
	}
	
	//args:
	//$redirect: string
	function do_login($args = array()) {
		$tipo = 'cliente'; // padrão

		extract($args);
		
		$usuario = strtolower(trim($this->input->post('login')));
		$sessid = $this->session->userdata('session_id');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		//salvamos no access log
		$data['ip'] = $ip;
		$data['usuario'] = $usuario;
		$this->db->insert('acessos',$data);
		
		if($tipo == 'admin') {
			$str = "SELECT nome, id
					FROM {$this->_prefix}adm
					WHERE login='$usuario'";
		} else {
			$str = "SELECT nome, id, rel_id, email, tipo
					FROM {$this->_prefix}usuarios
					WHERE (email='$usuario' OR login='$usuario') AND tipo='$tipo'";
		}
		$query = $this->db->query($str);
		$row = $query->row();
		$query->free_result();
		
		$array = array(
						'nome' => $row->nome,
						'id' => $row->id,
						'usuario' => $usuario,
						'sessid' => $sessid,
						'tipo' => $tipo,
						'logado' => true
						);
		
		if($tipo != 'admin') {
			$array['rel_id'] = $row->rel_id;
			$array['email'] = $row->email;
			$array['tipo'] = $row->tipo;

			//se não for admin, pegamos último acesso também
			$query = $this->db->query("SELECT data FROM {$this->_prefix}acessos WHERE usuario='$usuario' ORDER BY data DESC LIMIT 1");
			if($query->num_rows() > 0) {
				$row = $query->row();
				$query->free_result();

				$array['ultimo_acesso'] = $row->data;
			} else {
				$array['ultimo_acesso'] = null;
			}
		}
						
		//die(print_r($array));
		
		$this->session->set_userdata($array);

		//$sdata = $this->session->all_userdata();
		//die(print_r($sdata));
		
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
	
	//args:
	//tipo: string
	//user: string
	function check_block($args = array()) {
		extract($args);

		if(!isset($tipo) || !isset($user)) {
			return false;
		}
		
		if($tipo == 'admin') {
			$query = $this->db->query("SELECT bloqueado FROM {$this->_prefix}adm WHERE login='$user'");
		} else {
			$query = $this->db->query("SELECT bloqueado FROM {$this->_prefix}usuarios WHERE email='$user'");
		}
		
		//login não existe
		if($query->num_rows() != 1) {
			return false;
		}
		
		$row = $query->row();
		
		if($row->bloqueado == 'true') {
			//usuário desbloqueado
			return true;
		} else {
			//usuário bloqueado
			return false;
		}
	}	
}

?>