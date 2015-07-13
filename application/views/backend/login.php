<div class="form-login">
	
	<?php if(isset($_POST['submit']) || $msg): ?>
	<div class="mensagem mensagem-erro">
		<?=validation_errors()?>
		<?php if(isset($erro)) echo $erro; ?>
		<?php if(isset($msg)) echo $msg; ?>
	</div>
	<?php endif; ?>
	
	<?php print_r($this->session->userdata()); ?>

	<?=form_open(current_url())?>
	
		<fieldset>

			<div class="campo">
				<label for="login">Login</label>
				<input id="login" type="text" name="login" value="<?=set_value('login')?>" autofocus>
			</div>
			
			<div class="campo">
				<label for="senha">Senha</label>
				<input id="senha" type="password" name="senha">
			</div>
			
			<button name="submit" class="botao botao-submit">
				Login
			</button>
			
		</fieldset>
		
	<?=form_close()?>
	
</div>