<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<div id="tituloProdutos">
			<div><h2>Lista de produtos cadastrados</h2></div>
		</div>
		<div id="listaProdutos">
			<div id="divLinhaProd">
				<div id="divListaProd">Titulo</div>
				<div id="divListaProd">Pre&ccedil;o</div>
				<div id="divListaProd">Quantidade</div>
				<div id="divListaProd">Status</div>
				<div id="divListaProd"></div>
			</div>
		<?php foreach (listaProd(1) as $prod) : ?>
			<div id="divLinhaProd">
				<div id="divListaProd"><?php echo $prod['Titulo']; ?></div>
				<div id="divListaProd"><?php echo real($prod['Preco']); ?></div>
				<div id="divListaProd"><?php echo $prod['QuantidadeEstoque']; ?></div>
				<div id="divListaProd"><?php echo ($prod['Status'] == 1) ? "Ativo" : "Inativo"; ?></div>
				<div id="divListaProd"><a href="<?php echo SITEBASE; ?>/cadastro_produto/alterar/<?php echo $prod['Codigo']; ?>">Alterar</a></div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php 
		} else {
			echo '<div id="divLinhaProd">Acesso Restrito! Efetue o login!</div>';
		}
		?>
	</div>
</div>