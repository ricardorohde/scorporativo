<h1>
	<?php if($acao == 'novo'): ?>
	Adicionar
	<?php else: ?>
	Alterar
	<?php endif; ?>
	<?=ucfirst($this->cskw);?>
</h1>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem info">
	<?=$msg?>
</div>
<?php endif; ?>

<?php if(isset($_POST['submit'])): ?>
<div class="mensagem erro">
	<?=validation_errors()?>
</div>
<?php endif; ?>

<?=form_open_multipart(current_url())?>

	<fieldset>
		
		<?php $this->load->view("backend/$this->kw/form"); ?>
		
		<?php if($acao == 'novo'): ?>
		<button name="submit" class="botao submit">
			Cadastrar
		</button>
		<?php else: ?>
		<button name="submit" class="botao submit">
			Alterar
		</button>
		<?php endif; ?>
		
	</fieldset>

<?=form_close()?>

<hr>

<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>