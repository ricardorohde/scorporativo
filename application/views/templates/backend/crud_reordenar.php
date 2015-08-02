<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>

<h1>Reordenar <?=ucfirst($this->ckw)?></h1>

<p>
	<strong>Clique e arraste os itens para reordená-los.</strong>
</p>

<div class="mensagem mensagem-resposta"></div>

<?php if(isset($entries) && !empty($entries) && $entries !== false): ?>

<input type="hidden" id="secao_cod" value="<?=$this->kw?>">

<ul class="lista-reorder js-sortable">
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
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>