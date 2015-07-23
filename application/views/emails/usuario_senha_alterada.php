<p style="font-size: 24px; color: #000000">
	Alteração de Senha da sua Conta
</p>

<p>
	Olá <?=$nome?>,
</p>
<p>
	Informamos que a senha da sua conta no site <?=$this->config->item('site_title')?>, e-mail <strong><?=$email?></strong>, foi alterada. <a target="_blank" href="<?=site_url("sessoes/login")?>">Você pode fazer o login na sua conta aqui</a>.
</p>
<p>
	Caso você não tenha feito esta modificação na sua conta, informe-nos imediatamente <a target="_blank" href="<?=site_url("contato")?>">através deste link</a>.
</p>

<p>
	Atenciosamente,
	<br>
	<?=$this->config->item('site_title')?>
</p>