<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		$codigoPago      = 0;
		$consulta = $db->consulta("select coalesce(max(c.id_pago),0)+1 ".
									"from tsc_pagos_compras c ");
			
			if($db->num_rows($consulta)>0){
				while($resultados = $db->fetch_array($consulta)){
					  $codigoPago  = $resultados[0];
					 	}
				}

        $consulta = $db->consulta("insert into tsc_pagos_compras(".
								  "id_pago,id_compra,fecha_pago,monto_pago,monto_retencion,monto_compra,estado,fecha_registro) ".
								  "values('".$codigoPago."','".$_POST['idFactura']."',now(),'".$_POST['saldo']."','".
								  			 $_POST['retencion']."','".$_POST['monto']."','A',now());");
	
		$array = array(0 => $codigoPago);
		        
		
		echo json_encode($array);
		
?>