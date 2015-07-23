<p style="font-size: 24px; color: #000000;">
	Recuperação de senha da sua conta
</p>

<p>
	Olá,
</p>

<p>
	Foi solicitado através do site <?=$this->config->item('site_title')?> a recuperação de senha para a conta com o e-mail <strong><?=$email?></strong>.
</p>
<p>
	Clique no link abaixo para cadastrar uma nova senha para a sua conta. Este link será válido para alteração de senha apenas para o dia de hoje, <?=date('d/m/Y')?>.
</p>
<p>
	<a href="<?=$link?>" target="_blank"><?=$link?></a>
</p>

<p>
	Caso não tenha solicitado esta alteração de senha pelo site, favor desconsiderar este e-mail.
</p>

<p>
	Atenciosamente,
	<br>
	<?=$this->config->item('site_title')?>
</p>