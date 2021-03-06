<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_model extends MY_Model {

	function __construct() {
        parent::__construct();

        $this->tbl = "categorias";
    }

	function get_all($args = array()) {
		$parents = 0;
		$per_page = 20;

		extract($args);

		$params = array(
						'select' => "*",
						'from' => $this->tbl,
						'where' => "1=1",
						'order_by' => 'ordem ASC, nome ASC',
						'per_page' => $per_page
						);

		if(isset($mae) && is_numeric($mae)) {
			$params['where'] .= " AND mae=$mae ";
		}
		if(isset($nivel)) {
			$params['where'] .= " AND nivel='$nivel' ";
		}
		if(isset($tipo)) {
			$params['where'] .= " AND tipo='$tipo' ";
		}
		if(isset($order_by)) {
			$params['order_by'] = $order_by;
		}
		if(isset($ativo)) {
			$params['where'] .= " AND ativo=$ativo ";
		}

		return $this->get_entries($params);
	}

	function get_by_id($id = null) {
		$params = array(
						'select' => "*",
						'from' => 'categorias',
						'where' => "id=$id",
						'single' => true
						);

		return $this->get_entries($params);
	}

	function add_adm($update = false, $id = null) {
		$this->load->helper('str');

		$this->db->trans_start();

		$data['nome'] = $this->input->post('nome');
		$data['slug'] = url_title(simplify($this->input->post('nome')));
		$data['tipo'] = $this->input->post('tipo');
		$data['ativo'] = $this->input->post('ativo');

		//apenas válido para produtos
		if($data['tipo'] == 'produtos' && $this->input->post('mae')) {
			$data['mae'] = $this->input->post('mae');
		}
		if($data['tipo'] == 'produtos') {
			$data['nivel'] = $this->input->post('nivel');
		} else {
			$data['nivel'] = 'grupo';
		}

		if($data['nivel'] == 'grupo') {
			$data['mae'] = null;
		}

		if($update) {
			$where = "id=$id";
			$str = $this->db->update_string($this->_prefix.$this->tbl,$data,$where);
		} else {
			$str = $this->db->insert_string($this->_prefix.$this->tbl,$data);
		}
		$this->db->query($str);

		//tudo pronto
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}

	function excluir($id = null) {
		if(!is_numeric($id)) {
			return false;
		}

		$this->db->trans_start();

		$this->db->query("UPDATE {$this->_prefix}imagens SET categoria_id=NULL WHERE categoria_id=$id");
		$this->db->query("UPDATE {$this->_prefix}conteudo SET categoria_id=NULL WHERE categoria_id=$id");
		$this->db->query("DELETE FROM {$this->_prefix}{$this->tbl} WHERE mae=$id");
		$this->db->query("DELETE FROM {$this->_prefix}{$this->tbl} WHERE id=$id");

		$this->db->trans_complete();

		return $this->db->trans_status();
	}

}

?>
