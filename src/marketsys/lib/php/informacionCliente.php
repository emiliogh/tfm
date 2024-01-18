<?php
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	  $consulta = $db->consulta("SELECT cl.id_cliente,
										tp.descripcion tipo_cliente,
										ct.definicion categoria_cliente,
										ti.descripcion tipo_identificacion,
										cl.numero_identificacion, 
										cl.nombre_cliente, 
										cl.direccion,
										cl.correo_electronico,
										cl.telefono
								   FROM tcu_clientes cl
								  INNER JOIN tcu_categorias_clientes ct
									 ON cl.id_categoria_cliente = ct.id_categoria_cliente
								    and ct.estado = 'A'
								  INNER JOIN tb_tipos_identificacion ti
									 ON cl.id_tipo_identificacion = ti.id_tipo_identificacion
								    AND ti.estado = 'A'
								  INNER JOIN tcu_tipos_clientes tp
									 ON tp.id_tipo_cliente = cl.id_tipo_cliente
								  WHERE cl.id_cliente = '".$_POST["id"]."';");

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
