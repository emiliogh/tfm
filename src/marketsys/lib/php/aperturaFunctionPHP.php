<?php
	

	function cargaDenominacion(){
		include("../../lib/conexion/class.conexion.php");
		$db = new MySQL();
		$query = "SELECT id_denominacion, definicion, valor_denominacion FROM tsc_denominaciones_moneda where estado = 'A' ORDER BY valor_denominacion, id_denominacion";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
    	if($numResul>0){
       		while($resultados = $db->fetch_array($consulta)){
				  echo '<tr><td class="clsEtiquetasTableUSD">'.$resultados[0].'</td>';
				  echo '<td class="clsEtiquetasTable">'.$resultados[1].'</td>';
				  echo '<td class="clsEtiquetasTableUSD"><span id="txtVDenominacion'.$resultados[0].'" name="txtVDenominacion'.$resultados[0].'" style="width: 100px; text-align: right;">'.$resultados[2].'</span></td>';
				  echo '<td class="clsObjetosTable"><input id="txtDenominacion'.$resultados[0].'" name="txtDenominacion'.$resultados[0].'" value="0" onChange="calcularApertura('.$resultados[0].');" style="width: 97%; text-align: right; height: 18px;"/></td>';
				  echo '<td class="clsEtiquetasTableUSD"><span id="txtTDenominacion'.$resultados[0].'" name="txtTDenominacion'.$resultados[0].'" style="width: 100px; text-align: right;">0.00</span></td></tr>';   
			}
		}		  
	}
	
	function cargaDenominacionCierre(){	
		include("../../lib/conexion/class.conexion.php");
		
		$db = new MySQL();
		$query = "select d.id_denominacion, d.definicion, d.valor_denominacion, a.cantidad cantidad,
						 DATE_FORMAT(ap.fecha_apertura,'%d-%m-%Y'), ap.total_apertura, DATE_FORMAT(ap.fecha_apertura,'%H:%i')
					from tsc_denominacion_apertura a
				   INNER JOIN tsc_denominaciones_moneda d
					  ON d.id_denominacion = a.id_denominacion
				   INNER JOIN tsc_aperturas_caja ap
					  ON ap.id_apertura = a.id_apertura
					 AND ap.id_establecimiento = a.id_establecimiento
					 AND ap.id_punto_emision = a.id_punto_emision
					 AND ap.id_personal = a.id_personal 
					 AND ap.estado = 'A'
				   INNER JOIN tas_usuarios us
					  ON us.id_personal = a.id_personal
					 AND us.estado = 'A'
				   WHERE us.usuario = '".$_SESSION["usuarioMS"]."'
					 AND a.estado = 'A'
				   ORDER BY 1;";
		
		//echo $query;	
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
    	if($numResul>0){
       		while($resultados = $db->fetch_array($consulta)){
				 $cta = $cta = $resultados[3];
				 $fecha = $resultados[4];
				 $hora = $resultados[6];
				 $ma = $resultados[5];
				  	echo '<tr><td class="clsEtiquetasTableUSD">'.$resultados[0].'</td>';
				  	echo '<td class="clsEtiquetasTable">'.$resultados[1].'</td>';
				  	echo '<td class="clsEtiquetasTableUSD"><span id="txtVDenominacion'.$resultados[0].'" name="txtVDenominacion'.$resultados[0].'" style="width: 100px; text-align: right;">'.$resultados[2].'</span></td>';
				  	echo '<td class="clsEtiquetasTableUSD"><span id="txtApertura'.$resultados[0].'" name="txtApertura'.$resultados[0].'" style="width: 100px; text-align: right;">'.$resultados[3].'</span></td>';
				  	echo '<td class="clsObjetosTable"><input id="txtDenominacion'.$resultados[0].'" name="txtDenominacion'.$resultados[0].'" value="0" onChange="calcularApertura('.$resultados[0].');" style="width: 97%; text-align: right; height: 18px;"/></td>';
				  	echo '<td class="clsEtiquetasTableUSD"><span id="txtTDenominacion'.$resultados[0].'" name="txtTDenominacion'.$resultados[0].'" style="width: 100px; text-align: right;">0.00</span></td></tr>';   
			}
				echo'</tbody><tfoot><tr>
						<td></td>
						<td colspan="2" class="tablaAperturaFood">
							<span style="width: 100px;">FECHA APERTURA:  '.$fecha.' '.$hora.'</span>		
						</td>
						<td class="tablaAperturaFood">
							<span style="width: 100px;">'.$ma.'</span>
						</td>
						<td></td>
							<td class="tablaAperturaFood">
								<span id="txtVTApertura" name="txtVTApertura" style="width: 100px;">0.00</span>		
							</td>
						</tr>
					</tfoot>';
		}
	}
?>
