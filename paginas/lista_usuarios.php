<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<div id="tituloProdutos">
			<div><h2>Lista de usu&aacute;rios cadastrados</h2></div>
		</div>
		<div id="listaProdutos">
			<div id="divLinhaProd">
				<div id="divListaProd">Nome</div>
				<div id="divListaProd">Email</div>
				<div id="divListaProd">Tipo</div>
				<div id="divListaProd">Status</div>
				<div id="divListaProd"></div>
			</div>
		<?php foreach (listaUsuarios() as $usuario) : ?>
			<div id="divLinhaProd">
				<div id="divListaProd"><?php echo $usuario['Nome']; ?></div>
				<div id="divListaProd"><?php echo $usuario['Email']; ?></div>
				<div id="divListaProd"><?php echo ($usuario['TipoUsuario'] == 1) ? "Cliente" : (($usuario['TipoUsuario'] == 2) ? "Funcion&aacute;rio" : "Administrador"); ?></div>
				<div id="divListaProd"><?php echo ($usuario['Status'] == 1) ? "Ativo" : "Inativo"; ?></div>
				<div id="divListaProd"><a href="<?php echo SITEBASE; ?>/cadastro_usuario/alterar/<?php echo $usuario['Codigo']; ?>">Alterar</a></div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php 
		} else {
			echo '<div id="divLinhaProd">Acesso Restrito! Efetue o login!</div>';
		}
		?>
	</div>
</div>