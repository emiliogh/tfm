<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
	$consulta = $db->consulta("select id_detalle_destino, ".
							         "count(*) ".
							    "from tsc_formas_pago ".
							   "where estado = 'A' ".
							     "and id_destino_transaccional = 2 ".
							     "and id_forma_pago = '".$_POST['id']."' ".
							   "group by id_destino_transaccional, ".
							  		    "id_detalle_destino ");
		
		$idDestino = 0;
		$NumDestino = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idDestino = $resultados[0];
				  $NumDestino = $resultados[1];
				  }
			}
		
		if ($NumDestino == 1){
		    $consulta = $db->consulta("insert into tsc_movimientos_bancarios (id_cuenta,fecha_movimiento,id_tipo_movimiento,numero_documento,".
								  										     "id_tipo_transaccion,monto,estado) ".
																      "values('".$idDestino."',now(),'".$_POST['tipoMovimiento']."','".
																			     $_POST['idFactura']."','".$_POST['idTrx']."','".
								  											     $_POST['monto']."','R');");
			
			$consulta = $db->consulta("update tsc_cuentas_bancarias ".
									     "set saldo_por_verificar = saldo_por_verificar +  ".$_POST['monto']." ".
									   "where id_cuenta = '".$idDestino."';");
		
			}
		
		$array = '';
		$array = array(0 => '0');
		        
		
		echo json_encode($array);
		
?>