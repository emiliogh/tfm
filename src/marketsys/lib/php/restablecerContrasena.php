<?php
SESSION_START();
	include("../conexion/class.conexion.php");
	
	$db = new MySQL();
	$consulta = $db->consulta(" select id_personal, usuario
								 from  tas_usuarios u
								 where u.id_usuario = '".$_POST['idusua']."';");
								 
	$idPersonal = -1;
    $usuario = '';
	if($db->num_rows($consulta)>=0){
	  while($resultados = $db->fetch_array($consulta)){ 
	    $idPersonal = $resultados[0];  
		$usuario = $resultados[1];    
	 }
	}
    $value = 0;
    if ($idPersonal != -1){
		$consulta = $db->consulta(" select nombre, correo_personal, correo_institucional
									 from  tgn_personal p
									 where p.id_personal = '".$idPersonal."';");

		$nombre = 0;
		$emailP = '';
		$emailC = '';
		if($db->num_rows($consulta)>=0){
		  while($resultados = $db->fetch_array($consulta)){ 
			$nombre = $resultados[0];  
			$emailP = $resultados[1];
			$emailC = $resultados[2];      
		 }
		}		

			/*****************************************/
			$opc_letras 	 = FALSE; //  FALSE para quitar las letras
			$opc_numeros 	 = TRUE;  // FALSE para quitar los números
			$opc_letrasMayus = TRUE;  // FALSE para quitar las letras mayúsculas
			$opc_especiales  = FALSE; // FALSE para quitar los caracteres especiales
			$longitud 		 = 6;
			$password 		 = "";

			$letras 		 = "abcdefghijklmnopqrstuvwxyz";
			$numeros 		 = "23456789";
			$letrasMayus 	 = "ABCDEFGHJKLMNPQRSTUVWXYZ";
			$especiales 	 = "|@#~$%()=^*+[]{}-_";
			$listado 		 = "";

			if ($opc_letras == TRUE)     { $listado .= $letras; }
			if ($opc_numeros == TRUE)    { $listado .= $numeros; }
			if($opc_letrasMayus == TRUE) { $listado .= $letrasMayus; }
			if($opc_especiales  == TRUE) { $listado .= $especiales; }

			str_shuffle($listado);
			for( $i=1; $i<=$longitud; $i++) {
				$password[$i] = $listado[rand(0,strlen($listado))];
				str_shuffle($listado);
				}

			$consulta = $db->consulta(" update tas_usuarios  set clave = md5('".trim($password)."') where id_usuario = '".$_POST['idusua']."';");

			/*****************************************/
			$para      = $emailP.', '.$emailC;
			$titulo    = utf8_decode('Generación de Contraseña');
			$mensaje   = utf8_decode('<html><head><title>Generación de Contraseña</title></head>
	<body><h3>Estimad@ '.strtoupper($nombre).'</h3><br></h4>Se ha generado una nueva contraseña para que pueda acceder al sistema <b>SISGEDU</b> de la <i>Unidad Educativa Fiscomisional Semipresencial PCEI de Manabí Padre Jorge Ugalde Paladines</i>. </h4><br><br>Su usuario de acceso es: <b>'.strtolower($usuario).'</b><br>Su nueva contraseña es: <b>'.trim($password).'</b><br><br><b>NOTA:</b> Si usted no ha solicitado la generación de una nueva contraseña, por favor comuniquese con la Autoridad de la Institución Educativa.<br>Este correo ha sido generado de manera automática a través del Sistema de Gestión Educativa SISGEDU.</body></html>');

			// Para enviar un correo HTML, debe establecerse la cabecera Content-type
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Cabeceras adicionales
			$cabeceras .= 'To: '.$emailP.', '.$emailC. "\r\n";
			$cabeceras .= 'From: Información <info@marabu-consulting.com>' . "\r\n";
			$cabeceras .= 'Reply-To: Soporte SISGEDU <soporte@marabu-consulting.com>' . "\r\n";

			$success = mail($para, $titulo, $mensaje, utf8_decode($cabeceras));
		    
		    if (!$success) {
				$value=1;
				$errorMessage = error_get_last()['message'];
				$ip = $_SERVER['REMOTE_ADDR'];
	 			$navegador = $_SERVER['HTTP_USER_AGENT'];
				$consulta = $db->consulta($this->conexion," insert into tbs_sqlerror (sql_,fecha,error,ip,informacion) values('".str_replace("'",'#',$success.'_'.'mail($para, $titulo, $mensaje, utf8_decode($cabeceras))')."',now(),'".str_replace("'",'',$errorMessage)."','".$ip."','".$navegador."');");
				
			}
			}else{$value=1;}
    
    $options = array(0 => $value);	

	echo json_encode($options);
	
?>