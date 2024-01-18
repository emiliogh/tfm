<?php
 SESSION_START();
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT distinct(nc.secuencia) id, o.descripcion ".
								"FROM tac_niveles_ofertas_centros nc ".
							   "inner join tac_ofertas o ".
								  "on o.id_oferta = nc.id_oferta ".
								 "and o.estado = 'A' ".
							   "where nc.estado = 'A' ".
								 "and nc.id_centro = ifnull(".$_POST['id'].",0) ".
								 "and nc.id_periodo = ifnull(".$_POST['ip'].",0) ".
								 "and nc.id_inspeccion = '".$_SESSION["idUsuario"]."' ".
								 "order by 2; ");
	
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
