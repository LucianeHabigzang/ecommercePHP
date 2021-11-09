<div id="principalCadastro">
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<form action="<?php echo SITEBASE?>/cadastrar_produto" method="post" name="" id="" enctype="multipart/form-data">
			<input name="Codigo" type="hidden" id="Codigo" value="<?php echo isset($Codigo) ? $Codigo : null; ?>" />
			<div id="divLinhaCadastro">Cadastro de Produto</div>
			<div id="cadastroLab">
				T&iacute;tulo:
			</div>
			<div id="cadastroCampo">
				<input name="Titulo" type="text" id="Titulo" value="<?php echo isset($Titulo) ? $Titulo : null; ?>" required/>
			</div>
			<div id="cadastroLab">
				Descri&ccedil;&atilde;o:
			</div>
			<div id="cadastroCampo">
				<input name="Descricao" type="text" id="Descricao" value="<?php echo isset($Descricao) ? $Descricao : null; ?>" required/>
			</div>
			<div id="cadastroLab">
				Pre&ccedil;o:
			</div>
			<div id="cadastroCampo">
				<input name="Preco" type="number" id="Preco" step="0.01" value="<?php echo isset($Preco) ? $Preco : null; ?>" required/>
			</div>
			<div id="cadastroLab">
				Quantidade em estoque:
			</div>
			<div id="cadastroCampo">
				<input name="QuantidadeEstoque" type="number" id="QuantidadeEstoque" value="<?php echo isset($QuantidadeEstoque) ? $QuantidadeEstoque : null; ?>" required/>
			</div>
			<div id="cadastroLab">
				Categoria:
			</div>
			<div id="cadastroCampo">
				<select name="Categoria" id="Categoria">
				 <option>Selecione...</option>
				 
				 <?php foreach (listaCategorias() as $categoria) { ?>
				 <option value="<?php echo $categoria['Codigo'] ?>" <?php echo isset($CodigoCategoria) ? (($categoria['Codigo'] == $CodigoCategoria) ? 'Selected' : '') : '' ; ?>><?php echo $categoria['Descricao'] ?></option>
				 <?php } ?>
				 
				 </select>
			</div>
			<?php if (isset($Imagem)){ ?>
			<div id="cadastroProdutoImagem">
				<img style="width: auto; height: 80%;" src="data:image/jpg;base64, <?php echo base64_encode($Imagem); ?>">
			</div>
			<?php } ?>
			<div id="cadastroLab">
				Imagem:
			</div>
			<div id="cadastroCampo">
				<input name="Imagem" type="file" id="Imagem"/>
			</div>
			<br />
			<div id="cadastroLab">
			</div>
			<div id="cadastroCampo">
				<input type=checkbox name="Status" value=1 <?php echo isset($Status) ? (($Status == 0) ? '' : 'checked') : 'checked' ; ?>>Ativo<br>
			</div>
			<div id="divLinhaCadastro"><input type="submit" name="Submit" value="Enviar"></div>
		</form>
		<?php 
		} else {
			echo '<div id="divLinhaProd">Acesso Restrito! Efetue o login!</div>';
		}
		?>
	</div>
</div>