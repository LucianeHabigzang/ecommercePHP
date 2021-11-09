<?php
function cadastrarSolicitados() {
	if (isset($_POST['Codigo'])) {
		if ((isset($_SESSION["TipoUsuario"])) && ($_SESSION["TipoUsuario"] == 3)) {
			
			$codigo = $_POST['Codigo'];
			$status = isset($_POST['Status']) ? $_POST['Status'] : '0';
		
			$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	
			/* check connection */
			if ($mysqli -> connect_errno) {
				printf("Connect failed: %s\n", $mysqli -> connect_error);
				exit();
			}
			
			$codigo = "'".$mysqli->real_escape_string($codigo)."'";
			$update_row = $mysqli -> query("UPDATE usuariosprodutos SET Status = $status WHERE Codigo = $codigo");
			$mysqli->close();
			
			if ($update_row) {
				echo "<div id='divLinha'>Cadastro alterado com sucesso!</div>";
				include ROOT . DS . 'paginas' . DS . 'lista_solicitados.php';
			} else {
				die('Error : (' . $mysqli -> errno . ') ' . $mysqli -> error);
				include ROOT . DS . 'paginas' . DS . 'lista_solicitados.php';
			}
					
				
			
		} else {
			echo "<div id='divLinha'>Voc&ecirc; n&atilde;o tem permi&ccedil;&atilde;o para cadastrar! Contate o administrador!</div>";
			include ROOT . DS . 'paginas' . DS . 'produtos.php';
		}
	} else {
		include ROOT . DS . 'paginas' . DS . 'lista_solicitados.php';
	}
}

cadastrarSolicitados();
?>