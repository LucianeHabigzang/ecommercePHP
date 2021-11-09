<?php
function enviaEmail($dadosemail){
	
	
	$mail = new PHPMailer();
	
	// 1 = Erros e mensagens
	// 2 = Apenas mensagens
	//$mail->SMTPDebug  = 1; 

	// Define os dados do servidor e tipo de conexão
	$mail->IsSMTP(); // Define que a mensagem será SMTP
	$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
	$mail->SMTPSecure = 'tls';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'dyingsuffocation.com.br';	// Endereço do servidor SMTP
	$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = 'vendas@dyingsuffocation.com.br'; // Usuário do servidor SMTP
	$mail->Password = 'Zyon40'; // Senha do servidor SMTP
	// Define o remetente
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->From = "vendas@dyingsuffocation.com.br"; // Seu e-mail
	$mail->FromName = "Dying Suffocation"; // Seu nome
	// Define os destinatário(s)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	//$mail->AddAddress('lucianetec@gmail.com.br', 'Luciane Cunha');
	$mail->AddAddress($dadosemail['add'], $dadosemail['addNome']);
	//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
	//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
	// Define os dados técnicos da Mensagem
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	//$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
	//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
	// Define a mensagem (Texto e Assunto)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->Subject  = $dadosemail['subject']; // Assunto da mensagem
	$mail->Body = $dadosemail['body'];
	//$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n :)";
	// Define os anexos (opcional)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	if(isset($dadosemail['AddAttachment'])){
		$mail->AddAttachment($dadosemail['AddAttachment'], "Boleto_DyingSuffocation.pdf");  // Insere um anexo
	}
	// Envia o e-mail
	$enviado = $mail->Send();
	// Limpa os destinatários e os anexos
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();
	// Exibe uma mensagem de resultado
	if ($enviado) {
	  return true;
	} else {
	  return "<b>Erro email:</b> " . $mail->ErrorInfo;
	}
}
?>