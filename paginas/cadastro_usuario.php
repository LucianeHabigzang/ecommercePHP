<div id="principalCadastro">
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<form action="<?php echo SITEBASE?>/cadastrar_usuario" method="post" name="" id="">
			<div id="divLinhaCadastro">Cadastro de Usu&aacute;rio</div>
			<div id="divFormUser">
				<input name="Codigo" type="hidden" id="Codigo" value="<?php echo isset($Codigo) ? $Codigo : null; ?>" />
				<div id="cadastroLab">
					Nome:
				</div>
				<div id="cadastroCampo">
					<input name="Nome" type="text" id="Nome" value="<?php echo isset($Nome) ? $Nome : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Telefone:
				</div>
				<div id="cadastroCampo">
					<input name="Telefone" type="tel" id="Telefone" value="<?php echo isset($Telefone) ? $Telefone : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Cpf
				</div>
				<div id="cadastroCampo">
					<input name="Cpf" type="text" id="Cpf" value="<?php echo isset($Cpf) ? $Cpf : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Data Nascimento
				</div>
				<div id="cadastroCampo">
					<input name="DataNasc" type="date" id="DataNasc" value="<?php echo isset($DataNasc) ? date('Y-m-d', strtotime($DataNasc)) : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Email
				</div>
				<div id="cadastroCampo">
					<input name="Email" type="email" id="Email" value="<?php echo isset($Email) ? $Email : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Rua
				</div>
				<div id="cadastroCampo">
					<input name="Rua" type="text" id="Rua" value="<?php echo isset($EndRua) ? $EndRua : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					N&uacute;mero
				</div>
				<div id="cadastroCampo">
					<input name="Numero" type="number" id="Numero" value="<?php echo isset($EndNro) ? $EndNro : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Cep
				</div>
				<div id="cadastroCampo">
					<input name="Cep" type="number" id="Cep" value="<?php echo isset($EndCep) ? $EndCep : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Bairro
				</div>
				<div id="cadastroCampo">
					<input name="Bairro" type="text" id="Bairro" value="<?php echo isset($EndBairro) ? $EndBairro : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Cidade
				</div>
				<div id="cadastroCampo">
					<input name="Cidade" type="text" id="Cidade" value="<?php echo isset($EndCidade) ? $EndCidade : ''; ?>" required/>
				</div>
				<?php if(isset($Senha)){?>
					<div id="cadastroLab">
						Senha Antiga
					</div>
					<div id="cadastroCampo">
						<input name="Senha" type="password" id="Senha" required/>
					</div>
					<div id="cadastroLab">
						Nova Senha
					</div>
					<div id="cadastroCampo">
						<input name="SenhaNova" type="password" id="SenhaNova" required/>
					</div>
					<div id="cadastroLab">
						Confirmar Senha
					</div>
					<div id="cadastroCampo">
						<input name="SenhaConfirma" type="password" id="SenhaConfirma" required/>
					</div>
				<?php } else { ?>
					<div id="cadastroLab">
						Senha
					</div>
					<div id="cadastroCampo">
						<input name="Senha" type="password" id="Senha" required/>
					</div>
				<?php } ?>
				<div id="cadastroLab">
				</div>
				<div id="cadastroCampo">
					<input type=checkbox id="Status" name="Status" value=1 <?php echo isset($Status) ? (($Status == 0) ? '' : 'checked') : 'checked' ; ?>>Ativo<br>
				</div>
				<?php
					if(isset($_SESSION["TipoUsuario"]) && ($_SESSION["TipoUsuario"] == 3)){
						echo '
						<div id="cadastroLab">
						</div>
						<div id="cadastroCampo">
							<input type=radio id="TipoUsuario" name="TipoUsuario" value=1 ' . (isset($TipoUsuario) ? (($TipoUsuario == 1) ? 'checked' : '') : 'checked') . '>Cliente
							<input type=radio id="TipoUsuario" name="TipoUsuario" value=2 ' . (isset($TipoUsuario) ? (($TipoUsuario == 2) ? 'checked' : '') : '') . '>Funcion&aacute;rio
							<input type=radio id="TipoUsuario" name="TipoUsuario" value=3 ' . (isset($TipoUsuario) ? (($TipoUsuario == 3) ? 'checked' : '') : '') . '>Administrador
						</div>';
					}
				?>
			</div>
			<div id="divLinhaCadastro">Endere&ccedil;o para entrega</div>
			<div id="divFormEntrega">
				<div id="cadastroLab">
					Rua
				</div>
				<div id="cadastroCampo">
					<input name="EntregaRua" type="text" id="EntregaRua" value="<?php echo isset($EntregaRua) ? $EntregaRua : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					N&uacute;mero
				</div>
				<div id="cadastroCampo">
					<input name="EntregaNumero" type="number" id="EntregaNumero" value="<?php echo isset($EntregaNro) ? $EntregaNro : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Cep
				</div>
				<div id="cadastroCampo">
					<input name="EntregaCep" type="number" id="EntregaCep" value="<?php echo isset($EntregaCep) ? $EntregaCep : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Bairro
				</div>
				<div id="cadastroCampo">
					<input name="EntregaBairro" type="text" id="EntregaBairro" value="<?php echo isset($EntregaBairro) ? $EntregaBairro : ''; ?>" required/>
				</div>
				<div id="cadastroLab">
					Cidade
				</div>
				<div id="cadastroCampo">
					<input name="EntregaCidade" type="text" id="EntregaCidade" value="<?php echo isset($EntregaCidade) ? $EntregaCidade : ''; ?>" required/>
				</div>	
			</div>
			</ br>
			<div id="divLinhaCadastro">
				<input type="submit" name="Submit" value="Enviar">
			</div>
		</form>
	</div>
</div>