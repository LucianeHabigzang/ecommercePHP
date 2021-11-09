<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<div id="tituloProdutos">
			<div><h2>Lista de produtos solicitados</h2></div>
		</div>
		<div id="listaProdutos">
			<div id="divLinhaProd">
				<div id="divListaPedi">Data</div>
				<div id="divListaPedi">Produto</div>
				<div id="divListaPedi">Quantidade</div>
				<div id="divListaPedi">Iteressado</div>
				<div id="divListaPedi">Status</div>
				<div id="divListaPedi"></div>
			</div>
		<?php
		$solicitados = listaSolicitados();
		if ($solicitados != null) {
			foreach ($solicitados as $prod) : ?>
				<div id="divLinhaProd">
					<div id="divListaPedi"><?php echo formatDate($prod['DataCadastro']); ?></div>
					<div id="divListaPedi"><?php echo $prod['Titulo']; ?></div>
					<div id="divListaPedi"><?php echo $prod['QuantidadeInteresse']; ?></div>
					<div id="divListaPedi"><?php echo $prod['Email']; ?></div>
					<div id="divListaPedi"><?php echo ($prod['Status'] == 1) ? "Ativo" : "Inativo"; ?></div>
					<div id="divListaPedi"><a href="<?php echo SITEBASE; ?>/cadastro_solicitados/alterar/<?php echo $prod['Codigo']; ?>">Alterar</a></div>
				</div>
			<?php endforeach; 
		} else {
			echo '<div id="divLinhaProd">Nenhum produto solicitado!</div>';
		} ?>
		</div>
		<?php 
		} else {
			echo '<div id="divLinhaProd">Acesso Restrito! Efetue o login!</div>';
		}
		?>
	</div>
</div>