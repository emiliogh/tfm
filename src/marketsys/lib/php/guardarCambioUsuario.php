<?php
	include("../conexion/class.conexion.php");
	
	$db = new MySQL();
	
	$consulta = $db->consulta("select count(*), id_personal ".
								"from tas_usuarios ".
							   "where usuario = '".$_POST['usuaps']."' and id_usuario != '".$_POST['idusua']."' ".
							   "group by id_personal ");

	$existeUsuario = -1;
	$idPrslDupl = -1;
	if($db->num_rows($consulta)>=0){
		while($resultados = $db->fetch_array($consulta)){ 
			$existeUsuario = $resultados[0];
			$idPrslDupl = $resultados[1];
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
     /************************ACTUALIZACIÓN USUARIO **************************/
		 $consulta = $db->consulta("update tas_usuarios set usuario = '".strtolower($_POST['usuaps'])."'
								    where id_usuario = '".$_POST['idusua']."';");
		 
	 /*********************** EMAIL ************************/
	 $para      = $emailP.', '.$emailC;
	 $titulo    = utf8_decode('Cambio de Usuario');
	 $mensaje   = utf8_decode('<html><head><title>Generación de Usuario</title></head>
				<body><h3>Estimad@ '.strtoupper($nombPersonal).'</h3><br></h4>Se ha realizado un cambio de denominación a su usuario de ingreso para que pueda acceder al sistema <b>SISGEDU</b> de la <i>Unidad Educativa Fiscomisional Semipresencial PCEI de Manabí Padre Jorge Ugalde Paladines</i>. </h4><br><br>Su usuario de acceso es: <b>'.strtolower($_POST['usuaps']).'</b><br><br><b>NOTA:</b> Si usted ha recibido está generación de usuario y contraseña de manera equivicada, por favor indiquenos con las respuesta respectiva para comunicarnos con el administrador y las Autoridades de la Institución Educativa.<br>Este correo ha sido generado de manera automática a través del Sistema de Gestión Educativa SISGEDU.</body></html>');

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
	
	$options = array(0 => $retorno,
					 1 => $mensaje);

	echo json_encode($options);
	
?>