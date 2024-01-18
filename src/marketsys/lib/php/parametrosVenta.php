<?php
include_once("../../lib/conexion/class.conexion.php");

$db = new MySQL();
$query = "select porcentaje_iva ".
		   "from tsc_parametros pr ".
		  "WHERE estado = 'A';";

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $options =array();
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){ 
		 $options = array(0 => $resultados[0]);
		}
	}	
	
	echo json_encode($options);
	   
?>
