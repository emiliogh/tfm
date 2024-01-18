<?php
include_once("../../lib/conexion/class.conexion.php");

$db = new MySQL();
$query = "select t.* ".
		   "from tgn_empresas_info_tributaria t ".
	      "inner join tgn_empresas e ".
	         "on e.id_empresa = t.id_empresa ".
	        "and e.estado = 'A' ". 
		  "WHERE t.estado = 'A';";

	$consulta = $db->consulta($query);
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
