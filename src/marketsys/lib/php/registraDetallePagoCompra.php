<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
        
		$date = $_POST['fFormaPago'];
			$date = explode('/', $date);
			$date =  $date[2].'-'.$date[1].'-'.$date[0];

        $consulta = $db->consulta("insert into tsc_detalles_pagos_compra(".
								            "id_pago,id_forma_pago,numero,fecha_pago,monto_pago,".
								            "estado,fecha_registro) ".
								     "values('".$_POST['idPago']."','".$_POST['forpagMul']."','".$_POST['nroFormaPago']."',now(),'".$_POST['mFormaPago']."','A',now());");
	
		$array = array(0 => '0');        

		echo json_encode($array);
		
?>