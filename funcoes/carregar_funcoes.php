<?php
//CERREGAR FUNCOES OU INCLUDES
function load_funcoes($inc){
	$pastas = array('banco', 'url', 'produtos', 'geral', 'usuarios', 'pedidos', 'boletos', 'email');
	
	if (is_array($inc)) :
		foreach($inc as $func):
			for($i =0; $i < count($pastas); $i++):
				if (file_exists(ROOT.DIRECTORY_SEPARATOR.'funcoes/'.$pastas[$i].DIRECTORY_SEPARATOR.$func.'.php')) :
					include_once ROOT.DIRECTORY_SEPARATOR.'funcoes/'.$pastas[$i].DIRECTORY_SEPARATOR.$func.'.php';
				endif;
			endfor;
		endforeach;
	else :
		echo "Você passar parametros com array";
	endif;
}

?>