<!doctype html>
<html lang="<?=$site_lang?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?=$site_title?></title>
	<meta name="description" content="<?=$meta_desc?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="apple-touch-icon" href="apple-touch-icon.png">

	<link rel="stylesheet" href="css/frontend/frontend.css">
</head>
<body>

<div class="site">

	<header class="site-cabecalho" role="banner">
		
	</header>
	
	<main class="site-conteudo" role="main">
		
		<?=$rendered_page?>

	</main>

	<footer class="site-rodape" role="contentinfo">
		
	</footer>
	
</div>

<!-- JavaScripts -->
<script src="<?=base_url()?>js/vendor/jquery-1.11.3.min.js"></script>
<script src="<?=base_url()?>js/frontend/main.js"></script>

<?php if($_SERVER['HTTP_HOST'] == 'localhost'): ?>
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