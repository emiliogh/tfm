<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
    $var = $_POST['fechaDesde'];
		$date = str_replace('/', '-', $var);
			$fechaDesde = date('Y-m-d', strtotime($date));
  
	$var = $_POST['fechaHasta'];
		$date = str_replace('/', '-', $var);
			$fechaHasta = date('Y-m-d', strtotime($date));

   $query = "select f.id_compra,
				   concat(f.establecimiento,'-',f.punto_emision,'-',f.numero_factura),
				   fecha_compra,
				   cl.nombre_proveedor,
				   f.monto_subtotal,
				   f.monto_subtotal12,
				   f.monto_total,
				   f.saldo_pendiente,
				   case when f.tipo_factura = 1 then 'ELECT.' else 'MANUAL' end,
				   f.archivo_pdf,
				   r.codigo_retencion,
                   r.monto_retencion,
                   DATE_FORMAT(r.fecha_registro,'%d/%m/%Y'),
			       ifnull(r.secuencia,0)			
			  from tsc_compras f
			 inner join tsc_detalle_compra df
				on f.id_compra = df.id_compra
			 inner join tsc_proveedores cl
				on cl.id_proveedor = f.id_proveedor
			 left join tsc_retenciones_compras r
               on r.id_compra = f.id_compra	
			 where STR_TO_DATE(f.fecha_compra,'%d/%m/%Y') between '".$fechaDesde."' and '".$fechaHasta."'
			 group by f.id_compra,
					  concat(f.establecimiento,'-',f.punto_emision,'-',f.numero_factura),
					  fecha_compra,
					  f.monto_subtotal,
					  f.monto_impuesto,
					  f.monto_total,
					  f.saldo_pendiente,
					  case when f.tipo_factura = 1 then 'ELECT.' else 'MANUAL' end,
				      f.archivo_pdf,
					  r.codigo_retencion,
                      r.monto_retencion,
                      r.fecha_registro,
					  r.secuencia";


	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $tabla = '';
    $idAsiento 	= 0;
    $montoDebe 	= 0;
    $montoHaber = 0;
    
	 $tabla = $tabla.'<tr style="background: #6BA7D6; color: #f6f6f6">'.
						 '<td>Línea</td>'.
						 '<td>Factura</td>'.
						 '<td>Factura</td>'.
						 '<td>Fecha</td>'.
						 '<td>Cliente</td>'.
		 				 '<td>Total</td>'.
		 				 '<td>Saldo</td>'.
						 '<td>PDF Compra</td>'.
						 '<td>Retención</td>'.
						 '<td>Monto</td>'.
						 '<td>Fecha</td>'.
						 '<td colspan="2">PDF Retención</td></tr>';
  $i = 1;
  if($numResul>0){
	 while($resultados = $db->fetch_array($consulta)){
		   $tabla = $tabla.'<tr style="color: #000; margin: 0px; padding: 0px;" cellspacing="0">'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.$i.'</td>'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.$resultados[8].'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[1].'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[2].'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[3].'</td>'.
							   '<td style="text-align: right; border: 1px solid #4ba6c0;">'.number_format($resultados[6],2).'</td>'.
							   '<td style="text-align: right; border: 1px solid #4ba6c0;">'.number_format($resultados[7],2).'</td>'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   					'<img src="../images/icons/pdf.png" width="40px" alt="" '.
			   						'onclick="window.open('.chr(39).'../respaldos_compras/pdf/'.$resultados[9].''.chr(39).', '.
			   						chr(39).'_blank'.chr(39).');"/></td>'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.$resultados[10].'</td>'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.$resultados[11].'</td>'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.$resultados[12].'</td>'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
							   ($resultados[13]<'1'?'':'<img src="../images/icons/pdf.png" width="40px" alt="" '.
			   						'onclick="window.open('.chr(39).'../reports/retencionPDF.php?id='.$resultados[13].''.chr(39).', '.
			   						chr(39).'_blank'.chr(39).');"/>').'</td>'.
							'</tr>';
			   $i++;
		}
	}	

	$options = array(0 => $tabla,
					 1 => '');

	echo json_encode($options);
	   
?>
