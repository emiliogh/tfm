<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT distinct(p.id_personal) id, p.nombre descripcion ".
							    "FROM tgn_personal p ".
							    "LEFT JOIN tsc_personal_punto_emision e ".
							      "on p.id_personal = e.id_personal ".
							     "and e.id_establecimiento = ifnull(".$_POST['id'].",0) ".  
							     "and e.id_punto_emision = ifnull(".$_POST['id2'].",0) ORDER BY 2 ASC;");
	
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
