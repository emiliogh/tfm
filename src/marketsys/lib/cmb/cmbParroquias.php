<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT id_parroquia id, descripcion descripcion FROM tb_parroquias WHERE estado = 'A' and id_pais = ifnull(".$_POST['id'].",0) and id_provincia = ifnull(".$_POST['id2'].",0) and  	id_canton = ifnull(".$_POST['id3'].",0) ORDER BY 2 ASC;");
	
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
