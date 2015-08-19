<div class="grid12-3">
	<?php $this->load->view("frontend/minha_conta/menu"); ?>
</div>

<div class="grid12-9 ultima">
	<h1>Minha Conta</h1>
	
	<?php if($msg): ?>
	<div class="mensagem info">
		<?=$msg?>
	</div>
	<?php endif; ?>
	
	<p>
		Olá <?=$this->session->userdata('nome')?>!
	</p>
</div>