<h1><?=ucfirst($this->kw)?></h1>

<p>
	<a class="icone adicionar" href="<?=site_url("admin/$this->kw/adicionar_imagem")?>">Adicionar <?=$this->cskw?></a>
</p>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem mensagem-info">
	<?=$msg?>
</div>
<?php endif; ?>

<div class="mensagem mensagem-resposta"></div>

<?php if(isset($imagens) && !empty($imagens) && $imagens !== false): ?>

<p>
	<em>Arraste as imagens para reordená-las.</em>
</p>

<input type="hidden" id="secao_cod" value="<?=$this->kw?>">
<input type="hidden" id="obj_id" value="0">
<input type="hidden" id="obj_tipo" value="<?=$this->cskw?>">

<div class="imagens js-sortable grupo" data-funcao="reordenar_imagens">

	<?php foreach($imagens as $row):?>

	<div class="imagem imagem-<?=$this->cskw?>" id="fot_<?=$row->id?>">
		<?php if(empty($row->legenda)): ?>
		<h3><em>Sem legenda</em></h3>
		<?php else: ?>
		<h3><?=$row->legenda?></h3>
		<?php endif; ?>
		<img src="<?=base_url()?>imagens/enviadas/<?=$row->med?>" alt="Arquivo <?=$row->med?>">
		<a class="icone alterar" href="<?=site_url("admin/$this->kw/alterar_imagem/0/$row->id")?>">Alterar</a>
		<a class="icone excluir" href="<?=site_url("admin/$this->kw/excluir_imagem/$row->id")?>">Excluir</a>
	</div>

	<?php endforeach; ?>

</div>

<?php else: ?>

<p>Não há <?=$this->ckw?> cadastrad<?=$this->artigo?>s.</p>

<?php endif; ?>
