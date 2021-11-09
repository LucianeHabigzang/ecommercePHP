<div id="principalCadastro">
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<form action="<?php echo SITEBASE?>/cadastrar_promocao" method="post" name="" id="" enctype="multipart/form-data">
			<input name="Codigo" type="hidden" id="Codigo" value="<?php echo isset($Codigo) ? $Codigo : null; ?>" />
			<div id="divLinhaCadastro">Cadastro de Promo&ccedil;&atilde;o</div>
			<div id="cadastroLab">
				Produto:
			</div>
			<div id="cadastroCampo">
				<select name="CodigoProduto" id="CodigoProduto">
				 <option>Selecione...</option>
				 
				 <?php foreach (listaComboProd() as $produto) { ?>
				 <option value="<?php echo $produto['Codigo'] ?>" <?php echo isset($CodigoProduto) ? (($produto['Codigo'] == $CodigoProduto) ? 'Selected' : '') : '' ; ?>><?php echo $produto['Titulo'] ?></option>
				 <?php } ?>
				 
				 </select>
			</div>
			<br />
			<div id="cadastroLab">
				Pre&ccedil;o:
			</div>
			<div id="cadastroCampo">
				<input name="ValorPromocao" type="number" id="ValorPromocao" step="0.01" min='0' value="<?php echo isset($ValorPromocao) ? $ValorPromocao : null; ?>" required/>
			</div>
			<div id="cadastroLab">
				Data Final da promo&ccedil;&atilde;o:
			</div>
			<div id="cadastroCampo">
				<input name="DataFinal" type="date" id="DataFinal" value="<?php echo isset($DataFinal) ? date('Y-m-d', strtotime($DataFinal)) : ''; ?>" required/>
			</div>
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