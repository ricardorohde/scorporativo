<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teste_email extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index($tipo = null, $enviar = false) {
		//desativar função abaixo
		//die();
		
		if($tipo == 'usuario_novo_cadastro') {
			$content['nome'] = "Guilherme";
			$content['snome'] = "Müller";
			$content['email'] = "muller.guilherme@gmail.com";
			$content['senha'] = "teste";

			$emailparams = array('to' => 'contato@guilhermemuller.com.br'
								,'preview' => true
								,'template' => $tipo
								,'content' => $content
								);
			$this->_send_mail($emailparams);
		} else if($tipo == 'usuario_recupera_senha') {
			$content['email'] = $email = 'muller.guilherme@gmail.com';
			$data = date('Y-m-d');
			$salt = $this->config->item('static_salt');

			$key = sha1($data . $email . $salt);

			$content['link'] = site_url("sessoes/cadastrar_senha/$key");

			$emailparams = array('to' => 'contato@guilhermemuller.com.br'
								,'preview' => true
								,'template' => $tipo
								,'content' => $content
								);
			$this->_send_mail($emailparams);
		} else if($tipo == 'contato') {
			$content['nome'] = 'Teste';
			$content['email'] = 'email@exemplo.com';
			$content['telefone'] = '41 30822768';
			$content['cidade'] = 'Curitiba';
			$content['estado'] = 'PR';
			$content['mensagem'] = 'Mensagem teste.';
			
			$emailparams = array('to' => 'contato@guilhermemuller.com.br'
								,'preview' => true
								,'template' => $tipo
								,'content' => $content
								);
			$this->_send_mail($emailparams);
		} else {
			die('Tipo inválido.');
		}
	}
	
}

?>