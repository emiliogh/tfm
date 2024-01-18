<?php
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	 $consulta = $db->consulta("SELECT DATE_FORMAT(f.fecha_registro,'%d-%m-%Y') fecha,
									   DATE_FORMAT(f.fecha_registro,'%H:%I') hora,
									   f.numero_factura,
									   case when f.estado_electronico = 'G' then 'GENERADO'
											when f.estado_electronico = 'R' then 'RECHAZADO'
											when f.estado_electronico = 'A' then 'AUTORIZADO'
											when f.estado_electronico = 'E' then 'EMITIDO'
											when f.estado_electronico = 'B' then 'DEVUELTO' end estado_electronico,
									   fp.descripcion,
									   ifnull(f.monto_subtotal,0) monto_subtotal,
									   ifnull(f.monto_impuesto,0) monto_impuesto,
									   ifnull(f.monto_descuento,0) monto_descuento,
									   ifnull(f.monto_total,0) monto_total,
									   ifnull(f.saldo_pendiente,0) saldo_pendiente,
									   case when f.estado = 'E' then 'EMITIDA'
											when f.estado = 'A' then 'ANULADA'
											when f.estado = 'R' then 'ABONADA'
											when f.estado = 'P' then 'PAGADA' end estado,
									   f.id_factura,
									   f.xml_nombre
								  FROM tsc_facturas f
								 INNER JOIN tsc_formas_pago fp
									on fp.id_forma_pago = f.id_forma_pago
								 WHERE f.id_cliente = '".$_POST["id"]."'
								 ORDER BY f.id_factura desc;");

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
