<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("select ct.id_cuenta id, ".
								 	   "CONCAT('[',ct.codigo,'] ',ct.descripcion) descripcion ".
								  "from tfn_cuentas_contables ct ".
								 "inner join tfn_cuentas_periodo pr ".
									"on pr.id_cuenta_contable = ct.id_cuenta ".
								 "inner join tfn_parametros rt ".
									"on pr.id_periodo = rt.id_periodo_vigente ".
								 "order by 1 ");
	
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
