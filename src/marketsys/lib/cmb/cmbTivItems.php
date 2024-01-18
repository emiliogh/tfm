<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT i.id_item id, CONCAT(i.descripcion,'-',i.observacion) descripcion ".
							    "from tiv_items i where i.id_producto = '".$_POST['id']."' and i.estado = 'A' ".
							   "order by i.descripcion;");
	
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
