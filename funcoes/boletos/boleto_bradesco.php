<?php


function digitoVerificador_nossonumero($numero) {
	$resto2 = modulo_11($numero, 7, 1);
     $digito = 11 - $resto2;
     if ($digito == 10) {
        $dv = "P";
     } elseif($digito == 11) {
     	$dv = 0;
	} else {
        $dv = $digito;
     	}
	 return $dv;
}


function digitoVerificador_barra($numero) {
	$resto2 = modulo_11($numero, 9, 1);
     if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
        $dv = 1;
     } else {
	 	$dv = 11 - $resto2;
     }
	 return $dv;
}

function formata_numero($numero,$loop,$insert,$tipo = "geral") {
	if ($tipo == "geral") {
		$numero = str_replace(",","",$numero);
		while(strlen($numero)<$loop){
			$numero = $insert . $numero;
		}
	}
	if ($tipo == "valor") {
		//retira as virgulas formata o numero preenche com zeros
		$numero = str_replace(",","",$numero);
		while(strlen($numero)<$loop){
			$numero = $insert . $numero;
		}
	}
	if ($tipo == "convenio") {
		while(strlen($numero)<$loop){
			$numero = $numero . $insert;
		}
	}
	return $numero;
}


function fator_vencimento($data) {
	$data = explode("/",$data);
	$ano = $data[2];
	$mes = $data[1];
	$dia = $data[0];
    return(abs((_dateToDays("1997","10","07")) - (_dateToDays($ano, $mes, $dia))));
}

function _dateToDays($year,$month,$day) {
    $century = substr($year, 0, 2);
    $year = substr($year, 2, 2);
    if ($month > 2) {
        $month -= 3;
    } else {
        $month += 9;
        if ($year) {
            $year--;
        } else {
            $year = 99;
            $century --;
        }
    }
    return ( floor((  146097 * $century)    /  4 ) +
            floor(( 1461 * $year)        /  4 ) +
            floor(( 153 * $month +  2) /  5 ) +
                $day +  1721119);
}

function modulo_10($num) { 
		$numtotal10 = 0;
        $fator = 2;

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num,$i-1,1);
            // Efetua multiplicacao do numero pelo (falor 10)
            // 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Ita??
            $temp = $numeros[$i] * $fator; 
            $temp0=0;
            foreach (preg_split('//',$temp,-1,PREG_SPLIT_NO_EMPTY) as $k=>$v){ $temp0+=$v; }
            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }
		
        // v??rias linhas removidas, vide fun????o original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }
		
        return $digito;
		
}

function modulo_11($num, $base=9, $r=0)  {
    /**
     *   Autor:
     *           Pablo Costa <pablo@users.sourceforge.net>
     *
     *   Fun????o:
     *    Calculo do Modulo 11 para geracao do digito verificador 
     *    de boletos bancarios conforme documentos obtidos 
     *    da Febraban - www.febraban.org.br 
     *
     *   Entrada:
     *     $num: string num??rica para a qual se deseja calcularo digito verificador;
     *     $base: valor maximo de multiplicacao [2-$base]
     *     $r: quando especificado um devolve somente o resto
     *
     *   Sa??da:
     *     Retorna o Digito verificador.
     *
     *   Observa????es:
     *     - Script desenvolvido sem nenhum reaproveitamento de c??digo pr?? existente.
     *     - Assume-se que a verifica????o do formato das vari??veis de entrada ?? feita antes da execu????o deste script.
     */                                        

    $soma = 0;
    $fator = 2;

    /* Separacao dos numeros */
    for ($i = strlen($num); $i > 0; $i--) {
        // pega cada numero isoladamente
        $numeros[$i] = substr($num,$i-1,1);
        // Efetua multiplicacao do numero pelo falor
        $parcial[$i] = $numeros[$i] * $fator;
        // Soma dos digitos
        $soma += $parcial[$i];
        if ($fator == $base) {
            // restaura fator de multiplicacao para 2 
            $fator = 1;
        }
        $fator++;
    }

    /* Calculo do modulo 11 */
    if ($r == 0) {
        $soma *= 10;
        $digito = $soma % 11;
        if ($digito == 10) {
            $digito = 0;
        }
        return $digito;
    } elseif ($r == 1){
        $resto = $soma % 11;
        return $resto;
    }
}

