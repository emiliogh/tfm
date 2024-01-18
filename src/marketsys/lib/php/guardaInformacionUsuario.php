<?php

	include("../conexion/class.conexion.php");
	
	$db = new MySQL();
	
    $retorno = 0;
    $mensaje = '';
    if ($_POST['tipo']=='A')
	   {$consulta = $db->consulta("update tas_usuarios set estado = 'I'
								    where id_usuario = '".$_POST['idusua']."';");
	    $retorno = 0;
	    $mensaje = 'Se ha procedido a realizar la inactivación del usuario.';}
       if ($_POST['tipo']=='I')
		  {$consulta = $db->consulta("update tas_usuarios set estado = 'A'
									   where id_usuario = '".$_POST['idusua']."';");
		   $retorno = 0;
		   $mensaje = 'Se ha procedido a realizar la reactivación del usuario.';}   
           if ($_POST['tipo']=='N')
			  {$consulta = $db->consulta("select count(*), id_personal ".
										   "from tas_usuarios ".
										  "where usuario = '".$_POST['usuaps']."' group by id_personal ");
			   
			    $existeUsuario = -1;
			    $idPrslDupl = -1;
			    if($db->num_rows($consulta)>=0){
				  while($resultados = $db->fetch_array($consulta)){ 
					$existeUsuario = $resultados[0];
					  $idPrslDupl = $resultados[0];
				 }
				}
			   
			    if ($existeUsuario == 1)
				   {$consulta = $db->consulta("select nombre ".
												"from tgn_personal ".
											   "where id_personal = '".$idPrslDupl."' ");

						$nombPersonal = '';
						if($db->num_rows($consulta)>=0){
						  while($resultados = $db->fetch_array($consulta)){ 
							$nombPersonal = $resultados[0];  
						 }
						}
					$retorno = 1;
				    $mensaje = 'El usuario selecionado, ya se encuentra asignado a ['.$nombPersonal.
						       ']. Modifique el usuario e intente nuevamente.';}
			       else{$consulta = $db->consulta("select nombre,correo_personal,correo_institucional ".
												    "from tgn_personal ".
												   "where id_personal = '".$_POST['idpers']."' ");

						$nombPersonal = '';
						$emailP = '';
						$emailC = '';
						if($db->num_rows($consulta)>=0){
						  while($resultados = $db->fetch_array($consulta)){ 
							$nombPersonal = $resultados[0];  
							$emailP = $resultados[1];
							$emailC = $resultados[2]; 
						 }
						}
					    /********************* GENERACIÓN CONTRASEÑA ********************/
						$opc_letras 	 = FALSE; //  FALSE para quitar las letras
						$opc_numeros 	 = TRUE; // FALSE para quitar los números
						$opc_letrasMayus = TRUE; // FALSE para quitar las letras mayúsculas
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

					    /*************************** INSERCCIÓN *************************/
						$consulta = $db->consulta("insert into tas_usuarios (id_personal, usuario, clave, estado, avatar) 
													    values ('".$_POST['idpers']."','".strtolower($_POST['usuaps'])."',md5('".$password."'),'A','0.png');");
				        
					    /*********************** EMAIL ************************/
					    $para      = $emailP.', '.$emailC;
						$titulo    = utf8_decode('Generación de Usuario');
						$mensaje   = utf8_decode('<html><head><title>Generación de Usuario</title></head>
				<body><h3>Estimad@ '.strtoupper($nombPersonal).'</h3><br></h4>Se ha generado el usuario de ingreso para que pueda acceder al sistema <b>SISGEDU</b> de la <i>Unidad Educativa Fiscomisional Semipresencial PCEI de Manabí Padre Jorge Ugalde Paladines</i>. </h4><br><br>Su usuario de acceso es: <b>'.strtolower($_POST['usuaps']).'</b><br>Su contraseña es: <b>'.$password.'</b><br><br><b>NOTA:</b> Si usted ha recibido está generación de usuario y contraseña de manera equivicada, por favor indiquenos con las respuesta respectiva para comunicarnos con el administrador y las Autoridades de la Institución Educativa.<br>Este correo ha sido generado de manera automática a través del Sistema de Gestión Educativa SISGEDU.</body></html>');

						// Para enviar un correo HTML, debe establecerse la cabecera Content-type
						$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
						$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

						// Cabeceras adicionales
						$cabeceras .= 'To: '.$emailP.', '.$emailC. "\r\n";
						$cabeceras .= 'From: Información <info@marabu-consulting.com>' . "\r\n";
						$cabeceras .= 'Reply-To: Soporte SISGEDU <soporte@marabu-consulting.com>' . "\r\n";

						mail($para, $titulo, $mensaje, utf8_decode($cabeceras));
					   
					    $retorno = 0;
					    $mensaje = 'Se ha procedido a realizar la creación del usuario. Verificar el correo registrado.';}
			  }			 
	
		$options = array(0 => $retorno,
						 1 => $mensaje);	

	echo json_encode($options);

    
	
?>