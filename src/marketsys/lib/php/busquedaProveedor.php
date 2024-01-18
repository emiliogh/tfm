<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT ifnull(max(p.id_proveedor),0) id_proveedor, ".
       								 "ifnull(max(p.id_categoria_proveedor),0) id_categoria_proveedor, ".
       								 "ifnull(max(p.id_tipo_proveedor),0) id_tipo_proveedor, ".
							         "ifnull(sum(c.saldo_pendiente),0) saldo, ".
							         "DATE_FORMAT(ifnull(min(c.fecha_maxima_pago),now()),'%d-%m-%Y') fecha ".
							    "FROM tsc_proveedores p ".
							    "LEFT JOIN tsc_compras c ".
							      "ON c.id_proveedor = p.id_proveedor ".
							     "AND c.estado = 'A' ".
							   "WHERE p.numero_identificacion = '".$_POST['identificacion']."';");
	
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