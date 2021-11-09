<?php
function enviaSenha() {
	
	require_once('phpmailer/PHPMailerAutoload.php');
	
	if (!isset($_POST['email'])) {
		echo "<div id='divLinha'>Por favor, digite um email!</div>";
		include ROOT . DS . 'paginas' . DS . 'recuperar_senha.php';
	} else {
		
		$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);

		/* check connection */
		if ($mysqli -> connect_errno) {
			printf("Connect failed: %s\n", $mysqli -> connect_error);
			exit();
		}
		
		$email = "'".$mysqli->real_escape_string($_POST['email'])."'";
		
		/* Select queries return a resultset */
		$result = $mysqli -> query("SELECT * FROM usuarios WHERE Email = $email");
		
		if ($result -> num_rows > 0) {
			
			$obj = $result -> fetch_object();
			
			//Gera nova senha
			$novaSenha = '';
			$caracteres = 'abcdefghijklmnopqrstuvwxyz1234567890';
			$len = strlen($caracteres);
			for ($a = 1; $a <= 6; $a++) {
				$rand = mt_rand(1, $len);
				$novaSenha .= $caracteres[$rand-1];
			}
			
			$senha = "'".md5($novaSenha)."'";
			
			$update = $mysqli -> query("UPDATE usuarios SET Senha = $senha WHERE Codigo ='{$obj -> Codigo}'");
			
			if ($update) {
				
				//Informa via email
				$dadosemail['add'] = $obj -> Email;
				$dadosemail['addNome'] = $obj -> Nome;
				$dadosemail['subject'] = "Dying Suffocation - Nova senha";
				$dadosemail['body'] = "Pedido de recuperação de senha: Nova Senha: " . $novaSenha;
				
				$mail = enviaEmail($dadosemail);
				
				echo "<div id='divLinha'>Verifique seu email e digite a senha recebida!</div>";	
				include ROOT . DS . 'paginas' . DS . 'login.php';
				
			}  else {
				die('Error update senha : (' . $mysqli -> errno . ') ' . $mysqli -> error);
				include ROOT . DS . 'paginas' . DS . 'recuperar_senha.php';
			}
		} else {

			echo "<div id='divLinha'>Email n&atilde;o cadastrado! Por favor cadastre-se!</div>";

			include ROOT . DS . 'paginas' . DS . 'cadastro_usuario.php';

		}

		$mysqli -> close();
	}
}
enviaSenha();
?>