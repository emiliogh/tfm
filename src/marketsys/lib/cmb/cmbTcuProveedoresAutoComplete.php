<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT i.id_proveedor,
	 								  i.id_proveedor ".chr(34)."data".chr(34).", 	
									  CONCAT('[',i.numero_identificacion,'] ',i.nombre_proveedor,' - ',i.nombre_comercial) 
									  ".chr(34)."value".chr(34).", 
									  i.numero_identificacion, 
									  i.nombre_proveedor, 
									  i.nombre_comercial, 
									  ifnull(i.direccion,'QUITO'), 
									  ifnull(i.telefono,'000-0000'), 
									  ifnull(i.correo_electronico,'sin correo'), 
									  i.id_tipo_proveedor,
									  i.id_categoria_proveedor,
									  ifnull(sum(p.saldo_pendiente),'0.00') saldo,
									  min(DATE_FORMAT(p.fecha_maxima_pago,'%d/%m/%Y')) fecha
								 FROM tsc_proveedores i 
								inner join tsc_categorias_proveedor c
								   on c.id_categoria = i.id_tipo_proveedor
								 left join tsc_compras p
								   on p.id_proveedor = i.id_proveedor
								  and p.saldo_pendiente > 0
								  and p.estado IN ('A','E','V')  
								WHERE i.estado = 'A' 
								group by i.id_proveedor, 
									     CONCAT('[',i.numero_identificacion,'] ',i.nombre_proveedor,' - ',i.nombre_comercial), 
									     i.numero_identificacion, 
									     i.nombre_proveedor, 
									     ifnull(i.direccion,'PORTOVIEJO'), 
									     ifnull(i.telefono,'000-0000'), 
									     ifnull(i.correo_electronico,'sin correo'), 
									     i.id_tipo_proveedor
								order by i.nombre_proveedor;");
	
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
