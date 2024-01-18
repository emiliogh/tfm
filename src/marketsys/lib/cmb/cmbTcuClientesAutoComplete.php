<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT i.id_cliente ".chr(34)."data".chr(34).", 
									  CONCAT('[',i.numero_identificacion,'] ',i.nombre_cliente) ".chr(34)."value".chr(34).", 
									  i.numero_identificacion, 
									  i.nombre_cliente, 
									  ifnull(i.direccion,'PORTOVIEJO'), 
									  ifnull(i.telefono,'000-0000'), 
									  ifnull(i.correo_electronico,'sin correo'), 
									  i.id_tipo_cliente,
									  i.id_categoria_cliente,
									  c.porcentaje_ganancia,
									  ifnull(sum(f.saldo_pendiente),'0.00') saldo,
									  min(DATE_FORMAT(f.fecha_maxima_pago,'%d/%m/%Y')) fecha
								 FROM tcu_clientes i 
								inner join tcu_categorias_clientes c
								   on c.id_categoria_cliente = i.id_categoria_cliente
								 left join tsc_facturas f
								   on f.id_cliente = i.id_cliente
								  and f.saldo_pendiente > 0
								  and f.estado IN ('A','E','V')  
								WHERE i.estado = 'A' 
								group by i.id_cliente, 
									     CONCAT('[',i.numero_identificacion,'] ',i.nombre_cliente), 
									     i.numero_identificacion, 
									     i.nombre_cliente, 
									     ifnull(i.direccion,'PORTOVIEJO'), 
									     ifnull(i.telefono,'000-0000'), 
									     ifnull(i.correo_electronico,'sin correo'), 
									     i.id_tipo_cliente,
									     i.id_categoria_cliente,
									     c.porcentaje_ganancia
								order by i.nombre_cliente;");
	
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
