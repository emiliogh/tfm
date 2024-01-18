<?php
include_once("../../lib/conexion/class.conexion.php");

$db = new MySQL();
$query = "select descripcion, ".
			   	"cantidad_productos, ". 
			   	"porcentaje_descuento, ".
				"maximo_promociones, ".
				"id_promocion ".
		   "from tsc_promociones rt ".
		  "WHERE id_item 	 = '".$_POST["id"]."' ".
	        "AND estado 	 = 'A' ".
		    "AND now() 		 between fecha_desde and fecha_hasta;";

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $options =array();
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){ 
		 $options = array(0 => $resultados[0],
						  1 => $resultados[1],
						  2 => $resultados[2],
						  3 => $resultados[3],
						  4 => $resultados[4]);
		}
	}	
	
	echo json_encode($options);
	   
?>
