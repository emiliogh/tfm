<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT id_estudiante ".chr(34)."data".chr(34).", ".
									 "concat(numero_identificacion,'- ',nombre) ".chr(34)."value".chr(34).", ".
									 "id_estudiante, nombre ".
	                            "FROM tac_estudiantes e ".
							   "WHERE estado = 'A' ".
							   "AND e.id_estudiante NOT IN (SELECT oc.id_estudiante ".
																 "FROM tac_inscripcion_estudiantes oc ".
																 "INNER JOIN tcf_periodos p ".
																	"ON p.estado = 'A' ".
																   "AND oc.id_periodo = p.id_periodo ".
																   "AND oc.estado = 'A') ".
							   "order by nombre;");
	
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
