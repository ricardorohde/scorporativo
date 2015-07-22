<nav class="submenu abas grupo">
	<ul class="grupo">
		<li>
			<a <?=find_active("dados_gerais")?> href="<?=site_url("admin/$this->kw/detalhes/$item->id/dados_gerais")?>">
				Dados Gerais
			</a>
		</li>
		<li>
			<a <?=find_active("categorias")?> href="<?=site_url("admin/$this->kw/detalhes/$item->id/categorias")?>">
				Categorias
			</a>
		</li>
		<li>
			<a <?=find_active("foto")?> href="<?=site_url("admin/$this->kw/fotos/$item->id")?>">
				Fotos
			</a>
		</li>
	</ul>
</nav>
