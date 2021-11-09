<?php
function verificaUsuario() {
	if ((!isset($_POST['usuario'])) || (!isset($_POST['senha']))) {
		include ROOT . DS . 'paginas' . DS . 'produtos.php';
	} else if((!$_POST['senha']) || (!$_POST['usuario'])) {
		echo "<div id='divLinha'>Por favor, todos campos devem ser preenchidos!</div>";
		include ROOT . DS . 'paginas' . DS . 'login.php';
	} else {
		$usuario = $_POST['usuario'];
		$senha = $_POST['senha'];
		$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);

		/* check connection */
		if ($mysqli -> connect_errno) {
			printf("Connect failed: %s\n", $mysqli -> connect_error);
			exit();
		}

		/* Select queries return a resultset */
		$result = $mysqli -> query("SELECT * FROM usuarios WHERE Email='{$usuario}'");
		if ($result -> num_rows > 0) {
			$senha = md5($senha);
			$obj = $result -> fetch_object();
			
			if ($obj -> Senha == $senha) {
				// Inicia a session
				$_SESSION['Codigo'] = $obj -> Codigo;
				$_SESSION['Nome'] = $obj -> Nome;
				$_SESSION['Email'] = $obj -> Email;
				$_SESSION['TipoUsuario'] = $obj -> TipoUsuario;
				$_SESSION['EntregaRua'] = $obj -> EntregaRua;
				$_SESSION['EntregaNro'] = $obj -> EntregaNro;
				$_SESSION['EntregaCep'] = $obj -> EntregaCep;
				$_SESSION['EntregaBairro'] = $obj -> EntregaBairro;
				$_SESSION['EntregaCidade'] = $obj -> EntregaCidade;

				$mysqli -> query("UPDATE usuarios SET DataUltimoLog = now() WHERE Codigo ='{$obj -> Codigo}'");
				
				include ROOT . DS . 'paginas' . DS . 'produtos.php';
			} else {
				echo "<div id='divLinha'>Senha invalida!</div>";

				include ROOT . DS . 'paginas' . DS . 'login.php';
			}
		} else {

			echo "<div id='divLinha'>Usu&aacute;rio n&atilde;o cadastrado! Por favor cadastre-se!</div>";

			include ROOT . DS . 'paginas' . DS . 'cadastro_usuario.php';

		}

		$mysqli -> close();
	}
}
verificaUsuario();
?>