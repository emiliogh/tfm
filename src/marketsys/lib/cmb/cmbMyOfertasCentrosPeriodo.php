<?php
 SESSION_START();
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT secuencia id, ".
									 "f.descripcion descripcion ".
								  "FROM tac_ofertas_centros o ".
								 "inner join tac_ofertas f ".
								    "on f.id_oferta = o.id_oferta ".
								   "and f.estado = 'A' ".
								 "inner join tcf_periodos p ".
								    "on p.id_periodo = o.id_periodo ".
								   "and p.estado = 'A' ".
								 "WHERE o.estado = 'A' ".
								   "and o.id_centro = ifnull(".$_POST['id'].",0) ".
								   "and p.id_periodo = ifnull(".$_POST['ip'].",0) ".
								   "AND o.secuencia IN (SELECT oc.secuencia ".
														 "FROM tac_asignaturas_niveles_oferta_centros oc ".
													    "WHERE oc.estado = 'A' ".
													      "AND oc.id_centro = o.id_centro ".
														  "AND oc.id_periodo = o.id_periodo ".
														  "AND oc.id_profesor = '".$_SESSION["idUsuario"]."') ".
								 "ORDER BY 2 ASC;");
	
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
