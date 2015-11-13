<!doctype html>
<html lang="<?=$site_lang?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?=$site_title?></title>
	<meta name="description" content="<?=$meta_desc?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="apple-touch-icon" href="apple-touch-icon.png">

	<link rel="stylesheet" href="<?=base_url()?>css/frontend/frontend.css">
	
	<?php
	if(isset($head_files) && !empty($head_files)) {
		foreach($head_files as $value) {
			$this->load->view($value);
		}
	}
	?>
	
	<?=$head_code?>
</head>
<body class="bd-<?=$this->uri->segment(1,'home')?> bd-<?=$this->uri->segment(2,'generico')?> bd-<?=$this->site_lang?>">

<div class="site">

	<header class="site-cabecalho grupo">
		<a class="site-logo" href="<?=site_url()?>">
			<img src="<?=base_url()?>imagens/estrutura/<?=$this->config->item('arquivo_logo')?>" alt="Voltar para a página inicial - <?=$this->config->item('site_title')?>">
		</a>
		
		<div class="usuario-meta">
			<?php if($this->session->userdata('logado') && $this->session->userdata('tipo') == 'cliente'): ?>

			<?=$this->session->userdata('nome')?> | <a href="<?=site_url('minha_conta')?>">Minha Conta</a> | <a href="<?=site_url('sessoes/logout')?>">Sair</a>

			<?php else: ?>
			Olá visitante, <a href="<?=site_url('sessoes/login')?>">faça o login</a> ou <a href="<?=site_url('cadastro')?>">cadastre-se</a>
			<?php endif; ?>
		</div>

		<nav class="menu-principal">
			<?php if(isset($secoesmenu) && $secoesmenu): ?>
			<ul class="grupo">
				<?php foreach($secoesmenu as $row): ?>
				<li>
					<a <?=find_active($row->codigo,$this->uri->segment(1,'home'))?>  href="<?=site_url($row->codigo)?>">
						<?=$row->nome?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php else: ?>
			<p>
				Menu não disponível.
			</p>
			<?php endif; ?>
		</nav>
	</header>
	
	<main class="site-conteudo">
		
		<?=$rendered_page?>

	</main>

	<footer class="site-rodape">
		<div class="grupo">
			<div class="rodape-esq grid2-1">
				<?php if(isset($rodapeesq)): ?>
				<?=$rodapeesq->texto?>
				<?php endif; ?>
			</div>
			<div class="rodape-dir grid2-1 ultima a-dir">
				<?php if(isset($rodapedir)): ?>
				<?=$rodapedir->texto?>
				<?php endif; ?>
			</div>
		</div>
		
		<div class="grupo">
			<small class="copyright">
				&copy; <?=date('Y')?> <?=$this->config->item('site_title')?>. Todos os direitos reservados.
			</small>

			<a title="Desenvolvido por Guilherme Müller" rel="external" href="http://guilhermemuller.com.br" class="credito-gm"><img src="http://guilhermemuller.com.br/imagens/pas_azul.png"></a>
		</div>
	</footer>
	
</div>

<!-- JavaScripts -->
<script src="<?=base_url()?>js/vendor/jquery-1.11.3.min.js"></script>
<script src="<?=base_url()?>js/frontend/main.js"></script>
<?php
	if(isset($footer_files) && !empty($footer_files)) {
		foreach($footer_files as $value) {
			$this->load->view($value);
		}
	}
?>

<?=$footer_code?>

<?php if($_SERVER['HTTP_HOST'] != 'localhost'): ?>
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
	(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
	function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
	e=o.createElement(i);r=o.getElementsByTagName(i)[0];
	e.src='https://www.google-analytics.com/analytics.js';
	r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
	ga('create','UA-XXXXX-X','auto');ga('send','pageview');
</script>
<?php endif; ?>

</body>
</html>