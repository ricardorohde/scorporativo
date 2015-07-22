<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>

<h1><?=ucfirst($this->cskw)?>: <?=$item->nome?></h1>

<?php if(isset($msg) && !empty($msg)): ?>
<div class="mensagem"><?=$msg?></div>
<?php endif; ?>

<?php $this->load->view("backend/$this->kw/menu"); ?>

<?=$pag?>

<hr>

<p>
	<a href="<?=$redirect?>">&laquo; Voltar</a>
</p>
