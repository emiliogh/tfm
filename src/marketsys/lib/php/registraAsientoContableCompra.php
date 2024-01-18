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
							       "values(".$idAsiento.",4,'".$_POST['idFactura']."','ASIENTO CONTABLE COMPRA','ASIENTO AUTOMÁTICO ".
							      		     "NRO COMPRA. ".$_POST['idFactura']."', now(),'A',0,0,'P');");


        $consulta = $db->consulta("select ct.id_cuenta, ".
										 "sum(dc.subtotal - dc.descuento) debe, ".
								         "sum(dc.iva) iva ".
									"from tsc_detalle_compra dc ".
								   "inner join tfn_cuentas_contables ct ".
									  "on dc.id_cuenta_contable = ct.id_cuenta ".
								   "inner join tfn_cuentas_periodo pr ".
									  "on pr.id_cuenta_contable = ct.id_cuenta ".
								   "inner join tfn_parametros rt ".
									  "on pr.id_periodo = rt.id_periodo_vigente ".
								   "where id_compra = '".$_POST['idFactura']."' ".
								   "group by ct.codigo, ".
										    "ct.descripcion;");

	$i = 1;
	$ach = 0;
    $iva = 0;
    $cmp = 0;
	if($db->num_rows($consulta)>=0){
		while($resultados = $db->fetch_array($consulta)){
			/*** Rubro Compras ***/
			$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
										 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
										 "id_transaccion,monto_debe,monto_haber,estado) ".
										 "values(".$idAsiento.",'".$i."','".$resultados[0]."','1','".$_POST['idFactura']."',1,'".
										 $resultados[1]."',0,'A');"); 

			$ach = $ach + $resultados[1];
			$cmp = $cmp + $resultados[1];
			$iva = $iva + $resultados[2];
			$i++;
			} 
		}

		$consulta = $db->consulta("select id_cuenta_contable_iva, id_cuenta_contable_por_pagar ".
									"from tsc_parametros_compras pc ".
								   "where estado = 'A';");	

        $ach = $ach + $iva;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				/*** Rubro Compras ***/
				$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
											 "id_transaccion,monto_debe,monto_haber,estado) ".
									"values(".$idAsiento.",'".$i."','".$resultados[0]."','1','".$_POST['idFactura']."',1,'".
											 $iva."',0,'A');");
				$i++;
				$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
											 "id_transaccion,monto_debe,monto_haber,estado) ".
									"values(".$idAsiento.",'".$i."','".$resultados[1]."','1','".$_POST['idFactura']."',1,0,'".
											 $_POST['montoTotalPagar']."','A');");
				$i++;
			}
		}

		$consulta = $db->consulta("select tr.id_cuenta_contable, ".
										 "sum(valor_retencion) haber ".
								    "from tsc_retenciones_compras rr ". 
								   "inner join tsc_detalle_retenciones_compras rc ".
								      "on rr.secuencia = rc.codigo_retencion ".
								   "inner join tsc_tipos_retenciones_compras tr ".
									  "on tr.id_retencion = rc.id_codigo_retencion ".
									 "and tr.id_tipo_retenciones = rc.id_tipo_retencion ".
								   "where rr.id_compra = '".$_POST['idFactura']."' ".	
								   "group by tr.id_cuenta_contable;");

		$acd = $_POST['montoTotalPagar'];
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				/*** Rubro Compras ***/
				$instAsiento = $db->consulta("insert into tfn_detalle_asiento_contable ".
											 "(id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,numero_documento,".
											 "id_transaccion,monto_debe,monto_haber,estado) ".
									 "values(".$idAsiento.",'".$i."','".$resultados[0]."','1','".$_POST['idFactura']."',1,0,'".
											 $resultados[1]."','A');"); 

				$acd = $acd + $resultados[1];
				$i++;
				} 
			}
		
		/*** Actualización de Asiento ***/
		$consulta = $db->consulta("update tfn_asiento_contable set monto_debe = '".$ach."',monto_haber = '".$acd."', ".
							              "fecha_asiento = fecha_asiento ".
							       "where id_asiento = ".$idAsiento.";");


		$array = '';
		$array = array(0 => '0');
		        
		
		echo json_encode($array);
		
?>