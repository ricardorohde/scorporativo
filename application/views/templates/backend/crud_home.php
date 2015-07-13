<h1><?=ucfirst($this->ckw)?></h1>

<p>
	<a class="icone adicionar" href="<?=site_url("admin/$this->kw/adicionar/")?>">Adicionar <?=$this->cskw?></a>
</p>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem"><?=$msg?></div>
<?php endif; ?>

<?php if(isset($entries) && !empty($entries) && $entries !== false): ?>

<a class="icone imprimir" href="#">Imprimir</a>

<p>
	Listando registros de <?=$current?> até <?=$current+$perpage?> (<?=$totalrows?> registro<?php if($totalrows > 1) echo 's';?> no total):
</p>

<?=$this->pagination->create_links()?>

	<?php if(isset($this->template['custom_crud_table'])): ?>
	
		<?php $this->load->view($this->template['custom_crud_table']); ?>
	
	<?php else: ?>
	
	<table class="tabela">
		<tr>
			<th scope="col">Nome</th>
			<th scope="col">Opções</th>
		</tr>
	
	<?php foreach($entries as $row): ?>
		
		<tr>
			<td>
				<?php isset($row->nome) ? $nome = $row->nome : $nome = $row->titulo; ?>
				<a href="<?=site_url("admin/$this->kw/alterar/$row->id")?>">
					<?=$nome?>
				</a>
			</td>
			<td class="a-centro">
				<a class="icone alterar" href="<?=site_url("admin/$this->kw/alterar/$row->id")?>">Alterar</a>
				<a class="icone excluir" href="<?=site_url("admin/$this->kw/excluir/$row->id")?>">Excluir</a>
			</td>
		</tr>
		
	<?php endforeach; ?>
	
	</table>
	
	<?php endif; ?>

<?=$this->pagination->create_links()?>

<?php else: ?>

<p>Não há <?=$this->ckw?> cadastrad<?=$this->artigo?>s.</p>

<?php endif; ?>