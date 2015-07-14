<h1>Reordenar <?=ucfirst($this->ckw)?></h1>

<p>
	<strong>Clique e arraste os itens para reordená-los.</strong>
</p>

<div id="resposta"></div>

<?php if(isset($entries) && !empty($entries) && $entries !== false): ?>

<input type="hidden" id="secao_cod" value="<?=$this->kw?>">

<ul id="itens" class="lista-reorder">
	<?php foreach($entries as $row): ?>
	<li id="ite_<?=$row->id?>">
		<?=$row->nome?>
	</li>
	<?php endforeach; ?>
</ul>

<?php else: ?>

<p>Não há <?=$this->ckw?> cadastrad<?=$this->artigo?>s.</p>

<?php endif; ?>

<hr>

<p>
	<a href="<?=site_url("admin/$this->kw")?>">&laquo; Voltar</a>
</p>