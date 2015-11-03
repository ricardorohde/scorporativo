<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Paginas_model extends MY_Model {

	function __construct() {
        parent::__construct();
    }
	
	function get_all($args = array()) {
		$per_page = 20;
		$editavel = null;
		
		extract($args);
		
		$params = array(
						'from' => 'paginas',
						'order_by' => 'menu ASC, ordem ASC, nome ASC',
						'where' => '1=1',
						'per_page' => $per_page
						);
		
		if(isset($editavel) && is_numeric($editavel)) {
			$params['where'] .= " AND editavel=$editavel ";
		}
		
		if(isset($ativo) && is_numeric($ativo)) {
			$params['where'] .= " AND ativo=$ativo ";
		}

		if(isset($menu) && is_numeric($menu)) {
			$params['where'] .= " AND menu=$menu ";
			$parents = 0;
		}

		if(isset($parents) && $parents == 1) {
			$params['where'] .= ' AND (mae IS NULL OR mae=0) ';
		}

		if(isset($mae) && is_numeric($mae)) {
			$params['where'] .= " AND mae=$mae ";
		}
						
		return $this->get_entries($params);
	}
	
	function get_by_cod($cod = null) {
		$params = array(
						'where' => "codigo='$cod'",
						'from' => 'paginas',
						'single' => true
						);
						
		return $this->get_entries($params);
	}
	
	function get_by_id($id = null) {
		$params = array(
						'where' => "id=$id",
						'from' => 'paginas',
						'single' => true
						);
						
		return $this->get_entries($params);
	}
	
	function add_adm($update = false, $id = null) {
		
		$this->load->helper('str');
		
		$this->db->trans_start();

		if($this->input->post('mae')) {
			$data['mae'] = $this->input->post('mae');
		}
		$data['nome'] = $this->input->post('nome');
		$data['codigo'] = url_title(simplify($this->input->post('codigo')));
		$data['titulo'] = $this->input->post('titulo');
		$data['texto'] = $this->input->post('texto');
		$data['ativo'] = $this->input->post('ativo');
		
		$data['menu'] = $this->input->post('menu');
		$data['submenu'] = $this->input->post('submenu');
		$data['editavel'] = $this->input->post('editavel');
		
		if($update) {
			$where = "id=$id";
			$str = $this->db->update_string($this->_prefix.'paginas',$data,$where);
		} else {
			$str = $this->db->insert_string($this->_prefix.'paginas',$data);
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

	function del($id = null) {
		if(!is_numeric($id)) {
			return false;
		}
		
		$this->db->trans_start();

		$this->delimgs(array('id' => $id, 'tipo' => $this->cskw, 'all' => true));
		
		$this->db->query("DELETE FROM {$this->_prefix}paginas WHERE id=$id");
		
		$this->db->trans_complete();
		
		return true;
	}
	
}

?>