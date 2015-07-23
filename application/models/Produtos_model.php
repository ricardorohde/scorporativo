<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_model extends MY_Model {

	function __construct() {
        parent::__construct();
    }

	/*
	-- Getters
	*/

	function get_all($args = array()) {
		$perpage = 20;

		extract($args);

		$params = array(
						'select' => 'p.id, p.nome, i.thumb, p.slug, p.preco',
						'from' => 'produtos p',
						'join' => "LEFT JOIN {$this->_prefix}imagens i ON i.obj_id=p.id AND obj_tipo='produto'",
						'orderby' => 'p.nome ASC',
						'where' => '1=1',
						'perpage' => $perpage
						);

		if(isset($nome)) {
			$this->load->helper('str');
			$likestr = likestr($nome);
			$params['where'] .= " AND p.nome LIKE '$likestr' ";
		}

		if(isset($ativo) && is_numeric($ativo)) {
			$params['where'] .= " AND ativo=$ativo ";
		}

		return $this->get_entries($params);
	}

	function get_produto_categorias($args = array()) {
		$as_array = false;

		extract($args);

		$params = array(
						'select' => "pc.produto_id, pc.categoria_id, c.nome, c.slug, c.nivel",
						'from' => 'produtos_categorias pc',
						'join' => "JOIN {$this->_prefix}categorias c ON c.id=pc.categoria_id",
						'where' => "pc.produto_id=$produto"
						);

		if($as_array) {
			$results = $this->get_entries($params);
			if($results) {
				$result_array = array();

				foreach($results as $row) {
					$result_array[] = $row->categoria_id;
				}

				return $result_array;
			} else {
				return array();
			}
		}

		return $this->get_entries($params);
	}

	function get_by_cod($cod = null) {
		$params = array(
						'where' => "codigo='$cod'",
						'from' => 'produtos',
						'single' => true
						);

		return $this->get_entries($params);
	}

	function get_by_id($id = null) {
		$params = array(
						'where' => "id=$id",
						'from' => 'produtos',
						'single' => true
						);

		return $this->get_entries($params);
	}

	/*
	-- Setters
	*/

	function add_adm($update = false, $id = null) {
		$this->load->helper('str');

		$this->db->trans_start();

		$data['nome'] = $this->input->post('nome');
		$slug = $this->input->post('slug');
		if(empty($slug)) {
			$data['slug'] = url_title(simplify($this->input->post('nome')));
		} else {
			$data['slug'] = $slug;
		}
		$data['ativo'] = 0;

		if($update) {
			$where = "id=$id";
			$str = $this->db->update_string($this->_prefix.'produtos',$data,$where);
		} else {
			$str = $this->db->insert_string($this->_prefix.'produtos',$data);
		}
		$this->db->query($str);

		if(!$update) {
			$id = $this->db->insert_id();
		}

		//tudo pronto
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return $id;
		}
	}

	/*
	-- Updaters
	*/

	function upt_dados_gerais() {
		$this->load->helper('str');

		$item_id = $this->input->post('item_id');

		$this->db->trans_start();

		//tabela principal
		$data['nome'] = $this->input->post('nome');
		$data['preco'] = str_replace(',','.',$this->input->post('preco'));
		$data['peso'] = $this->input->post('peso');
		$data['descricao'] = $this->input->post('descricao');
		$data['ativo'] = $this->input->post('ativo');

		$slug = $this->input->post('slug');
		if(empty($slug)) {
			$data['slug'] = url_title(simplify($this->input->post('nome')));
		} else {
			$data['slug'] = $slug;
		}

		$str = $this->db->update_string("produtos",$data,"id=$item_id");
		$query = $this->db->query($str);

		unset($data);
		//

		//tudo ok
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	function upt_categorias() {
		$item_id = $this->input->post('item_id');

		$this->db->trans_start();

		//primeiro excluímos as categorias já associadas ao produto
		$this->db->query("DELETE FROM {$this->_prefix}produtos_categorias WHERE produto_id=$item_id");

		//agora inserimos as categorias conforme foram marcadas
		$categorias = $this->input->post('categorias');
		foreach($categorias as $row) {
			$data['produto_id'] = $item_id;
			$data['categoria_id'] = $row;

			$str = $this->db->insert_string($this->_prefix.'produtos_categorias',$data);
			$this->db->query($str);

			unset($data);
		}

		//tudo ok
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	/*
	-- Deleter
	*/

	function excluir($id = null) {
		if(!is_numeric($id)) {
			return false;
		}

		$this->db->trans_start();

		$this->excluir_imagens(array('id' => $id, 'tipo' => $this->cskw, 'all' => true));

		$this->db->query("DELETE FROM {$this->_prefix}produtos_categorias WHERE produto_id=$id");
		$this->db->query("DELETE FROM {$this->_prefix}produtos WHERE id=$id");

		$this->db->trans_complete();

		return true;
	}

}

?>
