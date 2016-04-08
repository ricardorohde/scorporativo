<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userlog_model extends MY_Model {

	function __construct() {
        parent::__construct();

        $this->tbl = "acessos";
    }
		
	function get_all($args = array()) {
		$per_page = 100;

		extract($args);

		$params = array(
						'select' => '*',
						'from' => $this->tbl,
						'order_by' => 'data_cadastro DESC',
						'per_page' => $per_page
						);
		
		return $this->get_entries($params);
	}
}

?>