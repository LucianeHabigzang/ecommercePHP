<div id="principalCadastro">
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<form action="<?php echo SITEBASE?>/cadastrar_solicitados" method="post" name="" id="" enctype="multipart/form-data">
			<input name="Codigo" type="hidden" id="Codigo" value="<?php echo isset($Codigo) ? $Codigo : null; ?>" />
			<div id="divLinhaCadastro">Solicita&ccedil;&atilde;o de produtos</div>
			<div id="cadastroLab">
				Produto:
			</div>
			<div id="cadastroCampo">
				<select name="CodigoProduto" id="CodigoProduto" disabled="true">
				 <option>Selecione...</option>
				 
				 <?php foreach (listaComboProd() as $produto) { ?>
				 <option value="<?php echo $produto['Codigo'] ?>" <?php echo isset($CodigoProduto) ? (($produto['Codigo'] == $CodigoProduto) ? 'Selected' : '') : '' ; ?>><?php echo $produto['Titulo'] ?></option>
				 <?php } ?>
				 
				 </select>
			</div>
			<div id="cadastroLab">
				Data da solicita&ccedil;&atilde;o:
			</div>
			<div id="cadastroCampo">
				<input name="DataCadastro" type="date" id="DataCadastro" value="<?php echo isset($DataCadastro) ? date('Y-m-d', strtotime($DataCadastro)) : ''; ?>" readonly="readonly"/>
			</div>
			<br />
			<div id="cadastroLab">
				Quantidade:
			</div>
			<div id="cadastroCampo">
				<input name="QuantidadeInteresse" type="number" id="QuantidadeInteresse" value="<?php echo isset($QuantidadeInteresse) ? $QuantidadeInteresse : null; ?>" readonly="readonly"/>
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