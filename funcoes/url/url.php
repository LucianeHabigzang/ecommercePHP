<?php
//FUNÇÂO DE URL AMIGAVEL
function urlAmigavel($url) {
	$pasta = ROOT . DS . 'paginas' . DS;
	
	if (isset($_GET[$url])) {
		
		$url = $_GET[$url];
		
		$url = str_replace("EN/", "", $url);
		
		if (substr_count($url, '/') > 0) {
			
			$pag = explode('/', $url);
			
			if (file_exists($pasta . $pag[0] . '.php')) {
				if ((isset($pag[1])) && ($pag[1] != null)) {
					if(($pag[0] == "cadastro_usuario") && ($pag[1] == "alterar")) {
						if(isset($pag[2])){
							$codigo = $pag[2];
						} else {
							$codigo = $_SESSION["Codigo"];
						}
						$dadosUsuario = (array)buscaUsuario($codigo);
						extract($dadosUsuario);
						include_once $pasta.'cadastro_usuario.php';
					} else if(($pag[0] == "cadastro_produto") && ($pag[1] == "alterar")) {
						$dadosProd = (array)buscaProduto($pag[2]);
						extract($dadosProd);
						include_once $pasta.'cadastro_produto.php';
					} else if(($pag[0] == "cadastro_promocao") && ($pag[1] == "alterar")) {
						$dadosPromocao = (array)buscaPromocao($pag[2]);
						extract($dadosPromocao);
						include_once $pasta.'cadastro_promocao.php';
					} else if(($pag[0] == "cadastro_solicitados") && ($pag[1] == "alterar")) {
						$dadosSolicitados = (array)buscaSolicitados($pag[2]);
						extract($dadosSolicitados);
						include_once $pasta.'cadastro_solicitados.php';
					} else if(($pag[0] == "cadastro_boleto") && ($pag[1] == "alterar")) {
						$dadosBoleto = (array)buscaBoletoAlterar($pag[2]);
						extract($dadosBoleto);
						include_once $pasta.'cadastro_boleto.php';
					} else if($pag[0] == "detalhe") {
						$dadosProd = (array)buscaProdutoDetalhe($pag[1]);
						extract($dadosProd);
						include_once $pasta.'detalhe.php';
					} else if($pag[0] == "detalhe_pedido") {
						$dadosPedido = (array)buscaPedido($pag[1]);
						extract($dadosPedido);
						include_once $pasta.'detalhe_pedido.php';
					} else if($pag[0] == "detalhe_pedido_adm") {
						$dadosPedido = (array)buscaPedido($pag[1]);
						extract($dadosPedido);
						include_once $pasta.'detalhe_pedido_adm.php';
					} else if($pag[0] == "registrar_interesse") {
						if(isset($pag[1]) && isset($pag[2])){
							registrarInteresse($pag[1], $pag[2]);
						} else {
							include_once $pasta.'produtos.php';
						}
					} else {
						include_once $pasta.'produtos.php';
					}
				}
				else {
					include_once $pasta . $pag[0] . '.php';
				}
			}
			else {
				include_once $pasta . 'erro.php';
			}
		}
		else {
			if (file_exists($pasta . $url . '.php')) {
				include_once $pasta . $url . '.php';
			}
			else {
				include_once $pasta . 'erro.php';
			}
		}
	}
	else {
		include_once $pasta.'home.php';
	}
}

?>
