<?php
	SESSION_START();
	
	include("../conexion/class.conexion.php"); 
	
try{
	$array = '';
	$db = new MySQL();
		$consulta = $db->consulta("select ifnull(max(id_factura),0) from tsc_facturas ");
		
		$idFactura = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idFactura =  $resultados[0];
				  }
			}
		$idFactura = $idFactura + 1;
	    $idCajero = $_SESSION["idUsuario"];
	    if ($_SESSION["idUsuario"]==''){$idCajero=$_COOKIE['idUsuarioCk'];}else{$idCajero=$_SESSION["idUsuario"];}
		$consulta = $db->consulta("select e.id_establecimiento, ".
								         "e.codigo_establecimiento, ".
								         "p.id_punto_emision, ".
								         "p.codigo_punto, ".
								         "LPAD(p.secuencia,9,'0'), ".  
								         "t.id_ambiente, ".  
								         "t.id_tipo_emision ".  
								    "from tsc_aperturas_caja a ".
								   "inner join tsc_establecimientos e ".
								      "on e.id_establecimiento = a.id_establecimiento ".
								     "and e.id_tipo_establecimiento = 1 ".
								   "inner join tsc_puntos_emision p ".
								      "on p.id_establecimiento = a.id_establecimiento ".
								     "and p.id_punto_emision = a.id_punto_emision ".
								   "inner join tgn_empresas m ".
									  "on m.estado = 'A' ".
								   "inner join tgn_empresas_info_tributaria t ".
									  "on t.estado = 'A' ".
									 "and t.id_empresa = m.id_empresa ". 
								   "where id_personal = '".$idCajero."' ".
								     "and a.estado = 'A'");
		$idEstablecimiento  = 0;
		$codEstablecimiento = 0;
		$idPuntoEmision     = 0;
		$codPuntoEmision    = 0;
		$secFactura 		= 0;
	    $ambienteFactura 	= 0;
	    $tipoEmisionFactura = 0;
	
		if($db->num_rows($consulta)>0){
			while($resultados = $db->fetch_array($consulta)){
				  $idEstablecimiento  = $resultados[0];
				  $codEstablecimiento = $resultados[1];
				  $idPuntoEmision     = $resultados[2];
				  $codPuntoEmision    = $resultados[3];
				  $secFactura 		  = $resultados[4];
				  $ambienteFactura	  = $resultados[5];
				  $tipoEmisionFactura = $resultados[6];
				  }
			}else if($db->num_rows($consulta)==0){
					 $array = array(0 => '-1');
				     echo json_encode($array);
				     return;}
				  
		
		//$consulta = $db->consulta("select LPAD(secuencia_factura,9,'0') from tsc_parametros where estado = 'A' ");
		
		//$secFactura = 0;
		//if($db->num_rows($consulta)>=0){
		//	while($resultados = $db->fetch_array($consulta)){
		//		  $secFactura =  $resultados[0];
		//		  }
		//	}
		
		$saldoPendiente = 0;
		$montoRentenciones = 0;
		if ($_POST['txtAplicaRet'] == 1){
			$saldoPendiente 	= $_POST['txtTotalVenta'] - $_POST['txtTotalRetenciones'];
			$montoRentenciones 	= $_POST['txtTotalRetenciones'];
			}else{$saldoPendiente 		= $_POST['txtTotalVenta'];
				  $montoRentenciones 	= 0;}
			
			$date = ($_POST['fechaFactura']);
				$date = explode('/', $date);
					$date =  $date[2].'-'.$date[1].'-'.$date[0];
		$consulta = $db->consulta("insert into tsc_facturas ".
								              "(id_factura,id_establecimiento,id_puntos_venta,id_cajero,secuencia_factura,fecha_registro,".
								  			   "numero_factura,id_cliente,fecha_factura,fecha_maxima_pago,id_forma_pago,estado,".
								               "monto_subtotal,monto_subtotal0,monto_subtotal_impuesto,porcentaje_impuesto,".
								  			   "monto_impuesto,monto_total,saldo_pendiente,monto_retenciones,id_ambiente,id_tipo_emision) ".
								        "values('".$idFactura."','".$idEstablecimiento."','".$idPuntoEmision."','".$idCajero."','".
								                   $secFactura."',now(),'".$codEstablecimiento.'-'.$codPuntoEmision.'-'.$secFactura."','".
								  				   $_POST['idCliente']."','".$date."',INTERVAL ".$_POST['vigenciaFormaPago']." DAY + now(),'".
								  				   $_POST['idFormaPago']."','E','".$_POST['txtSubtotalVenta']."','".$_POST['txtVTotalIVA0']."','".
								  				   $_POST['txtVTotalIVA12']."','".$_POST['iVAPorcentaje']."','".$_POST['txtTotalIVA12']."','".
								  				   $_POST['txtTotalVenta']."','".$saldoPendiente."','".$montoRentenciones."','".
								  				   $ambienteFactura."','".$tipoEmisionFactura."');");
				
					$consulta = $db->consulta("select id_destino_transaccional ".
											    "from tsc_formas_pago ".
											   "where id_forma_pago = '".$_POST['idFormaPago']."';");
					
					$idDestinoTransaccional = 0;
					if($db->num_rows($consulta)>=0){
						while($resultados = $db->fetch_array($consulta)){
							  $idDestinoTransaccional =  $resultados[0];
							  }
						}
						if ($idDestinoTransaccional == 1){
							$consulta = $db->consulta("insert into tsc_pagos ".
								              				"(id_establecimiento,id_punto_emision,id_personal,fecha_pago,".
								  			   				 "id_cliente,id_forma_pago,id_tipo_movimiento,id_numero_movimiento,monto_pago,".
								               				 "id_factura,valor_pendiente,saldo_pendiente,estado,usuario) ".
								        		      "values('".$idEstablecimiento."','".$idPuntoEmision."','".$idCajero."',now(),'".
								                  			  $_POST['idCliente']."','".$_POST['idFormaPago']."','".$idDestinoTransaccional."','".$idFactura."','".
															  $saldoPendiente."','".$idFactura."','".$saldoPendiente."','0','A','".$idCajero."');");
							
							$consulta = $db->consulta("update tsc_facturas set saldo_pendiente = 0, estado = 'P' ".
													   "where id_factura = '".$idFactura."';");
							
							} else if ($idDestinoTransaccional == 2){
							$consulta = $db->consulta("insert into tsc_pagos ".
								              		  "(id_establecimiento,id_punto_emision,id_personal,fecha_pago,".
								  			   		  "id_cliente,id_forma_pago,id_tipo_movimiento,id_numero_movimiento,".
													  "monto_pago,id_factura,valor_pendiente,saldo_pendiente,estado,usuario) ".
					        		    "values('".$idEstablecimiento."','".$idPuntoEmision."','".$idCajero."',now(),'".
					                  			   $_POST['idCliente']."','".$_POST['idFormaPago']."','".$idDestinoTransaccional."','".$idFactura."','".												  		   
												   $saldoPendiente."','".$idFactura."','".$saldoPendiente."','0','P','".
												   $idCajero."');");
							
							}

				$secFactura = $secFactura + 1;
				$consulta = $db->consulta("update tsc_puntos_emision ".
										  	 "set secuencia = '".$secFactura."' ".
										   "where id_punto_emision = '".$idPuntoEmision."' ".
								             "and id_establecimiento = '".$idEstablecimiento."' ");		

		$array = array(0 => $idFactura);
	
	} catch (PDOException $e) {
		 	 $array = array(0 =>'-2',
							1 =>$e->getMessage());
	}		        
		
		echo json_encode($array);
		
?>