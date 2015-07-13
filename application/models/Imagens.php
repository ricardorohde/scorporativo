<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Imagens extends MY_Model {
	
	function __construct() {
        parent::__construct();
		ini_set('memory_limit','128M');
		$this->load->library('image_lib');
		$this->erros = '';
    }
	
	function set_img($image_data = null, $savepath = null, $prefix = null) {
		if(!is_array($image_data)) {
			return false;
		}
		
		$this->image_data = $image_data;
		
		if($savepath == null) {
			$this->savepath = "imagens/fotos/" . $prefix . $image_data['file_name'];
		} else {
			$this->savepath = "imagens/$savepath/" . $prefix . $image_data['file_name'];
		}
		
		$this->finalname = $prefix . $image_data['file_name'];
	}
	
	function crop_centered($width = 500, $height = null) {
		list($origwidth,$origheight) = getimagesize($this->image_data['full_path']);
		
		if(!$height) {
			$height = $width;
		}
		
		$config['image_library'] = 'gd2';
		$config['source_image'] = $this->image_data['full_path'];
		$config['maintain_ratio'] = TRUE;
			
		//para que o corte saia certo, vamos primeiro diminuir a imagem
		$config['y_axis'] = '0';
		$config['x_axis'] = '0';
		if($origwidth > $origheight) {
			$config['master_dim'] = 'height';
			$config['width'] = ($origwidth * $height)/$origheight;
			//die($config['width']);
			if($config['width'] < $width) {
				$config['master_dim'] = 'width';
				$config['width'] = $width;
				$config['height'] = ($origheight * $width)/$origwidth;
			} else {
				$config['height'] = $height;
			}
		} else if($origwidth < $origheight) {
			$config['master_dim'] = 'width';
			$config['height'] = ($origheight * $width)/$origwidth;
			if($config['height'] < $height) {
				$config['master_dim'] = 'height';
				$config['height'] = $height;
				$config['width'] = ($origwidth * $height)/$origheight;
			} else {
				$config['width'] = $width;
			}
		} else {
			$config['width'] = $config['height'] = $width;
		}
		
		//imagem temporária reduzida
		$config['new_image'] = "imagens/temp/tocrop_".$this->finalname;
		$this->image_lib->initialize($config);
		$resize = $this->image_lib->resize();
		
		//die(print_r($config));
		
		$this->image_lib->clear();
		
		//agora sim fazemos o corte com base na imagem menor
		$config['image_library'] = 'gd2';
		$config['source_image'] = "imagens/temp/tocrop_".$this->finalname;
		$config['new_image'] = $this->savepath;
		$config['maintain_ratio'] = FALSE;
		$config['width'] = $width;
		$config['height'] = $height;
		
		//pegamos as dimensoes da imagem temporaria
		list($origwidth,$origheight) = getimagesize("imagens/temp/tocrop_".$this->finalname);
		
		//definimos as coordenadas do corte
		$config['x_axis'] = $origwidth/2 - $width/2;
		$config['y_axis'] = $origheight/2 - $height/2;
		
		$this->image_lib->initialize($config);
		
		$process = $this->image_lib->crop();
		
		//die(print_r($config));
		
		$this->image_lib->clear();
		
		//die('teste');
		
		@unlink("imagens/temp/tocrop_".$this->finalname);
		
		if(!$process) {
			$this->erros .= $this->image_lib->display_errors('','');
			unlink($this->savepath);
			
			return false;
		} else {
			return $this->finalname;
		}
	}
	
	function resize($maxwidth = 500, $maxheight = 500, $masterdim = 'auto') {
		list($origwidth,$origheight) = getimagesize($this->image_data['full_path']);
		
		//se a imagem já estiver no tamanho certo, apenas vamos movê-la
		if($origwidth <= $maxwidth && $origheight <= $maxheight) {
			copy($this->image_data['full_path'],$this->savepath);
			return $this->finalname;
		}
		
		$config['image_library'] = 'gd2';
		$config['source_image'] = $this->image_data['full_path'];
		$config['new_image'] = $this->savepath;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $maxwidth;
		$config['height'] = $maxheight;
		$config['master_dim'] = $masterdim;
		
		$this->image_lib->initialize($config);
		
		$process = $this->image_lib->resize();
		$this->image_lib->clear();
		
		if(!$process) {
			$this->erros .= $this->image_lib->display_errors('','');
			@unlink($this->savepath);
			
			return false;
		} else {
			return $this->finalname;
		}
	}
	
	function deleteSource() {
		@unlink($this->image_data['full_path']);
	}
}

?>