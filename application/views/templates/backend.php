<!doctype html>
<html lang="<?=$site_lang?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?=$site_title?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,700italic" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url()?>css/backend/backend.css">
	<link href="<?=base_url()?>js/vendor/jquery-ui.min.css" rel="stylesheet" media="screen">

	<?php
	if(isset($head_files) && !empty($head_files)) {
		foreach($head_files as $value) {
			$this->load->view($value);
		}
	}
	?>
	
	<?=$head_code?>
</head>
<body>

<div class="site">
	<header class="site-cabecalho grupo" role="banner">
		<a class="site-logo" href="<?=site_url("admin")?>">
			<span>Administrativo</span>
			<img src="<?=base_url()?>imagens/estrutura/<?=$this->config->item('arquivo_logo')?>" alt="Voltar para a página inicial - <?=$this->config->item('site_title')?>">
		</a>

		<?php if($logado_adm): ?>
		
		<div class="usuario-meta">
			Bem-vindo, <?=$sessao_adm['nome']?> |
			<a href="<?=site_url('admin/alterar_senha')?>">Alterar Senha</a> |
			<a <?=find_active('admin/alterar_senha')?> href="<?=site_url('admin/login/logout')?>">Sair</a>
		</div>

		<?php endif; ?>

		<a class="link-ver-site" href="<?=site_url()?>" rel="external">Abrir o site em outra janela &raquo;</a>

		<?php if($logado_adm): ?>
		
		<nav class="menu-principal" role="navigation">
			<ul class="grupo">
				<li>
					<a <?php if($this->uri->segment(2) == 'home') echo 'class="ativo"'; ?> href="<?=site_url('admin/home')?>">
						Home
					</a>
				</li>
				<li>
					<a <?=find_active('admin/clientes')?> href="<?=site_url('admin/clientes')?>">
						Clientes
					</a>
				</li>
				<li>
					<a <?=find_active('admin/produtos')?> href="<?=site_url('admin/produtos')?>">
						Produtos
					</a>
				</li>
				<li>
					<a <?=find_active('admin/categorias')?> href="<?=site_url('admin/categorias')?>">
						Categorias
					</a>
				</li>
				<li>
					<a <?=find_active('admin/paginas')?> href="<?=site_url('admin/paginas')?>">
						Páginas e Textos
					</a>
				</li>
				<li>
					<a <?=find_active('admin/slideshow')?> href="<?=site_url('admin/slideshow')?>">
						Slideshow
					</a>
				</li>
				<li>
					<a href="#">
						Outros Recursos
					</a>
					<ul>
						<li>
							<a <?=find_active('admin/userlog')?> href="<?=site_url('admin/userlog')?>">
								Relatório de Acessos ADM
							</a>
						</li>
						<li>
							<a <?=find_active('admin/usuarios')?> href="<?=site_url('admin/usuarios')?>">
								Usuários ADM
							</a>
						</li>
						<li>
							<a <?=find_active('admin/backup')?> href="<?=site_url('admin/backup')?>">
								Backup do Banco de Dados
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">Externo</a>
					<ul>
						<li>
							<a rel="external" href="http://analytics.google.com">
								Google Analytics
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
		<?php endif; ?>
    </header>
	
	<div class="site-corpo">
		<main class="site-conteudo" role="main">
			
			<?=$rendered_page?>
			
		</main>

		<footer class="site-rodape" role="contentinfo">
			<small>&copy; <?=date('Y')?> <?=$this->config->item('site_title')?>.</small>
		</footer>
	</div>
</div> <!-- END site -->

<script>
	var baseurl = '<?=site_url()?>';
	<?php if(isset($this->kw)): ?>
	var baseurlc = '<?=site_url("admin/$this->kw")?>/';
	<?php endif; ?>
</script>
<script src="<?=base_url()?>js/vendor/jquery-1.11.3.min.js"></script>
<script src="<?=base_url()?>js/vendor/jquery-ui.min.js"></script>
<script src="<?=base_url()?>js/backend/main.js"></script>
<?php
	if(isset($footer_files) && !empty($footer_files)) {
		foreach($footer_files as $value) {
			$this->load->view($value);
		}
	}
?>

<?=$footer_code?>

</body>
</html>