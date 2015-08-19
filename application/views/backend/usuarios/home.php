<h1>
	<?=ucfirst($this->ckw)?>
</h1>

<p>
	<a class="icone adicionar" href="<?=site_url("admin/$this->kw/adicionar/")?>">Adicionar <?=$this->cskw?></a>
</p>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem"><?=$msg?></div>
<?php endif; ?>

<div class="filtros">
	<?=form_open(site_url("admin/$this->kw/filtros"))?>
	<fieldset class="grupo">

		<div class="campo">
			<label>Nome</label>
			<input type="text" name="nome" size="30" value="<?=$busca['nome']?>">
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

<table class="tabela">
	<tr>
		<th scope="col">Login</th>
		<th scope="col">Nome</th>
		<th scope="col">Opções</th>
	</tr>

<?php foreach($entries as $row): ?>
	
	<tr>
		<td class="a-esq">
			<a href="<?=site_url("admin/$this->kw/alterar/$row->id")?>"><?=$row->login?></a>
		</td>
		<td>
			<?=$row->nome?>
		</td>
		<td>
			<a class="icone alterar" href="<?=site_url("admin/$this->kw/alterar/$row->id")?>">Alterar</a>
			<?php if($row->login != 'admin'): ?>
			<a class="icone excluir" href="<?=site_url("admin/$this->kw/excluir/$row->id")?>">Excluir</a>
			<?php endif; ?>
		</td>
	</tr>
	
<?php endforeach; ?>

</table>

<?=$this->pagination->create_links()?>

<?php else: ?>

<p>Não há <?=$this->ckw?> cadastrad<?=$this->artigo?>s.</p>

<?php endif; ?>