<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends MY_Model {

	function __construct() {
        parent::__construct();
    }
	
	function get_all($args = array()) {	
		$perpage = 20;
		
		extract($args);
		
		$params = array(
						'from' => 'clientes c',
						'orderby' => 'c.nome ASC',
						'join' => "JOIN {$this->_prefix}usuarios u ON u.rel_id=c.id",
						'where' => '1=1',
						'perpage' => $perpage
						);
		
		if(isset($nome)) {
			$this->load->helper('str');
			$likestr = likestr($nome);
			$params['where'] .= " AND c.nome LIKE '$likestr' ";
		}

		if(isset($ativo) && is_numeric($ativo)) {
			$params['where'] .= " AND ativo=$ativo ";
		}
						
		return $this->get_entries($params);
	}
	
	function get_by_id($id = null) {
		$params = array(
						'where' => "c.id=$id",
						'from' => 'clientes c',
						'join' => "JOIN {$this->_prefix}usuarios u ON u.rel_id=c.id",
						'single' => true
						);
						
		return $this->get_entries($params);
	}

	function get_by_email($email = null) {
		$params = array(
						'where' => "c.email='$email'",
						'from' => 'clientes c',
						'join' => "JOIN {$this->_prefix}usuarios u ON u.rel_id=c.id AND u.tipo='cliente'",
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
			$str = $this->db->update_string($this->_prefix.'clientes',$data,$where);
		} else {
			$str = $this->db->insert_string($this->_prefix.'clientes',$data);
			
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
		$this->db->query("DELETE FROM {$this->_prefix}clientes WHERE id=$id");
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
}

?>