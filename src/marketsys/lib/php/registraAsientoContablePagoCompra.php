<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();

	 /*** Secuencia Asiento Contable ***/
	 $consulta = $db->consulta("select ifnull(max(id_asiento),0) from tfn_asiento_contable ");

	 $idAsiento = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				$idAsiento =  $resultados[0];
			}
		}

	/*** Registro de Asiento Contable ***/
	$idAsiento = $idAsiento + 1;
	$consulta = $db->consulta("insert into tfn_asiento_contable (id_asiento,id_tipo_asiento,numero_documento,descripcion,glosa,".
							              "fecha_asiento,estado,monto_debe,monto_haber,estado_autorizacion) ".
							       "values(".$idAsiento.",5,'".$_POST['idFactura']."','ASIENTO CONTABLE PAGO DE COMPRA',".
							               "'ASIENTO AUTOMÁTICO NRO COMPRA. ".$_POST['idFactura']."', now(),'A',0,0,'P');");
	
	/****** Consulta Cuenta ******/
	$consulta = $db->consulta("select id_cuenta_contable_por_pagar ".
							    "from tsc_parametros_compras pc ".
							   "where estado = 'A';");
	$id_cuentaPagar = 0; 
	if($db->num_rows($consulta)>=0){
		while($resultados = $db->fetch_array($consulta)){
			  $id_cuentaPagar = $resultados[0];
		}
	}	

	/******* Registra Movimiento Bancario *******/
	$consultaMB = $db->consulta("SELECT f.id_destino_transaccional, f.id_detalle_destino, dc.numero, dc.monto_pago ".
							    "FROM tsc_detalles_pagos_compra dc ".
							   "INNER JOIN tsc_pagos_compras c ".
								  "ON c.id_pago = dc.id_pago ".
							   "INNER JOIN tsc_formas_pago f ".
								  "ON f.id_forma_pago = dc.id_forma_pago ".
							     "AND f.id_destino_transaccional in (1,2,4) ".
							   "inner join tsc_cuentas_bancarias b ".
								  "on b.id_cuenta = f.id_detalle_destino ".
							   "WHERE c.id_compra = '".$_POST['idFactura']."';");	
	$idCuentaFP = 0; 
    $acumulador = 0;
    $i = 1;
	if($db->num_rows($consultaMB)>=0){
		while($resultados = $db->fetch_array($consultaMB)){
			  $tipoMovimiento = 2;
			  if ($resultados[0] == 2){
		    	  $consulta = $db->consulta("insert into tsc_movimientos_bancarios ".
				                   					"(id_cuenta,fecha_movimiento,id_tipo_movimiento,numero_documento,".
								  					"id_tipo_transaccion,monto,estado) ".
											"values('".$resultados[1]."',now(),'".
													$tipoMovimiento."','".
													$_POST['idFactura']."','".$resultados[2]."','".
								  					$resultados[3]."','R');");
			
				$consulta = $db->consulta("update tsc_cuentas_bancarias ".
									     	 "set saldo_por_verificar = saldo_por_verificar -  ".$resultados[3]." ".
									   	   "where id_cuenta = '".$resultados[1]."';");
		
				}
			  if ($resultados[0] == 4){
		    	  $consulta = $db->consulta("insert into tsc_movimientos_bancarios ".
				                   					"(id_cuenta,fecha_movimiento,id_tipo_movimiento,numero_documento,".
								  					"id_tipo_transaccion,monto,estado) ".
											"values('".$resultados[1]."',now(),'".
													$tipoMovimiento."','".
													$_POST['idFactura']."','".$resultados[2]."','".
								  					$resultados[3]."','R');");
			
				$consulta = $db->consulta("update tsc_cuentas_bancarias ".
									     	 "set saldo_por_verificar = saldo_por_verificar -  ".$resultados[3]." ".
									   	   "where id_cuenta = '".$resultados[1]."';");
		
				}
		}
	}

	/****** Consulta Cuenta ******/
	$consulta = $db->consulta("SELECT f.id_cuenta_contable, sum(dc.monto_pago) ". 
							    "FROM tsc_detalles_pagos_compra dc ".
							   "INNER JOIN tsc_pagos_compras c ".
								  "ON c.id_pago = dc.id_pago ".
							   "INNER JOIN tsc_formas_pago f ".
								  "ON f.id_forma_pago = dc.id_forma_pago ".
							     "AND f.id_destino_transaccional in (1,2,4) ".
							   "WHERE c.id_compra = '".$_POST['idFactura']."' ".
							   "GROUP BY f.id_cuenta_contable;");
	
	$idCuentaFP = 0; 
    $acumulador = 0;
    $i = 1;
	if($db->num_rows($consulta)>=0){
		while($resultados = $db->fetch_array($consulta)){
			  $instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
											 "id_transaccion,monto_debe,monto_haber,estado) ".
											 "values(".$idAsiento.",'".$i."','".$resultados[0]."','5','".$_POST['idFactura']."',5,'".
											 $resultados[1]."',0,'A');");
			  
			  $acumulador = $acumulador + $resultados[1];
			  $i++;
		}
	}
	
	$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
											 "id_transaccion,monto_debe,monto_haber,estado) ".
											 "values(".$idAsiento.",'".$i."','".$id_cuentaPagar."','5','".$_POST['idFactura']."',5,0,".
											 "'".$acumulador."','A');");
	
		
	/*** Actualización de Asiento ***/
	$consulta = $db->consulta("update tfn_asiento_contable set monto_debe = '".$acumulador."',monto_haber = '".$acumulador."', ".
							  "fecha_asiento = fecha_asiento ".
							  "where id_asiento = ".$idAsiento.";");


	$array = '';
	$array = array(0 => '0');
		        
		
		echo json_encode($array);
		
?>