<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();

$idTipoTransaccion = '';
if ($_POST["idTipoTransaccion"] == 0){
	$idTipoTransaccion = 'm.id_tipo_transaccion';}
	else{$idTipoTransaccion = $_POST["idTipoTransaccion"];}
	
	/*$dateD = $_POST['fechaDesde'];
	$dateD = explode('/', $dateD);
	$dateD =  $dateD[2].'-'.$dateD[1].'-'.$dateD[0];

	$dateH = $_POST['fechaHasta'];
    $dateH = explode('/', $dateH);
	$dateH =  $dateH[2].'-'.$dateH[1].'-'.$dateH[0];*/
	$var = $_POST['fechaDesde'];
		$date = str_replace('/', '-', $var);
			$dateD = date('Y-m-d', strtotime($date));
  
	$var = $_POST['fechaHasta'];
		$date = str_replace('/', '-', $var);
			$dateH = date('Y-m-d', strtotime($date));

	$query = "select LPAD(id_movimiento,6,'0'), ".
					"DATE_FORMAT(fecha_movimiento,'%d-%m-%Y %H:%i'), ".
		            "case when id_tipo_transaccion = 1 then 'DEPÓSITOS' else 'RETIROS' end, ".
		            "numero_movimiento, ".
					"case when id_tipo_movimiento = 1 then 'VENTA' ".
		             	 "when id_tipo_movimiento = 2 then 'COMPRA' ".
						 "when id_tipo_movimiento = 3 then 'TRANSFERENCIA' ".
						 "when id_tipo_movimiento = 4 then 'NÓMINA' ".
						 "when id_tipo_movimiento = 5 then 'OTRO' end, ".
					"LPAD(numero_documento,9,0), ".
					"DATE_FORMAT(fecha_autorizacion,'%d-%m-%Y %H:%i'), ".
		            "u.usuario, ".
					"monto, id_tipo_movimiento, observacion, id_tipo_transaccion,saldo_cuenta ".
			   "from tsc_movimientos_bancarios m ".
		      "inner join tas_usuarios u ".
		         "on u.id_usuario = m.usuario_autorizacion ".
			  "WHERE m.id_cuenta 			   = '".$_POST["idCuenta"]."' ".
				"AND m.estado 				   = 'A' ".
				"AND DATE_FORMAT(fecha_movimiento,'%Y-%m-%d') ".
					"between '".$dateD."' and '".$dateH."' ".
			  "order by fecha_autorizacion desc;";

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $tabla = '';
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){
			  $href = ''; 	$valor = '';
				 $debe = 0;
			     $creditos = 0;
					if($resultados[11] == '1'){$creditos = $resultados[8];}
			           else {$debe = $resultados[8];}
			  if($resultados[9] == '1'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  if($resultados[9] == '2'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  if($resultados[9] == '3'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  if($resultados[9] == '4'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  if($resultados[9] == '5'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  if($resultados[11] == '1'){$valor = '  color: green;';}else{$valor = '  color: red;';}
		 	  $tabla = $tabla.'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
				   				  '<td style="text-align: center;">'.$resultados[0].'</td>'.
								  '<td style="text-align: center; border: 1px solid #4ba6c0;">'.$resultados[1].'</td>'.
				                  '<td style="text-align: center;">'.$resultados[3].'</td>'.
				                  '<td style="padding-left: 5px; border: 1px solid #4ba6c0;">'.$resultados[4].'</td>'.
								  '<td style="text-align: center;">'.
				  					'<a href="'.$href.'" target="_blank">'.$resultados[5].'</a></td>'.
								  '<td style="padding-left: 5px; border: 1px solid #4ba6c0;">'.$resultados[6].'</td>'.
				                  '<td style="padding-left: 5px;">'.$resultados[7].'</td>'.
				  				  '<td style="display: none;">'.$resultados[10].'</td>'.	
				                  '<td style="text-align: right; padding-right: 5px; border: 1px solid #4ba6c0;">'.$debe.'</td>'.
				  				  '<td style="text-align: right; padding-right: 5px; border: 1px solid #4ba6c0;">'.$creditos.'</td>'.
				                  '<td style="text-align: right; padding-right: 5px; border: 1px solid #4ba6c0;">'.$resultados[12].'</td>'.
								  '<td onClick="abrirDevengado(this)">'.
				  					'<img src="../images/icons/busqueda.png" width="22px" alt=""/></td></tr>';
		}
	}	
	
	$query = "select saldo_disponible, ".
					"saldo_por_verificar, ". 
					"saldo_por_devengar ".
			   "from tsc_cuentas_bancarias ".
			  "WHERE id_cuenta 			   = '".$_POST["idCuenta"]."';";

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $saldo = '';
	$retirosDevengar = '';
	$depositosDevengar = '';
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){
			  $saldoContable 	 = $resultados[0];
			  $depositosDevengar = $resultados[1];
			  $retirosDevengar 	 = $resultados[2];
			}
		}
	
	$options = array(0 => $tabla,
					 1 => $saldoContable,
					 2 => $depositosDevengar,
					 3 => $retirosDevengar);
	echo json_encode($options);
	   
?>
