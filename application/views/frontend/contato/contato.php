<h1><?=$pagina->titulo?></h1>

<p>
	Entre em contato conosco através do formulário abaixo:
</p>

<?php if(validation_errors()): ?>
<div class="mensagem mensagem-erro">
	<?=validation_errors()?>
</div>
<?php endif; ?>

<div class="form form-padrao">
	<?=form_open(current_url())?>
		
		<div class="campo">
			<label for="nome">Nome</label>
			<input type="text" id="nome" name="nome" value="<?=set_value('nome')?>">
		</div>
		
		<div class="campo">
			<label for="email">E-mail</label>
			<input type="email" id="email" name="email" value="<?=set_value('email')?>">
		</div>
		<div class="campo">
			<label for="telefone">Telefone</label>
			<input type="tel" id="telefone" name="telefone" value="<?=set_value('telefone')?>">
		</div>
		
		<div class="campo">
			<label for="mensagem">Mensagem</label>
			<textarea style="height: 10em" id="mensagem" name="mensagem"><?=set_value('mensagem')?></textarea>
		</div>
		
		<button class="botao botao-submit" type="submit" name="submit">Enviar</button>
		
	<?=form_close()?>
</div>