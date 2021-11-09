<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<div id="tituloProdutos">
			<div><h2>Pedido  <?php echo $FantCod;  ?></h2></div>
		</div>
		<form action="<?php echo SITEBASE?>/atualizar_pedido" method="post" name="" id="" enctype="multipart/form-data">
			<input name="Codigo" type="hidden" id="Codigo" value="<?php echo isset($Codigo) ? $Codigo : null; ?>" />
			<input name="CodigoUsuario" type="hidden" id="CodigoUsuario" value="<?php echo isset($CodigoUsuario) ? $CodigoUsuario : null; ?>" />
			<input name="FantCod" type="hidden" id="FantCod" value="<?php echo isset($FantCod) ? $FantCod : null; ?>" />
			<div id="divPedidosDetalhes">
				Data do pedido: <?php echo formatDate($Data);  ?>
			</div>
			<div id="divPedidosDetalhes">
				<div style="width: 20%; float: left;">
					Transito:
				</div>
				<div style="width: 80%; float: left;">
					<input type=radio id="Entregue" name="Entregue" value=0 <?php echo (isset($Entregue) ? (($Entregue == 0) ? 'checked' : '') : 'checked')?>>Entregar
					<input type=radio id="Entregue" name="Entregue" value=1 <?php echo (isset($Entregue) ? (($Entregue == 1) ? 'checked' : '') : '')?>>Em Transito
					<input type=radio id="Entregue" name="Entregue" value=2 <?php echo (isset($Entregue) ? (($Entregue == 2) ? 'checked' : '') : '')?>>Entregue
				</div>
			</div>
			<div id="divPedidosDetalhes">
				Rastreamento correios: <input name="Rastreamento" type="text" id="Rastreamento" value="<?php echo isset($Rastreamento) ? $Rastreamento : ''; ?>"/>
			</div>
			<div id="divPedidosDetalhes">
				<div style="width: 20%; float: left;">
					Pagamento:
				</div>
				<div style="width: 80%; float: left;">
					<input type=radio id="Pagamento" name="Pagamento" value=0 <?php echo (isset($Pagamento) ? (($Pagamento == 0) ? 'checked' : '') : 'checked')?>>N&atilde;o Pago
					<input type=radio id="Pagamento" name="Pagamento" value=1 <?php echo (isset($Pagamento) ? (($Pagamento == 1) ? 'checked' : '') : '')?>>Pago
				</div>
			</div>
			<div id="divPedidosDetalhes">
				<div style="width: 20%; float: left;">
					Status:
				</div>
				<div style="width: 80%; float: left;">
					<input type=radio id="Status" name="Status" value=1 <?php echo (isset($Status) ? (($Status == 1) ? 'checked' : '') : '')?>>Aberto
					<input type=radio id="Status" name="Status" value=0 <?php echo (isset($Status) ? (($Status == 0) ? 'checked' : '') : 'checked')?>>Finalizado
				</div>
			</div>
			<div id="divPedidosDetalhes">
				Valor do frete: R$ <?php echo real($ValorFrete);  ?> 
			</div>
			<div id="divPedidosDetalhes">
				Valor total do pedido: R$ <?php echo real($ValorTotal);  ?>
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
			<div id="divPedidosDetalhes">
			</div>
			<div id="divLinhaCadastro" style="text-align: right;">
				<input type="submit" name="Submit" value="Atualizar Pedido">
			</div>
		</form>
		<?php 
		} else {
			echo '<div id="divLinhaProd">Acesso Restrito! Efetue o login!</div>';
		}
		?>
	</div>
</div>