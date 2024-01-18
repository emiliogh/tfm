<?php
	SESSION_START();
	include_once("../conexion/class.conexion.php");

	$db = new MySQL();
		$query = "select saldo_disponible ".
				   "from tsc_cuentas_bancarias ". 
				  "WHERE id_cuenta		  	   = '".$_POST["idCuentaBancaria"]."';";
		$consulta = $db->consulta($query);
			$numResul = $db->num_rows($consulta);
			$saldoAnterior = 0;
		if($numResul>0){
		   while($resultados = $db->fetch_array($consulta)){
			     $saldoAnterior = $resultados[0];
		   		 }
			}
		if ($_POST["tipoTransaccion"] != 'RETIROS'){$saldoAnterior = $saldoAnterior + $_POST["montoTransaccion"];}
				else {$saldoAnterior = $saldoAnterior - $_POST["montoTransaccion"];}

		$query = "update tsc_movimientos_bancarios ".
					"set numero_movimiento 	  = '".$_POST["documentoBancario"]."', ". 
						"observacion 	  	  = '".$_POST["observacionBancaria"]."', ".
						"usuario_autorizacion = '".$_SESSION["idUsuario"]."', ".
						"fecha_autorizacion   = now(), ".
						"estado 			  = 'A', ".
						"fecha_movimiento 	  = fecha_movimiento, ".
			            "saldo_cuenta 		  = ".$saldoAnterior." ".
				  "WHERE id_movimiento		  = '".$_POST["idMovimiento"]."';";
		$consulta = $db->consulta($query);


		if ($_POST["tipoTransaccion"] != 'RETIROS'){
			$query = "update tsc_cuentas_bancarias ".
						"set saldo_por_verificar 	  = saldo_por_verificar - ".$_POST["montoTransaccion"].", ". 
							"saldo_disponible 	  	  = saldo_disponible + ".$_POST["montoTransaccion"].", ".
							"saldo_comercial 		  = saldo_comercial + ".$_POST["montoTransaccion"]." ".
					  "WHERE id_cuenta		  		  = '".$_POST["idCuentaBancaria"]."';";
			$consulta = $db->consulta($query);
			
				$query = "select id_tipo_movimiento, numero_documento ".
						   "from tsc_movimientos_bancarios ". 
						  "WHERE id_movimiento		  	   = '".$_POST["idMovimiento"]."';";
			
						$consulta = $db->consulta($query);
						$numResul = $db->num_rows($consulta);
						$tipoMovimiento = 0;
						$numMovimiento = 0;
							if($numResul>0){
							   while($resultados = $db->fetch_array($consulta)){
								     $tipoMovimiento = $resultados[0];
									 $numMovimiento  = $resultados[1];
							   		}
							}
			 				if ($tipoMovimiento == 1){
								$querU = "update tsc_facturas ".
										    "set saldo_pendiente = saldo_pendiente - ".$_POST["montoTransaccion"].", ".
									            "estado = 'P' ".
										  "WHERE id_factura		  	   = '".$numMovimiento."';";
								
										$consulta = $db->consulta($querU);
								
								$consulta = $db->consulta("update tsc_pagos ".
														  	 "set id_numero_movimiento = ".$_POST["idMovimiento"].", ".
														  	     "estado = 'A' ". 		
														   "where id_factura = ".$numMovimiento." ".
															 "and id_numero_movimiento = ".$numMovimiento." ".
															 "and estado = 'P';");
								}
			}
            else{$query = "update tsc_cuentas_bancarias ".
							 "set saldo_por_devengar 	= saldo_por_devengar - ".$_POST["montoTransaccion"].", ". 
								 "saldo_disponible 	  	= saldo_disponible - ".$_POST["montoTransaccion"].", ".
								 "saldo_comercial 		= saldo_comercial - ".$_POST["montoTransaccion"]." ".
						   "WHERE id_cuenta		  		= '".$_POST["idCuentaBancaria"]."';";
				 
				$consulta = $db->consulta($query);
				} 

?>
