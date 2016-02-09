<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
	
    function __construct() {
        parent::__construct();
    }

	public function set_value_default($field = '', $default = '')
	{
		$this->_field_data[$field]['postdata'] = $default;

		//print_r($this->_field_data);

		return $default;
	}
}

?>