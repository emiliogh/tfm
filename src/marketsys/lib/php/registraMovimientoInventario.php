<?php
SESSION_START();
include("../conexion/class.conexion.php");
try {
	$db = new MySQL();
	if (is_null($_SESSION["usuarioMS"])){
		$array = array(0 =>"Existe problemas con su usuario: ".$_SESSION["usuarioMS"].". Comuniquese con su administrador.",
					   1 =>10);
		echo json_encode($array);
		return;			   
		}
	
		$query = "SELECT registra_movimiento_inventario ".
				   "FROM tiv_clasificacion_productos c ".
			      "INNER JOIN tiv_items i ".
                     "on i.id_clasificacion = c.id_clasificacion ".
				  "WHERE i.id_item = ".$_POST["idItem"]." ".
					"AND i.estado = 'A' ";	
	
		$idRegistrarMovimiento = 0;
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				$idRegistrarMovimiento 		= $resultados[0];
			}
		}
		
		if ($idRegistrarMovimiento == 1){
			$query = "SELECT m.cantidad_actual, m.costo_promedio, m.costo_inteligente, i.id_venta_sin_stock ".
					   "FROM tiv_movimientos m ".
					  "INNER JOIN tiv_items i ".
						 "on i.id_item = m.id_item ".
					  "WHERE m.id_movimiento = (select max(s.id_movimiento) ".
												 "from tiv_movimientos s ".
												"where m.id_item = s.id_item ".
												  "and s.estado = 'A') ".
						"AND m.id_item = ".$_POST["idItem"]." ".
						"AND m.estado = 'A' ";
			$saldoAnterior = 0;
			$costoPromedio = 0;
			$costoInteligente = 0;
			$facturaSinStock = 0;

			$consulta = $db->consulta($query);
			$numResul = $db->num_rows($consulta);
			if($numResul>0){
				while($resultados = $db->fetch_array($consulta)){ 
					$saldoAnterior 		= $resultados[0];
					$costoPromedio 		= $resultados[1];
					$costoInteligente 	= $resultados[2];
					$facturaSinStock    = $resultados[3];
				}
			}

			if ($_POST["tipoTra"] == 2){
				$consulta = $db->consulta("select e.id_bodega ".
											"from tsc_personal_punto_emision p ".
										   "inner join tsc_establecimientos e ".
											  "on e.id_establecimiento = p.id_establecimiento ".
											 "and e.id_tipo_establecimiento = 1 ".
										   "where p.id_personal = '".$_SESSION["idUsuario"]."' ".
											 "and p.estado = 'A'");
				$idBodega  = 0;
				if($db->num_rows($consulta)>0){
					while($resultados = $db->fetch_array($consulta)){
						  $idBodega  = $resultados[0];
						  }
					}

				$cantidadActual 	= $saldoAnterior - $_POST["cantiM"];
				if ($cantidadActual >= 0){
					$precio_comercial	= $_POST["costoM"] - $costoPromedio;
					$ganancia			= $precio_comercial * $_POST["cantiM"];
					$sqlAperturaCaja="insert into tiv_movimientos (id_item,id_usuario,id_trx,fecha_movimiento,id_tipo_transaccion,id_transaccion,".
													"cantidad_anterior,cantidad_movimiento,cantidad_actual,costo_anterior,costo_movimiento, ".
													"costo_promedio, costo_inteligente, estado, id_bodega, id_bodega_despacho, observacion,".
													"precio_comercial,margen,id_tipo_movimiento) ".
													"VALUES (".$_POST["idItem"].",".$_SESSION["idUsuario"].",0,now(),2,".$_POST["idFactura"].",".
															   $saldoAnterior.",".$_POST["cantiM"].",".$cantidadActual.",".$costoInteligente.",".
															   $_POST["costoA"].",".$costoPromedio.",".$costoInteligente.",'A','".$idBodega."','".
															   $idBodega."',upper('VENTA FACTURA N° ".$_POST["idFactura"]."; Línea: ".
															   $_POST["idMovi"]."; PVP: ".$_POST["costoM"]."; GANANCIA PVP: ".$precio_comercial."'),".
																	$_POST["costoM"].",".$ganancia.",2);";

					$rowqryApertura = $db->consulta($sqlAperturaCaja);

					if (substr($rowqryApertura,0,11) == 'MySQL Error'){
						$array = array(0 =>$rowqryApertura,
									   1 =>10);
						echo json_encode($array);
						return;			   
					}
				}else{
					$resta = $_POST["cantiM"] - $_POST["cantSt"];
					if ($_POST["cantSt"] > 0){
						$precio_comercial	= $_POST["costoM"] - $costoPromedio;
						$ganancia			= $precio_comercial * $_POST["cantiM"];
						$sqlAperturaCaja="insert into tiv_movimientos (id_item,id_usuario,id_trx,fecha_movimiento,id_tipo_transaccion,".
														"id_transaccion,cantidad_anterior,cantidad_movimiento,cantidad_actual,costo_anterior,".
														"costo_movimiento,costo_promedio,costo_inteligente,estado,id_bodega,id_bodega_despacho,".
														"observacion,precio_comercial,margen,id_tipo_movimiento) ".
														"VALUES (".$_POST["idItem"].",".$_SESSION["idUsuario"].",0,now(),2,".$_POST["idFactura"].",".
																   $saldoAnterior.",".$saldoAnterior.",0,".$costoInteligente.",".
																   $_POST["costoA"].",".$costoPromedio.",".$costoInteligente.",'A','".$idBodega."','".
																   $idBodega."',upper('VENTA FACTURA N° ".$_POST["idFactura"]."; Línea: ".
																   $_POST["idMovi"]."; PVP: ".$_POST["costoM"]."; GANANCIA PVP: ".
																   $precio_comercial."'),".$_POST["costoM"].",".$ganancia.",2);";

						$rowqryApertura = $db->consulta($sqlAperturaCaja);

						if (substr($rowqryApertura,0,11) == 'MySQL Error'){
							$array = array(0 =>$rowqryApertura,
										   1 =>10);
							echo json_encode($array);
							return;			   
						}
					}
					$sqlAperturaCaja="insert into tiv_facturacion_sin_stock (id_item,id_factura,cantidad_vendida,valor_venta,estado,fecha_registro)".
						              			 "values(".$_POST["idItem"].",".$_POST["idFactura"].",".$resta.",'".$_POST["costoM"]."','A',now());";
						$rowqryApertura = $db->consulta($sqlAperturaCaja);

						if (substr($rowqryApertura,0,11) == 'MySQL Error'){
							$array = array(0 =>$rowqryApertura,
										   1 =>10);
							echo json_encode($array);
							return;			   
						}
				}

			}

			 $array = array(0 => 0,
							1 => '');
		}
	
	} catch (PDOException $e) {
		 $array = array(0 =>$e->getMessage(),
						1 =>10);
	}
	
	echo json_encode($array);
?>
