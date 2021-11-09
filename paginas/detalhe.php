<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<div id="tituloProdutos">
			<h1><?php echo $Titulo; ?></h1>
			<span><?php echo $Descricao; ?></span>
		</div>
		<div id="DetalheProduto">
			<a style="width: 350px; height: 300px;">
				<img src="data:image/jpg;base64, <?php echo base64_encode($Imagem); ?>" width="350">
			</a>
		</div>
		<div id="DetalheProduto">
			<p><em style="text-decoration: line-through;"><h5>De: R$ <?php echo real($Preco); ?></h5></em>

			<em style="display: block;"><h3>Por: R$ <?php echo (isset($ValorPromocao) && ($ValorPromocao != null)) ? real($ValorPromocao) : real($Preco); ?></h3></em>
			</p>
		    <div>
		        <div style="height: 40px;">
		        <label>Quantidade</label>
		        	<input type="number" name="quantidade" value="1" min="0">
		        </div>
				<?php
				if(isset($CodigoCategoria) && ($CodigoCategoria == 1)){
					echo '
					<div style="height: 40px;">
					<label>Tamanho</label>
						<input type=radio id="tamanho" name="tamanho" value=1 checked>P
						<input type=radio id="tamanho" name="tamanho" value=2 >M
						<input type=radio id="tamanho" name="tamanho" value=3 >G
						<input type=radio id="tamanho" name="tamanho" value=4 >GG
						<input type=radio id="tamanho" name="tamanho" value=5 >XG
					</div>';
				} else {
					echo '<input type="hidden" name="tamanho" value=0>';
				}
				?>
		        <div>
		        <label></label>
		        	<input type="submit" name="add" value="Comprar" id="adicionar">
		        	<input type="hidden" name="codigoProduto" value="<?php echo $Codigo; ?>">

		        	<img src="<?php echo getImg('loads/', 'loader.gif'); ?>" style="display: none" id="carregando" />

		        </div>
		        <div id="status"></div>
	        </div>
		</div>
	</div>
</div>