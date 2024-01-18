<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
   /********* Actualiza Totales Asientos ************/	
   $query = "update tfn_asiento_contable set ".
						"descripcion 	= '".$_POST['dscAsiento']."', ".
						"glosa 			= '".$_POST['glsAsiento']."', ".
						"monto_debe 	= '".$_POST['mtDbAsiento']."', ".
						"monto_haber 	= '".$_POST['mtHbAsiento']."' ".	
	   		 "where id_asiento  = '".$_POST['id']."' ";

	$consulta = $db->consulta($query);

    /************ Inactiva Detalles ***************/
	$query = "update tfn_detalle_asiento_contable set ".
					"estado 	= 'I', fecha_detalle = fecha_detalle ".	
	   		  "where id_asiento = '".$_POST['id']."' ";

	$consulta = $db->consulta($query);


	$options = array(0 => '0');
		echo json_encode($options);
?>