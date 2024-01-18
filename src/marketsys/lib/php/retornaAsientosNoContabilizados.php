<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
	$var = $_POST['fechaDesde'];
		$date = str_replace('/', '-', $var);
			$dateD = date('Y-m-d', strtotime($date));
  
	$var = $_POST['fechaHasta'];
		$date = str_replace('/', '-', $var);
			$dateH = date('Y-m-d', strtotime($date));


   $query = "select LPAD(a.id_asiento,6,'0'), ".
				   "date_format(a.fecha_asiento,'%d-%m-%Y %h:%i'), ".
				   "a.descripcion, ".
				   "a.glosa, ".
				   "a.id_tipo_asiento, ".
				   "LPAD(a.numero_documento,8,'0'), ".
				   "LPAD(da.linea_asiento,3,'0'), ".
				   "ct.codigo, ".
				   "ct.descripcion, ".
				   "da.monto_debe, ".
				   "da.monto_haber, ".
				   "a.monto_debe, ".
				   "a.monto_haber ".
			  "from tfn_asiento_contable a ".
			 "inner join tfn_detalle_asiento_contable da ".
				"on a.id_asiento = da.id_asiento ".
	           "and da.estado = 'A' ".
			 "inner join tfn_cuentas_contables ct ".
				"on ct.id_cuenta = da.id_cuenta ".
			 "inner join tfn_cuentas_periodo pr ".
				"on pr.id_cuenta_contable = ct.id_cuenta ".
			 "inner join tfn_parametros rt ".
				"on pr.id_periodo = rt.id_periodo_vigente ".
			 "where a.estado_autorizacion = 0 ".
			   "and a.id_tipo_asiento = case when '".$_POST['idTipoAsiento']."' = 0 then a.id_tipo_asiento else '".
	   				$_POST['idTipoAsiento']."' end ".
			   "and a.id_asiento = case when '".$_POST['idNumAsiento']."' = 0 then a.id_asiento else '".
	   				$_POST['idNumAsiento']."' end ".
	            "and DATE_FORMAT(fecha_asiento,'%Y-%m-%d') ".
					"between '".$dateD."' and '".$dateH."' ".
			  "order by a.id_asiento,da.linea_asiento";


	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $tabla = '';
    $idAsiento 	= 0;
    $montoDebe 	= 0;
    $montoHaber = 0;
    
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){
			  if ($idAsiento != number_format($resultados[0])){
			      if($resultados[4] == '1'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  	  if($resultados[4] == '2'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  	  if($resultados[4] == '3'){$href = '../reports/facturaPDF.php?idfactura='.$resultados[5];}
			  	  if($resultados[4] == '4'){
					 $consultaCmp = $db->consulta("SELECT ifnull(concat('../respaldos_compras/pdf/',archivo_pdf),".
											                 "concat('../respaldos_compras/xml/',archivo_xml)) ".
											     "FROM tsc_compras WHERE id_compra = '".$resultados[5]."';");
						
					    $href = '';
						if($db->num_rows($consultaCmp)>=0){
						   while($resultadosCmp = $db->fetch_array($consultaCmp)){ 
								 $href = $resultadosCmp[0];
								 }
						} 
						//$href = '../reports/facturaPDF.php?idfactura='.;
				  }
			  	  if($resultados[4] == '5'){
					 $consultaCmp = $db->consulta("SELECT ifnull(concat('../respaldos_compras/pdf/',archivo_pdf),".
											                 "concat('../respaldos_compras/xml/',archivo_xml) ".
											     "FROM tsc_compras WHERE id_compra = '".$resultados[5]."';");
						
					    $href = '';
						if($db->num_rows($consultaCmp)>=0){
						   while($resultadosCmp = $db->fetch_array($consultaCmp)){ 
								 $href = $resultadosCmp[0];
								 }
						} 
						//$href = '../reports/facturaPDF.php?idfactura='.;
				  }
				  
				  if ($idAsiento == 0){
					   $tabla = $tabla.'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
										  '<td style="text-align: left; background: #A9D2F3">Número</td>'.
										  '<td style="text-align: center; font-weight:200">'.$resultados[0].'</td>'.
						   				  '<td style="text-align: left; background: #A9D2F3">Fecha</td>'.	
										  '<td style="text-align: center; font-weight:200">'.$resultados[1].'</td>'.
						                  '<td style="text-align: left; background: #A9D2F3">Descripcion</td>'.
						                  '<td style="text-align: left; font-weight:200">'.$resultados[2].'</td></tr>'.
						   				'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
										  '<td style="text-align: left; background: #A9D2F3">Glosa</td>'.
										  '<td colspan="5" style="text-align: left;">'.$resultados[3].'</td></tr>'.
						                '<tr style="color: #000; border: 1px solid #4ba6c0;">'.
										  '<td style="text-align: left; background: #A9D2F3">Referencia</td>'.
										  '<td colspan="5" style="text-align: left;">'.
						   					   '<a href="'.$href.'" target="_blank">'.$resultados[5].'</a></td></tr>'.
						   				'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
										  '<td colspan="6" style="text-align: center;">'.
						   					'<table style="width: 100%">'.
						     				'<tr style="background: #6BA7D6; color: #f6f6f6"><td>Línea</td>'.
						   						'<td>Cuenta</td>'.
						   						'<td>Descripción</td>'.
						   						'<td>Debe</td>'.
						   						'<td>Haber</td></tr>';
					 		//$idAsiento = $resultados[0];
				      }else{
					   
					   $tabla = $tabla.'<tr><td colspan="3" style="text-align: right; background: #6BA7D6;">SUMAN ----></td>'.
						   					'<td style="text-align: right; background: #6BA7D6;">'.
						   						number_format($montoDebe,2).'</td>'.
						                    '<td style="text-align: right; background: #6BA7D6;">'.
						   						number_format($montoHaber,2).'</td>'.
						   			   '</tr></table></td></tr>'.
						   			   '<tr style="color: #000; border: 1px solid #4ba6c0;">'.
										  '<td colspan="6" style="text-align: center; background: #A9D2F3">'.
						   					'<table style="width: 450px;">'.
						   						'<tr class="estilo3">'.
													'<td style="width: 150px;">'.
													  '<button class="botonAprobar" '.
						   									'onClick="abrirAutorizaAsiento('.$idAsiento.')">'.
						   									'Autorizar</button></td>'.
													'<td style="width: 150px;">'.
													  '<button class="botonModificar" '.
						   									'onClick="modificaAsiento('.$idAsiento.');">'.
						   									'Modificar</button></td>'.
													'<td style="width: 150px;">'.
													  '<button class="botonImprimir" '.
						   									'onClick="imprimeAsiento('.$idAsiento.')">'.
						   									'Imprimir</button></td>'.
												'</tr>'.
						   					'</table>'.
						   				  '</td></tr>'.
						   			   '<tr style="color: #000; border: 1px solid #4ba6c0;">'.
						 				  '<td colspan="6" style="text-align: center;"><br></td></tr>'.
						   			   '<tr style="color: #000; border: 1px solid #4ba6c0;">'.
										  '<td style="text-align: left; background: #A9D2F3">Número</td>'.
										  '<td style="text-align: center; font-weight:200">'.$resultados[0].'</td>'.
						   				  '<td style="text-align: left; background: #A9D2F3">Fecha</td>'.	
										  '<td style="text-align: center; font-weight:200">'.$resultados[1].'</td>'.
						                  '<td style="text-align: left; background: #A9D2F3">Descripcion</td>'.
						                  '<td style="text-align: left; font-weight:200">'.$resultados[2].'</td></tr>'.
						   				'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
										  '<td style="text-align: left; background: #A9D2F3">Glosa</td>'.
										  '<td colspan="5" style="text-align: left;">'.$resultados[3].'</td></tr>'.
						                '<tr style="color: #000; border: 1px solid #4ba6c0;">'.
										  '<td style="text-align: left; background: #A9D2F3">Referencia</td>'.
										  '<td colspan="5" style="text-align: left;">'.
						   					   '<a href="'.$href.'" target="_blank">'.$resultados[5].'</a></td></tr>'.
						   				'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
										  '<td colspan="6" style="text-align: center;">'.
						   					'<table style="width: 100%">'.
						     				'<tr style="background: #6BA7D6; color: #f6f6f6"><td>Línea</td>'.
						   						'<td>Cuenta</td>'.
						   						'<td>Descripción</td>'.
						   						'<td>Debe</td>'.
						   						'<td>Haber</td></tr>';
					  	
				      }
				  	$idAsiento = number_format($resultados[0]);
			      }
			
			  $tabla = $tabla.'<tr style="color: #000; margin: 0px; padding: 0px;" cellspacing="0">'.
				   				'<td style="text-align: center; border: 1px solid #4ba6c0;">'.$resultados[6].'</td>'.
								'<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[7].'</td>'.
				  				'<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.
				                     utf8_encode($resultados[8]).'</td>'.
				   				'<td style="text-align: right; border: 1px solid #4ba6c0;">'.number_format($resultados[9],2).'</td>'.
				                '<td style="text-align: right; border: 1px solid #4ba6c0;">'.number_format($resultados[10],2).'</td>'.
				  			  '</tr>';
			$montoDebe 	= $resultados[11];
    		$montoHaber = $resultados[12];
		}
	}	
	$tabla = $tabla.'<tr><td colspan="3" style="text-align: right; background: #6BA7D6;">SUMAN ----></td>'.
						'<td style="text-align: right; background: #6BA7D6;">'.
							 number_format($montoDebe,2).'</td>'.
						'<td style="text-align: right; background: #6BA7D6;">'.
							 number_format($montoHaber,2).'</td>'.
					 '</tr>'.
					 '<td colspan="6" style="text-align: center;background: #A9D2F3">'.
						'<table style="width: 450px;">'.
						   '<tr class="estilo3">'.
							 '<td style="width: 150px;">'.
								'<button class="botonAprobar" '.
						   			'onClick="abrirAutorizaAsiento('.$idAsiento.')">'.
						   			'Autorizar</button></td>'.
							 '<td style="width: 150px;">'.
								'<button class="botonModificar" '.
						   			'onClick="modificaAsiento('.$idAsiento.')">'.
						   			'Modificar</button></td>'.
							 '<td style="width: 150px;">'.
								 '<button class="botonImprimir" '.
						   			 'onClick="imprimeAsiento('.$idAsiento.')">'.
						   			 'Imprimir</button></td>'.
							'</tr>'.
						'</table>'.
						'</td></tr>';
	
	$options = array(0 => $tabla,
					 1 => number_format($cantidadIn,2),
					 2 => number_format($montoIn,2),
					 3 => number_format($cantidadOut,2),
					 4 => number_format($montoOut,2),
					 5 => number_format($cantidadSal,2),
					 6 => number_format($montoSal,2));

	echo json_encode($options);
	   
?>
