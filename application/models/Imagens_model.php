<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagens_model extends MY_Model {

	function __construct() {
        parent::__construct();
		ini_set('memory_limit','128M');
		$this->load->library('image_lib');
		$this->erros = '';
    }

	function set_img($image_data = null, $prefix = null, $save_path = null) {
		if(!is_array($image_data)) {
			return false;
		}

		$this->image_data = $image_data;

		if($save_path == null) {
			$this->save_path = "imagens/enviadas/" . $prefix . $image_data['file_name'];
		} else {
			$this->save_path = "imagens/$save_path/" . $prefix . $image_data['file_name'];
		}

		$this->final_name = $prefix . $image_data['file_name'];
	}

	function crop_centered($width = 500, $height = null) {
		list($orig_width,$orig_height) = getimagesize($this->image_data['full_path']);

		if(!$height) {
			$height = $width;
		}

		$config['image_library'] = 'gd2';
		$config['source_image'] = $this->image_data['full_path'];
		$config['maintain_ratio'] = TRUE;

		//para que o corte saia certo, vamos primeiro diminuir a imagem
		$config['y_axis'] = '0';
		$config['x_axis'] = '0';
		if($orig_width > $orig_height) {
			$config['master_dim'] = 'height';
			$config['width'] = ($orig_width * $height)/$orig_height;
			//die($config['width']);
			if($config['width'] < $width) {
				$config['master_dim'] = 'width';
				$config['width'] = $width;
				$config['height'] = ($orig_height * $width)/$orig_width;
			} else {
				$config['height'] = $height;
			}
		} else if($orig_width < $orig_height) {
			$config['master_dim'] = 'width';
			$config['height'] = ($orig_height * $width)/$orig_width;
			if($config['height'] < $height) {
				$config['master_dim'] = 'height';
				$config['height'] = $height;
				$config['width'] = ($orig_width * $height)/$orig_height;
			} else {
				$config['width'] = $width;
			}
		} else {
			$config['width'] = $config['height'] = $width;
		}

		//imagem tempor�ria reduzida
		$config['new_image'] = "imagens/temp/tocrop_".$this->final_name;
		$this->image_lib->initialize($config);
		$resize = $this->image_lib->resize();

		//die(print_r($config));

		$this->image_lib->clear();

		//agora sim fazemos o corte com base na imagem menor
		$config['image_library'] = 'gd2';
		$config['source_image'] = "imagens/temp/tocrop_".$this->final_name;
		$config['new_image'] = $this->save_path;
		$config['maintain_ratio'] = FALSE;
		$config['width'] = $width;
		$config['height'] = $height;

		//pegamos as dimensoes da imagem temporaria
		list($orig_width,$orig_height) = getimagesize("imagens/temp/tocrop_".$this->final_name);

		//definimos as coordenadas do corte
		$config['x_axis'] = $orig_width/2 - $width/2;
		$config['y_axis'] = $orig_height/2 - $height/2;

		$this->image_lib->initialize($config);

		$process = $this->image_lib->crop();

		//die(print_r($config));

		$this->image_lib->clear();

		//die('teste');

		@unlink("imagens/temp/tocrop_".$this->final_name);

		if(!$process) {
			$this->erros .= $this->image_lib->display_errors('','');
			unlink($this->save_path);

			return false;
		} else {
			return $this->final_name;
		}
	}

	function resize($max_width = 500, $max_height = 500, $master_dim = 'auto') {
		list($orig_width,$orig_height) = getimagesize($this->image_data['full_path']);

		//se a imagem já estiver no tamanho certo, apenas vamos movê-la
		if($orig_width <= $max_width && $orig_height <= $max_height) {
			copy($this->image_data['full_path'],$this->save_path);
			return $this->final_name;
		}

		$config['image_library'] = 'gd2';
		$config['source_image'] = $this->image_data['full_path'];
		$config['new_image'] = $this->save_path;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $max_width;
		$config['height'] = $max_height;
		$config['master_dim'] = $master_dim;

		$this->image_lib->initialize($config);

		$process = $this->image_lib->resize();
		$this->image_lib->clear();

		if(!$process) {
			$this->erros .= $this->image_lib->display_errors('','');
			@unlink($this->save_path);

			return false;
		} else {
			return $this->final_name;
		}
	}

	function delete_source() {
		@unlink($this->image_data['full_path']);
	}
}

?>
