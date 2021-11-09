<div id="principalCadastro">
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<form action="verifica_usuario" method="post" name="" id="">
			<div id="divLinhaCadastro">Login</div>
			<div id="divLinhaCadastro">
				Usuario
				<br />
				<input name="usuario" type="text" id="usuario" />
			</div>
			<div id="divLinhaCadastro">
				Senha
				<br />
				<input name="senha" type="password" id="senha" />
			</div>
			<div id="divLinhaCadastro">
				<input type="submit" name="Submit" value="Enviar">
			</div>
		</form>
		<div id="divLinhaCadastro">
			<a href="<?php echo SITEBASE; ?>/recuperar_senha">Esqueci a senha.</a>
		</div>
	</div>
</div>