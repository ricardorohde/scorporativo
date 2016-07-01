<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends MY_Model {

	function __construct() {
        parent::__construct();

        $this->tbl = 'clientes';
    }
	
	function get_all($args = array()) {	
		$per_page = 20;
		
		extract($args);
		
		$params = array(
						'select' => "*",
						'from' => "{$this->tbl} c",
						'join' => "JOIN {$this->_prefix}usuarios u ON u.rel_id=c.id",
						'where' => '1=1',
						'order_by' => 'c.nome ASC',
						'per_page' => $per_page
						);
		
		if(isset($nome)) {
			$this->load->helper('str');
			$like_str = like_str($nome);
			$params['where'] .= " AND c.nome LIKE '$like_str' ";
		}

		if(isset($ativo) && is_numeric($ativo)) {
			$params['where'] .= " AND c.ativo=$ativo ";
		}
						
		return $this->get_entries($params);
	}
	
	function get_by_id($id = null) {
		$params = array(
						'select' => "*",
						'from' => "{$this->tbl} c",
						'join' => "JOIN {$this->_prefix}usuarios u ON u.rel_id=c.id",
						'where' => "c.id=$id",
						'single' => true
						);
						
		return $this->get_entries($params);
	}

	function get_by_email($email = null) {
		$params = array(
						'select' => "*",
						'from' => "{$this->tbl} c",
						'join' => "JOIN {$this->_prefix}usuarios u ON u.rel_id=c.id AND u.tipo='cliente'",
						'where' => "c.email='$email'",
						'single' => true
						);
						
		return $this->get_entries($params);
	}
	
	function add_adm($update = false, $id = null) {

		$this->db->trans_start();

		$data['nome'] = $this->input->post('nome');
		$data['email'] = $this->input->post('email');
		
		if($update) {
			$where = "id=$id";
			$str = $this->db->update_string($this->_prefix.$this->tbl,$data,$where);
		} else {
			$str = $this->db->insert_string($this->_prefix.$this->tbl,$data);
			
		}
		$this->db->query($str);

		if(!$update) {
			$id = $this->db->insert_id();
		} else if(!$id) {
			$id = $this->session->userdata('relid');
		}

		unset($data);

		//usuario
		$data['rel_id'] = $id;
		$data['nome'] = $this->input->post('nome');
		$data['email'] = $this->input->post('email');
		
		if($this->input->post('ativo')) {
			$data['ativo'] = $this->input->post('ativo');
		} else {
			$data['ativo'] = 1; //ativo
		}

		$senha = $this->input->post('senha');
		if($senha) {
			$salt = $this->config->item('static_salt');
			$dynamic = microtime();
			$hashedpass = sha1($dynamic . $senha . $salt);	
			
			$data['senha'] = $hashedpass;
			$data['salt'] = $dynamic;
		}

		if($update) {
			$where = "id=$id";
			$str = $this->db->update_string($this->_prefix.'usuarios',$data,$where);
		} else {
			$str = $this->db->insert_string($this->_prefix.'usuarios',$data);
			
		}
		$this->db->query($str);
		
		//tudo pronto
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return $id;
		}
	}

	function upt_senha($id) {
		if(!$id) {
			return false;
		}

		$senha = $this->input->post('senha');

		$salt = $this->config->item('static_salt');
		$dynamic = microtime();
		$hashedpass = sha1($dynamic . $senha . $salt);	
		
		$data['senha'] = $hashedpass;
		$data['salt'] = $dynamic;

		$where = "rel_id=$id AND tipo='cliente'";
		$str = $this->db->update_string($this->_prefix.'usuarios',$data,$where);

		$this->db->query($str);

		return true;
	}
	
	function excluir($id = null) {
		if(!is_numeric($id)) {
			return false;
		}
		
		$this->db->trans_start();
		
		$this->db->query("DELETE FROM {$this->_prefix}usuarios WHERE rel_id=$id AND tipo='cliente'");
		$this->db->query("DELETE FROM {$this->_prefix}{$this->tbl} WHERE id=$id");
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
}

?>