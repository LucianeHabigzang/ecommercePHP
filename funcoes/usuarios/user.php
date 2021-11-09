<?php
// BUSCA USUARIO
function buscaUsuario($codigo){
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}

	$result = $mysqli -> query("SELECT * FROM usuarios WHERE Codigo = '{$codigo}'");

	$obj = $result -> fetch_object();

	$mysqli -> close();
	return $obj;
}
// FUNÇÃO LISTA USUARIOS
function listaUsuarios() {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);

	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = " SELECT * FROM usuarios ORDER BY Nome ";
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

?>