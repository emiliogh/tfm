<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
   $query = "SELECT i.id_item, ".
				   "concat(i.descripcion,' (',i.observacion,')') item, ".
				   "ifnull(p.descripcion,' - ') presentacion, ".
				   "ifnull(f.nombre_comercial,' - ') fabricante, ".
				   "codigo_barra, ".
				   "m.cantidad_actual, ".
				   "m.costo_promedio, ".
				   "m.costo_inteligente ".
			  "FROM tiv_movimientos m ".
			 "INNER JOIN tiv_items i ".
				"ON i.id_item = m.id_item ".
			   "AND m.id_movimiento = (select max(s.id_movimiento) ".
							            "from tiv_movimientos s ".
						               "where i.id_item = s.id_item ".
	   									 "and s.id_bodega = m.id_bodega ".	
										 "and s.estado = 'A' ".
										 "and m.estado = 'A') ".
			 "LEFT JOIN tiv_presentacion p ".
			   "on i.id_presentacion = p.id_presentacion ".
			 "LEFT JOIN tiv_fabricantes f ".
			   "on i.id_fabricante = f.id_fabricante ".
			"WHERE i.estado = 'A' ".
			  "and m.id_bodega = case when '".$_POST['idBodega']."' = 0 then m.id_bodega else '".$_POST['idBodega']."' end ".
			  "and i.id_producto = case when '".$_POST['idProducto']."' = 0 then i.id_producto else '".$_POST['idProducto']."' end ".
			  "and i.id_clasificacion = case when '".$_POST['idCategoria']."' = 0 then i.id_clasificacion else '".$_POST['idCategoria']."' end ".
			"order by 1";

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $tabla = '';
    $montoPromedio = 0;
    $montoInteligente = 0;
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){
			  $totalPromedio = 0;
			  $totalInteligente = 0;
			
			  $totalPromedio = $resultados[5] * $resultados[6];
		      $totalInteligente = $resultados[5] * $resultados[7];		  
			  $tabla = $tabla.'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
				   				  '<td style="text-align: center;">'.$resultados[0].'</td>'.
								  '<td style="text-align: left;">'.$resultados[1].'</td>'.
				  				  '<td style="text-align: left;">'.$resultados[2].'</td>'.
				   				  '<td style="text-align: left;">'.$resultados[3].'</td>'.
				                  '<td style="text-align: center;">'.$resultados[4].'</td>'.
				  				  '<td style="text-align: right;">'.number_format($resultados[5],2).'</td>'.
				  				  '<td style="text-align: right;">'.number_format($resultados[6],2).'</td>'.
				  				  '<td style="text-align: right;">'.number_format($resultados[7],2).'</td>'.
				    			  '<td style="text-align: right;">'.number_format($totalPromedio,2).'</td>'.
				  				  '<td style="text-align: right;">'.number_format($totalInteligente,2).'</td></tr>';
			$montoPromedio = $montoPromedio + $totalPromedio;
			$montoInteligente = $montoInteligente + $totalInteligente;	
		}
	}	

	
	$options = array(0 => $tabla,
					 1 => number_format($montoPromedio,2),
					 2 => number_format($montoInteligente,2));
	echo json_encode($options);
	   
?>
