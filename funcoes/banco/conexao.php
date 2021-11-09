<?php

/*
define('HOST', 'include_once');
define('USUARIO', 'dying927_root');
define('SENHA', 'Zyon40Dying');
define('BD', 'dying927_vendasonlinedb');

/*/
define('HOST', 'localhost');
define('USUARIO', 'root');
define('SENHA', '');
define('BD', 'vendasOnlineDB');
//*/

//error_reporting(0);

// FUNCAO DE CONEXAO
function conecta() {
	// Conecta-se ao banco de dados MySQL
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	// Caso algo tenha dado errado, exibe uma mensagem de erro
	if (mysqli_connect_errno())
		trigger_error(mysqli_connect_error());
}
?>