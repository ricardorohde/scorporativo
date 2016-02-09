<ul class="menu-conta">
	<li>
		<a <?=find_active('minha_conta/home')?> href="<?=site_url("minha_conta")?>">Home</a>
	</li>
	<li>
		<a <?=find_active('minha_conta/cadastro')?> href="<?=site_url("minha_conta/cadastro")?>">Cadastro</a>
	</li>
	<li>
		<a href="<?=site_url("sessoes/logout")?>">Sair</a>
	</li>
</ul>