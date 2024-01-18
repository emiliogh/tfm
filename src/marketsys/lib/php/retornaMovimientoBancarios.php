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
					"case when id_tipo_movimiento = 1 then 'VENTA' ".
		             	 "when id_tipo_movimiento = 2 then 'COMPRA' ".
						 "when id_tipo_movimiento = 3 then 'TRANSFERENCIA' ".
						 "when id_tipo_movimiento = 4 then 'NÓMINA' ".
						 "when id_tipo_movimiento = 5 then 'OTRO' end, ".
					"LPAD(numero_documento,9,0), ".
					"case when id_tipo_transaccion = 1 then 'PAGOS POR TARJETA DE CRÉDITO' else 'RETIROS' end, ".
					"monto, id_tipo_movimiento ".
			   "from tsc_movimientos_bancarios m ".
			  "WHERE m.id_cuenta 			   = '".$_POST["idCuenta"]."' ".
				"AND m.estado 				   = 'R' ".
				"AND m.id_tipo_transaccion 	   = ".$idTipoTransaccion." ".
				"AND DATE_FORMAT(fecha_movimiento,'%Y-%m-%d') ".
					"between '".$dateD."' and '".$dateH."';";

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $tabla = '';
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){
			  $href = '';
			  if($resultados[6] == '1'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[3];}
			  if($resultados[6] == '2'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[3];}
			  if($resultados[6] == '3'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[3];}
			  if($resultados[6] == '4'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[3];}
			  if($resultados[6] == '5'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[3];}
		 	  $tabla = $tabla.'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
				   				  '<td style="text-align: center;">'.$resultados[0].'</td>'.
								  '<td style="text-align: center; border: 1px solid #4ba6c0;">'.$resultados[1].'</td>'.
								  '<td style="padding-left: 5px;">'.$resultados[2].'</td>'.
								  '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
				  					'<a href="'.$href.'" target="_blank">'.$resultados[3].'</a></td>'.
								  '<td style="padding-left: 5px;">'.$resultados[4].'</td>'.
								  '<td style="text-align: right; padding-right: 5px; border: 1px solid #4ba6c0;">'.$resultados[5].'</td>'.
								  '<td onClick="abrirDevengado(this)">'.
				  					'<img src="../images/icons/busqueda.png" width="22px" alt=""/></td></tr>';
		}
	}	
	
	echo $tabla;
	   
?>
