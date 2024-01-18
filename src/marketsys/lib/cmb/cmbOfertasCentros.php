<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT secuencia id, concat(p.descripcion,'  |',f.descripcion) descripcion FROM tac_ofertas_centros o inner join tac_ofertas f on f.id_oferta = o.id_oferta and f.estado = 'A' inner join tcf_periodos p on p.id_periodo = o.id_periodo and p.estado = 'A' WHERE o.estado = 'A' and o.id_centro = ifnull(".$_POST['id'].",0) ORDER BY 2 ASC;");
	
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
