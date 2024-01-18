<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT i.id_item ".chr(34)."data".chr(34).", CONCAT('[',i.codigo_barra,'] ',i.descripcion,'-',i.observacion) ".chr(34)."value".chr(34).", i.id_item, CONCAT('[',i.codigo_barra,'] ',i.descripcion,'-',i.observacion), ifnull(m.costo_promedio,'0.000000'), ifnull(m.cantidad_actual,'0.00') FROM tiv_items i left join tiv_movimientos m on i.id_item = m.id_item and m.id_movimiento = (select max(s.id_movimiento) from tiv_movimientos s where i.id_item = s.id_item) WHERE i.estado = 'A' order by i.descripcion;");
	
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
