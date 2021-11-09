<?php

include_once '../config.php';

function graficoDataaaaa() {

	$sql = "SELECT produtos.Titulo, COUNT(*) AS qtd FROM itenspedido LEFT JOIN produtos ON (produtos.Codigo = itenspedido.CodigoProduto) GROUP BY itenspedido.CodigoProduto";

	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);

	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$result = $mysqli -> query($sql);
	
	$jsonCart = array();
	
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$rows[] = $row;
			//$jsonCart['dados'][] = array('Produto' => $row['Titulo'], 'Quantidade' => $row['qtd']);
		}
		
		$mysqli -> close();
		return $row;
	} else {
		$mysqli -> close();
		return FALSE;
	}

}

graficoDataaaaa();

?>