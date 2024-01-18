<?php
 SESSION_START();
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT an.id_asignatura id, ".
									 "ag.nombre descripcion ".
								  "FROM tac_asignaturas_niveles an ".
								 "INNER JOIN tac_asignaturas ag ".
								    "ON an.id_asignatura = ag.id_asignatura ".
							     "INNER JOIN tac_asignaturas_niveles_oferta_centros ac ".
								    "ON ac.id_nivel = an.id_nivel ".
							       "AND ac.id_asignatura = an.id_asignatura ".
							       "AND ac.estado = 'A' ".
								   "AND ac.id_centro 	= '".$_POST['id']."' ".
								   "AND ac.id_periodo 	= '".$_POST['ip']."' ".
								   "AND ac.secuencia 	= '".$_POST['sc']."' ".
								   "AND ac.id_secuencia = '".$_POST['nv']."' ".
								 "WHERE an.estado = 'A' ".
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
