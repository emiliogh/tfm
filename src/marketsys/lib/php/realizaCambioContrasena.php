<?php
SESSION_START();
	include("../conexion/class.conexion.php");
	
	$db = new MySQL();
	$consulta = $db->consulta(" select count(*) num
								 from  tas_usuarios u
								 where u.id_usuario = '".$_SESSION['idUsuario']."'
								   and u.clave = md5('".$_POST['ca']."');");
								 
	$respuesta = 0;							 
	if($db->num_rows($consulta)>=0){
	  while($resultados = $db->fetch_array($consulta)){ 
	   $respuesta = $resultados['num'];  
	 }
	}
	$verificacion = 0; 
	if ($respuesta == 0){
	    $verificacion = 1;}
		else {	$consulta = $db->consulta(" update tas_usuarios  set clave = md5('".strtoupper($_POST['nc'])."') where id_usuario = '".$_SESSION['idUsuario']."';");
				$consulta = json_encode($consulta);
				if (strcmp($consulta,'"ERROR"') == 0)
					{$verificacion= -1;}
            }
		
			
		$options =array(0 => $verificacion);
		
	
	echo json_encode($options);
	
?>