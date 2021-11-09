<?php
function cadastrarPedido()
{
	
	require_once('phpmailer/PHPMailerAutoload.php');
	
	if (isset($_SESSION['carrinho'])) {
		$codigoUsuario = $_SESSION['Codigo'];
		$tipoFrete = $_POST['TipoFrete'];
		$tipoPagamento = $_POST['TipoPagamento'];
		$status = 1; //1 - Aberto 0 - Finalizado
		$entregue = 0; //0 - Entregar 1 - Em transito 2 - Entregue
		$pagamento = 0; //0 - Não Pago  1 - Pago
		
		$qtdBoleto = 1;
		if($tipoPagamento != 1) {
			if(isset($_POST['qtdParcelas']) && ($_POST['qtdParcelas'] <= 12)){
				$qtdBoleto = $_POST['qtdParcelas'];
			} else {
				echo "<div id='divLinha'>O parcelamento m&aacute;ximo &eacute; de 12 parcelas!</div>";
				include ROOT . DS . 'paginas' . DS . 'lista_Carrinho.php';
				break;
			}
			
		}
		
		// cep de destino
		$cepDestino = $_SESSION['EntregaCep'];
								
		// URL dos correios
		$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=94190250&sCepDestino={$cepDestino}&nVlPeso=0.1&nCdFormato=1&nVlComprimento=20&nVlAltura=20&nVlLargura=13&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico=40010,41106&nVlDiametro=0&StrRetorno=xml";
		
		// retorno
		$retorno = simplexml_load_file($url);
		if ($retorno) {
			foreach ( (array) $retorno as $index => $value )
		    {
		        $out[$index] = ( is_object ( $value ) ) ? xml2array ( $value ) : $value;
		    }
								
			foreach ( (array) $out['cServico'][0] as $index => $value )
		    {
		        $obj1[$index] = $value;
		    }
			foreach ( (array) $out['cServico'][1] as $index => $value )
		    {
		        $obj2[$index] = $value;
		    }
		}
		//1 - SEDEX 2 - PAC 3 - Retirar no local
		$valorFrete = 0;
		if ($tipoFrete == 1) {
			$valorFrete = floatval(str_replace(',', '.', $obj1["Valor"]));
		} elseif ($tipoFrete == 2) {
			$valorFrete = floatval(str_replace(',', '.', $obj2["Valor"]));
		}
		
		$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
		
		/* check connection */
		if ($mysqli -> connect_errno) {
			printf("Connect failed: %s\n", $mysqli -> connect_error);
			exit();
		}
		
		$insert_row = $mysqli -> query("INSERT INTO pedidos (CodigoUsuario, ValorFrete, Data, Status, Entregue, Pagamento) VALUES ($codigoUsuario, $valorFrete, now(), $status, $entregue, $pagamento)");
				
		if ($insert_row) {
			$codigoPedido = $mysqli->insert_id;
			$total = 0;
			foreach ($_SESSION['carrinho'] as $key => $value){
		
				$idProduto = $value['produto_id'];
				$dadosProdutos = buscaProdutoDetalhe($idProduto);
				
				$qtd = $value['qtd'];
				$tamanho = "'".$mysqli->real_escape_string($value['tamanho'] == null ? 0 : $value['tamanho'])."'";
				$valorUnitario = (($dadosProdutos -> ValorPromocao != null) ? $dadosProdutos -> ValorPromocao : $dadosProdutos -> Preco);
				$valorTotal = $valorUnitario * $qtd;
				$total += $valorTotal;
			
				$sql = " INSERT INTO itenspedido (Quantidade, ValorUnitario, ValorTotal, CodigoPedido, CodigoProduto, Tamanho) VALUES ($qtd, $valorUnitario, $valorTotal, $codigoPedido, $idProduto, $tamanho); ";
				
				$insert_item = $mysqli -> query($sql);
				
				if (!$insert_item) {
					die('Error insert itens pedido : (' . $mysqli -> errno . ') ' . $mysqli -> error);
					include ROOT . DS . 'paginas' . DS . 'lista_Carrinho.php';
					break;
				}
				
				//Baixa no estoque
				$quantidadeEstoque = $dadosProdutos->QuantidadeEstoque - $qtd;
				$update_produto = $mysqli -> query("UPDATE produtos SET QuantidadeEstoque = $quantidadeEstoque WHERE Codigo = $idProduto");
				
				if (!$update_produto) {
					die('Error update produto : (' . $mysqli -> errno . ') ' . $mysqli -> error);
					include ROOT . DS . 'paginas' . DS . 'lista_Carrinho.php';
				}
			
			}
			$fantCod = "'".$mysqli->real_escape_string("#" . $codigoPedido . date('dmY') . $codigoUsuario )."'";
			$total += $valorFrete;
			
			$update_row = $mysqli -> query("UPDATE pedidos SET ValorTotal = $total, FantCod = $fantCod WHERE Codigo = $codigoPedido");
			if (!$update_row) {
				die('Error update pedido : (' . $mysqli -> errno . ') ' . $mysqli -> error);
				include ROOT . DS . 'paginas' . DS . 'lista_Carrinho.php';
			}
			
			//Gera Boletos
			$dadosboleto = array();
			
			$dadosboleto["nosso_numero"] = $mysqli->real_escape_string($codigoPedido . date('Y') . $codigoUsuario );  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!
			
			// Dados do Cliente
			$cliente = (array)buscaUsuario($codigoUsuario);
			
			//Dados do boleto para salvar no banco
			$statusBoleto = 0;
			$sacado = "'" . $mysqli->real_escape_string($cliente['Nome']) . "'";
			$endereco1 = "'" . $mysqli->real_escape_string("Rua: " . $cliente['EndRua'] . " , " . $cliente['EndNro'] . " - Barirro: " . $cliente['EndBairro']) . "'";
			$endereco2 = "'" . $mysqli->real_escape_string($cliente['EndCidade'] . " - " . $cliente['EndEstado'] . " CEP: " . $cliente['EndCep']) . "'";
			
			//Dados pagamento
			$dias_de_prazo_para_pagamento = 10;
			$dadosboleto["data_vencimento"] = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400)); 
			$dadosboleto["valor_boleto"] = 	$total / $qtdBoleto;
			
			for($i = 1; $i <= $qtdBoleto; $i++){
				
				$boletoSalvar = geraBoletos($dadosboleto);
					
				$valorBoleto = $boletoSalvar["valor_boleto"];
				$linhaDigitavel = "'" . $mysqli->real_escape_string($boletoSalvar["linha_digitavel"]) . "'";
				$agenciaCodigo = "'" . $mysqli->real_escape_string($boletoSalvar["agencia_codigo"]) . "'";
				$nossoNumero = "'" . $mysqli->real_escape_string($boletoSalvar["nosso_numero"]) . "'";
				$codigoBancoComDv = "'" . $mysqli->real_escape_string($boletoSalvar["codigo_banco_com_dv"]) . "'";
				$dataVencimento = "'". date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $dadosboleto["data_vencimento"]))) . "'";
				
				$sql = "INSERT INTO boletos(Sacado, Endereco1, Endereco2, DataDocumento, ValorBoleto, Status, LinhaDigitavel, AgenciaCodigo, NossoNumero, CodigoBancoComDv, DataVencimento, CodigoPedido) VALUES ($sacado, $endereco1, $endereco2, now(), $valorBoleto, $statusBoleto, $linhaDigitavel, $agenciaCodigo, $nossoNumero, $codigoBancoComDv, $dataVencimento, $codigoPedido)";
	
				$insert_Boleto = $mysqli -> query($sql);
				
				if (!$insert_Boleto) {
					die('Error insert Boleto : (' . $mysqli -> errno . ') ' . $mysqli -> error);
					include ROOT . DS . 'paginas' . DS . 'lista_Carrinho.php';
					break;
				}
				
				$dadosboleto["data_vencimento"] = date("d/m/Y", strtotime("+1 month", strtotime(str_replace('/', '-', $dadosboleto["data_vencimento"]))));
				
			}

			$content = http_build_query(array(
			    'Codigo' => $codigoPedido,
			    'Email' => '1',
			));
			  
			$context = stream_context_create(array(
			    'http' => array(
			    	'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                    "Content-Length: ".strlen($content)."\r\n".
                    "User-Agent:MyAgent/1.0\r\n",
			        'method'  => 'POST',
			        'content' => $content,
			    )
			));
			
			$result = file_get_contents(SITEBASE . '/paginas/pdf_boleto.php', null, $context);
			
			
			//Informa via email
			$dadosemail['add'] = $cliente['Email'];
			$dadosemail['addNome'] = $cliente['Nome'];
			$dadosemail['subject'] = "Dying Suffocation - Pedido cadastrado";
			$dadosemail['body'] = "Pedido cadastrado com sucesso: " . $fantCod . " Segue em anexo o boleto referente ao seu pedido!";
			$dadosemail['AddAttachment'] = TMP . "boleto" . $codigoPedido . ".pdf";
			
			$mail = enviaEmail($dadosemail);
			
			//Limpa o carrinho.
			unset($_SESSION['carrinho']);
			
			echo "<div id='divLinha'>Pedido cadastrado com sucesso!</div>";
			include ROOT . DS . 'paginas' . DS . 'pedidos.php';
			
			$mysqli->close();
			
		} else {
			die('Error insert pedido : (' . $mysqli -> errno . ') ' . $mysqli -> error);
			include ROOT . DS . 'paginas' . DS . 'lista_Carrinho.php';
		}
		
	} else {
		include ROOT . DS . 'paginas' . DS . 'produtos.php';
	}
}
cadastrarPedido();
?>