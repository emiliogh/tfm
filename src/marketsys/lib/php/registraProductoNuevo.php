<?php
	SESSION_START();
	
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		$consulta = $db->consulta("select count(*) from tiv_items where codigo_barra = '".$_POST['codigoBarra']."'");
		
		$idExisteRegistrado = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idExisteRegistrado =  $resultados[0];
				  }
			}
		
	if ($idExisteRegistrado == 0){
		$chkVentaSStock = 0;
		if ($_POST['chkVentaSStock'] == 'true'){
			$chkVentaSStock = 1;}
			if ($_POST['chkGrabaIVA'] == 'true'){
				$chkGrabaIVA = 1;}
		$consulta = $db->consulta("insert into tiv_items(id_clasificacion,id_producto,descripcion,observacion,codigo_barra,id_fabricante,".
														"id_presentacion,id_graba_iva,id_venta_sin_stock,estado,porcentaje_gan_min,precio_costo) ".
								         		 "values('".$_POST['tipoProducto']."','".$_POST['producto']."','".
								  							utf8_decode(strtoupper($_POST['descripcion']))."','".
								  							utf8_decode(strtoupper($_POST['detalleProd']))."','".
															$_POST['codigoBarra']."','".strtoupper($_POST['idFabricante'])."','".
															strtolower($_POST['idPresentacion'])."','".$chkGrabaIVA."','".
															$chkVentaSStock."','A','".$_POST['porcentajeMin']."','".
															$_POST['precioCosto']."');");
						
							$consulta = $db->consulta("select id_item from tiv_items where codigo_barra = '".$_POST['codigoBarra']."'");
							$idCliente = 0;
							if($db->num_rows($consulta)>=0){
								while($resultados = $db->fetch_array($consulta)){
									  $idCliente =  $resultados[0];
									  }
								}
				}

		$array = '';
		$array = array(0 => $idExisteRegistrado,
					   1 => $idCliente);
		        
		
		echo json_encode($array);
		
?>