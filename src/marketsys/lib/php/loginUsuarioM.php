<?php
SESSION_START();
	include("../conexion/class.conexion.php");
		$usuario = $_SESSION["usuarioMS"];
		$clave 	 = base64_decode($_POST["clave"]);
		
		$id_session = strtotime(date("Y-m-d h:i:sa")).rand(1000,9999);
		$direccion_ip = $_SERVER['REMOTE_ADDR'];
		$navegador = $_SERVER['HTTP_USER_AGENT'];
		$nombreEquipo = gethostbyaddr($direccion_ip);
		$respuesta = -1;

	$db = new MySQL();
	$consulta = $db->consulta("select pas_login('".$usuario."', '".$clave."', '".$id_session."', '".$direccion_ip."', '".$navegador."', '".$nombreEquipo."');");
	if($db->num_rows($consulta)>=0){
	  while($resultados = $db->fetch_array($consulta)){ 
	   $respuesta = $resultados[0];  
	 }
	}
	
	$array = array(0 => $respuesta);
		
	
	echo json_encode($array);
	
?>