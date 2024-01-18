<?php
	SESSION_START();
	
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	 $nuevoSaldo = $_POST['saldo'] - $_POST['pago'];
	 $estadoFact = '';
	 if ($nuevoSaldo > 0){
		 $estadoFact = 'R';
		}else{$estadoFact = 'P';}
	 $diferencia = $_POST['saldo'] - $_POST['pago'];
	 
	 /* Actualización de Factura */
	 $consulta = $db->consulta("update tsc_facturas
								   set saldo_pendiente = '".$nuevoSaldo."',
								       estado = '".$estadoFact."'
								 WHERE id_factura = '".$_POST["idfactura"]."';");
								 						 
	
	 /* Búsqueda de Forma de Pago */
	 $consulta = $db->consulta("select fp.id_cuenta_contable, fp.id_destino_transaccional ".
								"from tsc_formas_pago fp ".
							   "where fp.id_forma_pago = '".$_POST['fpago']."';");
	 $idCuentaFormaPago = 0;
     $idDestinoTransaccional = 0;
	 if($db->num_rows($consulta)>=0){
		while($resultados = $db->fetch_array($consulta)){
			  $idCuentaFormaPago =  $resultados[0];
			  $idDestinoTransaccional =  $resultados[1];
			  }
		}
	
	/*Pago*/
	if (!$_SESSION["idUsuario"]){$idCajero=$_COOKIE['idUsuarioCk'];}else{$idCajero=$_SESSION["idUsuario"];}
	$consulta = $db->consulta("select id_establecimiento, ".
									 "id_puntos_venta, ".
									 "id_cliente ".
								"from tsc_facturas ".
							   "WHERE id_factura = '".$_POST["idfactura"]."';");
							   
		$idEstablecimiento  = 0;
		$idPuntoEmision     = 0;
		$idCliente     		= 0;
		
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idEstablecimiento  = $resultados[0];
				  $idPuntoEmision     = $resultados[1];
				  $idCliente		  = $resultados[2];
				  }
			}
					 
	$consulta = $db->consulta("insert into tsc_pagos ".
										  "(id_establecimiento,id_punto_emision,id_personal,fecha_pago,".
										  "id_cliente,id_forma_pago,id_tipo_movimiento,id_numero_movimiento,".
										  "monto_pago,id_factura,valor_pendiente,saldo_pendiente,estado,usuario) ".
							"values('".$idEstablecimiento."','".$idPuntoEmision."','".$idCajero."',now(),'".
									   $idCliente."','".$_POST['fpago']."','".$idDestinoTransaccional."','".$_POST["idfactura"]."','".
									   $_POST['pago']."','".$_POST["idfactura"]."','".$_POST['saldo']."','0','P','".$idCajero."');");
	
	
	/* Cuentas por Cobrar */
	$consulta = $db->consulta("select id_cuenta_por_cobrar from tsc_parametros where estado = 'A'; ");	
	$cuentaXCobrar = 0;
	if($db->num_rows($consulta)>=0){
		while($resultados = $db->fetch_array($consulta)){
			  $cuentaXCobrar =  $resultados[0];
			  }
		}
	
	
	
	/*** Registro de Asiento Contable para Pago ***/
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
										  "values(".$idAsiento.",2,'".$_POST['idfactura']."','ASIENTO CONTABLE PAGO','".
												  "ASIENTO AUTOMÁTICO PAGO DE FACTURA NRO. ".$_POST['idfactura']."', now(),'A','".$_POST['pago']."','".$_POST['pago']."','P');");
		
		
		$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
										 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
										 "id_transaccion,monto_debe,monto_haber,estado) ".
								  "values(".$idAsiento.",1,'".$idCuentaFormaPago."','1','".$_POST['idfactura']."',1,'".
											$_POST['pago']."',0,'A');");
		
		$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
										 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
										 "id_transaccion,monto_debe,monto_haber,estado) ".
								  "values(".$idAsiento.",2,'".$cuentaXCobrar."','1','".$_POST['idfactura']."',1,0,'".
											$_POST['pago']."','A');");
	

?>
