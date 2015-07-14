<h1>Relatório de Acessos a Áreas Restritas</h1>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem">
	<?=$msg?>
</div>
<?php endif; ?>

<?php if(isset($entries) && !empty($entries) && $entries !== false): ?>

<p>
	Listando registros de <?=$current?> até <?=$current+$per_page?> (<?=$total_rows?> registro<?php if($total_rows > 1) echo 's';?> no total):
</p>

<?=$this->pagination->create_links()?>

<table class="tabela">
	<tr>
		<th scope="col">Data</th>
		<th scope="col">Usuário</th>
		<th scope="col">IP</th>
	</tr>

<?php foreach($entries as $row): ?>
	
	<tr>
		<td class="a-esq">
			<?=date('d/m/Y H:i:s',strtotime($row->data_cadastro))?>
		</td>
		<td class="a-esq">
			<?=$row->usuario?>
		</td>
		<td class="a-dir">
			<?=$row->ip?>
		</td>
	</tr>
	
<?php endforeach; ?>

</table>

<?=$this->pagination->create_links()?>

<?php else: ?>

<p>Nenhum relatório disponível.</p>

<?php endif; ?>