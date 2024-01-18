<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
	/*** Secuencia ***/
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
							       "values(".$idAsiento.",1,'".$_POST['idFactura']."','ASIENTO CONTABLE FACTURA','ASIENTO AUTOMÁTICO ".
							      		     "SECUENCIA DE FACTURA NRO. ".$_POST['idFactura']."', now(),'A',0,0,'P');");

    $consulta = $db->consulta("select fp.id_cuenta_contable, fp.id_destino_transaccional ".
								"from tsc_formas_pago fp ".
							   "where fp.id_forma_pago = '".$_POST['idFormaPago']."'");
	
	$idCuentaFormaPago = 0;
    $idDestinoTransaccional = 0;
	if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idCuentaFormaPago =  $resultados[0];
				  $idDestinoTransaccional =  $resultados[1];
				  }
			}

		/*** Parametros Auxiliares ***/
		$consulta = $db->consulta("select porcentaje_iva, id_cuenta_por_cobrar from tsc_parametros where estado = 'A'; ");
		
		$IVA = 0;
		$cuentaXCobrar = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $IVA =  $resultados[0];
				  $cuentaXCobrar =  $resultados[1];
				  }
			}
	
	 /*** Cuentas Contables para Venta ***/
	 $consulta = $db->consulta("select cl.id_cuenta_contable, ".
							          "sum(total) monto, ".
									  "cl.id_cuenta_contable_iva, ".
							          "sum(case when i.id_graba_iva = 1 then total when i.id_graba_iva = 0 then 0 end) monto_iva, ".
									  "cl.id_cuenta_contable_desc, ".
							   		  "sum(descuento) ".
								 "from tsc_detalles_factura df ".
								"inner join tiv_items i ".
								   "on i.id_item = df.id_rubro ".
								"inner join tiv_productos p ".
								   "on p.id_producto = i.id_producto ".
								"inner join tiv_clasificacion_productos cl ".
								   "on cl.id_clasificacion = p.id_categoria ".
								"where df.id_factura = '".$_POST['idFactura']."' ".
							    "group by cl.id_cuenta_contable,".
							  			 "cl.id_cuenta_contable_iva,".
							  			 "cl.id_cuenta_contable_desc");

		 $i = 1;
         $ach = 0;
		 if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  /*** Rubro Venta ***/
				  $instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											               "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
														    "id_transaccion,monto_debe,monto_haber,estado) ".
													"values(".$idAsiento.",'".$i."','".$resultados[0]."','1','".$_POST['idFactura']."',1,0,'".
											                  $resultados[1]."','A');"); 
				
				  $ach = $ach + $resultados[1];
				  $i++;
				  
				  /*** Rubro IVA ***/
				  $valorIVA = $IVA*$resultados[3]/100;
				  $instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											               "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
														    "id_transaccion,monto_debe,monto_haber,estado) ".
													"values(".$idAsiento.",'".$i."','".$resultados[2]."','1','".$_POST['idFactura']."',1,0,'".
											                  $valorIVA."','A');"); 
				
				  $ach = $ach + $valorIVA;
				  $i++;	
				
				  /*** Rubro Descuento ***/	
				  /*$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											               "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
														    "id_transaccion,monto_debe,monto_haber,estado) ".
													"values(".$idAsiento.",'".$i."','".$resultados[4]."','1','".$_POST['idFactura']."',1,0,'".
											                  $resultados[5]."','A');"); 
				
				  $ach = $ach + $resultados[2];
				  $i++;*/
				  } 
			}
	
	/*** Cuentas Contables Inventarios ***/
	$consulta = $db->consulta("select id_cuenta_inventario, id_cuenta_costo ".
								"from tiv_parametros ".
							   "where estado = 'A'; ");
	
	$idCuentaInventario = 0;
    $idCuentaCostos = 0;
	if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idCuentaInventario =  $resultados[0];
				  $idCuentaCostos =  $resultados[0];
				  }
			}

	$consulta = $db->consulta("select sum(cantidad_movimiento*costo_movimiento) ".
								"from tiv_movimientos ".
							   "where id_tipo_transaccion = 2 ".
								 "and id_transaccion = '".$_POST['idFactura']."' ");

		 $acd = 0;
		 if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  /*** Rubro Inventarios ***/
				  $instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											               "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
														    "id_transaccion,monto_debe,monto_haber,estado) ".
													"values(".$idAsiento.",'".$i."','".$idCuentaInventario."','1','".$_POST['idFactura']."',1,0,'".
											                  $resultados[0]."','A');"); 
				
				  $ach = $ach + $resultados[0];
				  $i++;
				  
				  /*** Rubro Costo ***/
				  $instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											               "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
														    "id_transaccion,monto_debe,monto_haber,estado) ".
													"values(".$idAsiento.",'".$i."','".$idCuentaCostos."','1','".$_POST['idFactura']."',1,'".
											                  $resultados[0]."',0,'A');"); 
				
				  $acd = $acd + $resultados[0];
				  $i++;	
				  } 
			}
		
		/*** Cuentas Contables Retenciones ***/
		$consulta = $db->consulta("select case when id_tipo_retencion = 1 then t1.id_cuenta ".
										 "when id_tipo_retencion = 2 then t2.id_cuenta end, ".
								   		 "valor_retenido ".
									"from tsc_detalle_retenciones_facturas d ".
								   "inner join tsc_retenciones_facturas r ".
									  "on r.id_retencion = d.id_retencion ".
								   "inner join tiv_retenciones_tipos_clientes_tipos_productos c ".
									  "on c.id_configuracion = d.id_retencion_tb ".
								   "inner join tfn_cuentas_contables t1 ".
									  "on t1.id_cuenta = id_cuenta_contable_renta ".
								   "inner join tfn_cuentas_contables t2 ".
									  "on t2.id_cuenta = id_cuenta_contable_iva ".
								   "where numero_documento = '".$_POST['idFactura']."' order by d.id_retencion_tb;");

		 if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  /*** Rubro Retencion Fuente ***/
				  $instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											               "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
														    "id_transaccion,monto_debe,monto_haber,estado) ".
													"values(".$idAsiento.",'".$i."','".$resultados[0]."','1','".$_POST['idFactura']."',1,'".
											                  $resultados[1]."',0,'A');"); 
				
				  $acd = $acd + $resultados[1];
				  $i++;	
				  } 
			}
		
		/*** Cierre de Asiento Contable ***/
        $valorFinal = $ach - $acd;
		$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
											 "id_transaccion,monto_debe,monto_haber,estado) ".
									  "values(".$idAsiento.",'".$i."','".$cuentaXCobrar."','1','".$_POST['idFactura']."',1,'".
											    $valorFinal."',0,'A');");

		/*** Actualización de Asiento ***/
		$consulta = $db->consulta("update tfn_asiento_contable set monto_debe = '".$ach."',monto_haber = '".$ach."', ".
							              "fecha_asiento = fecha_asiento ".
							       "where id_asiento = ".$idAsiento.";");


		/*** Registro de Asiento Contable para Pago ***/
		if($idDestinoTransaccional == 1){
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
							       			  "values(".$idAsiento.",2,'".$_POST['idFactura']."','ASIENTO CONTABLE PAGO','".
									  				  "ASIENTO AUTOMÁTICO PAGO DE FACTURA NRO. ".$_POST['idFactura']."', now(),'A','".$valorFinal."','".$valorFinal."','P');");
			
			
			$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
											 "id_transaccion,monto_debe,monto_haber,estado) ".
									  "values(".$idAsiento.",1,'".$idCuentaFormaPago."','1','".$_POST['idFactura']."',1,'".
											    $valorFinal."',0,'A');");
			
			$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
											 "id_transaccion,monto_debe,monto_haber,estado) ".
									  "values(".$idAsiento.",2,'".$cuentaXCobrar."','1','".$_POST['idFactura']."',1,0,'".
											    $valorFinal."','A');");
			
		   }

		if($idDestinoTransaccional == 2){
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
							       			  "values(".$idAsiento.",2,'".$_POST['idFactura']."','ASIENTO CONTABLE PAGO ',".
									  				  "'ASIENTO AUTOMÁTICO PAGO DE FACTURA NRO. ".$_POST['idFactura']."', now(),'I','".$valorFinal."','".$valorFinal."','P');");
			
			
			$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
											 "id_transaccion,monto_debe,monto_haber,estado) ".
									  "values(".$idAsiento.",1,'".$idCuentaFormaPago."','1','".$_POST['idFactura']."',1,'".
											    $valorFinal."',0,'A');");
			
			$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
											 "id_transaccion,monto_debe,monto_haber,estado) ".
									  "values(".$idAsiento.",2,'".$cuentaXCobrar."','1','".$_POST['idFactura']."',1,0,'".
											    $valorFinal."','A');");
		   }

		$array = '';
		$array = array(0 => '0');
		        
		echo json_encode($array);
		
?>
