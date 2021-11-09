<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<div id="tituloProdutos">
			<div>
				<h2>Produtos</h2> 
				<form name="buscaCategoria" method="post" action="<?php echo SITEBASE?>/produtos">
				    <select name="Categoria" id="Categoria">
					 <option>Selecione...</option>
					 
					 <?php foreach (listaCategorias() as $categoria) { ?>
					 <option value="<?php echo $categoria['Codigo'] ?>"><?php echo $categoria['Descricao'] ?></option>
					 <?php } ?>
					 
					 </select>
				    <input type="submit"  value="Buscar" />
				</form>
			</div>
		</div>
		<!-- LISTA DE PRODUTOS -->
		<div id="listaProdutos">
		<?php 
		if(isset($_POST['Categoria'])){
			$listaProd = listaProd(0, $_POST['Categoria']);			
		}else{
			$listaProd = listaProd();
		}
		if($listaProd != null){
			foreach ($listaProd as $prod) : ?>
				<div id="itemProduto">
					<div id="divProdutoDecoracao">
						<div id="itemProdutosImagemTxt">
							<div id="itemProdutosImagem">
								<a id="txtDecoracaoNone" href="<?php echo SITEBASE; ?>/detalhe/<?php echo $prod['Codigo']; ?>"><img id="imagemProduto" alt="<?php echo $prod['Descricao']; ?>" src="data:image/jpg;base64, <?php echo base64_encode($prod['Imagem']); ?>"></a>
							</div>
							<div id="itemProdutosTxt">
								<h4><a id="txtDecoracaoNone" href="<?php echo SITEBASE; ?>/detalhe/<?php echo $prod['Codigo']; ?>"><?php echo limitar($prod['Titulo'], 5); ?></a></h4>
							</div>
						</div>
						<div id="divProdutosValor">
							<em style="text-decoration: line-through;"><h5>De: R$ <?php echo real($prod['Preco']); ?></h5></em>
						</div>
						<div id="divProdutosValorPromo">
							<em style="display: block;"><h3>Por: R$ <?php echo (isset($prod['ValorPromocao']) && ($prod['ValorPromocao'] != null)) ? real($prod['ValorPromocao']) : real($prod['Preco']); ?></h3></em>
						</div>
			
						<div id="divProdutosDetalhes">
							<a id="txtDecoracaoNone"  href="<?php echo SITEBASE; ?>/detalhe/<?php echo $prod['Codigo']; ?>">Mais Detalhe</a>
						</div>
					</div>
				</div>
			<?php 
				endforeach; 
			} else {
				echo "Nenhum produto cadastrado! selecione outra categoria!";
			}
			
			?>
		
		</div>
		<!-- FIM DE LISTA PRODUTOS -->
	</div>
</div>