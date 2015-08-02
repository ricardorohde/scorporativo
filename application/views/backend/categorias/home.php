<h1><?=ucfirst($this->ckw)?></h1>

<p>
	<a class="icone adicionar" href="<?=site_url("admin/$this->kw/adicionar/")?>">Adicionar <?=$this->cskw?></a>
</p>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem"><?=$msg?></div>
<?php endif; ?>

<?php if(isset($entries) && !empty($entries) && $entries !== false): ?>

<p>
	Listando registros de <?=$current?> até <?=$current+$per_page?> (total <?=$total_rows?> registro<?php if($total_rows > 1) echo 's';?>):
</p>

<?=$this->pagination->create_links()?>

<table class="tabela">
	<tr>
		<th scope="col">Nome</th>
		<th scope="col">Nível</th>
		<th scope="col">Tipo</th>
		<th class="td-opcoes" scope="col">Opções</th>
	</tr>

<?php foreach($entries as $row): ?>

	<tr>
		<td class="a-esq">
			<a href="<?=site_url("admin/$this->kw/alterar/$row->id")?>"><?=$row->nome?></a>
		</td>
		<td><?=ucfirst($row->nivel)?></td>
		<td><?=ucfirst($row->tipo)?></td>
		<td>
			<a class="icone alterar" href="<?=site_url("admin/$this->kw/alterar/$row->id")?>">Alterar</a>
			<a class="icone excluir" href="<?=site_url("admin/$this->kw/excluir/$row->id")?>">Excluir</a>
		</td>
	</tr>

	<?php
		$children = $this->obj->get_all(array('mae' => $row->id));
		if(isset($children) && $children !== false):
	?>

	<?php
		foreach($children as $l):
	?>
	<tr class="subitem subitem-linha">
		<td class="a-esq td-subcat">
			<a href="<?=site_url("admin/$this->kw/alterar/$l->id")?>"><?=$l->nome?></a>
		</td>
		<td><?=ucfirst($l->nivel)?></td>
		<td><?=ucfirst($l->tipo)?></td>
		<td>
			<a class="icone alterar" href="<?=site_url("admin/$this->kw/alterar/$l->id")?>">Alterar</a>
			<a class="icone excluir" href="<?=site_url("admin/$this->kw/excluir/$l->id")?>">Excluir</a>
		</td>
	</tr>

		<?php
			$categorias = $this->obj->get_all(array('mae' => $l->id));
			if($categorias !== false):
			foreach($categorias as $c):
		?>

		<tr class="subitem subitem-categoria">
			<td class="a-esq td-subcat">
				<a href="<?=site_url("admin/$this->kw/alterar/$c->id")?>"><?=$c->nome?></a>
			</td>
			<td><?=ucfirst($c->nivel)?></td>
			<td><?=ucfirst($c->tipo)?></td>
			<td>
				<a class="icone alterar" href="<?=site_url("admin/$this->kw/alterar/$c->id")?>">Alterar</a>
				<a class="icone excluir" href="<?=site_url("admin/$this->kw/excluir/$c->id")?>">Excluir</a>
			</td>
		</tr>

			<?php
				$subcategorias = $this->obj->get_all(array('mae' => $c->id));
				if($subcategorias !== false):
				foreach($subcategorias as $s):
			?>

			<tr class="subitem subitem-subcategoria">
				<td class="a-esq td-subcat">
					<a href="<?=site_url("admin/$this->kw/alterar/$s->id")?>"><?=$s->nome?></a>
				</td>
				<td><?=ucfirst($s->nivel)?></td>
				<td><?=ucfirst($s->tipo)?></td>
				<td>
					<a class="icone alterar" href="<?=site_url("admin/$this->kw/alterar/$s->id")?>">Alterar</a>
					<a class="icone excluir" href="<?=site_url("admin/$this->kw/excluir/$s->id")?>">Excluir</a>
				</td>
			</tr>

			<?php endforeach; endif; ?>

		<?php endforeach; endif; ?>

	<?php endforeach; ?>

	<?php endif; ?>

<?php endforeach; ?>

</table>

<?=$this->pagination->create_links()?>

<?php else: ?>

<p>Não há <?=$this->ckw?> cadastrad<?=$this->artigo?>s.</p>

<?php endif; ?>
