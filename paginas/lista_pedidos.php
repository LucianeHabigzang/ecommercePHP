<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<div id="tituloProdutos">
			<div><h2>Lista de pedidos cadastrados</h2></div>
		</div>
		<div id="listaProdutos">
			<div id="divLinhaProd">
				<div id="divListaPediTotal">Pedido</div>
				<div id="divListaPediTotal">Data</div>
				<div id="divListaPediTotal">Valor Total</div>
				<div id="divListaPediTotal">Transito</div>
				<div id="divListaPediTotal">Status</div>
				<div id="divListaPediTotal">Pagamento</div>
				<div id="divListaPediTotal"></div>
				<div id="divListaPediTotal"></div>
			</div>
		<?php 
		$pedidos = listaPedidos();
		 if($pedidos != null){
			 foreach ($pedidos as $pedi) : ?>
			<div id="divLinhaProd">
				<div id="divListaPediTotal"><?php echo $pedi['FantCod']; ?></div>
				<div id="divListaPediTotal"><?php echo formatDate($pedi['Data']); ?></div>
				<div id="divListaPediTotal"><?php echo "R$ " . real($pedi['ValorTotal']); ?></div>
				<div id="divListaPediTotal"><?php echo ($pedi['Entregue'] == 0) ? "Entregar" : (($pedi['Entregue'] == 1) ? "Em transito" : "Entregue"); ?></div>
				<div id="divListaPediTotal"><?php echo ($pedi['Status'] == 1) ? "Aberto" : "Finalizado"; ?></div>
				<div id="divListaPediTotal"><?php echo ($pedi['Pagamento'] == 1) ? "Pago" : "N&atilde;o pago"; ?></div>
				<div id="divListaPediTotal"><a href="<?php echo SITEBASE; ?>/detalhe_pedido_adm/<?php echo $pedi['Codigo']; ?>">Detalhar</a></div>
				<div id="divListaPediTotal">
					<form action="<?php echo SITEBASE?>/paginas/pdf_boleto.php" method="post" name="" id="" target="_blank" enctype="multipart/form-data">
						<input name="Codigo" type="hidden" id="Codigo" value="<?php echo $pedi['Codigo']; ?>" />
						<input type="submit" name="Submit" value="Imprimir Boleto">
					</form>
				</div>
			</div>
			<?php endforeach; 
		 } else {
		 	echo '<div id="divLinhaProd">Nenhum pedido cadastrado!</div>'; 
		 } ?>
		</div>
		<?php 
		} else {
			echo '<div id="divLinhaProd">Acesso Restrito! Efetue o login!</div>';
		}
		?>
	</div>
</div>