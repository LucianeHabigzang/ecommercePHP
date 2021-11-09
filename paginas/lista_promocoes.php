<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<div id="tituloProdutos">
			<div><h2>Lista de Promo&ccedil;&otilde;es cadastradas</h2></div>
		</div>
		<div id="listaProdutos">
			<div id="divLinhaProd">
				<div id="divListaProd">Produto</div>
				<div id="divListaProd">Pre&ccedil;o</div>
				<div id="divListaProd">Data Final</div>
				<div id="divListaProd">Status</div>
				<div id="divListaProd"></div>
			</div>
		<?php 
		$listaPromocoes = listaPromocoes();
		if($promocoes != null){
			foreach ($listaPromocoes as $promocoes) : ?>
				<div id="divLinhaProd">
					<div id="divListaProd"><?php echo $promocoes['Titulo']; ?></div>
					<div id="divListaProd"><?php echo real($promocoes['ValorPromocao']); ?></div>
					<div id="divListaProd"><?php echo formatDate($promocoes['DataFinal']); ?></div>
					<div id="divListaProd"><?php echo ($promocoes['Status'] == 1) ? "Ativo" : "Inativo"; ?></div>
					<div id="divListaProd"><a href="<?php echo SITEBASE; ?>/cadastro_promocao/alterar/<?php echo $promocoes['Codigo']; ?>">Alterar</a></div>
				</div>
				<?php endforeach; 
			} else {
				echo '<div id="divLinhaProd">Nenhuma promo&ccedil;&atilde;o cadastrada!</div>';
			} ?>
		</div>
		<?php 
		} else {
			echo '<div id="divLinhaProd">Acesso Restrito! Efetue o login!</div>';
		}
		?>
	</div>
</div>