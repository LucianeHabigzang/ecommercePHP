<?php

require '../config.php';

if(isset($_POST["Codigo"])){
	
	$codigoPedido = $_POST["Codigo"];
	$boletos = buscaBoletos($codigoPedido);
	
} elseif(isset($_POST["CodigoBoleto"])){
	
	$codigoBoleto = $_POST["CodigoBoleto"];
	$boletos = buscaBoletoImprimir($codigoBoleto);
	
} else {
	include_once $pasta . 'erro.php';
}



//Incluindo o arquivo onde está a Classe FPDF
require_once("../fpdf/class_fpdf.php");

//Definindo o diretório das fontes
define("FPDF_FONTPATH","../fpdf/font/");

//Iniciando o construtor FPDF
$pdf = new class_fpdf();
//$pdf= new FPDF("L","mm",array(101,201));



foreach ($boletos as $dadosboleto) {
	
	// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
	

	// DADOS DA SUA CONTA - Bradesco
	$dadosboleto["Agencia"] = "2374"; // Num da agencia, sem digito
	$dadosboleto["AgenciaDv"] = "4"; // Digito do Num da agencia
	$dadosboleto["Conta"] = "113500"; 	// Num da conta, sem digito
	$dadosboleto["ContaDv"] = "7"; 	// Digito do Num da conta
	
	// DADOS PERSONALIZADOS - Bradesco
	$dadosboleto["ContaCedente"] = "113500"; // ContaCedente do Cliente, sem digito (Somente Números)
	$dadosboleto["ContaCedente_dv"] = "7"; // Digito da ContaCedente do Cliente
	$dadosboleto["Carteira"] = "09";  // Código da Carteira: pode ser 06 ou 03
	
	// SEUS DADOS
	$dadosboleto["Identificacao"] = "Boleto - Loja virtual Dying Suffocation";
	$dadosboleto["CpfCnpj"] = "936.903.710-15";
	$dadosboleto["Endereco"] = "Rua Xavantes, 1113, Amadori";
	$dadosboleto["CidadeUf"] = "Pato Branco / Paraná";
	$dadosboleto["Cedente"] = "Dying Suffocation";
	
	// INFORMACOES PARA O CLIENTE
	$dadosboleto["Demonstrativo1"] = "Pagamento de Compra na Loja virtual Dying Suffocation";
	$dadosboleto["Demonstrativo2"] = "Mensalidade referente a compra na loja virtual";
	$dadosboleto["Demonstrativo3"] = "http://www.dingsuffodation.com.br";
	$dadosboleto["Instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
	$dadosboleto["Instrucoes2"] = "- Receber até 10 dias após o vencimento";
	$dadosboleto["Instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: contato@dyingsuffocation.com.br";
	$dadosboleto["Instrucoes4"] = "- Emitido pela loja virtual Dying Suffocation - www.dyingsuffocation.com.br";
	
	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["ValorBoleto"] = real($dadosboleto["ValorBoleto"]);
	$dadosboleto["DataVencimento"] = formatDate($dadosboleto["DataVencimento"]);
	$dadosboleto["DataDocumento"] = formatDate($dadosboleto["DataDocumento"]);
	
	$dadosboleto["Quantidade"] = "001";
	$dadosboleto["ValorUnitario"] = $dadosboleto["ValorBoleto"];
	$dadosboleto["Aceite"] = "SEM";
	$dadosboleto["Especie"] = "R$";
	$dadosboleto["EspecieDoc"] = "DS";
	
	$dadosboleto["NumeroDocumento"] = $dadosboleto["NossoNumero"]; // Num do pedido ou do documento = Nosso numero
	$dadosboleto["DataProcessamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	
	//Chamando o método para adicionar página
	$pdf->AddPage();
	
	$pdf->SetMargins(5, 5, 5, 5);
	//$pdf->SetAutoPageBreak(false);
	        
	$pdf->Image('../img/logobradesco.jpg',15,12,29,8);
	$pdf->SetY(15);
	$pdf->SetX(15);
	$pdf->SetLineWidth(0.7);
	$pdf->Cell(29,5,'',"R",0,"L");
	$pdf->SetFont('arial','B',16);
	$pdf->Cell(20,5,$dadosboleto["CodigoBancoComDv"],"R",0,"C");
	$pdf->SetFont('arial','B',12);
	$pdf->Cell(131,5,$dadosboleto["LinhaDigitavel"],0,0,"R");
	
	$pdf->SetY(20);
	$pdf->SetX(15);
	$pdf->SetLineWidth(1);
	$pdf->Line(15, 20, 195, 20);
	$pdf->SetLineWidth(0);
	$pdf->SetY(20);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(142,3,'Local de Pagamento',"LT",0,"L");
	$pdf->Cell(38,3,'Vencimento',"LTR",0,"L");
	$pdf->SetY(23);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(142,5,utf8_decode('Pagável em qualquer Banco até o vencimento'),"L",0,"L");
	$pdf->Cell(38,5,$dadosboleto["DataVencimento"],"LR",0,"L");
	
	$pdf->SetY(28);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(142,3,'Cedente',"LT",0,"L");
	$pdf->Cell(38,3,utf8_decode('Agência / Cod. Cedente'),"LTR",0,"L");
	$pdf->SetY(31);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(142,5,utf8_decode($dadosboleto["Cedente"]),"L",0,"L");
	$pdf->Cell(38,5,$dadosboleto["AgenciaCodigo"],"LR",0,"L");
	
	$pdf->SetY(36);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(38,3,'Data Documento',"LT",0,"L");
	$pdf->Cell(38,3, utf8_decode('Nº Documento'),"LT",0,"L");
	$pdf->Cell(19,3,utf8_decode('Espécie Doc.'),"LT",0,"C");
	$pdf->Cell(19,3,'Aceite',"LT",0,"C");
	$pdf->Cell(28,3,'Data do Processamento',"LT",0,"L");
	$pdf->Cell(38,3,utf8_decode('Nosso Número'),"LTR",0,"L");
	$pdf->SetY(39);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(38,5, $dadosboleto["DataDocumento"],"L",0,"L");
	$pdf->Cell(38,5,$dadosboleto["NumeroDocumento"],"L",0,"L");
	$pdf->Cell(19,5,$dadosboleto["EspecieDoc"],"L",0,"C");
	$pdf->Cell(19,5,$dadosboleto["Aceite"],"L",0,"C");
	$pdf->Cell(28,5,$dadosboleto["DataProcessamento"],"L",0,"L");
	$pdf->Cell(38,5,$dadosboleto["NossoNumero"],"LR",0,"L");
	
	$pdf->SetY(44);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(38,3,'Uso Banco',"LT",0,"L");
	$pdf->Cell(29,3,'Carteira',"LT",0,"C");
	$pdf->Cell(9,3,utf8_decode('Espécie'),"LT",0,"C");
	$pdf->Cell(38,3,'Quantidade',"LT",0,"C");
	$pdf->Cell(28,3,'Valor',"LT",0,"L");
	$pdf->Cell(38,3,'(-) Valor do Documento',"LTR",0,"L");
	$pdf->SetY(47);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(38,5,'Uso Banco',"L",0,"L");
	$pdf->Cell(29,5,$dadosboleto["Carteira"],"L",0,"C");
	$pdf->Cell(9,5,$dadosboleto["Especie"],"L",0,"C");
	$pdf->Cell(38,5,$dadosboleto["Quantidade"],"L",0,"C");
	$pdf->Cell(28,5,$dadosboleto["ValorUnitario"],"L",0,"L");
	$pdf->Cell(38,5,$dadosboleto["ValorBoleto"],"LR",0,"L");
	
	$pdf->SetY(52);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(142,4,utf8_decode('Instruções'),"LT",0,"L");
	$pdf->Cell(38,4,'(-) Desconto / Abatimento',"LTR",0,"L");
	$pdf->SetY(56);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(142,4,utf8_decode($dadosboleto["Instrucoes1"]),"L",0,"L");
	$pdf->Cell(38,4,'',"LR",0,"L");
	$pdf->SetY(60);
	$pdf->SetX(15);
	$pdf->Cell(142,4,utf8_decode($dadosboleto["Instrucoes2"]),"L",0,"L");
	$pdf->SetFont('arial','',7);
	$pdf->Cell(38,4,utf8_decode('(-) Outras Deduções'),"LTR",0,"L");
	$pdf->SetY(64);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(142,4,utf8_decode($dadosboleto["Instrucoes3"]),"L",0,"L");
	$pdf->Cell(38,4,'',"LR",0,"L");
	$pdf->SetY(68);
	$pdf->SetX(15);
	$pdf->Cell(142,4,utf8_decode($dadosboleto["Instrucoes4"]),"L",0,"L");
	$pdf->SetFont('arial','',7);
	$pdf->Cell(38,4,'(+) Mora / Multa',"LTR",0,"L");
	$pdf->SetY(72);
	$pdf->SetX(15);
	$pdf->Cell(142,4,'',"L",0,"L");
	$pdf->Cell(38,4,'',"LR",0,"L");
	$pdf->SetY(76);
	$pdf->SetX(15);
	$pdf->Cell(142,4,'',"L",0,"L");
	$pdf->Cell(38,4,utf8_decode('(+) Outros Acréscimos'),"LTR",0,"L");
	$pdf->SetY(80);
	$pdf->SetX(15);
	$pdf->Cell(142,4,'',"L",0,"L");
	$pdf->Cell(38,4,'',"LR",0,"L");
	$pdf->SetY(84);
	$pdf->SetX(15);
	$pdf->Cell(142,4,'',"L",0,"L");
	$pdf->Cell(38,4,'(-) Valor Cobrado',"LTR",0,"L");
	$pdf->SetY(88);
	$pdf->SetX(15);
	$pdf->Cell(142,4,'',"LB",0,"L");
	$pdf->Cell(38,4,'',"LRB",0,"L");
	
	$pdf->SetY(92);
	$pdf->SetX(15);
	$pdf->Cell(90,5,'Sacado:',0,0,"L");
	$pdf->Cell(90,5,'',0,0,"L");
	
	$pdf->SetY(97);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',10);
	$pdf->Cell(90,5,utf8_decode($dadosboleto["Sacado"]),0,0,"L");
	$pdf->Cell(90,5,'',0,0,"L");
	
	$pdf->SetY(102);
	$pdf->SetX(15);
	$pdf->Cell(90,5,utf8_decode($dadosboleto["Endereco1"]),0,0,"L");
	$pdf->Cell(90,5,'',0,0,"L");
	
	$pdf->SetY(107);
	$pdf->SetX(15);
	$pdf->Cell(90,5,utf8_decode($dadosboleto["Endereco2"]),0,0,"L");
	$pdf->Cell(90,5,'',0,0,"L");
	
	$pdf->SetY(112);
	$pdf->SetX(15);
	$pdf->SetLineWidth(1);
	$pdf->Line(15, 112, 195, 112);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(180,5,utf8_decode("Autenticação Mecânica"),0,0,"R");
	
	$pdf->SetLineWidth(0.5);
	$pdf->SetDash(1,1);
	$pdf->Line(5,130,205,130);
	$pdf->SetDash();
	
	
	//Via do banco
	
	
	$pdf->Image('../img/logobradesco.jpg',15,142,29,8);
	$pdf->SetY(145);
	$pdf->SetX(15);
	$pdf->SetLineWidth(0.7);
	$pdf->Cell(29,5,'',"R",0,"L");
	$pdf->SetFont('arial','B',16);
	$pdf->Cell(20,5,$dadosboleto["CodigoBancoComDv"],"R",0,"C");
	$pdf->SetFont('arial','B',12);
	$pdf->Cell(131,5,$dadosboleto["LinhaDigitavel"],0,0,"R");
	
	$pdf->SetY(150);
	$pdf->SetX(15);
	$pdf->SetLineWidth(1);
	$pdf->Line(15, 150, 195, 150);
	$pdf->SetLineWidth(0);
	$pdf->SetY(150);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(142,3,'Local de Pagamento',"LT",0,"L");
	$pdf->Cell(38,3,'Vencimento',"LTR",0,"L");
	$pdf->SetY(153);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(142,5,utf8_decode('Pagável em qualquer Banco até o vencimento'),"L",0,"L");
	$pdf->Cell(38,5,$dadosboleto["DataVencimento"],"LR",0,"L");
	$pdf->SetY(158);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(142,3,'Cedente',"LT",0,"L");
	$pdf->Cell(38,3,utf8_decode('Agência / Cod. Cedente'),"LTR",0,"L");
	$pdf->SetY(161);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(142,5,$dadosboleto["Cedente"],"L",0,"L");
	$pdf->Cell(38,5,$dadosboleto["AgenciaCodigo"],"LR",0,"L");
	
	$pdf->SetY(166);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(38,3,'Data Documento',"LT",0,"L");
	$pdf->Cell(38,3, utf8_decode('Nº Documento'),"LT",0,"L");
	$pdf->Cell(19,3,utf8_decode('Espécie Doc.'),"LT",0,"C");
	$pdf->Cell(19,3,'Aceite',"LT",0,"C");
	$pdf->Cell(28,3,'Data do Processamento',"LT",0,"L");
	$pdf->Cell(38,3,utf8_decode('Nosso Número'),"LTR",0,"L");
	$pdf->SetY(169);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(38,5, $dadosboleto["DataDocumento"],"L",0,"L");
	$pdf->Cell(38,5,$dadosboleto["NumeroDocumento"],"L",0,"L");
	$pdf->Cell(19,5,$dadosboleto["EspecieDoc"],"L",0,"C");
	$pdf->Cell(19,5,$dadosboleto["Aceite"],"L",0,"C");
	$pdf->Cell(28,5,$dadosboleto["DataProcessamento"],"L",0,"L");
	$pdf->Cell(38,5,$dadosboleto["NossoNumero"],"LR",0,"L");
	
	$pdf->SetY(174);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(38,3,'Uso Banco',"LT",0,"L");
	$pdf->Cell(29,3,'Carteira',"LT",0,"C");
	$pdf->Cell(9,3,utf8_decode('Espécie'),"LT",0,"C");
	$pdf->Cell(38,3,'Quantidade',"LT",0,"C");
	$pdf->Cell(28,3,'Valor',"LT",0,"L");
	$pdf->Cell(38,3,'(-) Valor do Documento',"LTR",0,"L");
	$pdf->SetY(177);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(38,5,'Uso Banco',"L",0,"L");
	$pdf->Cell(29,5,$dadosboleto["Carteira"],"L",0,"C");
	$pdf->Cell(9,5,$dadosboleto["Especie"],"L",0,"C");
	$pdf->Cell(38,5,$dadosboleto["Quantidade"],"L",0,"C");
	$pdf->Cell(28,5,$dadosboleto["ValorUnitario"],"L",0,"L");
	$pdf->Cell(38,5,$dadosboleto["ValorBoleto"],"LR",0,"L");
	
	$pdf->SetY(182);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(142,4,utf8_decode('Instruções'),"LT",0,"L");
	$pdf->Cell(38,4,'(-) Desconto / Abatimento',"LTR",0,"L");
	$pdf->SetY(186);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(142,4,utf8_decode($dadosboleto["Instrucoes1"]),"L",0,"L");
	$pdf->Cell(38,4,'',"LR",0,"L");
	$pdf->SetY(190);
	$pdf->SetX(15);
	$pdf->Cell(142,4,utf8_decode($dadosboleto["Instrucoes2"]),"L",0,"L");
	$pdf->SetFont('arial','',7);
	$pdf->Cell(38,4,utf8_decode('(-) Outras Deduções'),"LTR",0,"L");
	$pdf->SetY(194);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(142,4,$dadosboleto["Instrucoes3"],"L",0,"L");
	$pdf->Cell(38,4,'',"LR",0,"L");
	$pdf->SetY(198);
	$pdf->SetX(15);
	$pdf->Cell(142,4,utf8_decode($dadosboleto["Instrucoes4"]),"L",0,"L");
	$pdf->SetFont('arial','',7);
	$pdf->Cell(38,4,'(+) Mora / Multa',"LTR",0,"L");
	$pdf->SetY(202);
	$pdf->SetX(15);
	$pdf->Cell(142,4,'',"L",0,"L");
	$pdf->Cell(38,4,'',"LR",0,"L");
	$pdf->SetY(206);
	$pdf->SetX(15);
	$pdf->Cell(142,4,'',"L",0,"L");
	$pdf->Cell(38,4,utf8_decode('(+) Outros Acréscimos'),"LTR",0,"L");
	$pdf->SetY(210);
	$pdf->SetX(15);
	$pdf->Cell(142,4,'',"L",0,"L");
	$pdf->Cell(38,4,'',"LR",0,"L");
	$pdf->SetY(214);
	$pdf->SetX(15);
	$pdf->Cell(142,4,'',"L",0,"L");
	$pdf->Cell(38,4,'(-) Valor Cobrado',"LTR",0,"L");
	$pdf->SetY(218);
	$pdf->SetX(15);
	$pdf->Cell(142,4,'',"LB",0,"L");
	$pdf->Cell(38,4,'',"LRB",0,"L");
	
	$pdf->SetY(222);
	$pdf->SetX(15);
	$pdf->Cell(90,5,'Sacado:',0,0,"L");
	$pdf->Cell(90,5,'',0,0,"L");
	
	$pdf->SetY(227);
	$pdf->SetX(15);
	$pdf->SetFont('arial','',10);
	$pdf->Cell(90,5,utf8_decode($dadosboleto["Sacado"]),0,0,"L");
	$pdf->Cell(90,5,'',0,0,"L");
	
	$pdf->SetY(232);
	$pdf->SetX(15);
	$pdf->Cell(90,5,utf8_decode($dadosboleto["Endereco1"]),0,0,"L");
	$pdf->Cell(90,5,'',0,0,"L");
	
	$pdf->SetY(237);
	$pdf->SetX(15);
	$pdf->Cell(90,5,utf8_decode($dadosboleto["Endereco2"]),0,0,"L");
	$pdf->Cell(90,5,'',0,0,"L");
	
	$pdf->SetY(242);
	$pdf->SetX(15);
	$pdf->SetLineWidth(1);
	$pdf->Line(15, 242, 195, 242);
	$pdf->SetFont('arial','',7);
	$pdf->Cell(180,5,utf8_decode("Autenticação Mecânica - Ficha de Compensão"),0,0,"R");
	
	$pdf->SetFont('Arial','',7);
	$pdf->Code128(20,250,$dadosboleto["LinhaDigitavel"],103,13);

}
if(isset($_POST['Email'])){
	$pdf->Output(TMP . "boleto" . $_POST['Codigo'] . ".pdf","F");
} else {
	//Gerando o arquivo PDF
	$pdf->Output("boleto.pdf","I");
}

?>