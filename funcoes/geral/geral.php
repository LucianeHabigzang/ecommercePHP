<?php
//FORMATA DATA
function formatDate($data){
	return date('d/m/Y', strtotime($data));
}

//PEGA IMAGEM
function getImg($pasta, $img){
	if (file_exists(ROOT.DS.'img'.DS.$pasta.DS.$img)) :
		return SITEBASE."/img/{$pasta}/{$img}";      //DS.'img'.DS.$pasta.DS.$img;
	else :
		return SITEBASE."/img/notfound.jpg";   //DS.'img'.DS.'notfound.jpg';
	endif;
}

//FUNÇÂO LIMITA TEXTO
function limitar($texto, $quantidade = 50){
	$texto = explode(" ", $texto);
	return implode(" ", array_slice($texto, 0, $quantidade));
}

// FORMATA VALOR
function real($valor){
	return number_format($valor, 2, ",", ".");
}

//DIVISÂO DE PARCELAS
function parcela($valor, $quantidade){
	$divisao = $valor/$quantidade;
	return sprintf("<span>até %sx de %s </span>", $quantidade, real($divisao));
}



