<?php
SESSION_START();
include("../conexion/class.conexion.php");
	$db = new MySQL();
	 $consulta = $db->consulta("select f.id_factura,
									   f.numero_factura,
									   date_format(f.fecha_registro,'%d-%m-%Y') fecha,
									   i.descripcion rubro,
									   df.precio_venta,
									   df.cantidad,
									   df.subtotal,
									   df.descuento,
									   df.total
								  from tsc_facturas f
								 inner join tsc_detalles_factura df
									on f.id_factura = df.id_factura
								 inner join tiv_items i
									on i.id_item =  df.id_rubro
								 where f.id_factura = ".$_POST["idFactura"]."
								 order by df.linea_factura;");

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