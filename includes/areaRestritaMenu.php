<?php
echo '<div id="restritaMenu">';
	echo '<div class="navRes" id="navRes">';
		echo '<ul>';
			if (!isset($_SESSION['Codigo']) || $_SESSION == Array()) {
				echo '<li>';
				echo '<a href="' . SITEBASE . '/login">Login</a>';
				echo '</li>';
				echo '<li>';
				echo '<a href="' . SITEBASE . '/cadastro_usuario/">Cadastre-se</a>';
				echo '</li>';
			} else {
				echo "Bem vindo! <br />";
				echo $_SESSION["Nome"];
				echo '<br />';
				echo '<a id="txtDecoracaoNone" href="' . SITEBASE . '/cadastro_usuario/alterar">Alterar Cadastro</a>';
				echo '<br />';
				echo '<a id="txtDecoracaoNone" href="' . SITEBASE . '/pedidos/">Pedidos</a>';
			}
			
			echo '<li>';
				echo '<a href="' . SITEBASE . '/produtos/">Produtos</a>';
			echo '</li>';
			
	      echo '<li id="cartAll">';
	        echo '<a href="' . SITEBASE . '/lista_carrinho/" id="countCart">Carrinho (0)</a>';
			if ((isset($url) && ($url == "lista_carrinho/")) || (!isset($_SESSION['carrinho']))) {
				echo '<div style="display: none;">';
			} else {
				echo '<div>';
			}
	        echo '<ul style="margin: 0; padding: 0;">';
	          echo '<li>';
				echo '<table>';
				  echo '<thead>';
				    echo '<tr>';
				      echo '<th>Produto</th>';
				      echo '<th>Quantidade</th>';
				      echo '<!--<th>Valor</th>-->';
				      echo '<th>Subtotal</th>';
				      echo '<th width="5">Remover</th>';
				    echo '</tr>';
				  echo '</thead>';
				  echo '<tbody>';
				  	echo '<tr><td colspan="3">Nenhum produto Adicionado</td></tr>';
				  echo '</tbody>';
	
				  echo '<tfoot>';
				  	echo '<tr>';
				      echo '<td>Total:</td>';
				      echo '<td colspan="3" id="totalCart">R$ 0,00</td>';
				    echo '</tr>';
				  echo '</tfoot>';
				echo '</table>';
			echo '</li>';
	        echo '</ul>';
			echo '</div>';
	      echo '</li>';
	
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
			echo '<div class="navResAdm" id="navResAdm">';
	 		echo "<u><b>Painel de Controle</b></u> <br />";
			echo '<ul style="margin: 0; padding: 0;">';
				echo '<li>';
					echo '<a href="' . SITEBASE . '/cadastro_produto/"> Cadastro de produtos </a>';
				echo '</li>';
				echo '<li>';
					echo '<a href="' . SITEBASE . '/lista_produtos/">Produtos Cadastrados</a>';
				echo '</li>';
				echo '<li>';
					echo '<a href="' . SITEBASE . '/lista_pedidos/">Pedidos Cadastrados</a>';
				echo '</li>';
				echo '<li>';
					echo '<a href="' . SITEBASE . '/grafico_vendas/">Gr&aacute;fico de vendas</a>';
				echo '</li>';
				echo '<li>';
					echo '<a href="' . SITEBASE . '/lista_solicitados/">Produtos Solicitados</a>';
				echo '</li>';
				echo '<li>';
					echo '<a href="' . SITEBASE . '/lista_boletos/">Boletos Cadastrados</a>';
				echo '</li>';

			if ($_SESSION["TipoUsuario"] == 3) {
				echo '<li>';
					echo '<a href="' . SITEBASE . '/cadastro_promocao/"> Cadastro de promo&ccedil;&atilde;o </a>';
				echo '</li>';
				echo '<li>';
					echo '<a href="' . SITEBASE . '/lista_promocoes/"> Promo&ccedil;&otilde;es Cadastradas  </a>';
				echo '</li>';
				echo '<li>';
					echo '<a href="' . SITEBASE . '/cadastro_usuario/"> Cadastro de Usu&aacute;rio </a>';
				echo '</li>';
				echo '<li>';
					echo '<a href="' . SITEBASE . '/lista_usuarios/">Usuarios Cadastrados</a>';
				echo '</li>';
				
			}
		echo '</ul>';
	echo '</div>';
	}
			echo '<li>';
				echo '<a href="' . SITEBASE . '/logout">Sair</a>';
			echo '</li>';
		echo '</ul>';
	echo '</div>';
echo '</div>';
?>