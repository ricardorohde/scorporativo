<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Session extends MY_Model {

	function __construct() {
        parent::__construct();
    }
	
	//args:
	//$close: true/false
	//$level: string
	function check_session($args = array()) {
		extract($args);

		if(!isset($level)) {
			exit('nível não especificado.');
		}
		
		$user_id = $this->session->userdata('id');
		//echo "userid: $user_id<br>";

		if(!is_numeric($user_id)) {
			if($close) {
				//die('erro8');
				$this->close(array('redirect' => true,'dest' => $level));
			} else {
				//die('erro3');
				return false;
			}
		}
		
		$session_id = $this->session->userdata('session_id');
		$user_ip = $_SERVER['REMOTE_ADDR'];
		$slevel = $this->session->userdata('level');
		$slogged = $this->session->userdata('logged');
		
		if($slogged != TRUE) {
			if($close) {
				//die('erro9');
				$this->close(array('redirect' => true,'dest' => $level));
			} else {
				//die('erro1');
				return false;
			}
		}
		
		if($level == 'admin') {
			$query = $this->db->query("SELECT * FROM {$this->_prefix}adm WHERE id=$user_id");
		} else {
			$query = $this->db->query("SELECT * FROM {$this->_prefix}usuarios WHERE id=$user_id");
		}
		
		if($query->num_rows() != 1) {
			if($close) {
				//die('erro10');
				$this->close(array('redirect' => true,'dest' => $level));
			} else {
				//die('erro2');
				return false;
			}
		}
		$row = $query->row();
		
		/*if($level == 'admin') {
			//database check
			$this->db->select('ip_address')->from('sessoes')->where('session_id',$session_id);
			$ipquery = $this->db->get();
				
			if($ipquery->num_rows() < 1) {
				if($close) {
					//die('erro11');
					$this->close(array('redirect' => true,'dest' => $level));
				} else {
					//die('erro5');
					return false;
				}
			}
				
			$iprow = $ipquery->row();				
			if ($user_ip != $iprow->ip_address) {
				if($close) {
					//die('erro12');
					$this->close(array('redirect' => true,'dest' => $level));
				} else {
					//die('erro4');
					return false;
				}
			}
		}*/
		
		if ($slogged != TRUE || $slevel != $level) {
			if($close) {
				//die('erro13');
				$this->close(array('redirect' => true,'dest' => $level));
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
	
	//args:
	//$redirect: string
	//$dest: string
	function close($args = array()) {
		extract($args);
		
		$array = array('logged' => FALSE,
					   'level' => null,
					   'id' => null,
					   'nome' => null,
					   'user' => null,
					   'ip' => null,
					   'sessid' => null,
					   'relid' => null,
					   'email' => null,
					   'validado' => null);
		
		$this->session->set_userdata($array);
		//$this->session->sess_destroy();
		
		if($redirect) {
			$end = substr($this->uri->uri_string(),0);
			$end = str_replace('/','|',$end);
			
			$this->session->set_userdata('msg','Por favor, faça o login para acessar esta página.');
			
			if($dest == 'cliente') {
				redirect("sessoes/login/$end");
			} else {
				redirect("$dest/login/index/$end");
			}
		}
	}
	
}

?>