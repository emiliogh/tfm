<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
   $query = "select LPAD(a.id_asiento,6,'0'), ".
				   "date_format(a.fecha_asiento,'%d-%m-%Y %h:%i'), ".
				   "a.descripcion, ".
				   "a.glosa, ".
				   "a.id_tipo_asiento, ".
				   "LPAD(a.numero_documento,8,'0'), ".
				   "da.linea_asiento, ".
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
	    	 "where a.id_asiento = '".$_POST['id']."' ".
			 "order by a.id_asiento,da.linea_asiento";

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	$idAsiento = 0;
	$montoDebe = 0;
    $montoHaber = 0;
    $i = 1;
    if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){
			  if ($idAsiento == 0){
				  $tabla = $tabla.'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
									 '<td style="text-align: left; background: #A9D2F3"><b>'.utf8_decode('Número').'</b></td>'.
									 '<td style="text-align: center; font-weight:200">'.
					  					'<span id="idAsiento">'.($resultados[0]).'</span></td>'.
									 '<td style="text-align: left; background: #A9D2F3"><b>Fecha</b></td>'.	
									 '<td style="text-align: center; font-weight:200">'.($resultados[1]).'</td>'.
									 '<td style="text-align: left; background: #A9D2F3"><b>Descripcion</b></td>'.
									 '<td style="text-align: left; font-weight:200">'.
					  					'<input id="dscAsiento" style="width: 100%;" value="'.($resultados[2]).
					  					'"/></td></tr>'.
								  '<tr style="color: #000; border: 1px solid #4ba6c0;">'.
									 '<td style="text-align: left; background: #A9D2F3"><b>Glosa</b></td>'.
									 '<td colspan="5" style="text-align: left;">'.
					  					'<input id="glsAsiento" style="width: 100%;" value="'.utf8_decode($resultados[3]).
					  					'"/></td></tr>'.
								  '<tr style="color: #000; border: 1px solid #4ba6c0;">'.
									 '<td colspan="6" style="text-align: center;">'.
										 '<table id="tablaAsientoDetalles" style="width: 100%">'.
											 '<tr style="background: #6BA7D6; color: #f6f6f6">'.
					  							 '<td style="width: 5%;"><b>Línea<b></td>'.
												 '<td style="width: 15%;"><b>Cuenta</b></td>'.
												 '<td style="width: 50%;"><b>Descripción</b></td>'.
												 '<td style="width: 12%;"><b>Debe</b></td>'.
												 '<td style="width: 12%;"><b>Haber</b></td>'.
					  							 '<td colspan="2" style="width: 6%;"></td></tr>';
			   				
							$montoDebe = $resultados[11];
    						$montoHaber = $resultados[12];
							$idAsiento = 1;					
			   				}
			
			   $tabla = $tabla.'<tr style="color: #000; margin: 0px;">'.
				   				'<td style="text-align: center; border: 1px solid #4ba6c0;">'.
				   					$i.'</td>'.
								'<td style="text-align: left; border: 1px solid #4ba6c0;">'.
				   					'<input id="sp2'.$i.'" value="'.($resultados[7]).'" '.
				   					 	'style="width: 100%" onChange="cambioCuenta('.chr(39).$i.chr(39).');"/></td>'.
				  				'<td style="text-align: left; border: 1px solid #4ba6c0;">'.
				   					'<span id="sp3'.$i.'">'.$resultados[8].'</span></td>'.
				   				'<td style="text-align: right; border: 1px solid #4ba6c0;">'.
				   					'<input id="sp4'.$i.'" value="'.number_format($resultados[9],2).'" '.
				   						'style="width: 100%; text-align: right;" onChange="calculaDebe('.
				   							chr(39).$i.chr(39).');"/></td>'.
				                '<td style="text-align: right; border: 1px solid #4ba6c0;">'.
				   					'<input id="sp5'.$i.'" value="'.number_format($resultados[10],2).'" '.
				   						'style="width: 100%; text-align: right;" onChange="calculaHaber('.
				   							chr(39).$i.chr(39).');"/></td>'.
				   			    '<td><img onClick="eliminarLineaAsiento(this)" '.
				   					'src="../images/icons/eliminarLinea.png" height="20"></td>'.
				  			  '</tr>';
			$i++;
		}
	}

	$tabla = $tabla.'<tr><td colspan="3" style="text-align: right; background: #6BA7D6;"><b>SUMAN ----></b></td>'.
						'<td style="text-align: right; background: #6BA7D6;"><b>'.
						  '<input id="mtDbAsiento" style="width: 100%; text-align: right" value="'.
							number_format($montoDebe,2).'"/></b></td>'.
						'<td style="text-align: right; background: #6BA7D6;"><b>'.
						  '<input id="mtHbAsiento" style="width: 100%; text-align: right"" value="'.
							number_format($montoHaber,2).'"/></b></td>'.
					 '</tr></table></td></tr>';
	
	$options = array(0 => utf8_encode($tabla));

	echo json_encode($options);
	   
?>
