<?php
 SESSION_START();
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT oc.id_asignatura id, ".
									 "ag.nombre descripcion ".
								  "FROM tac_asignaturas_niveles_oferta_centros oc ".
								 "INNER JOIN tac_asignaturas ag ".
								    "ON ag.id_asignatura = oc.id_asignatura ".
								 "WHERE oc.estado = 'A' ".
								   "AND oc.id_centro 	= '".$_POST['id']."' ".
								   "AND oc.id_periodo 	= '".$_POST['ip']."' ".
								   "AND oc.secuencia 	= '".$_POST['sc']."' ".
								   "AND oc.id_secuencia = '".$_POST['nv']."' ".
								   "AND oc.id_profesor 	= '".$_SESSION["idUsuario"]."' ".
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
