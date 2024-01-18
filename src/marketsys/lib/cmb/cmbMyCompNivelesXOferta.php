<?php
 SESSION_START();
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT oc.id_secuencia id, concat(nv.descripcion,' ','".chr(34)."',oc.paralelo,'".chr(34)."') descripcion ".
							    "FROM tac_niveles_ofertas_centros oc ".
							   "INNER JOIN tac_niveles nv ".
							      "ON nv.id_nivel = oc.id_nivel ".
							   "WHERE oc.estado = 'A' ".
							     "and oc.id_centro = ifnull(".$_POST['id'].",0) ".
							     "and oc.id_periodo = ifnull(".$_POST['ip'].",0) ".
							     "and oc.secuencia = ifnull(".$_POST['sc'].",0) ".
							     "AND oc.id_responsable = '".$_SESSION["idUsuario"]."' ".
							  "ORDER BY oc.id_nivel, oc.paralelo ASC");
	/* SELECT * 
FROM tac_niveles_ofertas_centros oc
INNER JOIN tac_niveles nv
   ON nv.id_nivel = oc.id_nivel */
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
