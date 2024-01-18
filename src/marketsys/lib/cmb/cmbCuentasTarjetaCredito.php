<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT id_cuenta id, concat(cuenta,' -',upper(descripcion)) descripcion ".
							    "FROM tsc_cuentas_bancarias c ".
							   "WHERE c.estado = 'A' and id_tipo_cuenta IN(3) ".
							   "ORDER BY 2 ASC;");
	
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
