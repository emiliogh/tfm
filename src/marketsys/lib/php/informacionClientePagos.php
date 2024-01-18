<?php
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	 $consulta = $db->consulta("select lpad(p.id_pago,6,'0') pago,
									   DATE_FORMAT(p.fecha_pago,'%d-%m-%Y') fecha,
									   DATE_FORMAT(p.fecha_pago,'%H:%I') hora,
									   f.descripcion forma_pago,
									   c.numero_factura,
									   p.monto_pago
								  from tsc_pagos p
								 inner join tsc_formas_pago f
									on p.id_forma_pago = f.id_forma_pago
								 inner join tsc_facturas c
									on c.id_factura = p.id_factura
								 where p.id_cliente = '".$_POST["id"]."'
								 ORDER BY p.id_pago desc;");

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
