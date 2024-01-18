<?php
	SESSION_START();
	
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		$consulta = $db->consulta("select count(*) from tsc_proveedores where numero_identificacion = '".$_POST['numIdentific']."'");
		
		$idExisteRegistrado = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idExisteRegistrado =  $resultados[0];
				  }
			}
		
	if ($idExisteRegistrado == 0){
		$consulta = $db->consulta("insert into tsc_proveedores (id_tipo_proveedor,id_categoria_proveedor,id_tipo_identificacion,nombre_comercial,".
															   "numero_identificacion,nombre_proveedor,direccion,correo_electronico,telefono,estado)".
								         			 "values('".$_POST['tipoCliente']."','".$_POST['categCliente']."','".$_POST['tipoIdentCli']."','".
								  					 		 	utf8_decode(strtoupper($_POST['nombreClient']))."','".
								   							 	$_POST['numIdentific']."','".
								  							 	utf8_decode(strtoupper($_POST['razonSocial']))."','".
								  							 	utf8_decode(strtoupper($_POST['direccionCli']))."','".
								  							 	utf8_decode(strtolower($_POST['emailCliente']))."','".
								  							 	$_POST['telefonoClie']."','A');");
						$consulta = $db->consulta("select id_proveedor from tsc_proveedores ".
												   "where numero_identificacion = '".$_POST['numIdentific']."'");
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