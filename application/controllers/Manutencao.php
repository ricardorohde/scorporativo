<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manutencao extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function teste_email($tipo = null, $enviar = false) {
		//desativar função abaixo
		//die();
		
		if($tipo == 'usuario_novo_cadastro') {
			$cdata['nome'] = "Guilherme";
			$cdata['snome'] = "Müller";
			$cdata['email'] = "muller.guilherme@gmail.com";
			$cdata['senha'] = "teste";

			$emailparams = array('to' => 'contato@guilhermemuller.com.br'
								,'preview' => true
								,'template' => $tipo
								,'cdata' => $cdata
								);
			$this->_send_mail($emailparams);
		} else if($tipo == 'usuario_recupera_senha') {
			$cdata['email'] = $email = 'muller.guilherme@gmail.com';
			$data = date('Y-m-d');
			$salt = $this->config->item('static_salt');

			$key = sha1($data . $email . $salt);

			$cdata['link'] = site_url("sessoes/cadastrar_senha/$key");

			$emailparams = array('to' => 'contato@guilhermemuller.com.br'
								,'preview' => true
								,'template' => $tipo
								,'cdata' => $cdata
								);
			$this->_send_mail($emailparams);
		} else {
			$emdata['nome'] = 'Teste';
			$emdata['email'] = 'email@exemplo.com';
			$emdata['telefone'] = '41 30822768';
			$emdata['cidade'] = 'Curitiba';
			$emdata['estado'] = 'PR';
			$emdata['mensagem'] = 'Mensagem teste.';
			
			$emailparams = array('to' => 'contato@guilhermemuller.com.br'
								,'preview' => true
								,'template' => $tipo
								,'cdata' => $emdata
								);
			$this->_send_mail($emailparams);
		}
	}
	
}

?>