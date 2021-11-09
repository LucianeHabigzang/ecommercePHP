<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["Codigo"])) {
				
		?>	
		<div id="tituloProdutos">
			<div><h2>Pedido  <?php echo $FantCod;  ?></h2></div>
		</div>
		<form action="<?php echo SITEBASE?>/paginas/pdf_boleto.php" method="post" name="" id="" target="_blank" enctype="multipart/form-data">
			<input name="Codigo" type="hidden" id="Codigo" value="<?php echo isset($Codigo) ? $Codigo : null; ?>" />
			<div id="divPedidosDetalhes" style="width: 50%; float: left;">
				Data do pedido: <?php echo formatDate($Data);  ?>
			</div>
			<div id="divPedidosDetalhes" style="width: 50%; float: left;">
				<input type="submit" name="Submit" value="Imprimir Boleto">
			</div>
		</form>
		<div id="divPedidosDetalhes">
			Transito: <?php echo ($Entregue == 0) ? "Entregar" : (($Entregue == 1) ? "Em transito" : "Entregue"); ?>
		</div>
		<div id="divPedidosDetalhes">
			Pagamento: <?php echo ($Pagamento == 0) ? "N&atilde;o Pago" : "Pago"; ?>
		</div>
		<div id="divPedidosDetalhes">
			<h3>Itens do pedido:</h3>
		</div>
		<div id="divPedidosDetalhes">
		</div>
		<div id="listaCarrinho">
			<div id="divLinhaProd">
				<div id="divListaPedi">Item</div>
				<div id="divListaPedi">Quantidade</div>
				<div id="divListaPedi">Tamanho</div>
				<div id="divListaPedi">Valor unit&aacute;rio</div>
				<div id="divListaPedi">Valor total</div>
				<div id="divListaPedi"></div>
			</div>
		<?php foreach (buscaPedidoItens($Codigo) as $pediItens) : ?>
			<div id="divLinhaProd">
				<div id="divListaPedi"><?php echo $pediItens['Titulo']; ?></div>
				<div id="divListaPedi"><?php echo $pediItens['Quantidade']; ?></div>
				<div id="divListaPedi"><?php echo (($pediItens['Tamanho'] == 1) ? "P" : (($pediItens['Tamanho'] == 2) ? "M" : (($pediItens['Tamanho'] == 3) ? "G" : (($pediItens['Tamanho'] == 4) ? "GG" : (($pediItens['Tamanho'] == 5) ? "XG" : "--"))))); ?></div>
				<div id="divListaPedi"><?php echo "R$ " . real($pediItens['ValorUnitario']); ?></div>
				<div id="divListaPedi"><?php echo "R$ " . real($pediItens['ValorTotal']); ?></div>
				<div id="divListaPedi"><?php  ?></div>
			</div>
			<?php endforeach; ?>
		</div>
		<div id="divProdutosDetalhesAlinhaValor">
			<h3>Valor do frete: R$ <?php echo real($ValorFrete);  ?></h3> 
		</div>
		<div id="divProdutosDetalhesAlinhaValor">
			<h2>Valor total do pedido: R$ <?php echo real($ValorTotal);  ?></h2>
		</div>
		<?php 
		} else {
			echo '<div id="divLinhaProd">Acesso Restrito! Efetue o login!</div>';
		}
		?>
	</div>
</div>