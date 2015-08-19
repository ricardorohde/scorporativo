<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>

<h1>Imagens: "<?=$nome?>"</h1>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem"><?=$msg?></div>
<?php endif; ?>

<?php
if(file_exists("application/views/backend/$this->kw/detalhes.php")) {
	$this->load->view("backend/$this->kw/menu",array($this->cskw => $item));
}
?>

<p>
	<a class="icone adicionar" href="<?=site_url("admin/$this->kw/adicionar_imagem/$item->id")?>">Adicionar uma imagem</a>
</p>

<div class="mensagem mensagem-resposta"></div>

<?php if($imagens): ?>

<p>
	Listando todas as fotos para este item:
</p>

<p>
	<em>Arraste as fotos para reordená-las.</em>
</p>

<input type="hidden" id="secao_cod" value="<?=$this->kw?>">
<input type="hidden" id="obj_tipo" value="<?=$this->cskw?>">
<input type="hidden" id="obj_id" value="<?=$item->id?>">

<div class="imagens js-sortable grupo" data-funcao="reordenar_imagens">

<?php foreach($imagens as $row):?>

<div class="imagem imagem-<?=$row->obj_tipo?>" id="fot_<?=$row->id?>">
	<?php if(empty($row->legenda)): ?>
	<h3><em>Sem legenda</em></h3>
	<?php else: ?>
	<h3><?=$row->legenda?></h3>
	<?php endif; ?>
	<img src="<?=base_url()?>imagens/enviadas/<?=$row->thumb?>" alt="imagens/enviadas/<?=$row->thumb?>">
	<a class="icone alterar" href="<?=site_url("admin/$this->kw/alterar_imagem/$item->id/$row->id")?>">Alterar</a>
	<a class="icone excluir" href="<?=site_url("admin/$this->kw/excluir_imagem/$row->id")?>">Excluir</a>
</div>

<?php endforeach; ?>

</div>

<?php else: ?>

<p>Não há imagens cadastradas.</p>

<?php endif; ?>

<hr>

<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>
