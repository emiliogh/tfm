<?php
 SESSION_START();
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT id_centro id, ".
									 "descripcion descripcion ".
							    "FROM tac_centros c ".
								"WHERE estado = 'A' ".
								  "AND c.id_centro IN (SELECT oc.id_centro ".
														"FROM tac_asignaturas_niveles_oferta_centros oc ".
													   "WHERE oc.estado = 'A' ".
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