function monta_linha_digitavel($codigo) {

	// 01-03    -> C??digo do banco sem o digito
	// 04-04    -> C??digo da Moeda (9-Real)
	// 05-05    -> D??gito verificador do c??digo de barras
	// 06-09    -> Fator de vencimento
	// 10-19    -> Valor Nominal do T??tulo
	// 20-44    -> Campo Livre (Abaixo)
	
	// 20-23    -> C??digo da Agencia (sem d??gito)
	// 24-05    -> N??mero da Carteira
	// 26-36    -> Nosso N??mero (sem d??gito)
	// 37-43    -> Conta do Cedente (sem d??gito)
	// 44-44    -> Zero (Fixo)
        

        // 1. Campo - composto pelo c??digo do banco, c??digo da mo??da, as cinco primeiras posi????es
        // do campo livre e DV (modulo10) deste campo
        
        $p1 = substr($codigo, 0, 4);							// Numero do banco + Carteira
        $p2 = substr($codigo, 19, 5);						// 5 primeiras posi????es do campo livre
        $p3 = modulo_10("$p1$p2");						// Digito do campo 1
        $p4 = "$p1$p2$p3";								// Uni??o
        $campo1 = substr($p4, 0, 5).'.'.substr($p4, 5);

        // 2. Campo - composto pelas posi??oes 6 a 15 do campo livre
        // e livre e DV (modulo10) deste campo
        $p1 = substr($codigo, 24, 10);						//Posi????es de 6 a 15 do campo livre
        $p2 = modulo_10($p1);								//Digito do campo 2	
        $p3 = "$p1$p2";
        $campo2 = substr($p3, 0, 5).'.'.substr($p3, 5);

        // 3. Campo composto pelas posicoes 16 a 25 do campo livre
        // e livre e DV (modulo10) deste campo
        $p1 = substr($codigo, 34, 10);						//Posi????es de 16 a 25 do campo livre
        $p2 = modulo_10($p1);								//Digito do Campo 3
        $p3 = "$p1$p2";
        $campo3 = substr($p3, 0, 5).'.'.substr($p3, 5);

        // 4. Campo - digito verificador do codigo de barras
        $campo4 = substr($codigo, 4, 1);

        // 5. Campo composto pelo fator vencimento e valor nominal do documento, sem
        // indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
        // tratar de valor zerado, a representacao deve ser 000 (tres zeros).
		$p1 = substr($codigo, 5, 4);
		$p2 = substr($codigo, 9, 10);
		$campo5 = "$p1$p2";

        return "$campo1 $campo2 $campo3 $campo4 $campo5"; 
}

function geraCodigoBanco($numero) {
    $parte1 = substr($numero, 0, 3);
    $parte2 = modulo_11($parte1);
    return $parte1 . "-" . $parte2;
}



