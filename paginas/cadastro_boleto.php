<div id="principalCadastro">
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<form action="<?php echo SITEBASE?>/cadastrar_boleto" method="post" name="" id="" enctype="multipart/form-data">
			<input name="Codigo" type="hidden" id="Codigo" value="<?php echo isset($Codigo) ? $Codigo : null; ?>" />
			<div id="divLinhaCadastro">Altera&ccedil;&atilde;o de boleto</div>
			<div id="cadastroLab">
				Pedido:
			</div>
			<div id="cadastroCampo">
				<input name="FantCod" type="text" id="FantCod" value="<?php echo isset($FantCod) ? $FantCod : null; ?>" readonly="readonly"/>
			</div>
			<div id="cadastroLab">
				Data do vencimento:
			</div>
			<div id="cadastroCampo">
				<input name="DataVencimento" type="date" id="DataVencimento" value="<?php echo isset($DataVencimento) ? date('Y-m-d', strtotime($DataVencimento)) : ''; ?>" required />
			</div>
			<br />
			<div id="cadastroLab">
				Valor Total:
			</div>
			<div id="cadastroCampo">
				<input name="ValorBoleto" type="number" id="ValorBoleto" step="0.01" min='0' value="<?php echo isset($ValorBoleto) ? $ValorBoleto : null; ?>" required/>
			</div>
			<br />
			<div id="cadastroLab">
			</div>
			<div id="cadastroCampo">
				<input type=checkbox name="Status" value=1 <?php echo isset($Status) ? (($Status == 0) ? '' : 'checked') : 'checked' ; ?>>Pago<br>
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