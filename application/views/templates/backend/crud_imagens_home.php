<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>

<h1>Fotos: "<?=$nome?>"</h1>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem"><?=$msg?></div>
<?php endif; ?>

<?php
if(file_exists("application/views/backend/$this->kw/detalhes.php")) {
	$this->load->view("backend/$this->kw/menu",array($this->cskw => $o));
}
?>

<p>
	<a class="icone adicionar" href="<?=site_url("admin/$this->kw/addfoto/$o->id")?>">Adicionar uma foto</a>
</p>

<div id="resposta"></div>

<?php if(isset($fotos) && !empty($fotos) && $fotos !== false): ?>

<p>
	Listando todas as fotos para este item:
</p>

<p>
	<em>Arraste as fotos para reordená-las.</em>
</p>

<div id="fotos" class="grupo">

<input type="hidden" id="secao_cod" value="<?=$this->kw?>">
<input type="hidden" id="obj_tipo" value="<?=$this->cskw?>">
<input type="hidden" id="obj_id" value="<?=$o->id?>">

<?php foreach($fotos as $row):?>

<div class="foto" id="fot_<?=$row->id?>">
	<?php if(empty($row->legenda)): ?>
	<h3><em>Sem legenda</em></h3>
	<?php else: ?>
	<h3><?=$row->legenda?></h3>
	<?php endif; ?>
	<img src="<?=base_url()?>imagens/fotos/<?=$row->thumb?>" alt="imagens/fotos/<?=$row->thumb?>" />
	<a class="icone alterar" href="<?=site_url("admin/$this->kw/altfoto/$o->id/$row->id")?>">Alterar</a>
	<a class="icone excluir" href="<?=site_url("admin/$this->kw/excimg/$row->id")?>">Excluir</a>
</div>
	
<?php endforeach; ?>

</div>

<?php else: ?>

<p>Não há fotos cadastradas.</p>

<?php endif; ?>

<hr>

<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>