<?php
function cadastrarProduto() {
	if (isset($_POST['Codigo'])) {
		$codigo = $_POST['Codigo'];
		$titulo = $_POST['Titulo'];
		$descricao = $_POST['Descricao'];
		$preco = $_POST['Preco'];
		$quantidade = $_POST['QuantidadeEstoque'];
		$categoria = $_POST['Categoria'];
		$status = isset($_POST['Status']) ? 1 : 0;
		
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
			
			if ((!$titulo) || (!$descricao) || ($preco == '') || ($quantidade == '') || ($categoria == '')){
				echo "<div id='divLinha'>Por favor, todos campos devem ser preenchidos!</div>";
				include ROOT . DS . 'paginas' . DS . 'cadastro_produto.php';
				
			} else{
				
				$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
		
				/* check connection */
				if ($mysqli -> connect_errno) {
					printf("Connect failed: %s\n", $mysqli -> connect_error);
					exit();
				}
				 
				$descricao = "'".$mysqli->real_escape_string($descricao)."'";
				$titulo = "'".$mysqli->real_escape_string($titulo)."'";
				
				if(!$codigo){
					
					$imagem = $_FILES["Imagem"];
					$nomeFinal = time().'.jpg';
					
					if (($imagem) && (preg_match("/(^image\/(pjpeg|jpeg|jpg|png|gif|bmp))/i", $imagem["type"])) && (move_uploaded_file($imagem['tmp_name'], $nomeFinal))) {
						
						$tamanhoImg = filesize($nomeFinal);
						$mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg));
						
						$insert_row = $mysqli -> query("INSERT INTO produtos (titulo, descricao, preco, quantidadeEstoque, codigoCategoria, dataCadastro, status, imagem) VALUES ($titulo, $descricao, $preco, $quantidade, $categoria, now(), $status, '$mysqlImg')");
						unlink($nomeFinal);
						
						if ($insert_row) {
							$mysqli->close();
							echo "<div id='divLinha'>Produto cadastrado com sucesso!</div>";
							include ROOT . DS . 'paginas' . DS . 'cadastro_produto.php';
						} else {
							die('Error : (' . $mysqli -> errno . ') ' . $mysqli -> error);
							include ROOT . DS . 'paginas' . DS . 'cadastro_produto.php';
						}
					} else {
						echo "<div id='divLinha'>Imagem Inv&aacute;lida!</div>";
						include ROOT . DS . 'paginas' . DS . 'cadastro_produto.php';
					}
				} else {
					
					$codigo = "'".$mysqli->real_escape_string($codigo)."'";
					
					$sql = " UPDATE produtos SET titulo = $titulo, descricao = $descricao, preco = $preco, quantidadeEstoque = $quantidade, codigoCategoria = $categoria, status = $status  ";
					
					
					if (isset($_FILES["Imagem"])) {
						
						$imagem = $_FILES["Imagem"];
						$nomeFinal = time().'.jpg';
						
						if (($imagem) && (preg_match("/(^image\/(pjpeg|jpeg|jpg|png|gif|bmp))/i", $imagem["type"])) && (move_uploaded_file($imagem['tmp_name'], $nomeFinal))) {
						
						$tamanhoImg = filesize($nomeFinal);
						$mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg));
						
						$sql .= " , imagem =  '$mysqlImg' ";
						
						}
					}
					
					$sql .= "  WHERE Codigo = $codigo  ";
					$update_row = $mysqli -> query($sql);
					
					if ($update_row) {
						$mysqli->close();
						echo "<div id='divLinha'>Produto alterado com sucesso!</div>";
						include ROOT . DS . 'paginas' . DS . 'cadastro_produto.php';
					} else {
						die('Error : (' . $mysqli -> errno . ') ' . $mysqli -> error);
						include ROOT . DS . 'paginas' . DS . 'cadastro_produto.php';
					}
				}
			}
		} else {
			echo "<div id='divLinha'>Voc&ecirc; n&atilde;o tem permi&ccedil;&atilde;o para cadastrar! Contate o administrador!</div>";
			include ROOT . DS . 'paginas' . DS . 'produtos.php';
		}
	} else {
		include ROOT . DS . 'paginas' . DS . 'cadastro_produto.php';
	}
}

cadastrarProduto();
?>



