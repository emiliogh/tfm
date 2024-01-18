<?php

require_once('../../PHPMailer/PHPMailerAutoload.php');

class sendEmail {

    public function enviarCorreo($tipo, $nombre,$claveAcceso,$email) {
	 
		$to         = 'cesarroblesquintero@gmail.com'; //$email;
		$subject    = 'PastryCook Comprobante Electrónica';
		$messageb   = utf8_decode('<html><head><title>Comprobante Electrónico</title></head>'.
					  '<body><h3>Estimad@ '.strtoupper($nombre).'</h3><br></h4>'.
					  'Le informamos que su comprobante electrónico ha sido emitido exitosamente y se encuentra adjunto al presente correo. '.
					  '</h4><br><br><br><b>NOTA:</b> Si recibe este mensaje por error, por favor notifiquelo al remitente de inmediato y '.
					  'elimine el contenido de su bandeja de entrada.<br>'.
					  'Este correo ha sido generado de manera automática a través del Sistema Informático MarketSys.</body></html>');

		$attachment = '../autorizados/'.$claveAcceso.'.pdf';
		$content = file_get_contents($attachment);

		/* Attachment content transferred in Base64 encoding MUST be split into chunks 76 characters in length as
		specified by RFC 2045 section 6.8. By default, the function chunk_split() uses a chunk length of 76 with
		a trailing CRLF (\r\n). The 76 character requirement does not include the carriage return and line feed */
		$content = chunk_split(base64_encode($content));

		/* Boundaries delimit multipart entities. As stated in RFC 2046 section 5.1, the boundary MUST NOT occur
		in any encapsulated part. Therefore, it should be unique. As stated in the following section 5.1.1, a
		boundary is defined as a line consisting of two hyphens ("--"), a parameter value, optional linear whitespace,
		and a terminating CRLF. */
		$prefix     = "part_"; // This is an optional prefix
		/* Generate a unique boundary parameter value with our prefix using the uniqid() function. The second parameter
		makes the parameter value more unique. */
		$boundary   = uniqid($prefix, true);
		
		$attachment2 = '../autorizados/'.$claveAcceso.'.xml';
		$content2 = file_get_contents($attachment2);

		/* Attachment content transferred in Base64 encoding MUST be split into chunks 76 characters in length as
		specified by RFC 2045 section 6.8. By default, the function chunk_split() uses a chunk length of 76 with
		a trailing CRLF (\r\n). The 76 character requirement does not include the carriage return and line feed */
		$content2 = chunk_split(base64_encode($content2));

		/* Boundaries delimit multipart entities. As stated in RFC 2046 section 5.1, the boundary MUST NOT occur
		in any encapsulated part. Therefore, it should be unique. As stated in the following section 5.1.1, a
		boundary is defined as a line consisting of two hyphens ("--"), a parameter value, optional linear whitespace,
		and a terminating CRLF. */
		$prefix2     = "part_"; // This is an optional prefix
		/* Generate a unique boundary parameter value with our prefix using the uniqid() function. The second parameter
		makes the parameter value more unique. */
		$boundary2   = uniqid($prefix2, true);
		
		// headers
		$headers    = implode("\r\n", [
						'From: MarketSys <info@marabu-consulting.com>',
						'Reply-To: Asistencia MarketSys <soporte@marabu-consulting.com>',
						'X-Mailer: PHP/' . PHP_VERSION,
						'MIME-Version: 1.0',
						// boundary parameter required, must be enclosed by quotes
						'Content-Type: multipart/mixed; boundary="' . $boundary . '"',
						"Content-Transfer-Encoding: 7bit",
						"This is a MIME encoded message." // message for restricted transports
					]);

		// message and attachment
		$message    = implode("\r\n", [ 
								"--" . $boundary, // header boundary delimiter line
								'Content-Type: text/plain; charset="iso-8859-1"',
								"Content-Transfer-Encoding: 8bit",
								$message,
								"--" . $boundary, // content boundary delimiter line
								'Content-Type: application/octet-stream; name="RenamedFile.pdf"',
								"Content-Transfer-Encoding: base64",
								"Content-Disposition: attachment",
								$content,
								"--" . $boundary . "--" // closing boundary delimiter line
							]);
		
		/*$message    = implode("\r\n", [ 
								"--" . $boundary2, // header boundary delimiter line
								'Content-Type: text/plain; charset="iso-8859-1"',
								"Content-Transfer-Encoding: 8bit",
								$message,
								"--" . $boundary2, // content boundary delimiter line
								'Content-Type: application/octet-stream; name="RenamedFile.pdf"',
								"Content-Transfer-Encoding: base64",
								"Content-Disposition: attachment",
								$content,
								"--" . $boundary2 . "--" // closing boundary delimiter line
							]);*/
		
		$result = mail($to, $subject, $messageb.$message, $headers); // send the email
		
		if ($result) {
			exit;
		}
		else {
			// Your mail was not sent. Check your logs to see if
			// the reason was reported there for you.
		}
		
    }

}
