<?php

	SESSION_START();
	include_once("../conexion/class.conexion.php");

	$db = new MySQL();

   	$var = $_POST['fechaDesde'];
		$date = str_replace('/', '-', $var);
			$fechaDesde = date('Y-m-d', strtotime($date));
  
	$var = $_POST['fechaHasta'];
		$date = str_replace('/', '-', $var);
			$fechaHasta = date('Y-m-d', strtotime($date));

   $query ="select f.secuencia,
				   f.codigo_retencion,
				   date_format(f.fecha_emision,'%d/%m/%Y'),
				   cl.nombre_proveedor,
				   f.monto_retencion,f.secuencia,0,0,
				   case when f.estado_electronico = 'G' then 'GENERADO'
				        when f.estado_electronico = 'R' then 'RECHAZADO'
						when f.estado_electronico = 'A' then 'AUTORIZADO'
						when f.estado_electronico = 'E' then 'EMITIDO'
						when f.estado_electronico = 'B' then 'DEVUELTO' end,
					f.log_transaccional,
					f.xml_nombre,
					case when f.estado_electronico = 'G' then '#6077AA'
				         when f.estado_electronico = 'R' then '#E67E22'
						 when f.estado_electronico = 'A' then '#27AE60'
						 when f.estado_electronico = 'E' then '#C0392B'
						 when f.estado_electronico = 'B' then '#D4AC0D' end,
					c.id_compra, f.secuencia 	 
			   from tsc_retenciones_compras f
			  inner join tsc_detalle_retenciones_compras df
			 	 on f.secuencia= df.codigo_retencion
              inner join tsc_compras c
                 on c.id_compra = f.id_compra
			  inner join tsc_proveedores cl
				 on cl.id_proveedor = c.id_proveedor
			  Where f.fecha_emision between '".$fechaDesde."' and '".$fechaHasta."'	
			  group by f.secuencia,
					   f.codigo_retencion,
					   f.fecha_emision,
					   f.monto_retencion,
					   case when f.estado_electronico = 'G' then 'GENERADO'
						    when f.estado_electronico = 'R' then 'RECHAZADO'
						    when f.estado_electronico = 'A' then 'AUTORIZADO'
						    when f.estado_electronico = 'E' then 'EMITIDO'
						    when f.estado_electronico = 'B' then 'DEVUELTO' end,
					   f.log_transaccional,
					   f.xml_nombre,
					   case when f.estado_electronico = 'G' then '#6077AA'
				            when f.estado_electronico = 'R' then '#E67E22'
						    when f.estado_electronico = 'A' then '#27AE60'
						    when f.estado_electronico = 'E' then '#C0392B'
						    when f.estado_electronico = 'B' then '#D4AC0D' end ";


	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $tabla = '';
    $idAsiento 	= 0;
    $montoDebe 	= 0;
    $montoHaber = 0;
    
	 $tabla = $tabla.'<tr style="background: #6BA7D6; color: #f6f6f6">'.
						 '<td>Línea</td>'.
						 '<td>Retención</td>'.
						 '<td>Fecha</td>'.
						 '<td>Cliente</td>'.
		 				 '<td>Total</td>'.
		 				 '<td colspan="4">Información Electrónica</td></tr>';
  $i = 1;
  if($numResul>0){
	 while($resultados = $db->fetch_array($consulta)){
		   $tabla = $tabla.'<tr style="color: #000; margin: 0px; padding: 0px;" cellspacing="0">'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.$i.'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[1].'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[2].'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.($resultados[3]).'</td>'.
							   '<td style="text-align: right; border: 1px solid #4ba6c0;">'.number_format($resultados[4],2).'</td>'.
							   '<td style="text-align: LEFT; border: 1px solid #4ba6c0;color: '.$resultados[11].' ">'.$resultados[8].'</td>'.
			                   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   					'<button type="button" style="width: 100%;" onclick="observacionItem('.chr(39).$resultados[5].chr(39).');">'.
			   						'<img src="../images/icons/iconoObservacion.png" style="height: 18px;" alt=""></button></td>'.
			   				   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   				   '<img src="../images/icons/pdf.png" width="40px" alt="" '.
			   						'onclick="window.open('.chr(39).'../reports/retencionPDF.php?id='.$resultados[5].chr(39).', '.
			   						chr(39).'_blank'.chr(39).');"/></td>'.
			                   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   				   '<img src="../images/icons/xml.png" width="40px" alt="" '.
			   						'onclick="window.open('.chr(39).'../facturaElectronica/generados/'.$resultados[10].chr(39).', '.
			   						chr(39).'_blank'.chr(39).');"/></td>'. 
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   					 '<img src="../images/icons/sri.png" width="40px" alt="" '.
			   						'onClick="registraRetencionElectronica('.$resultados[12].')"/></td>'.
			   					'<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   					 '<img src="../images/icons/email.png" width="40px" alt="" '.
			   						'onClick="alert('.$resultados[5].')"/></td>'.
							'</tr>';
			   $i++;
		}
	}	

	$options = array(0 => ($tabla).$fechaHasta,
					 1 => '');

	echo json_encode($options);
	   
?>
