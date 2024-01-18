<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
   $query = "select m.id_movimiento, ".
				   "DATE_FORMAT(m.fecha_movimiento,'%d-%m-%Y %h:%i') fecha, ".
	               "concat(i.descripcion,' (',i.observacion,')') item, ".   
				   "upper(m.observacion), ".
				   "id_tipo_transaccion, LPAD(id_transaccion,8,'0'), ".
				   "case when t.movimiento = '+' then ".
						"m.cantidad_movimiento else null end, ".
				   "case when t.movimiento = '+' then ".
						"m.cantidad_movimiento*m.costo_movimiento else null end, ".
				   "case when t.movimiento = '-' then ".
						"m.cantidad_movimiento else null end, ".
				   "case when t.movimiento = '-' then ".
						"m.cantidad_movimiento*m.costo_movimiento else null end, ".
				   "cantidad_actual, ".
				   "cantidad_actual*costo_promedio, ".
				   "costo_promedio, ".
				   "costo_inteligente ".
			  "from tiv_movimientos m ".
			 "INNER JOIN tiv_items i ".
				"ON i.id_item = m.id_item ".
			 "inner join tiv_tipos_movimientos t ".
			    "on m.id_tipo_movimiento = t.id_tipo_movimiento ".
	         "WHERE m.estado = 'A' ".
			   "and m.id_bodega = case when '".$_POST['idBodega']."' = 0 then m.id_bodega else '".$_POST['idBodega']."' end ".
			   "and i.id_producto = case when '".$_POST['idProducto']."' = 0 then i.id_producto else '".$_POST['idProducto']."' end ".
			    "and i.id_clasificacion = case when '".$_POST['idCategoria']."' = 0 then i.id_clasificacion else '".$_POST['idCategoria']."' end ".
			    "and m.id_item = case when '".$_POST['idItem']."' = 0 then m.id_item else '".$_POST['idItem']."' end ".
	            "and m.id_tipo_movimiento = case when '".$_POST['idTipoMov']."' = 0 then m.id_tipo_movimiento else '".$_POST['idTipoMov']."' end ".
	            "and DATE(DATE_FORMAT(m.fecha_movimiento,'%d/%m/%Y')) >= '".$_POST['fechaDesde']."' ".
	            "and DATE(DATE_FORMAT(m.fecha_movimiento,'%d/%m/%Y')) <= '".$_POST['fechaHasta']."' ".
	         "order by 1 asc";

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $tabla = '';
    $cantidadIn = 0;
    $montoIn = 0;
    $cantidadOut = 0;
    $montoOut = 0;
    $cantidadSal = 0;
    $montoSal = 0;
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){
			  $totalPromedio = 0;
			  $totalInteligente = 0;
			
			  if($resultados[4] == '1'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  if($resultados[4] == '2'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  if($resultados[4] == '3'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  if($resultados[4] == '4'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  if($resultados[4] == '5'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
		 	  
			  $tabla = $tabla.'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
				   				  '<td style="text-align: center;">'.$resultados[0].'</td>'.
								  '<td style="text-align: left;">'.$resultados[1].'</td>'.
				  				  '<td style="text-align: left;">'.$resultados[2].'</td>'.
				   				  '<td style="text-align: left;">'.$resultados[3].'</td>'.
				                  '<td style="text-align: center;">'.
				  					   '<a href="'.$href.'" target="_blank">'.$resultados[5].'</a></td>'.
				  				  '<td style="text-align: right;">'.number_format($resultados[6],2).'</td>'.
				  				  '<td style="text-align: right;">'.number_format($resultados[7],2).'</td>'.
				  				  '<td style="text-align: right;">'.number_format($resultados[8],2).'</td>'.
				    			  '<td style="text-align: right;">'.number_format($resultados[9],2).'</td>'.
				                  '<td style="text-align: right;">'.number_format($resultados[10],2).'</td>'.
				                  '<td style="text-align: right;">'.number_format($resultados[11],2).'</td>'.
				                  '<td style="text-align: right;">'.number_format($resultados[12],4).'</td>'.
				  				  '<td style="text-align: right;">'.number_format($resultados[13],4).'</td></tr>';
			$cantidadIn  = $cantidadIn + $resultados[6];
			$montoIn     = $montoIn    + $resultados[7];
			$cantidadOut = $cantidadOut+ $resultados[8];
			$montoOut    = $montoOut   + $resultados[9];
			$cantidadSal = $resultados[10];
			$montoSal    = $resultados[11];
		}
	}	

	
	$options = array(0 => $tabla,
					 1 => number_format($cantidadIn,2),
					 2 => number_format($montoIn,2),
					 3 => number_format($cantidadOut,2),
					 4 => number_format($montoOut,2),
					 5 => number_format($cantidadSal,2),
					 6 => number_format($montoSal,2));

	echo json_encode($options);
	   
?>
