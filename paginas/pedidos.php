<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["Codigo"])) {
				
		?>	
		<div id="tituloProdutos">
			<div><h2>Lista de pedidos cadastrados</h2></div>
		</div>
		<div id="listaProdutos">
			<div id="divLinhaProd">
				<div id="divListaPedi">Pedido</div>
				<div id="divListaPedi">Data</div>
				<div id="divListaPedi">Valor Total</div>
				<div id="divListaPedi">Transito</div>
				<div id="divListaPedi">Status</div>
				<div id="divListaPedi"></div>
			</div>
		<?php
		 $pedidos = listaPedidos($_SESSION['Codigo']);
		 if($pedidos != null){
			 foreach ($pedidos as $pedi) : ?>
				<div id="divLinhaProd">
					<div id="divListaPedi"><?php echo $pedi['FantCod']; ?></div>
					<div id="divListaPedi"><?php echo formatDate($pedi['Data']); ?></div>
					<div id="divListaPedi"><?php echo "R$ " . real($pedi['ValorTotal']); ?></div>
					<div id="divListaPedi"><?php echo ($pedi['Entregue'] == 0) ? "Entregar" : (($pedi['Entregue'] == 1) ? "Em transito" : "Entregue"); ?></div>
					<div id="divListaPedi"><?php echo ($pedi['Status'] == 1) ? "Aberto" : "Finalizado"; ?></div>
					<div id="divListaPedi"><a href="<?php echo SITEBASE; ?>/detalhe_pedido/<?php echo $pedi['Codigo']; ?>">Detalhar</a></div>
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