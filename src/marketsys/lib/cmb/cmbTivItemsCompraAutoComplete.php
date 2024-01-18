<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT i.id_producto ".chr(34)."data".chr(34).", 
							          concat(i.descripcion,' - ',i.detalle) ".chr(34)."value".chr(34).", 
									  i.descripcion,
							          i.valor_venta, 
							          i.graba_iva, 
							          i.id_cuenta_contable,
							          i.id_cuenta_retencion_renta,
									  i.id_cuenta_retencion_iva
							     FROM tsc_productos_compra i 
							    WHERE i.estado = 'A'
							      AND i.id_proveedor = ".$_POST['id']."
							   order by i.descripcion;");
	
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
