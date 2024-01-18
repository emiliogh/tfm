<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
	/*** Secuencia ***/
	$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
										"(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
										 "id_transaccion,monto_debe,monto_haber,estado) ".
									"values(".$_POST['id'].",'".$_POST['linea']."','".
								 			  $_POST['idCta']."','','','','".$_POST['debe']."','".
											  $_POST['habe']."','A');");
	$array = '';
	$array = array(0 => '0');

	echo json_encode($array);
		
?>
