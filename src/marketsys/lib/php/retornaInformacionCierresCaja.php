<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
    $var = $_POST['fechaDesde'];
		$date = str_replace('/', '-', $var);
			$fechaDesde = date('Y-m-d', strtotime($date));
  
	$var = $_POST['fechaHasta'];
		$date = str_replace('/', '-', $var);
			$fechaHasta = date('Y-m-d', strtotime($date));

   	$query = "select a.id_apertura,
				   	 DATE_FORMAT(a.fecha_apertura,'%d-%m-%Y') dia,
					 DATE_FORMAT(a.fecha_apertura,'%H:%i') haper,
					 DATE_FORMAT(a.fecha_cierre,'%d-%m-%Y') dia,
					 DATE_FORMAT(a.fecha_cierre,'%H:%i') hcierr,
					 a.total_apertura apertura, 
					 a.total_recaudado recaudado,
					 a.total_cierre monto
			    from tsc_aperturas_caja a
		       inner join tsc_facturas f
				  on f.fecha_registro between a.fecha_apertura and a.fecha_cierre
			   where a.id_establecimiento = ".$_POST['idEstablecimiento']." 
				 and a.id_punto_emision = ".$_POST['idPuntoEmision']." 
				 and a.id_personal = ".$_POST['idCajero']." 
				 -- and a.fecha_apertura 
				 and a.estado = 'C'
				 and date(a.fecha_apertura) between '".$fechaDesde."' and '".$fechaHasta."'
			 group by  a.id_apertura,
					   a.fecha_apertura,
					   a.fecha_cierre,
					   a.total_apertura, 
					   a.total_recaudado,
					   a.total_cierre;";


	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $tabla = '';
    $idAsiento 	= 0;
    $montoDebe 	= 0;
    $montoHaber = 0;
    
	 $tabla = $tabla.'<tr style="background: #6BA7D6; color: #f6f6f6">'.
						 '<td>Línea</td>'.
		                 '<td>Código</td>'.
						 '<td colspan="2">Apertura</td>'.
						 '<td colspan="2">Cierre</td>'.
		 				 '<td>Valor apertura</td>'.
		 				 '<td>Monto recaudado</td>'.
		                 '<td>Monto cierre</td>'.
						 '<td>Opciones</td></tr>';
  $i = 1;
  if($numResul>0){
	 while($resultados = $db->fetch_array($consulta)){
		   $tabla = $tabla.'<tr style="color: #000; margin: 0px; padding: 0px;" cellspacing="0">'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.$i.'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.
			   						str_pad($resultados[0],6,'0',STR_PAD_LEFT).'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[1].'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[2].'</td>'.
			                   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[3].'</td>'.
							   '<td style="text-align: left; border: 1px solid #4ba6c0; font-weight:200">'.$resultados[4].'</td>'.
							   '<td style="text-align: right; border: 1px solid #4ba6c0;">'.number_format($resultados[5],2).'</td>'.
							   '<td style="text-align: right; border: 1px solid #4ba6c0;">'.number_format($resultados[6],2).'</td>'.
			              	   '<td style="text-align: right; border: 1px solid #4ba6c0;">'.number_format($resultados[7],2).'</td>'.
							   '<td style="text-align: center; border: 1px solid #4ba6c0;">'.
			   					'<img src="../images/icons/imprimir.png" width="40px" alt="" '.
			   						'onclick="window.open('.chr(39).'../reports/cierreCajaSupervisor.php?id='.$resultados[0].
			   							'&cajero='.$_POST['idCajero'].''.chr(39).', '.chr(39).'_blank'.chr(39).');"/></td>'.
							'</tr>';
			   $i++;
		}
	}	

	$options = array(0 => $tabla,
					 1 => '');

	echo json_encode($options);
	   
?>
