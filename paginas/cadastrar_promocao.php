<?php
function cadastrarPromocao() {
	if (isset($_POST['Codigo'])) {
		if ((isset($_SESSION["TipoUsuario"])) && ($_SESSION["TipoUsuario"] == 3)) {
			
			$codigo = $_POST['Codigo'];
			$codigoProduto = $_POST['CodigoProduto'];
			$valorPromocao = "'" . $_POST['ValorPromocao'] . "'";
			$dataFinal = $_POST['DataFinal'];
			$status = $_POST['Status'];

			if ((!$codigoProduto) || (!$valorPromocao) || (!$dataFinal)) {
				echo "<div id='divLinha'>Por favor, todos campos devem ser preenchidos!</div>";
				include ROOT . DS . 'paginas' . DS . 'cadastro_promocao.php';
			} else {
				$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
		
				/* check connection */
				if ($mysqli -> connect_errno) {
					printf("Connect failed: %s\n", $mysqli -> connect_error);
					exit();
				}
				$result = $mysqli -> query("SELECT * FROM promocoes WHERE Status = 1 AND CodigoProduto = $codigoProduto");
				if (($result -> num_rows > 0) && (!$codigo)){
					echo "<div id='divLinha'>Promo&ccedil;&atilde;o j&aacute; cadastrada!</div>";
					include ROOT . DS . 'paginas' . DS . 'cadastro_promocao.php';
				} else {
					
					$dataFinal = "'". date('Y-m-d H:i:s', strtotime($dataFinal)) . "'";
					
					if(!$codigo){
							
						$codigoUsuario = $_SESSION["Codigo"];
						$insert_row = $mysqli -> query("INSERT INTO promocoes (CodigoProduto, ValorPromocao, DataFinal, DataCadastro, CodigoUsuario, Status) VALUES($codigoProduto, $valorPromocao, $dataFinal, now(), $codigoUsuario, $status)");
						$mysqli->close();
						
						if ($insert_row) {
							echo "<div id='divLinha'>Cadastro realizado com sucesso!</div>";
							include ROOT . DS . 'paginas' . DS . 'cadastro_promocao.php';
						} else {
							die('Error : (' . $mysqli -> errno . ') ' . $mysqli -> error);
							include ROOT . DS . 'paginas' . DS . 'cadastro_promacao.php';
						}
																																																								
					} else {
						$codigo = "'".$mysqli->real_escape_string($codigo)."'";
						$update_row = $mysqli -> query("UPDATE promocoes SET CodigoProduto = $codigoProduto, ValorPromocao = $valorPromocao, DataFinal = $dataFinal, Status = $status WHERE Codigo = $codigo");
						
						if ($update_row) {
							$mysqli->close();
							echo "<div id='divLinha'>Cadastro alterado com sucesso!</div>";
							include ROOT . DS . 'paginas' . DS . 'cadastro_promocao.php';
						} else {
							die('Error : (' . $mysqli -> errno . ') ' . $mysqli -> error);
							include ROOT . DS . 'paginas' . DS . 'cadastro_promocao.php';
						}
						
					}
				}
			}
		} else {
			echo "<div id='divLinha'>Voc&ecirc; n&atilde;o tem permi&ccedil;&atilde;o para cadastrar! Contate o administrador!</div>";
			include ROOT . DS . 'paginas' . DS . 'produtos.php';
		}
	} else {
		include ROOT . DS . 'paginas' . DS . 'cadastro_promocao.php';
	}
}

cadastrarPromocao();
?>