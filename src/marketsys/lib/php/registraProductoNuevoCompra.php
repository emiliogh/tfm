<?php
	SESSION_START();
	
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		$consulta = $db->consulta("select count(*) from tsc_productos_compra where descripcion = '".$_POST['descripcionNw']."'");
		
		$idExisteRegistrado = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idExisteRegistrado =  $resultados[0];
				  }
			}
		
	if ($idExisteRegistrado == 0){
		$chkVentaSStock = 1;}
		if ($_POST['chkGrabaIVA'] == 'true'){
			$chkGrabaIVA = 1;}

		$consulta = $db->consulta("insert into tsc_productos_compra(id_proveedor,descripcion,detalle,valor_venta,graba_iva,".
														"id_cuenta_contable,id_cuenta_retencion_renta,id_cuenta_retencion_iva,estado) ".
								         		 "values('".$_POST['idCliente']."','".
								  							utf8_decode(strtoupper($_POST['descripcion']))."','".
								  							utf8_decode(strtoupper($_POST['detalleNW']))."','".
															$_POST['precioVenta']."','".$chkGrabaIVA."','".
															$_POST['idCuenta']."','".$_POST['retencionRta']."','".
															$_POST['retencionIVA']."','A');");
						
							$consulta = $db->consulta("select id_producto 
							                             from tsc_productos_compra 
														where descripcion = '".$_POST['codigoBarra']."'");
							$idCliente = 0;
							if($db->num_rows($consulta)>=0){
								while($resultados = $db->fetch_array($consulta)){		
									  $idCliente =  $resultados[0];
									  }
								}
				

		$array = '';
		$array = array(0 => $idExisteRegistrado,
					   1 => $idCliente);
		        
		
		echo json_encode($array);
		
?>