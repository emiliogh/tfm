<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT id_distribucion id, descripcion descripcion FROM tac_distribucion_periodo WHERE nivel_distribucion = ifnull('".$_POST['idn']."',0) AND id_periodo = ifnull('".$_POST['id']."',0) and ifnull(id_distribucion_padre,0) = ifnull('".$_POST['idp']."',0) ORDER BY 1 ASC;");
	
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
