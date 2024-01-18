<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT id_personal id, upper(nombre) descripcion FROM tgn_personal WHERE estado = 'A' and id_personal !=0 ORDER BY 2 ASC;");
	
	$rows = array();
	/*Recorrido de Datos*/
	if($db->num_rows($consulta)>=0){
	  while($resultados = $db->fetch_array($consulta)){ 
	    $rows[] = array_map('utf8_encode',$resultados);
	 }
	}
	
	/*Retorno de Información*/
	echo json_encode($rows);
?>
