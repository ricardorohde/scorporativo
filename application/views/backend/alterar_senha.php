<h1>
	Alterar Senha
</h1>

<?php if(isset($_POST['submit'])): ?>
<div class="mensagem">
	<?=validation_errors()?>
	<?php if(isset($msg)) echo $msg; ?>
</div>
<?php endif; ?>

<?=form_open(current_url())?>

	<fieldset>
		
		<div class="campo">
			<label>Nova Senha</label>
			<input type="password" name="senha">
		</div>
		
		<div class="campo">
			<label>Confirme a Nova Senha</label>
			<input type="password" name="senhaconf">
		</div>
		
		<button name="submit" class="botao submit">
			Alterar
		</button>
		
	</fieldset>
	
<?=form_close()?>