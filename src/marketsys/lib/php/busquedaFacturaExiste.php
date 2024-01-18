<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT count(*) ".
							    "FROM tsc_compras ".
							   "WHERE autorizacion_sri = '".$_POST['numeroAutorizacion']."' ".
							     "and numero_factura = '".$_POST['numFactura']."';");
	
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