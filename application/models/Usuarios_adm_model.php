<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_adm_model extends MY_Model {

	function __construct() {
        parent::__construct();
    }
	
	function get_all() {
		$params = array(
						'select' => 'id, login, nome',
						'from' => 'adm',
						'orderby' => 'id ASC',
						'per_page' => 20
						);
		
		return $this->get_entries($params);
	}
	
	function get_by_id($id = null) {
		$params = array(
				 		'select' => 'id, login, nome, nivel',
						'where' => "id='$id'",
						'from' => 'adm',
						'single' => true
						);
						
		return $this->get_entries($params);
	}
	
	function get_by_login($login = null) {
		$params = array(
						'where' => "login='$login'",
						'from' => 'adm',
						'single' => true
						);
						
		return $this->get_entries($params);
	}
	
	function add_adm($update = false, $id = null) {
		if($this->input->post('nome')) {
			$data['nome'] = $this->input->post('nome');
		}
		if($this->input->post('login')) {
			$data['login'] = $this->input->post('login');
		}
		if($this->input->post('nivel')) {
			$data['nivel'] = $this->input->post('nivel');
		}
		$data['nivel'] = 1; //por enquanto
		
		if($this->input->post('senha')) {
			$senha = $this->input->post('senha');
			$salt = $this->config->item('static_salt');
			$dynamic = microtime();
			$hashedpass = sha1($dynamic . $senha . $salt);	
			
			$data['senha'] = $hashedpass;
			$data['salt'] = $dynamic;
		}
		
		$this->db->set($data);
		
		if($update) {
			if($id == null) {
				return false;
			}
			
			if(is_numeric($id)) {
				$this->db->where('id',$id);	
			} else {
				$this->db->where('login',$id);
			}
			$this->db->update('adm');
		} else {
			$this->db->insert('adm');
		}
		
		return true;
	}
	
	function del($id = null) {
		$this->db->trans_start();
		
		//$this->db->query("DELETE FROM `mr_permissoes` WHERE user_id='$id'");
		$this->db->query("DELETE FROM {$this->_prefix}adm WHERE id='$id'");
			
		//tudo ok
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}
}

?>