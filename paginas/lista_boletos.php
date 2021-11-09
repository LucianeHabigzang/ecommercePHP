<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<div id="tituloProdutos">
			<div><h2>Lista de boletos cadastrados</h2></div>
		</div>
		<div id="listaProdutos">
			<div id="divLinhaProd">
				<div id="divListaPedi">Pedido</div>
				<div id="divListaPedi">Data vencimento</div>
				<div id="divListaPedi">Valor Total</div>
				<div id="divListaPedi">Status</div>
				<div id="divListaPedi"></div>
				<div id="divListaPedi"></div>
			</div>
		<?php 
		$listaBoletos = buscaBoletos();
		if($listaBoletos != null){
			foreach ($listaBoletos as $boleto) : ?>
				<div id="divLinhaProd">
					<div id="divListaPedi"><?php echo $boleto['FantCod']; ?></div>
					<div id="divListaPedi"><?php echo formatDate($boleto['DataVencimento']); ?></div>
					<div id="divListaPedi"><?php echo real($boleto['ValorBoleto']); ?></div>
					<div id="divListaPedi"><?php echo ($boleto['Status'] == 1) ? "Pago" : "N&atilde;o pago"; ?></div>
					<div id="divListaPedi"><a href="<?php echo SITEBASE; ?>/cadastro_boleto/alterar/<?php echo $boleto['Codigo']; ?>">Alterar</a></div>
					<div id="divListaPedi">
					<form action="<?php echo SITEBASE?>/paginas/pdf_boleto.php" method="post" name="" id="" target="_blank" enctype="multipart/form-data">
						<input name="CodigoBoleto" type="hidden" id="CodigoBoleto" value="<?php echo $boleto['Codigo']; ?>" />
						<input type="submit" name="Submit" value="Imprimir Boleto">
					</form>
				</div>
				</div>
				<?php endforeach; 
			} else {
				echo '<div id="divLinhaProd">Nenhum boleto cadastrado!</div>';
			} ?>
		</div>
		<?php 
		} else {
			echo '<div id="divLinhaProd">Acesso Restrito! Efetue o login!</div>';
		}
		?>
	</div>
</div>