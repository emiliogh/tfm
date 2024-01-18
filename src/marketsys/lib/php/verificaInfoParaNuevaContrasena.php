<?php
SESSION_START();
	include("../conexion/class.conexion.php");
	include '../phpmailer/PHPMailerAutoload.php';

	$db = new MySQL();
	if(strcmp(strtoupper($_POST['captcha']),strtoupper($_SESSION['random_number']))){
	   $verificacion = 1;
	   
	}else{  
		$consulta = $db->consulta(" select count(*) num
									  from tb_actores_culturales u
									 where u.numero_identificacion = '".$_POST['identificacion']."';");
		
		if($db->num_rows($consulta)>0){
			   while($resultados = $db->fetch_array($consulta)){ 
			   $verificacion = $resultados['num'];  
			 }
			if ($verificacion > 0){
				$num_caracteres = "5"; // asignamos el n�mero de caracteres que va a tener la nueva contrase�a
				$consulta = $db->consulta(" select count(*) num
											  from tb_actores_culturales u
											 where u.numero_identificacion = '".$_POST['identificacion']."'
											   and u.correo_electronico = '".$_POST['email']."';");
				
						if($db->num_rows($consulta)>0){
							   while($resultados = $db->fetch_array($consulta)){ 
									 $verificacion = $resultados['num'];  
								}
									
								if ($verificacion>0){
									$email = $_POST['email'];
									$consulta = $db->consulta(" select razon_social rz
																  from tb_actores_culturales u
																 where u.numero_identificacion = '".$_POST['identificacion']."';");
									if($db->num_rows($consulta)>0){
									   while($resultados = $db->fetch_array($consulta)){ 
									   $respuesta = $resultados['rz'];  
									 }
									}		
									
									$actorCultural = $respuesta;
									$nueva_clave = substr(md5(rand()), 0, $num_caracteres);
									
									
									$mail = new PHPMailer();
									$mail->Mailer = "smtp";
									$mail->IsSMTP();
									$mail->SMTPAuth = true; 
									$mail->Host = "mail.culturaypatrimonio.gob.ec";
									$mail->Port = 465;
									$mail->SMTPSecure = "ssl";
									$mail->Username = "ruac-informativo@culturaypatrimonio.gob.ec";
									$mail->Password = "mcyp2016";
									$mail->Timeout=30;

										//parametros de correo
										$mail->setFrom("ruac-informativo@culturaypatrimonio.gob.ec", "informativo Validadores");

										$mail->Subject = 'Recuperar contraseña ';

										$mail->AltBody = 'This is a plain-text message body';
										////////////////////////

										$carta = "Estimad@: <strong>" . $actorCultural . "<br></strong>. Su contraseña es: <strong>" . strtoupper($nueva_clave) . "</strong>"


											. "<br><b>Nota: este correo es de caracter informativo, por favor no responder</b> "
											. "<br><br>Atentamente<br> "
											. "Ministerio de Cultura y Patrimonio";

										$mail->msgHTML($carta);
										$mail->CharSet = 'UTF-8';
										$mail->addAddress($email, "");
										$mail->addBCC('ruac-informativo@culturaypatrimonio.gob.ec', "Cultura 2017");
										$mail->IsHTML(true);
										#echo !extension_loaded('openssl')?"Not Available":"Available";

										if (!$mail->Send()) {
											echo "Error: " . $mail->ErrorInfo . " " . "<br>";
										} else {
											$mail->clearAddresses();
											$consulta = $db->consulta(" update tb_actores_culturales  set contrasena = md5('".strtoupper($nueva_clave)."') where numero_identificacion = '".$_POST['identificacion']."';");
											$consulta = json_encode($consulta);
											if (strcmp($consulta,'"ERROR"') == 0)
												{$verificacion= -1;}
											else{$verificacion=0;}
										}
							
								}else{$verificacion=3;} 
							}	
				 
				}else{$verificacion = 2;}
			}	
		}	
		$options =array(0 => $verificacion);
		
	
	echo json_encode($options);
	
?>
