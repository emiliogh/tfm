<?php
include_once("../../lib/conexion/class.conexion.php");

$db = new MySQL();
$query = "select id_configuracion, ".
			   	"porcentaje_retencion_iva, ". 
			   	"porcentaje_retencion_renta ".
		   "from tiv_retenciones_tipos_clientes_tipos_productos rt ".
		  "WHERE rt.id_tipo_cliente 			= '".$_POST["idCliente"]."' ".
		    "AND rt.id_clasificacion_producto 	= '".$_POST["idProducto"]."' ".
            "AND now() between fecha_desde and fecha_hasta;";

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $options =array();
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){ 
		 $options = array(0 => $resultados[0],
						  1 => $resultados[1],
						  2 => $resultados[2]);
		}
	}else{
		if($numResul==0){
		   $options = array(0 => '0.00',
						    1 => '0.00',
						    2 => '0.00');
			}
		}
	
	echo json_encode($options);
	   
?>
