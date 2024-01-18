<?php
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	  $consulta = $db->consulta("SELECT cl.id_cliente,cl.numero_identificacion, cl.nombre_cliente nombre_ciudadano
								   FROM tcu_clientes cl
								  INNER JOIN tcu_categorias_clientes ct
									 ON cl.id_categoria_cliente = ct.id_categoria_cliente
								    and ct.estado = 'A'
								  INNER JOIN tb_tipos_identificacion ti
									 ON cl.id_tipo_identificacion = ti.id_tipo_identificacion
								    AND ti.estado = 'A'    
								  WHERE cl.estado = 'A'
								    AND (cl.numero_identificacion like UPPER('%".$_GET["idBusqueda"]."%')
									 or UPPER(cl.nombre_cliente) like UPPER('%".$_GET["idBusqueda"]."%')) 
								  order by cl.nombre_cliente desc;");
		
	$rows = array();
	/*Recorrido de Datos*/
	if($db->num_rows($consulta)>=0){
	  while($resultados = $db->fetch_array($consulta)){ 
	    $rows[] = $resultados;
	 }
	}
	
	/*Retorno de Información*/
	echo json_encode($rows);

?>
