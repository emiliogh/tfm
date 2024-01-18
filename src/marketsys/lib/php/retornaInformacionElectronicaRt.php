<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
   $query = "select f.log_transaccional	
			  from tsc_retenciones_compras f
			 Where f.secuencia =".$_GET['idfactura'];


	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $Observacion = '';
	if($numResul>0){
	 while($resultados = $db->fetch_array($consulta)){
		   $Observacion = utf8_encode($resultados[0]);
		}
	}	

	$options = array(0 => $Observacion);

	echo json_encode($options);
	   
?>
