<?php
function cadastrarUsuario() {
	if (isset($_POST['Codigo'])) {
		$codigo = $_POST['Codigo'];
		$nome = $_POST['Nome'];
		$telefone = $_POST['Telefone'];
		$cpf = $_POST['Cpf'];
		$dataNasc = $_POST['DataNasc'];
		$email = $_POST['Email'];
		$rua = $_POST['Rua'];
		$numero = $_POST['Numero'];
		$cep = $_POST['Cep'];
		$bairro = $_POST['Bairro'];
		$cidade = $_POST['Cidade'];
		$ruaEntrega = $_POST['EntregaRua'];
		$numeroEntrega = $_POST['EntregaNumero'];
		$cepEntrega = $_POST['EntregaCep'];
		$bairroEntrega = $_POST['EntregaBairro'];
		$cidadeEntrega = $_POST['EntregaCidade'];
		$senha = $_POST['Senha'];
		$status = $_POST['Status'];
	
		if ((!$nome) || (!$telefone) || (!$cpf) || (!$dataNasc) || (!$email) || (!$rua) || (!$numero) || (!$cep) || (!$bairro) || (!$cidade) || (!$senha) || (!$ruaEntrega) || (!$numeroEntrega) || (!$cepEntrega) || (!$bairroEntrega) || (!$cidadeEntrega)) {
			echo "<div id='divLinha'>Por favor, todos campos devem ser preenchidos!</div>";
			include ROOT . DS . 'paginas' . DS . 'cadastro_usuario.php';
		} else {
			$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	
			/* check connection */
			if ($mysqli -> connect_errno) {
				printf("Connect failed: %s\n", $mysqli -> connect_error);
				exit();
			}
			$result = $mysqli -> query("SELECT * FROM usuarios WHERE Email='{$email}'");
			if (($result -> num_rows > 0) && (!$codigo)){
				echo "<div id='divLinha'>Email j&aacute; cadastrado!</div>";
				include ROOT . DS . 'paginas' . DS . 'login.php';
			} else {
				
				$nome = "'".$mysqli->real_escape_string($nome)."'";
				$cpf = "'".$mysqli->real_escape_string($cpf)."'";
				$dataNasc = "'". date('Y-m-d H:i:s', strtotime($dataNasc)) . "'";
				$rua = "'".$mysqli->real_escape_string($rua)."'";
				$cep = "'".$mysqli->real_escape_string($cep)."'";
				$bairro = "'".$mysqli->real_escape_string($bairro)."'";
				$cidade = "'".$mysqli->real_escape_string($cidade)."'";
				$email = "'".$mysqli->real_escape_string($email)."'";
				$telefone = "'".$mysqli->real_escape_string($telefone)."'";
				$ruaEntrega = "'".$mysqli->real_escape_string($ruaEntrega)."'";
				$cepEntrega = "'".$mysqli->real_escape_string($cepEntrega)."'";
				$bairroEntrega = "'".$mysqli->real_escape_string($bairroEntrega)."'";
				$cidadeEntrega = "'".$mysqli->real_escape_string($cidadeEntrega)."'";
				
				
				if (isset($_SESSION["TipoUsuario"]) && ($_SESSION["TipoUsuario"] == 3)) {
					$tipoUsuario = $_POST["TipoUsuario"];
				} else if (isset($_SESSION["TipoUsuario"]) && ($_SESSION["TipoUsuario"] == 2)) {
					$tipoUsuario = 2; //Funcionário
				} else {
					$tipoUsuario = 1; //Cliente
				}
				
				if(!$codigo){
					
					$senha = "'".md5($senha)."'";
				
					$insert_row = $mysqli -> query("INSERT INTO usuarios (Nome, Telefone, Cpf, DataNasc, Email, EndRua, EndNro, EndCep, EndBairro, EndCidade, Senha, EntregaRua, EntregaNro, EntregaCep, EntregaBairro, EntregaCidade, DataCadastro, TipoUsuario, Status) VALUES($nome, $telefone, $cpf, $dataNasc, $email, $rua, $numero, $cep, $bairro, $cidade, $senha, $ruaEntrega, $numeroEntrega, $cepEntrega, $bairroEntrega, $cidadeEntrega, now(), $tipoUsuario, $status)");
					$mysqli->close();
					
					if ($insert_row) {
						echo "<div id='divLinha'>Cadastro realizado com sucesso!</div>";
						include ROOT . DS . 'paginas' . DS . 'login.php';
					} else {
						die('Error : (' . $mysqli -> errno . ') ' . $mysqli -> error);
						include ROOT . DS . 'paginas' . DS . 'cadastro_usuario.php';
					}
																																																							
				} else {
					$usuario = (array)buscaUsuario($codigo);
					$senha = md5($senha);
					if($senha != $usuario['Senha']){
						extract($usuario);
						echo "<div id='divLinha'>Senha antiga incorreta!</div>";
						include ROOT . DS . 'paginas' . DS . 'cadastro_usuario.php';
					} else {
						
						$senhaNova = $_POST['SenhaNova'];
						$senhaConfirma = $_POST['SenhaConfirma'];
						
						if ($senhaNova != $senhaConfirma) {
							extract($usuario);
							echo "<div id='divLinha'>Senha nova diferente da senha confirma!</div>";
							include ROOT . DS . 'paginas' . DS . 'cadastro_usuario.php';
						} else {
							
							$senhaNova = "'".md5($senhaNova)."'";
							
							$codigo = "'".$mysqli->real_escape_string($codigo)."'";
							$update_row = $mysqli -> query("UPDATE usuarios SET Nome = $nome, Telefone = $telefone, Cpf = $cpf, DataNasc = $dataNasc, Email = $email, EndRua = $rua, EndNro = $numero, EndCep = $cep, EndBairro = $bairro, EndCidade = $cidade, Senha = $senhaNova, EntregaRua = $ruaEntrega, EntregaNro = $numeroEntrega, EntregaCep = $cepEntrega, EntregaBairro = $bairroEntrega, EntregaCidade = $cidadeEntrega, TipoUsuario = $tipoUsuario, Status = $status WHERE Codigo = $codigo");
							
							if ($update_row) {
								$mysqli->close();
								echo "<div id='divLinha'>Cadastro alterado com sucesso!</div>";
								include ROOT . DS . 'paginas' . DS . 'produtos.php';
							} else {
								die('Error : (' . $mysqli -> errno . ') ' . $mysqli -> error);
								include ROOT . DS . 'paginas' . DS . 'cadastro_usuario.php';
							}
						}
					}
				}
			}
		}
	} else {
		include ROOT . DS . 'paginas' . DS . 'cadastro_usuario.php';
	}
}

cadastrarUsuario();
?>