<?php require 'config.php'; ?>

<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->

<html class="no-js" lang="en">
	<head>
	<meta charset="UTF-8">
	<script src="<?php echo SITEBASE; ?>/js/jquery-1.11.3.min.js"></script>
	<script src="<?php echo SITEBASE; ?>/js/jquery-1.11.3.js"></script>
	<script src="<?php echo SITEBASE; ?>/js/carrinho.js"></script>
	
		<title></title>
		<link rel="stylesheet" type="text/css" href="<?php echo SITEBASE; ?>/css/site.css">
	</head>
	<body>
		<div id="section">
			<div id="fundo">
				<div>
					<!-- MENU -->
					<?php include_once 'includes/header.php'; ?>
				</div>
				<div>
					<?php urlAmigavel('url'); ?>
				</div>
			</div>
			<div>
				<!-- RODAPE -->
				<?php include_once 'includes/footer.php'; ?>
			</div>
		</div>
	</body>
</html>
