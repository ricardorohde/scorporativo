<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends My_Model {
	
	function __construct() {
        parent::__construct();
    }
	
	function upload($args = array()) {
		$campo = 'imagem';
		$path = 'imagens/temp/';
		$types = 'jpg|gif|png';
		$max_size = 10000;
		$max_width = 10000;
		$max_height = 10000;
		$encrypt = true;

		extract($args);
		
		if(empty($_FILES[$campo]['name'])) {
			return;
		}
		
		if($encrypt) {
			$config['encrypt_name'] = TRUE;
		}
		$config['upload_path'] = $path;
		$config['allowed_types'] = $types;
		$config['max_size']	= $max_size;
		$config['max_width']  = $max_width;
		$config['max_height']  = $max_height;
			
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload($campo)) {
			//die('erro');
			return $this->upload->display_errors('','');
		} else {
			return $data = $this->upload->data();
		}
	}
}

?>