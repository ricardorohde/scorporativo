<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends My_Model {
	
	function __construct() {
        parent::__construct();
    }
	
	function upload($campo = 'imagem', $path = 'imagens/temp/', $types = 'jpg|gif|png', $maxsize = 10000, $maxwidth = 10000, $maxheight = 10000, $encrypt = true) {
		
		if(empty($_FILES[$campo]['name'])) {
			return;
		}
		
		if($encrypt) {
			$config['encrypt_name'] = TRUE;
		}
		$config['upload_path'] = $path;
		$config['allowed_types'] = $types;
		$config['max_size']	= $maxsize;
		$config['max_width']  = $maxwidth;
		$config['max_height']  = $maxheight;
			
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