function geraBoletos($dadosboleto) {

	//Dados da conta
	$dadosboleto["agencia"] = "2374"; // Num da agencia, sem digito
	$dadosboleto["agencia_dv"] = "4"; // Digito do Num da agencia
	$dadosboleto["conta"] = "113500"; 	// Num da conta, sem digito
	$dadosboleto["conta_dv"] = "7"; 	// Digito do Num da conta
	
	// DADOS PERSONALIZADOS - Bradesco
	$dadosboleto["conta_cedente"] = "113500"; // ContaCedente do Cliente, sem digito (Somente N??meros)
	$dadosboleto["conta_cedente_dv"] = "7"; // Digito da ContaCedente do Cliente
	$dadosboleto["carteira"] = "09";  // C??digo da Carteira: pode ser 06 ou 03
	
	$codigobanco = "237";
	$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
	$nummoeda = "9";
	$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);
	
	//valor tem 10 digitos, sem virgula
	$valor = formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
	//agencia ?? 4 digitos
	$agencia = formata_numero($dadosboleto["agencia"],4,0);
	//conta ?? 6 digitos
	$conta = formata_numero($dadosboleto["conta"],6,0);
	//dv da conta
	$conta_dv = formata_numero($dadosboleto["conta_dv"],1,0);
	//carteira ?? 2 caracteres
	$carteira = $dadosboleto["carteira"];
	
	//nosso n??mero (sem dv) ?? 11 digitos
	$nnum = formata_numero($dadosboleto["carteira"],2,0).formata_numero($dadosboleto["nosso_numero"],11,0);
	//dv do nosso n??mero
	$dv_nosso_numero = digitoVerificador_nossonumero($nnum);
	
	//conta cedente (sem dv) ?? 7 digitos
	$conta_cedente = formata_numero($dadosboleto["conta_cedente"],7,0);
	//dv da conta cedente
	$conta_cedente_dv = formata_numero($dadosboleto["conta_cedente_dv"],1,0);
	
	//$ag_contacedente = $agencia . $conta_cedente;
	
	// 43 numeros para o calculo do digito verificador do codigo de barras
	$dv = digitoVerificador_barra("$codigobanco$nummoeda$fator_vencimento$valor$agencia$nnum$conta_cedente".'0', 9, 0);
	// Numero para o codigo de barras com 44 digitos
	$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$agencia$nnum$conta_cedente"."0";
	
	$nossonumero = substr($nnum,0,2).'/'.substr($nnum,2).'-'.$dv_nosso_numero;
	$agencia_codigo = $agencia."-".$dadosboleto["agencia_dv"]." / ". $conta_cedente ."-". $conta_cedente_dv;
	
	
	$dadosboleto["codigo_barras"] = $linha;
	$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha);
	$dadosboleto["agencia_codigo"] = $agencia_codigo;
	$dadosboleto["nosso_numero"] = $nossonumero;
	$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;
	
	return $dadosboleto;
	
}

function buscaBoletos($codigoPedido = null) {
	
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);

	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = " ";
	
	if($codigoPedido){
		$sql .= " SELECT * FROM boletos WHERE CodigoPedido = '{$codigoPedido}' ";
	} else {
		$sql .= " SELECT pedidos.FantCod, boletos.Codigo, boletos.DataVencimento, boletos.ValorBoleto, boletos.Status FROM boletos LEFT JOIN pedidos ON (boletos.CodigoPedido = pedidos.Codigo)";
	}
	
	$result = $mysqli -> query($sql);
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_array(MYSQLI_ASSOC))
			$rows[] = $row;
		
		$mysqli -> close();
		return $rows;
	} else {
		$mysqli -> close();
		return FALSE;
	}
}

function buscaBoletoAlterar($codigo){
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	$codigo = $mysqli->real_escape_string($codigo);
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = "SELECT pedidos.FantCod, boletos.Codigo, boletos.DataVencimento, boletos.ValorBoleto, boletos.Status, boletos.NossoNumero FROM boletos LEFT JOIN pedidos ON (boletos.CodigoPedido = pedidos.Codigo) WHERE boletos.Codigo = '{$codigo}'";
	
	$result = $mysqli -> query($sql);
	
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_array(MYSQLI_ASSOC))
			$rows[] = $row;
		
		$mysqli -> close();
		return (object)$rows[0];
	} else {
		$mysqli -> close();
		return FALSE;
	}
}

function buscaBoletoImprimir($codigo) {
	$mysqli = new mysqli(HOST, USUARIO, SENHA, BD);
	$mysqli -> set_charset('utf8');
	
	$codigo = $mysqli->real_escape_string($codigo);
	
	/* check connection */
	if ($mysqli -> connect_errno) {
		printf("Connect failed: %s\n", $mysqli -> connect_error);
		exit();
	}
	
	$sql = "SELECT * FROM boletos WHERE Codigo = '{$codigo}'";
	
	$result = $mysqli -> query($sql);
	
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_array(MYSQLI_ASSOC))
			$rows[] = $row;
		
		$mysqli -> close();
		return $rows;
	} else {
		$mysqli -> close();
		return FALSE;
	}
}

?>
