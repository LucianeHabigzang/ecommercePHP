</script>
<style>
	#galleria {
		height: 320px;
	}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo SITEBASE; ?>/css/site.css">
<!-- load jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>

<!-- load Galleria -->
<script src="<?php echo SITEBASE; ?>/js/galleria-1.4.2.min.js"></script>
<script src="<?php echo SITEBASE; ?>/js/galleria.classic.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITEBASE; ?>/css/galleria.classic.css">

<div id="principalFotos" class="principalFotos">

	<div id="galleria">
		<a href="img/foto1.jpg"> <img
		src="img/foto1.jpg",
		data-big="img/foto1.jpg"
		data-title="MusicalBox"
		data-description="Pato Branco, Paran&acute;."
		> </a>
		<a href="img/Foto.jpg"> <img
		src="img/Foto.jpg",
		data-big="img/Foto.jpg"
		data-title="MusicalBox"
		data-description="Pato Branco, Paran&acute;."
		> </a>
		<a href="img/show5.jpg"> <img
		src="img/show5.jpg",
		data-big="img/show5.jpg"
		data-title="Balada Infernal"
		data-description="Pato Branco, Paran&acute;."
		> </a>
	</div>
</div>
<script>
	// Load the classic theme
	Galleria.loadTheme('galleria.classic.min.js');

	// Initialize Galleria
	Galleria.run('#galleria');

</script>