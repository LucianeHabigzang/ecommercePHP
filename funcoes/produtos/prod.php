<?php
// FUNÇÃO LISTA CATEGORIAS
function listaCategorias() {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}

	/* Select queries return a resultset */
	$result = $mysqli -> query("SELECT * FROM categorias");
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

// FUNÇÃO LISTA PRODUTOS
function listaProd($listaAdm = 0, $codigoCategoria = 0) {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$DataAtual = date("Y-m-d");
	
	$sql = " SELECT produtos.Codigo, produtos.Titulo, produtos.Descricao, produtos.Preco, produtos.QuantidadeEstoque, produtos.CodigoCategoria, produtos.Status, promocoes.Codigo as PromocaoCodigo, promocoes.ValorPromocao, promocoes.DataFinal, promocoes.Status as PromocaoStatus, produtos.Imagem FROM produtos LEFT JOIN promocoes ON (promocoes.CodigoProduto = produtos.Codigo AND promocoes.DataFinal > '{$DataAtual}') ";
	if (!$listaAdm) {
		$sql .= " WHERE produtos.Status = '1' ";
	}
	
	if ($codigoCategoria){
		$sql .= " AND produtos.CodigoCategoria = '{$codigoCategoria}'  ";
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

function listaComboProd() {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = " SELECT Codigo, Titulo FROM produtos WHERE Status = '1' ";
	
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


// FUNÇÃO BUSCA PRODUTO
function buscaProduto($codigo) {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	$codigo = $mysqli->real_escape_string($codigo);
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = "SELECT * FROM produtos WHERE Codigo = '{$codigo}'";
	$result = $mysqli -> query($sql);
	
	$obj = $result -> fetch_object();

	$mysqli -> close();
	return $obj;

}

// FUNÇÃO BUSCA PRODUTO DETALHE
function buscaProdutoDetalhe($codigo) {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	$codigo = $mysqli->real_escape_string($codigo);
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$DataAtual = date("Y-m-d");
	
	$sql = "SELECT produtos.Codigo, produtos.Titulo, produtos.Descricao, produtos.Preco, produtos.QuantidadeEstoque, produtos.CodigoCategoria, produtos.Status, promocoes.Codigo as PromocaoCodigo, promocoes.ValorPromocao, promocoes.DataFinal, promocoes.Status as PromocaoStatus, produtos.Imagem FROM produtos LEFT JOIN promocoes ON (promocoes.CodigoProduto = produtos.Codigo AND promocoes.DataFinal > '{$DataAtual}') WHERE produtos.Codigo = '{$codigo}'";
	$result = $mysqli -> query($sql);
	
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_array(MYSQLI_ASSOC))
			$rows[] = $row;
		
		$mysqli -> close();
		return (object)$rows[0];
	} else {
		$mysqli -> close();
		return FALSE;
	}

}

//FUNÇÂO GETCART
function getCart() {

	$jsonCart = array();
	$jsonCart['totalCarrinho'] = 0;
	$jsonCart['count'] = 0;

	if (isset($_SESSION['carrinho']) AND !empty($_SESSION['carrinho'])) {

		$jsonCart['count'] = count($_SESSION['carrinho']);
		$total = 0;

		foreach ($_SESSION['carrinho'] as $key => $value) :
			$idProduto = $value['produto_id'];
			$dadosProdutos = buscaProdutoDetalhe($idProduto);
			$valor = number_format(($dadosProdutos -> ValorPromocao != null) ? $dadosProdutos -> ValorPromocao : $dadosProdutos -> Preco, 2, ",", ".");
			$subtotal = number_format((($dadosProdutos -> ValorPromocao != null) ? $dadosProdutos -> ValorPromocao : $dadosProdutos -> Preco) * $value['qtd'], 2, ",", ".");
			
			$jsonCart['dados'][] = array('id' => $key, 'nome' => limitar($dadosProdutos -> Titulo, 1), 'qtd' => $value['qtd'], 'tamanho' => $value['tamanho'], 'valor' => $valor, 'subtotal' => $subtotal);

			//SOMAR TUDO
			$total += $subtotal;

		endforeach;
		$jsonCart['totalCarrinho'] = number_format($total, 2, ",", ".");
	}

	//RETORNA JSON COM SEM DADOS
	return json_encode($jsonCart);

}

function buscaPromocao($codigo)
{
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	$codigo = $mysqli->real_escape_string($codigo);
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}

	$result = $mysqli -> query("SELECT * FROM promocoes WHERE Codigo = '{$codigo}'");

	$obj = $result -> fetch_object();

	$mysqli -> close();
	return $obj;
}

// FUNÇÃO LISTA PROMOÇÕES
function listaPromocoes() {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = " SELECT promocoes.Codigo, promocoes.ValorPromocao, promocoes.DataFinal, promocoes.Status, produtos.Titulo  FROM promocoes INNER JOIN produtos ON (promocoes.CodigoProduto = produtos.Codigo) ";
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


function registrarInteresse($codigoProd, $qtd){
	
	if (($codigoProd != null) && ($qtd != null)) {
		
		$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
		
		$codigoUsr = "'".$mysqli->real_escape_string(isset($_SESSION['Codigo']) ? $_SESSION['Codigo'] : 1)."'";
		$codigoProd = "'".$mysqli->real_escape_string($codigoProd)."'";
		
		/* check connection */
		if ($mysqli -> connect_errno) {
			printf("Connect failed: %s\n", $mysqli -> connect_error);
			exit();
		}
		
		$insert_row = $mysqli -> query("INSERT INTO usuariosprodutos(CodigoUsuario, CodigoProduto, DataCadastro, QuantidadeInteresse) VALUES ($codigoUsr,$codigoProd,now(),$qtd)");
		
		$mysqli->close();
		
		if ($insert_row) {
			echo "<div id='divLinha'>Registro cadastrado com sucesso!</div>";
			include ROOT . DS . 'paginas' . DS . 'produtos.php';
		} else {
			die('Error : (' . $mysqli -> errno . ') ' . $mysqli -> error);
			include ROOT . DS . 'paginas' . DS . 'produtos.php';
		}
		
	} else {
		include ROOT . DS . 'paginas' . DS . 'produtos.php';
	}
	
}


function listaSolicitados(){
	
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = " SELECT usuariosprodutos.Codigo, usuariosprodutos.Status, usuariosprodutos.CodigoUsuario, usuariosprodutos.CodigoProduto, usuariosprodutos.DataCadastro, usuariosprodutos.QuantidadeInteresse, produtos.Titulo, usuarios.Email FROM usuariosprodutos LEFT JOIN produtos ON (usuariosprodutos.CodigoProduto = produtos.Codigo) LEFT JOIN usuarios ON (usuariosprodutos.CodigoUsuario = usuarios.Codigo) ";
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


function buscaSolicitados($codigo){
	
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	$codigo = $mysqli->real_escape_string($codigo);
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}

	$result = $mysqli -> query("SELECT * FROM usuariosprodutos WHERE Codigo = '{$codigo}'");

	$obj = $result -> fetch_object();

	$mysqli -> close();
	return $obj;
}




