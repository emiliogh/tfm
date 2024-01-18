<?php
	//set cookie lifetime for 100 days (60sec * 60mins * 24hours * 100days)
	//ini_set('session.cookie_lifetime', 60 * 60 * 24 * 100);
	//ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 100);
	//maybe you want to precise the save path as well
	//ini_set('session.save_path', '/home/yoursite/sessions');
	//then start the session
	session_start();

	include("../conexion/class.conexion.php"); date_default_timezone_set('America/Guayaquil');
		$usuario = base64_decode($_POST["usuario"]);
		$clave 	 = base64_decode($_POST["clave"]);
		
		$id_session = strtotime(date("Y-m-d h:i:sa")).rand(1000,9999);
		$direccion_ip = $_SERVER['REMOTE_ADDR'];
		$navegador = $_SERVER['HTTP_USER_AGENT'];
		$nombreEquipo = gethostbyaddr($direccion_ip);
		$respuesta = -1;

	$db = new MySQL();
	$consulta = $db->consulta("select pas_login('".$usuario."', '".
							  					   $clave."', '".
							                       $id_session."', '".
							                       $direccion_ip."', '".
							    				   $navegador."', '".
							  					   $nombreEquipo."');");
	/*$consulta = json_encode($consulta);
	if(strcmp($consulta,'"ERROR"') == 0){$verificacion=-1;}
	else{*/
	if($db->num_rows($consulta)>=0){
		  while($resultados = $db->fetch_array($consulta)){ 
		   $respuesta = $resultados[0];
		   $infoUsuario = $db->consulta("select *
										   from vas_informacion_usuarios u
										  where u.id_usuario ='".$respuesta."';");
			while($resUsuario = $db->fetch_array($infoUsuario)){
				  $_SESSION["usuarioMS"] 		= $usuario;
				  $_SESSION['autorizadoLogin'] 	= $id_session;
				  $_SESSION["currentsession"] 	= $id_session;
				  $_SESSION["telefonoc"] 		= $resUsuario[7];
				  $_SESSION["telefonov"] 		= $resUsuario[6];
				  $_SESSION["avatar"] 			= $resUsuario[8];
				  $_SESSION["correo"] 			= $resUsuario[5];
				  $_SESSION["perfil"] 			= $resUsuario[4];
				  $_SESSION["nombre"] 			= $resUsuario[2];
				  $_SESSION["identificacion"] 	= $resUsuario[3];
				  $_SESSION["idUsuario"] 		= $resUsuario[0];
				  $_SESSION["idperfil"] 		= $resUsuario[9];
				  $_SESSION["spUs"] 			= $resUsuario[10];
				  //if (!isset($_COOKIE['idUsuarioCk'])){
				  setcookie("idUsuarioCk", "", time()-3600);
				  setcookie('idUsuarioCk',$resUsuario[0],time()+31536000);
				  //	  }
				
				}  
		    }
	   //} 
	}
	
	$array = array(0 => $respuesta);
		
	
	echo json_encode($array);
	
?>
