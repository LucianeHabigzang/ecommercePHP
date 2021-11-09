<?php
// FUNÇÃO LISTA PEDIDOS
function listaPedidos($codigo = null) {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);

	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = " SELECT * FROM pedidos ";
	
	if ($codigo) {
		$sql .= " WHERE CodigoUsuario = '{$codigo}' ";
	}
	
	$result = $mysqli -> query($sql);
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_array(MYSQLI_ASSOC))
			$rows[] = $row;
		
		$mysqli -> close();
		return $rows;
	} else {
		$mysqli -> close();
		return FALSE;
	}
}

// FUNÇÃO BUSCA PEDIDO
function buscaPedido($codigo) {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$codigo = $mysqli->real_escape_string($codigo);
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = "SELECT * FROM pedidos WHERE Codigo = '{$codigo}'";
	$result = $mysqli -> query($sql);
	
	$obj = $result -> fetch_object();

	$mysqli -> close();
	return $obj;

}

// FUNÇÃO BUSCA ITENS DO PEDIDO
function buscaPedidoItens($codigo) {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$codigo = $mysqli->real_escape_string($codigo);
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = "SELECT itenspedido.CodigoProduto, itenspedido.Tamanho, itenspedido.ValorUnitario, itenspedido.Quantidade, itenspedido.ValorTotal, produtos.Titulo FROM itenspedido LEFT JOIN produtos ON (produtos.Codigo = itenspedido.CodigoProduto) WHERE itenspedido.CodigoPedido = '{$codigo}'";
	$result = $mysqli -> query($sql);
	
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_array(MYSQLI_ASSOC))
			$rows[] = $row;
		
		$mysqli -> close();
		return $rows;
	} else {
		$mysqli -> close();
		return FALSE;
	}

}



function graficoData() {

	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = "  SELECT produtos.Titulo, COUNT(*) AS qtd FROM itenspedido LEFT JOIN produtos ON (produtos.Codigo = itenspedido.CodigoProduto) GROUP BY itenspedido.CodigoProduto ";
	
	$result = $mysqli -> query($sql);
	$rows = array();
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_array(MYSQLI_ASSOC))
			$rows[] = $row;
			
		
		$mysqli -> close();
		return json_encode($rows);
	} else {
		$mysqli -> close();
		return FALSE;
	}

}



?>