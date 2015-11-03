<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	function __construct() {
		parent::__construct();

		$this->_prefix = $this->config->item('_prefix');
	}

	function get_entries($args = array()) {
		$csv = false;
		$debug = false;
		$debug_count = false;
		$change_page = true;
		$this->current = 0;
		$this->per_page = 1000;
		$this->total_rows = 0;
		$select = '*';

		extract($args);

		if(isset($per_page) && $per_page > 0 && $change_page) {
			$str = "SELECT COUNT(*) as numrows FROM $this->_prefix$from ";
			if(isset($join) && !empty($join)) {
				$str .= "$join ";
			}
			if(isset($where) && !empty($where)) {
				$str .= "WHERE $where ";
			}
			if(isset($group_by) && !empty($group_by)) {
				$str .= "GROUP BY $group_by ";
			}

			if($debug_count) {
				print($str) . '<br>';
			}

			$query = $this->db->query($str);

			if(isset($group_by) && !empty($group_by)) {
				$this->total_rows = $query->num_rows();
			} else {
				$this->total_rows = $query->row()->numrows;
			}

			$query->free_result();

			// se houver paginação
			$current = $this->uri->segment($this->uri->total_segments());
			if(!strstr($current,'p-')) {
				$current = 0;
			} else {
				$current = str_replace('p-','',$current);
				if(!is_numeric($current)) {
					$current = 0;
				}
			}
			$this->current = $current;
			$this->per_page = $per_page;
		}

		$str = "SELECT $select FROM $this->_prefix$from ";
		if(isset($join) && !empty($join)) {
			$str .= "$join ";
		}
		if(isset($where) && !empty($where)) {
			$str .= "WHERE $where ";
		}
		if(isset($group_by) && !empty($group_by)) {
			$str .= "GROUP BY $group_by ";
		}
		if(isset($having) && !empty($having)) {
			$str .= "HAVING $having ";
		}
		if(isset($order_by) && !empty($order_by)) {
			$str .= "ORDER BY $order_by ";
		}
		if(isset($per_page) && $per_page > 0 && $change_page) {
			$str .= "LIMIT $current, $per_page ";
		}

		$query = $this->db->query($str);

		if($debug) {
			print($str) . '<br>';
		}

		if($query->num_rows() < 1) {
			return false;
		}

		if($csv == true) {
			//retorna csv
			$result_csv = $this->dbutil->csv_from_result($query);
			return $result_csv;
		}

		if(isset($single) && $single == true) {
			return $query->row();
		} else {
			return $query->result();
		}
	}

	function add($adata = array()) {
		return $this->add_adm(false,null,$adata);
	}

	function upt($adata = array(), $id) {
		return $this->add_adm(true,$id,$adata);
	}

	function add_imagem($img_data, $id_item, $update = false, $id_imagem = null) {
		$tipo = $this->input->post('tipo');

		//colocamos a(s) imagem(s)
		if(is_array($img_data['a1'])) {
			if($tipo == 'slide') {
				$this->img->set_img($img_data['a1'],'slide_');
				$data['med'] = $this->img->crop_centered($this->config->item('slide_width'),$this->config->item('slide_height'));
			} else {
				$this->img->set_img($img_data['a1'],'thumb_');
				$data['thumb'] = $this->img->crop_centered(150);

				$this->img->set_img($img_data['a1'],'med_');
				$data['med'] = $this->img->resize(800,600);
			}
		}

		$this->img->delete_source();

		$data['obj_id'] = $id_item;
		$data['obj_tipo'] = $tipo;
		$data['legenda'] = $this->input->post('legenda');
		$data['link'] = $this->input->post('link');

		//campos adicionais
		if($this->input->post('categoria')) {
			$data['categoria_id'] = $this->input->post('categoria');
		}

		if($update) {
			$where = "id=$id_imagem";
			$str = $this->db->update_string('imagens',$data,$where);
		} else {
			//ordem para jogar lá para o final
			$data['ordem'] = 9999;

			$str = $this->db->insert_string('imagens',$data);
		}

		$this->db->query($str);

		return true;
	}

	//args:
	//$id: integer
	//$all: true / false
	//$destructive: true / false
	//$tipo: tipo da imagem (obj_tipo)
	function excluir_imagens($args = array()) {
		$all = false;
		$destructive = true;

		extract($args);

		if(!isset($id) || !is_numeric($id)) {
			return false;
		}

		if($all) {
			if(!isset($tipo)) {
				return false;
			}
			$query = $this->db->query("SELECT mini, thumb, med, big, mini_2x, thumb_2x, med_2x, big_2x FROM {$this->_prefix}imagens WHERE obj_id=$id AND obj_tipo='$tipo'");
		} else {
			$query = $this->db->query("SELECT mini, thumb, med, big, mini_2x, thumb_2x, med_2x, big_2x FROM {$this->_prefix}imagens WHERE id=$id");
		}

		if($query->num_rows() < 1) {
			//nenhuma imagem para excluir
			return true;
		}

		if($all) {
			$result = $query->result();
		} else {
			$result = array($query->row());
		}

		foreach($result as $row) {
			//deleta as imagens
			@unlink("imagens/enviadas/$row->mini");
			@unlink("imagens/enviadas/$row->thumb");
			@unlink("imagens/enviadas/$row->med");
			@unlink("imagens/enviadas/$row->big");
			@unlink("imagens/enviadas/$row->mini_2x");
			@unlink("imagens/enviadas/$row->thumb_2x");
			@unlink("imagens/enviadas/$row->med_2x");
			@unlink("imagens/enviadas/$row->big_2x");
		}

		if($all) {
			if($destructive == 'true') {
				$this->db->query("DELETE FROM {$this->_prefix}imagens WHERE obj_id=$id AND obj_tipo='$tipo'");
			} else {
				$this->db->query("UPDATE {$this->_prefix}imagens SET mini=NULL, thumb=NULL, med=NULL, big=NULL, mini_2x=NULL, thumb_2x=NULL, med_2x=NULL, big_2x=NULL WHERE obj_id=$id AND obj_tipo='$tipo'");
			}
		} else {
			if($destructive == 'true') {
				$this->db->query("DELETE FROM {$this->_prefix}imagens WHERE id=$id");
			} else {
				$this->db->query("UPDATE {$this->_prefix}imagens SET mini=NULL, thumb=NULL, med=NULL, big=NULL, mini_2x=NULL, thumb_2x=NULL, med_2x=NULL, big_2x=NULL WHERE id=$id");
			}
		}

		return TRUE;
	}

	//args:
	//$id: integer
	//$tipo: string
	function get_imagens($args = array()) {
		if(isset($this->cskw)) {
			$tipo = $this->cskw;
		}

		extract($args);

		$params = array(
						'select' => '*',
						'from' => 'imagens',
						'where' => '1=1',
						//'debug' => true,
						'order_by' => 'ordem ASC, data_cadastro ASC'
						);

		if(isset($id) && is_numeric($id)) {
			$params['where'] .= " AND obj_id=$id ";
		}
		if(isset($tipo)) {
			$params['where'] .= " AND obj_tipo='$tipo' ";
		}
		if(isset($categoria) && is_numeric($categoria)) {
			$params['where'] .= " AND categoria_id=$categoria ";
		}

		return $this->get_entries($params);
	}

	function get_imagem($id_imagem = null) {
		if(empty($id_imagem)) {
			return false;
		}

		$params = array(
						'select' => '*',
						'from' => 'imagens',
						'where' => "id=$id_imagem",
						'single' => true
						);

		return $this->get_entries($params);
	}

	function reordenar_imagens() {
		$tipo = $this->input->post('tipo');
		$ordem = $this->input->post('ordem');
		$obj = $this->input->post('obj');
		$ordem = explode('&',$ordem);
		//print_r($ordem);

		$i = 1;
		foreach($ordem as $row) {
			$value = substr($row,6);
			if(!is_numeric($value)) {
				continue;
			}
			$str = "UPDATE {$this->_prefix}imagens SET ordem=$i WHERE id=$value";
			if(!empty($obj)) {
				$str .= " AND obj_id=$obj ";
			}
			$str .= " AND obj_tipo='$tipo' ";
			echo $str;

			$this->db->query($str);
			$i++;
		}

		if($this->db->affected_rows() > 0) {
			return "Ordem atualizada.";
		} else {
			return "Ordem atualizada.";
		}
	}

	function reordenar() {
		$ordem = $this->input->post('ordem');
		$ordem = explode('&',$ordem);
		//print_r($ordem);

		$i = 1;
		foreach($ordem as $row) {
			$value = substr($row,6);
			if(!is_numeric($value)) {
				continue;
			}
			$str = "UPDATE {$this->_prefix}{$this->kw} SET ordem=$i WHERE id=$value";
			//echo $str;

			$this->db->query($str);
			$i++;
		}

		return "Ordem atualizada.";
	}

	//args:
	//$field: string
	//$table: string
	//$str: string
	function check_duplicates($args) {
		extract($args);

		$this->db->select($field)->from($table)->where($field,$str);
		$query = $this->db->get();

		if($query->num_rows() > 0) {
			//já existe um cadastro com este campo igual
			return TRUE;
		} else {
			//campo OK
			return FALSE;
		}
	}

	function get_estados() {
		$params = array(
						'select' => '*',
						'from' => 'estados',
						'order_by' => 'sigla ASC'
						);

		return $this->get_entries($params);
	}

}

?>
