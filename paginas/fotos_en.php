<style>
	#galleria {
		height: 320px;
	}
</style>
<link rel="stylesheet" type="text/css" href="site.css">
<!-- load jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>

<!-- load Galleria -->
<script src="galleria-1.4.2.min.js"></script>

<div id="principalFotos" class="principalFotos">

	<div id="galleria">
		<a href="img/foto1.jpg"> <img
		src="img/foto1.jpg",
		data-big="img/foto1.jpg"
		data-title="Tatu"
		data-description="Pato Branco, Paran�."
		> </a>
		<a href="img/Foto.jpg"> <img
		src="img/Foto.jpg",
		data-big="img/Foto.jpg"
		data-title="Tatu"
		data-description="Pato Branco, Paran�."
		> </a>
		<a href="img/show5.jpg"> <img
		src="img/show5.jpg",
		data-big="img/show5.jpg"
		data-title="Balada Infernal"
		data-description="Pato Branco, Paran�."
		> </a>
	</div>
</div>
<script>
	// Load the classic theme
	Galleria.loadTheme('galleria.classic.min.js');

	// Initialize Galleria
	Galleria.run('#galleria');

</script>