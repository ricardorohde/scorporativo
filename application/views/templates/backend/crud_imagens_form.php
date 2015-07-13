<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>

<h1>
	<?php if($acao == 'alterar'): ?>
	Alterar
	<?php else: ?>
	Adicionar
	<?php endif; ?>
	foto: <?=$nome?>
</h1>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem info">
	<?=$msg?>
</div>
<?php endif; ?>

<?php if(isset($_POST['submit'])): ?>
<div class="mensagem">
	<?php if (isset($erro)) echo $erro; ?>
	<?=validation_errors()?>
</div>
<?php endif; ?>

<?php
if(file_exists("application/views/backend/$this->kw/detalhes.php")) {
	$this->load->view("backend/$this->kw/menu",array($this->cskw => $o));
}
?>

<?=form_open_multipart(current_url())?>

	<fieldset>
		
		<input type="hidden" name="obj" value="<?=$o->id?>">
		<input type="hidden" name="tipo" value="<?=$this->cskw?>">
		
		<div class="campo">
			<?php if(empty($foto->med)): ?>
			<label>Imagem <span>formatos jpg, gif ou png, tamanho máximo 5mb</span></label>
			<input type="hidden" name="MAX_FILE_SIZE" value="5242880">
			<input type="file" class="input" name="imagem">
			<?php else: ?>
			Foto <a class="icone excluir" href="<?=site_url("admin/$this->kw/excimg/$foto->id/false")?>">Excluir</a>
			<br>
			<img style="width:250px" src="<?=base_url()?>imagens/fotos/<?=$foto->med?>">
			<?php endif; ?>
		</div>
		
		<div class="campo">
			<label>Legenda <span>opcional</span></label>
			<input type="text" name="legenda" value="<?=set_value('legenda')?>" style="width: 30em">
		</div>
		
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