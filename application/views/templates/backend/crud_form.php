<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>

<h1>
	<?php if($acao == 'novo'): ?>
	Adicionar
	<?php else: ?>
	Alterar
	<?php endif; ?>
	<?=ucfirst($this->cskw);?>
</h1>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem mensagem-info">
	<?=$msg?>
</div>
<?php endif; ?>

<?php if(isset($_POST['submit'])): ?>
<div class="mensagem mensagem-erro">
	<?=validation_errors()?>
</div>
<?php endif; ?>

<?=form_open_multipart(current_url())?>

	<?php $this->load->view("backend/$this->kw/form"); ?>

	<button name="submit" class="botao botao-submit">
		<?php if($acao == 'novo'): ?>
			Cadastrar
		<?php else: ?>
			Alterar
		<?php endif; ?>
	</button>

<?=form_close()?>

<hr>

<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>
