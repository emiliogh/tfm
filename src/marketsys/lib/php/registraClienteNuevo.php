<?php
	SESSION_START();
	
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		$consulta = $db->consulta("select count(*) from tcu_clientes where numero_identificacion = '".$_POST['numIdentific']."'");
		
		$idExisteRegistrado = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idExisteRegistrado =  $resultados[0];
				  }
			}
		
	if ($idExisteRegistrado == 0){
		$consulta = $db->consulta("insert into tcu_clientes (id_tipo_cliente,id_categoria_cliente,id_tipo_identificacion,numero_identificacion,".
															"nombre_cliente,direccion,correo_electronico,telefono,estado) ".
								         			 "values('".$_POST['tipoCliente']."','".$_POST['categCliente']."','".$_POST['tipoIdentCli']."','".
								  					 		 $_POST['numIdentific']."','".strtoupper($_POST['nombreClient'])."','".
								  							 strtoupper($_POST['direccionCli'])."','".strtolower($_POST['emailCliente'])."','".
								  							 $_POST['telefonoClie']."','A');");
						$consulta = $db->consulta("select id_cliente from tcu_clientes where numero_identificacion = '".$_POST['numIdentific']."'");
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