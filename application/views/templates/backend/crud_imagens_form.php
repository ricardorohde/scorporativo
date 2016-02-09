<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>

<h1>
	<?php if($acao == 'alterar'): ?>
	Alterar
	<?php else: ?>
	Adicionar
	<?php endif; ?>
	imagem: <?=$nome?>
</h1>

<?php if(isset($msg) && $msg): ?>
<div class="mensagem mensagem-info">
	<?=$msg?>
</div>
<?php endif; ?>

<?php if(validation_errors() || $erro): ?>
<div class="mensagem mensagem-erro">
	<?php if ($erro) echo $erro; ?>
	<?=validation_errors()?>
</div>
<?php endif; ?>

<?php
if(file_exists("application/views/backend/$this->kw/detalhes.php")) {
	$this->load->view("backend/$this->kw/menu",array($this->cskw => $item));
}
?>

<?=form_open_multipart(current_url())?>

	<input type="hidden" name="obj" value="<?=$item->id?>">
	<input type="hidden" name="tipo" value="<?=$this->cskw?>">

	<div class="campo">
		<?php if(empty($imagem->med)): ?>
		<label>Imagem <span>formatos jpg, gif ou png, tamanho máximo 5mb</span></label>
		<input type="hidden" name="MAX_FILE_SIZE" value="5242880">
		<input type="file" name="imagem">
		<?php else: ?>
		Imagem <a class="icone excluir" href="<?=site_url("admin/$this->kw/excluir_imagem/$imagem->id/false")?>">Excluir</a>
		<br>
		<img src="<?=base_url()?>imagens/enviadas/<?=$imagem->med?>" alt="Arquivo <?=$imagem->med?>">
		<?php endif; ?>
	</div>

	<div class="campo">
		<label>Legenda <span>opcional</span></label>
		<input type="text" name="legenda" value="<?=set_value('legenda')?>">
	</div>

	<button name="submit" class="botao  botao-submit">
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
