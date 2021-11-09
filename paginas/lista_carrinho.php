<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<div id="tituloProdutos">
			<div><h2>Itens no Carrinho</h2></div>
		</div>
	<?php
		if (isset($_SESSION['carrinho'])) {
				
	?>	
		<div id="listaCarrinho">
			<div id="divLinhaProd">
				<div id="divListaPedi">Titulo</div>
				<div id="divListaPedi">Pre&ccedil;o</div>
				<div id="divListaPedi">Quantidade</div>
				<div id="divListaPedi">Tamanho</div>
				<div id="divListaPedi">Sub-Total</div>
				<div id="divListaPedi"></div>
			</div>
		<?php 
				$total = 0;
				foreach ($_SESSION['carrinho'] as $key => $value) : 

				$idProduto = $value['produto_id'];
				$dadosProdutos = buscaProdutoDetalhe($idProduto);
				
		?>
			<div id="divLinhaProd">
				<div id="divListaPedi"><?php echo limitar($dadosProdutos -> Titulo, 1); ?></div>
				<div id="divListaPedi"><?php echo " R$ " . real(($dadosProdutos -> ValorPromocao != null) ? $dadosProdutos -> ValorPromocao : $dadosProdutos -> Preco); ?></div>
				<div id="divListaPedi"><?php echo $value['qtd']; ?></div>
				<div id="divListaPedi"><?php echo (($value['tamanho'] == 1) ? "P" : (($value['tamanho'] == 2) ? "M" : (($value['tamanho'] == 3) ? "G" : (($value['tamanho'] == 4) ? "GG" : (($value['tamanho'] == 5) ? "XG" : "--"))))); ?></div>
				<div id="divListaPedi"><?php echo " R$ " . real((($dadosProdutos -> ValorPromocao != null) ? $dadosProdutos -> ValorPromocao : $dadosProdutos -> Preco) * $value['qtd']); ?></div>
				<div id="divListaPedi">
					<div id="ItemCarrinho">
					<a href="#" id="carrinhoRemoveItem" data-id="<?php echo $key; ?>"><span>Retirar</span></a>
					</div>
				</div>
			</div>
		<?php 
			
				$total += (($dadosProdutos -> ValorPromocao != null) ? $dadosProdutos -> ValorPromocao : $dadosProdutos -> Preco) * $value['qtd'];
				endforeach; 
		?>
		</div>
		<div>
		<?php
			if (isset($_SESSION['Codigo'])) {
				
		?>	
			<form action="<?php echo SITEBASE?>/cadastrar_pedido" method="post" name="" id="" enctype="multipart/form-data">
				<?php
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
				?>
				<div id="divCarinhoInfo">
					<h3>Pagamento via Boleto:</h3>
					<?php  
						echo "<div id='divLinhaCarrinho'><input type=radio id='TipoPagamento' name='TipoPagamento' value=1 checked><a>&Agrave; Vista</a></div>"; 
					    echo "<div id='divLinhaCarrinho'><input type=radio id='TipoPagamento' name='TipoPagamento' value=2><a>Parcelado </a><input min='0' max='12' style='width: 50px;' type='number' name='qtdParcelas' value='12'><a> vezes </a></div>";
						
					?>
				</div>
				<div id="divCarinhoInfo">
					<h3>Valor do frete:</h3>
					<?php  
						if(isset($obj1) && isset($obj2)) {
							echo "<div id='divLinhaCarrinho'><input type=radio id='TipoFrete' name='TipoFrete' onchange='ChangeTipoFrete(this, " . "\"" . real($total + str_replace(",", ".", $obj1["Valor"])) . "\"" . ")' value=1><a>SEDEX: R$ " . $obj1["Valor"] . " Prazo de entrega: " . $obj1["PrazoEntrega"] . " dias ". " </a></div>"; 
					    	echo "<div id='divLinhaCarrinho'><input type=radio id='TipoFrete' name='TipoFrete' onchange='ChangeTipoFrete(this, " . "\"" . real($total + str_replace(",", ".", $obj2["Valor"])) . "\"" . ")' value=2 checked><a>PAC: R$ " . $obj2["Valor"] . " Prazo de entrega: " . $obj2["PrazoEntrega"] . " dias ". " </a></div>";
							echo "<div id='divLinhaCarrinho'><input type=radio id='TipoFrete' name='TipoFrete' onchange='ChangeTipoFrete(this, " . "\"" . real($total) . "\"" . ")' value=3><a>Retirar no local </a></div>";  
						} else {
							echo "<a>Valores n&atilde;o informados! Tente mais tarde! </a>";
						}
					?>
				</div>
				<div id="divProdutosDetalhes">
					<h2 id="ValorTotal">Valor Total: <?php echo " R$ " . real($total + (isset($obj2["Valor"]) ? str_replace(",", ".", $obj2["Valor"]) : 0)); ?></h2>
				</div>		
				<div id="divPedidosDetalhes">
					<h3>Endere&ccedil;o para entrega:</h3><?php echo "<a>Rua: " . $_SESSION['EntregaRua'] . "  -  N&uacute;mero: " . $_SESSION['EntregaNro'] . " -  CEP: " . $_SESSION['EntregaCep'] . "  -  Bairro: " . $_SESSION['EntregaBairro'] . "  -  Cidade: " . $_SESSION['EntregaCidade'] . "</a>"; ?> 
				</div>
				<div id="divProdutosDetalhes">		
						<input type="submit" name="Submit" value="Finalizar pedido">
				</div>
			</form>
			<?php
				} else {
			?>
				
				<div id="divProdutosDetalhes">
					<h2 id="ValorTotal">Valor Total: <?php echo " R$ " . real($total); ?></h2>
					
				</div>
				
				<div style="padding: 100px;">
					<h3>Fa&ccedil;a login ou cadastre-se para finalizar seu pedido!</h3>
					
				</div>
			<?php
				}
						
			?>	
		</div>
		<?php 
		} else {
			echo '<div id="divLinhaProd">Nenhum produto Adicionado no carrinho!</div>';
		}
		?>
	</div>
</div>