<?php
function cadastrarBoleto() {
	if (isset($_POST['Codigo'])) {
		if ((isset($_SESSION["TipoUsuario"])) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
			
			$codigo = $_POST['Codigo'];
			$status = isset($_POST['Status']) ? $_POST['Status'] : '0';
		
			$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	
			/* check connection */
			if ($mysqli -> connect_errno) {
				printf("Connect failed: %s\n", $mysqli -> connect_error);
				exit();
			}
			
			$boleto = (array)buscaBoletoAlterar($codigo);
			//Gera boleto com novos valores
			$dadosboleto = array();
			$dadosboleto["nosso_numero"] = $boleto['NossoNumero'];
			$dadosboleto["data_vencimento"] = date("d/m/Y", strtotime($_POST['DataVencimento'])); 
			$dadosboleto["valor_boleto"] = 	$_POST['ValorBoleto'];
			
			$boletoSalvar = geraBoletos($dadosboleto);
					
			$valorBoleto = $boletoSalvar["valor_boleto"];
			$linhaDigitavel = "'" . $mysqli->real_escape_string($boletoSalvar["linha_digitavel"]) . "'";
			$agenciaCodigo = "'" . $mysqli->real_escape_string($boletoSalvar["agencia_codigo"]) . "'";
			$nossoNumero = "'" . $mysqli->real_escape_string($boletoSalvar["nosso_numero"]) . "'";
			$codigoBancoComDv = "'" . $mysqli->real_escape_string($boletoSalvar["codigo_banco_com_dv"]) . "'";
			$dataVencimento = "'". date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $dadosboleto["data_vencimento"]))) . "'";
			
			
			$codigo = "'".$mysqli->real_escape_string($codigo)."'";
			
			$update_row = $mysqli -> query("UPDATE boletos SET ValorBoleto = $valorBoleto, LinhaDigitavel = $linhaDigitavel, DataVencimento = $dataVencimento, Status = $status WHERE Codigo = $codigo");
			$mysqli->close();
			
			if ($update_row) {
				echo "<div id='divLinha'>Cadastro alterado com sucesso!</div>";
				include ROOT . DS . 'paginas' . DS . 'lista_boletos.php';
			} else {
				die('Error : (' . $mysqli -> errno . ') ' . $mysqli -> error);
				include ROOT . DS . 'paginas' . DS . 'lista_boletos.php';
			}
					
				
			
		} else {
			echo "<div id='divLinha'>Voc&ecirc; n&atilde;o tem permi&ccedil;&atilde;o para cadastrar! Contate o administrador!</div>";
			include ROOT . DS . 'paginas' . DS . 'produtos.php';
		}
	} else {
		include ROOT . DS . 'paginas' . DS . 'lista_boletos.php';
	}
}

cadastrarBoleto();
?>