<h1>
	Alterar Senha
</h1>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem mensagem-info">
	<?=$msg?>
</div>
<?php endif; ?>

<?php if(isset($_POST['submit']) && $erro): ?>
<div class="mensagem mensagem-erro">
	<?=validation_errors()?>
</div>
<?php endif; ?>

<?=form_open(current_url())?>

	<p>
		Login: <?=$this->session->userdata('usuario')?>
	</p>

	<fieldset class="grupo">
		<div class="campo">
			<label>Nova Senha</label>
			<input type="password" name="senha">
		</div>

		<div class="campo">
			<label>Confirme a Nova Senha</label>
			<input type="password" name="senha_conf">
		</div>
	</fieldset>

	<button name="submit" class="botao botao-submit">
		Alterar
	</button>

<?=form_close()?>
