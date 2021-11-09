<?php
function atualizarPedido(){
	
	require_once('phpmailer/PHPMailerAutoload.php');
	
	if(isset($_POST['Codigo'])){
		
		$codigoUsuario = $_POST['CodigoUsuario'];
		$codigoPedido = $_POST['Codigo'];
		$pagamento = $_POST['Pagamento']; //0 - Não Pago  1 - Pago
		$status = $_POST['Status']; //1 - Aberto 0 - Finalizado
		$entregue = $_POST['Entregue']; //0 - Entregar 1 - Em transito 2 - Entregue
		$fantCod = $_POST['FantCod']; 
		
		$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
		
		/* check connection */
		if ($mysqli -> connect_errno) {
			printf("Connect failed: %s\n", $mysqli -> connect_error);
			exit();
		}
		
		$rastreamento = "'".$mysqli->real_escape_string($_POST['Rastreamento'])."'";
		
		$update_row = $mysqli -> query("UPDATE pedidos SET Pagamento = $pagamento, Status = $status, Entregue = $entregue, Rastreamento = $rastreamento WHERE Codigo = $codigoPedido");
		
		if (!$update_row) {
			die('Error update pedido : (' . $mysqli -> errno . ') ' . $mysqli -> error);
			include ROOT . DS . 'paginas' . DS . 'lista_pedidos.php';
		}
		
		// Dados do Cliente
		$cliente = (array)buscaUsuario($codigoUsuario);
		
		if ($entregue == 1) {
			//Informa via email
			$dadosemail['add'] = $cliente['Email'];
			$dadosemail['addNome'] = $cliente['Nome'];
			$dadosemail['subject'] = "Dying Suffocation - Pedido em transito";
			$dadosemail['body'] = "Pedido: " . $fantCod . " Foi encaminhado para o endereço de entrega. Você pode acompanhar seu pedido pelo rastreamento: " . $rastreamento;
			
			$mail = enviaEmail($dadosemail);
		}
		
		if ($pagamento == 1) {
			//Informa via email
			$dadosemail['add'] = $cliente['Email'];
			$dadosemail['addNome'] = $cliente['Nome'];
			$dadosemail['subject'] = "Dying Suffocation - Pagamento identificado";
			$dadosemail['body'] = "Pedido: " . $fantCod . " Identificamos que o pagamento do seu pedido foi efetuado! ";
			
			$mail = enviaEmail($dadosemail);
		}
		
		echo "<div id='divLinha'>Pedido atualizado com sucesso!</div>";
		include ROOT . DS . 'paginas' . DS . 'lista_pedidos.php';
		
	} else {
		include ROOT . DS . 'paginas' . DS . 'lista_pedidos.php';
	}
}

atualizarPedido();

?>