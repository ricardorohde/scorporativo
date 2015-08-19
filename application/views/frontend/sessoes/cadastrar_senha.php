<h1>Recuperar conta</h1>

<h2>Cadastro de nova senha</h2>

<p>
	Preencha os campos abaixo para cadastrar uma nova senha para a sua conta:
</p>

<?php if(isset($_POST['submit']) || isset($erro)): ?>
<div class="mensagem erro">
	<?php if (isset($erro)) {echo $erro;} ?>
	<?=validation_errors()?>
</div>
<?php endif; ?>

<?=form_open(current_url())?>
	<fieldset>
		
		<div class="campo">
			<label for="email">E-mail</label>
			<input type="text" autofocus id="email" name="email" value="<?=set_value('email')?>">
		</div>

		<fieldset class="grupo">
			<div class="campo grid2-1">
				<label>Nova Senha</label>
				<input type="password" name="senha">
			</div>
			<div class="campo grid2-1 ultima">
				<label>Confirme a Nova Senha</label>
				<input type="password" name="senhaconf">
			</div>
		</fieldset>

		<button class="botao submit" name="submit">
			Cadastrar Nova Senha
		</button>

	</fieldset>
<?=form_close()?>

<hr>

<p>
	<a href="<?=site_url()?>">&laquo; Home</a>
</p>