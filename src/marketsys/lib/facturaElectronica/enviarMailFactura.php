<?php

function multi_attach_mail($to, $nombre, $file, $nmb){

	include '../../PHPMailer/PHPMailerAutoload.php';

 try {
	//attachment files path array
	//$files = array('../autorizados/'.$file.'.pdf','../autorizados/'.$file.'.xml');
	$subject = utf8_decode($nmb.' Comprobante Electrónica'); 
	
	 $pLMSys = '../../images/logoMarketSys.png';
     $tLMSys = pathinfo($pLMSys, PATHINFO_EXTENSION);
     $dLMSys = file_get_contents($pLMSys);
     $bLMSys = 'data:image/'.$tLMSys.';base64,'.base64_encode($dLMSys);
	
	 $pLEmpr = '../../images/logoEmpresa.png';
     $tLEmpr = pathinfo($pLEmpr, PATHINFO_EXTENSION);
     $dLEmpr = file_get_contents($pLEmpr);
     $bLEmpr = 'data:image/'.$tLEmpr.';base64,'.base64_encode($dLEmpr);
	 
	 $pLIEmp = '../../images/logoEmpresaBody.png';
     $tLIEmp = pathinfo($pLIEmp, PATHINFO_EXTENSION);
     $dLIEmp = file_get_contents($pLIEmp);
     $bLIEmp = 'data:image/'.$tLIEmp.';base64,'.base64_encode($dLIEmp);
	
	
	$message = '<html><head><title>Comprobante Electrónico</title></head>'.
				'<body>'.
				'<table style="width: 100%;">'.
					'<tr><td style="text-align: left;"><img src="'.$bLEmpr.'" style="height: 70px"></td>'.
						'<td style="text-align: right;"><img src="'.$bLIEmp.'" style="height: 50px"></td></tr>'.
					'<tr><td colspan="2"><br><h3>Estimad@ '.strtoupper(utf8_decode($nombre)).'</h3></td></tr>'.
					'<tr><td colspan="2"><br><br>Le informamos que su comprobante electrónico ha sido emitido de manera exitosa. le adjuntamos los datos de facturación electrónica. </td></tr>'.
					'<tr><td colspan="2"><br><hr><br><b>NOTA:</b> Si recibe este mensaje por error, notifique al remitente de forma inmediata y proceda a eliminar el contenido de su bandeja de entrada.<br></td></tr>'.
					'<tr><td colspan="2"><hr><br>Este correo ha sido generado de manera automática a través del Sistema Informático MarketSys.</td></tr>'.
					'<tr><td colspan="2"><br><img src="'.$bLMSys.'" style="height: 40px" alt="MarketSys"/><br>Marabú Consulting&Services<br>www.marabu-consulting.com</td></tr></table></body></html>'.
					'<hr><p><b>Total archivos adjuntos : </b>2 archivos</p>';

	//call multi_attach_mail() function and pass the required arguments
	//$send_email = multi_attach_mail($to,$subject,$html_content,$from,$from_name,$files);
	
	$mail = new PHPMailer();
		$mail->SMTPSecure = 'ssl';
		$mail->Host = "smtp.gmail.com"; // GMail
		$mail->Port = 465;
		$mail->Username = "marabu.notificaciones@gmail.com";
		$mail->Password = "Marabu123.!";
		//parametros de correo
		$mail->setFrom("marabu.notificaciones@gmail.com", "MarketSys");
	
	$mail->Subject = $subject;

	$mail->AltBody = 'This is a plain-text message body';
	$carta = utf8_decode($message);
	$mail->AddAttachment('../autorizados/'.$file.'.pdf');
	$mail->AddAttachment('../autorizados/'.$file.'.xml');
	
	$mail->msgHTML($carta);
	//$mail->CharSet = 'UTF-8';
	$mail->addAddress($to);
	
	
	$mail->IsHTML(true);

	if (!$mail->Send()) {
		$retorno = 1;
		$msj = $mail->ErrorInfo;
	} else {
		$retorno = 0;
		$msj = 'OK';
		$mail->clearAddresses();
	}
	
	echo ($msj);
	
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}	
    /*$from = $senderName." <".$senderMail.">"; 
    $headers = "From: $from";

    // boundary 
    $semi_rand = md5(time()); 
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

    // headers for attachment 
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

    // multipart boundary 
    // multipart boundary 
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
    "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 

    // preparing attachments
    if(count($files) > 0){
        for($i=0;$i<count($files);$i++){
            if(is_file($files[$i])){
                $message .= "--{$mime_boundary}\n";
                $fp =    @fopen($files[$i],"rb");
                $data =  @fread($fp,filesize($files[$i]));

                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: application/octet-stream; name=\"".basename($files[$i])."\"\n" . 
                "Content-Description: ".basename($files[$i])."\n" .
                "Content-Disposition: attachment;\n" . " filename=\"".basename($files[$i])."\"; size=".filesize($files[$i]).";\n" . 
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
    }

    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $senderMail;

    //send email
    $mail = @mail($to, $subject, $message, $headers, $returnpath); 

    //function return true, if email sent, otherwise return fasle
    if($mail){ return TRUE; } else { return FALSE; }
	*/
}



//print message after email sent
//echo $send_email?"<h1>Mail Sent</h1>":"<h1>Mail sending failed.</h1>";

?>