<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>

<h1>
	<?php if($acao == 'alterar'): ?>
	Alterar
	<?php else: ?>
	Adicionar
	<?php endif; ?>
	<?=$this->cskw?>
</h1>

<?php if(isset($msg) && $msg): ?>
<div class="mensagem mensagem-info">
	<?=$msg?>
</div>
<?php endif; ?>

<?php if(validation_errors()): ?>
<div class="mensagem mensagem-erro">
	<?=validation_errors()?>
</div>
<?php endif; ?>

<?=form_open_multipart(current_url())?>

	<fieldset>

		<input type="hidden" name="obj" value="0">
		<input type="hidden" name="tipo" value="<?=$this->cskw?>">

		<div class="campo">
			<?php if(empty($imagem->med)): ?>
			<label>Imagem <?=$this->config->item('slide_width')?> &times; <?=$this->config->item('slide_height')?> <span>formatos jpg, gif ou png, tamanho máximo 5mb</span></label>
			<input type="hidden" name="MAX_FILE_SIZE" value="5242880">
			<input type="file" name="imagem">
			<?php else: ?>
			Imagem <?=$this->config->item('slide_width')?> &times; <?=$this->config->item('slide_height')?> <a class="icone excluir" href="<?=site_url("admin/$this->kw/excluir_imagem/$imagem->id/false")?>">Excluir</a>
			<br>
			<img src="<?=base_url()?>imagens/enviadas/<?=$imagem->med?>" alt="Arquivo <?=$imagem->med?>">
			<?php endif; ?>
		</div>

		<fieldset class="grupo">
			<div class="campo grid2-1">
				<label>Legenda <span>opcional</span></label>
				<input type="text" name="legenda" value="<?=set_value('legenda')?>">
			</div>

			<div class="campo grid2-1 ultima">
				<label>Link <span>opcional</span></label>
				<input type="text" name="link" value="<?=set_value('link')?>">
			</div>
		</fieldset>

        <button name="submit" class="botao botao-submit">
		<?php if($acao == 'novo'): ?>
            Cadastrar
        <?php else: ?>
            Alterar
        <?php endif; ?>
        </button>
	</fieldset>

<?=form_close()?>

<hr>

<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>
