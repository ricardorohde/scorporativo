<h1>Recuperar conta</h1>

<p>
	Digite seu e-mail, abaixo, para iniciar o processo de recuperação de senha.
</p>

<?php if(isset($_POST['submit']) || isset($erro)): ?>
<div class="mensagem erro">
	<?php if (isset($erro)) {echo $erro;} ?>
	<?=validation_errors()?>
</div>
<?php endif; ?>

<?=form_open(current_url())?>

	<div class="campo">
		<label for="email">E-mail</label>
		<input type="text" autofocus id="email" name="email" value="<?=set_value('email')?>">
	</div>
	
	<button class="botao submit" name="submit">
		Enviar
	</button>

<?=form_close()?>

<p>
	Caso haja qualquer dúvida, <a href="<?=site_url("contato")?>">entre em contato conosco</a>.
</p>

<hr>

<p>
	<a href="<?=site_url("sessoes/login")?>">&laquo; Voltar</a>
</p>