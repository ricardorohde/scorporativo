<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->sess->check_session(array('close' => true, 'tipo' => 'admin'));
	}
	
	function index() {
		$data['msg'] = $this->session->userdata('msg');
		$this->session->unset_userdata('msg');
		
		$this->_render('backend/backup',$data);
	}
	
	function gerar($tipo = 'completo') {
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		
		$nome = date('Y-m-d') . '_bd' . $this->config->item('site_cod') . '.sql';
		
		// Backup your entire database and assign it to a variable
		$prefs = array(
                'format'      => 'txt',    // gzip, zip, txt
                'filename'    => $nome,    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,     // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,     // Whether to add INSERT data to backup file
                'newline'     => "\n"      // Newline character used in backup file
              );

		$backup =& $this->dbutil->backup($prefs);
		
		// Write the file to your server
		write_file('arquivos/'.$nome, $backup);
		
		// Send the file to your desktop
		force_download($nome, $backup);
	}

}

?>