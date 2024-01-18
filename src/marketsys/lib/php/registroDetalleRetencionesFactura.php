<?php
	SESSION_START();
	include_once("../conexion/class.conexion.php");

	$db = new MySQL();
		$query = "insert into tsc_detalle_retenciones_facturas ".
						    "(id_retencion,linea_retencion,id_retencion_tb,id_tipo_retencion,porcentaje_retencion,monto_aplicable,".
							 "valor_retenido,estado,fecha_registro) ".
			          "values('".$_POST["idRetencion"]."','".$_POST["lineaRetencion"]."','".$_POST["idTRetencion"]."','".
								 $_POST["idTipoRetencion"]."','".$_POST["porcentajeRetencion"]."','".$_POST["montoARetencion"]."','".
								 $_POST["montoRetencion"]."','A',now());";

		$consulta = $db->consulta($query);

	$array = array(0 => 0);
	echo json_encode($array);

?>