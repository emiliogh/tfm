<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();

   $var = $_POST['fechaDesde'];
		$date = str_replace('/', '-', $var);
			$fechaDesde = date('Y-m-d', strtotime($date));
  
	$var = $_POST['fechaHasta'];
		$date = str_replace('/', '-', $var);
			$fechaHasta = date('Y-m-d', strtotime($date));

   $query ="select f.id_factura,
				   f.numero_factura,
				   date_format(f.fecha_factura,'%d/%m/%Y'),
				   cl.nombre_cliente,
				   f.monto_subtotal,
				   f.monto_impuesto,
				   f.monto_total,
				   f.saldo_pendiente,
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
						 when f.estado_electronico = 'B' then '#D4AC0D' end
			  from tsc_facturas f
			 inner join tsc_detalles_factura df
				on f.id_factura = df.id_factura
			 inner join tcu_clientes cl
				on cl.id_cliente = f.id_cliente
			 Where f.fecha_factura between '".$fechaDesde."' and '".$fechaHasta."'
			   -- and f.estado = 'E'
			 group by f.id_factura,
					  f.numero_factura,
					  f.fecha_factura,
					  f.monto_subtotal,
					  f.monto_impuesto,
					  f.monto_total,
					  f.saldo_pendiente,
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
						 '<td>Factura</td>'.
						 '<td>Fecha</td>'.
						 '<td>Cliente</td>'.
		 				 '<td>Total</td>'.
		 				 '<td>Saldo</td>'.
						 '<td colspan="4">Información Electrónica</td></tr>';
  $i = 1;
  if($numResul>0){
	 while($resultados = $db->fetch_array($consulta)){
		   $tabla = $tabla.'<tr style="color: #000; margin: 0px; padding: 0px;" cellspacing="0">'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.$i.'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[1].'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[2].'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.utf8_encode($resultados[3]).'</td>'.
							   '<td style="text-align: right; border: 1px solid #4ba6c0;">'.number_format($resultados[6],2).'</td>'.
							   '<td style="text-align: right; border: 1px solid #4ba6c0;">'.number_format($resultados[7],2).'</td>'.
							   '<td style="text-align: LEFT; border: 1px solid #4ba6c0;color: '.$resultados[11].' ">'.$resultados[8].'</td>'.
			                   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   					'<button type="button" style="width: 100%;" onclick="observacionItem('.chr(39).$resultados[0].chr(39).');">'.
			   						'<img src="../images/icons/iconoObservacion.png" style="height: 18px;" alt=""></button></td>'.
			   				   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   				   '<img src="../images/icons/pdf.png" width="40px" alt="" '.
			   						'onclick="window.open('.chr(39).'../reports/facturaPDF.php?idfactura='.$resultados[0].chr(39).', '.
			   						chr(39).'_blank'.chr(39).');"/></td>'.
			                   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   				   '<img src="../images/icons/xml.png" width="40px" alt="" '.
			   						'onclick="window.open('.chr(39).'../facturaElectronica/generados/'.$resultados[10].chr(39).', '.
			   						chr(39).'_blank'.chr(39).');"/></td>'. 
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   					 '<img src="../images/icons/sri.png" width="40px" alt="" '.
			   						'onClick="registraFacturaElectronica('.$resultados[0].')"/></td>'.
			   					'<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   					 '<img src="../images/icons/email.png" width="40px" alt="" '.
			   						'onClick="alert('.$resultados[0].')"/></td>'.
							'</tr>';
			   $i++;
		}
	}	

	$options = array(0 => ($tabla),
					 1 => '');

	echo json_encode($options);
	   
?>
