<h1>
	<?=ucfirst($this->ckw)?>
</h1>

<p>
	<a class="icone adicionar" href="<?=site_url("admin/$this->kw/adicionar")?>">Adicionar <?=$this->cskw?></a>
	<?php if($busca['menu']): ?>
	<a class="icone switch" href="<?=site_url("admin/$this->kw/reordenar/$filtros")?>">Reordenar <?=$this->ckw?></a>
	<?php endif; ?>
</p>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem"><?=$msg?></div>
<?php endif; ?>

<div class="filtros">
	<?=form_open(site_url("admin/$this->kw/filtros"))?>
	<fieldset class="grupo">

		<div class="campo">
			<label>Menu</label>
			<input type="text" name="menu" size="15" value="<?=$busca['menu']?>">
		</div>

		<button class="botao botao-filtros">
			Pesquisar
		</button>
		
	</fieldset>
	<?=form_close()?>

	<a class="icone cross" href="<?=site_url("admin/$this->kw")?>">Limpar Pesquisa</a>
</div>

<?php if(isset($entries) && !empty($entries) && $entries !== false): ?>

<p>
	Listando registros de <?=$current?> até <?=$current+$per_page?> (<?=$total_rows?> registro<?php if($total_rows > 1) echo 's';?> no total):
</p>

<?=$this->pagination->create_links()?>

	<?php if(isset($this->template['custom_crud_table'])): ?>
	
		<?php $this->load->view($this->template['custom_crud_table']); ?>
	
	<?php else: ?>
	
	<table class="tabela">
		<tr>
			<th scope="col">Página</th>
			<th scope="col">Menu</th>
			<th scope="col">Editável</th>
			<th scope="col">Opções</th>
		</tr>
	
	<?php
		foreach($entries as $row):
			$children = $this->obj->get_all(array('mae'=>$row->id));
	?>
		
		<tr>
			<td class="a-esq">
				<span style="display: none"><?=$row->id?></span>

				<?php if($row->editavel == '1'): ?>
				<a href="<?=site_url("admin/$this->kw/alterar/$row->id")?>">
					<?=$row->nome?>
				</a>
				<?php else: ?>
				<?=$row->nome?>
				<?php endif; ?>
			</td>
			<td>
				<?=$row->menu?>
			</td>
			<td>
				<?php if($row->editavel == '1'): ?>
				Sim
				<?php else: ?>
				Não
				<?php endif; ?>
			</td>
			<td>
				<?php if($row->editavel == '1'): ?>

				<a class="icone alterar" href="<?=site_url("admin/$this->kw/alterar/$row->id")?>">Alterar</a>

				<?php else: ?>
				--
				<?php endif; ?>
			</td>
		</tr>
		
		<?php if(isset($children) && $children !== false): ?>
		
		<?php foreach($children as $srow): ?>
		<tr class="subitem subitem-linha">
			<td class="a-esq subcat">
				<span style="display: none"><?=$srow->id?></span>

				<?php if($srow->editavel == '1'): ?>
				<a href="<?=site_url("admin/$this->kw/alterar/$srow->id")?>">
					<?=$srow->nome?>
				</a>
				<?php else: ?>
				<?=$srow->nome?>
				<?php endif; ?>
			</td>
			<td>
				<?php if($srow->editavel == '1'): ?>
				Sim
				<?php else: ?>
				Não
				<?php endif; ?>
			</td>
			<td>
				<?php if($srow->editavel == '1'): ?>

				<a class="icone alterar" href="<?=site_url("admin/$this->kw/alterar/$srow->id")?>">Alterar</a>

				<?php else: ?>
				--
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>

		<?php endif; ?>

	<?php endforeach; ?>
	
	</table>
	
	<?php endif; ?>

<?=$this->pagination->create_links()?>

<?php else: ?>

<p>Não há <?=$this->ckw?> cadastrad<?=$this->artigo?>s.</p>

<?php endif; ?>