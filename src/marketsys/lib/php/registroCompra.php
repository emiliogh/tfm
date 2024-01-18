<?php
	SESSION_START();
	
	include("../conexion/class.conexion.php"); 
	
try{
	$array = '';
	$db = new MySQL();
	    $idEProveedor = 0;
		$idProveedor  = 0;
		if ($_POST['idCliente'] == '0'){
			$consulta = $db->consulta("select count(*) ".
									    "from tsc_proveedores ".
									   "where numero_identificacion = '".$_POST['identificacion']."';");
		
			if($db->num_rows($consulta)>=0){
				while($resultados = $db->fetch_array($consulta)){
					  $idEProveedor =  $resultados[0];
					  }
				}
			
			if ($idEProveedor == 0){
				$consulta = $db->consulta("insert into tsc_proveedores ".
										   "(id_tipo_identificacion,id_tipo_proveedor,id_categoria_proveedor,numero_identificacion, ".
											"nombre_proveedor,nombre_comercial,direccion,estado,fecha_registro) values (".
											 "2,'".$_POST['idTipoCliente']."','".$_POST['idCategoria']."','".
											  $_POST['identificacion']."','".$_POST['cliente']."','".
											  $_POST['nombreComercial']."','".$_POST['direccionCliente']."','A',now());");
				}
			
			$consulta = $db->consulta("select id_proveedor ".
									    "from tsc_proveedores ".
									   "where numero_identificacion = '".$_POST['identificacion']."';");
		
			
			if($db->num_rows($consulta)>=0){
				while($resultados = $db->fetch_array($consulta)){
					  $idProveedor =  $resultados[0];
					  }
				}
			
		    }else{$idProveedor = $_POST['idCliente'];
				  $idEProveedor = 1;}
					  
									  
		$consulta = $db->consulta("select ifnull(max(id_compra),0) from tsc_compras ");
		
		$idFactura = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idFactura =  $resultados[0];
				  }
			}
		$idFactura = $idFactura + 1;
		
		$saldoPendiente = 0;
		$montoRentenciones = 0;
		if ($_POST['txtAplicaRet'] == 1){
			$saldoPendiente 	= $_POST['txtTotalVenta'] - $_POST['txtRetencion'];
			$montoRentenciones 	= $_POST['txtRetencion'];
			}else{$saldoPendiente 		= $_POST['txtTotalVenta'];
				  $montoRentenciones 	= 0;}
			
		
		$consulta = $db->consulta("select count(*), ifnull(id_compra,0)  ".
								    "from tsc_compras ".
								   "where autorizacion_sri = '".$_POST['numAutorizacion']."' ".
								     "and numero_factura = '".$_POST['numFactura']."' ".
								   "group by id_compra;");
		
			$idECompra = 0;
	        $idCompra = 0;
			if($db->num_rows($consulta)>=0){
				while($resultados = $db->fetch_array($consulta)){
					   $idECompra =  $resultados[0];
					   $idCompra =   $resultados[1];;
					  }
				}
			
		if ($idECompra == 0){
		    $consulta = $db->consulta("insert into tsc_compras ".
								             "(id_compra,establecimiento,punto_emision,numero_factura,".
											  "autorizacion_sri,id_proveedor,tipo_factura,".
								  			  "fecha_compra,fecha_maxima_pago,estado,id_usuario_registro,fecha_registro,".
								              "monto_subtotal,monto_subtotal0,monto_subtotal_impuesto,porcentaje_impuesto,".
								  			  "monto_impuesto,monto_total,saldo_pendiente,monto_retencion,archivo_xml,archivo_pdf) ".
								        "values('".$idFactura."','".$_POST['numEstablecimiento']."','".
									               $_POST['numPuntoEmision']."','".$_POST['numFactura']."','".
									               $_POST['numAutorizacion']."','".$idProveedor."','".
									  			   $_POST['tipoFactura']."','".$_POST['fechaFactura']."',".
								                   "now(),'A','".$_SESSION["idUsuario"]."',now(),'".
								                   $_POST['txtSubtotalVenta']."','".$_POST['txtVTotalIVA0']."','".
								                   $_POST['txtVTotalIVA12']."','".$_POST['iVAPorcentaje']."','".
								  				   $_POST['txtTotalIVA12']."','".$_POST['txtTotalVenta']."','".$saldoPendiente."','".
									  			   $montoRentenciones."','".$_POST['fileXML']."','".$_POST['filePDF']."');");
			
			}else{$idFactura = $idCompra;}

		$array = array(0 => $idFactura,
					   1 => $idEProveedor,
					   2 => $idECompra,
					   3 => $idProveedor);
	
	} catch (PDOException $e) {
		 	 $array = array(0 =>'-2',
							1 =>$e->getMessage());
	}		        
		
		echo json_encode($array);
		
?>