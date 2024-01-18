<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT id_forma_pago id, 
									  descripcion descripcion,
									  tiempo_vigencia detalle
								 FROM tsc_formas_pago 
								WHERE estado = 'A'
								  AND id_forma_pago > 0
								  AND aplicable_compras = 'S'
							    ORDER BY 2 ASC;");
	
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
