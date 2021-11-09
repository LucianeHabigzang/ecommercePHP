<?php require 'config.php'; ?>

<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->

<html class="no-js" lang="en">
	<head>
	<script src="<?php echo SITEBASE; ?>/js/jquery-1.11.3.min.js"></script>
	<script src="<?php echo SITEBASE; ?>/js/jquery-1.11.3.js"></script>
	<script src="<?php echo SITEBASE; ?>/js/carrinho.js"></script>
	
		<title></title>
		<link rel="stylesheet" type="text/css" href="<?php echo SITEBASE; ?>/css/site.css">
	</head>
	<body>
		<div id="section">
			<div id="fundo">
				<div id="new-header">
					<!-- MENU -->
					<?php include_once 'includes/header_en.php'; ?>
				</div>
				<!--<div class="row ofertas-bloco"> -->
					<?php urlAmigavel('url'); ?>
				<!-- </div> -->
			</div>	
			<div id="new-footer">
					<!-- RODAPE -->
				<?php include_once 'includes/footer.php'; ?>
			</div>
			</div>
		</div>
	</body>
</html>
