<?php
include_once '../config.php';

// COMO ESTAMOS TRABALHANDO COMSERVIDOR LOCAL
// ESTA LINHA ABAIXO SERVE PARA DEFINIR UM TEMPO, ANTE DE EXECUTAR TUDO ABAIXO

sleep(2);

/* COMEÇAMOS AQUI, PARA RECEBER NA VARIÁVEL A AÇÂO, ASSIM SENDO MANIPULAMOS O MESMO DE ACORDO */
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
	case 'add':
		
		$produto  	= filter_input(INPUT_POST, 'produto', FILTER_SANITIZE_STRING);
		$qtdAtual   = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
		$tamanho   = filter_input(INPUT_POST, 'tamanho', FILTER_SANITIZE_NUMBER_INT);
		$idsess 	= $produto . $tamanho;
		$dadosProduto = buscaProduto($produto);
		
			//VERIFICAMOS SE O PRODUTO EXISTE
			if($dadosProduto){
				//VERIFICAMOS SE A QUANTIDADE DO PRODUTO É MAIOR QUE A QUANTIDADE ATUAL DO USUÁRIO, E DEPOIS VERIFICAMOS SE A QUANTIDADE ATUAL É MAIOR QUE 0, SENDO ASSIM FAZEMOS TODA MANIPULAÇÂO!
				if(($dadosProduto->QuantidadeEstoque >= $qtdAtual) AND ($qtdAtual > 0)){
					//Verifica se a sessão existe, se não criamos ela como array vazio
					if(!isset($_SESSION['carrinho'])){
						$_SESSION['carrinho'] = array();
					}

					//Verifica se existe o produto no indice
					if(empty($_SESSION['carrinho'][$idsess])){
						$_SESSION['carrinho'][$idsess] = array(
							'produto_id' => $produto,
							'qtd' => $qtdAtual,
							'tamanho' => $tamanho
						);
					} else {
						// MODIFICAMOS A QUANTIDADE DE ACORDO COM O PRODUTO DA SESSÂO "CARRINHO"
						$_SESSION['carrinho'][$idsess]['qtd'] = $qtdAtual;
						$_SESSION['carrinho'][$idsess]['tamanho'] = $tamanho;
					}
					//Produtos prod.php	
					echo getCart();
					
				}else{
					echo json_encode("notQtd");
				}
			} else {
				echo json_encode('notProd');
			}

		break;

	// OBTEMOS TODOS O ITENS DA SESSÃO "CARRINHO"
	case 'getCarrinho':
			echo getcart();
		break;
	// DELETEMOS O ITEN DA SESSÂO "CARRINHO" DE ACORDO COM O ID QUE RECEBEMOS
	case 'deleteIten':
		$key = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

			// VERIFICAMOS SE REALMENTE O PRODUTO EXISTE, PARA DEPOIS EXCLUIR-LO DA SESSÃO "CARRINHO"
			if(isset($_SESSION['carrinho'][$key])){
				unset($_SESSION['carrinho'][$key]);
				echo json_encode('OK');
			}

		break;

	default:
		# code...
		break;
}
