<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_adm_model extends MY_Model {

	function __construct() {
        parent::__construct();

        $this->tbl = "adm";
    }

	function get_all() {
		$params = array(
						'select' => 'id, login, nome',
						'from' => $this->tbl,
						'order_by' => 'id ASC',
						'per_page' => 20
						);

		return $this->get_entries($params);
	}

	function get_by_id($id = null) {
		$params = array(
				 		'select' => 'id, login, nome, nivel',
						'where' => "id='$id'",
						'from' => $this->tbl,
						'single' => true
						);

		return $this->get_entries($params);
	}

	function get_by_login($login = null) {
		$params = array(
						'where' => "login='$login'",
						'from' => $this->tbl,
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

		if($update) {
			if(is_numeric($id)) {
				$where = "id=$id";
			} else {
				$where = "login='$id'";
			}
			$str = $this->db->update_string($this->_prefix.$this->tbl,$data,$where);
		} else {
			$str = $this->db->insert_string($this->_prefix.$this->tbl,$data);
		}
		$this->db->query($str);

		return true;
	}

	function excluir($id = null) {
		if(!is_numeric($id)) {
			return false;
		}
		
		$this->db->trans_start();

		$this->db->query("DELETE FROM {$this->_prefix}{$this->tbl} WHERE id='$id'");

		//tudo ok
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
}

?>
