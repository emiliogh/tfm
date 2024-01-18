<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
    $var = $_POST['fechaDesde'];
		$date = str_replace('/', '-', $var);
			$fechaDesde = date('Y-m-d', strtotime($date));
  
	$var = $_POST['fechaHasta'];
		$date = str_replace('/', '-', $var);
			$fechaHasta = date('Y-m-d', strtotime($date));

   	if($_POST['id'] == 0){
	  $query = "select DATE_FORMAT(f.fecha_factura,'%d-%m-%Y'), 
					   sum(f.monto_subtotal) subtotal,
					   sum(f.monto_impuesto) iva,
					   sum(f.monto_total)    total
				  from tsc_facturas f
				 where f.fecha_factura between '".$fechaDesde."' and '".$fechaHasta."'
				   and exists (select * 
								 from tsc_detalles_factura d
								where f.id_factura = d.id_factura)
				 group by f.fecha_factura
				 order by f.fecha_factura";
		
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);

		$rows = array();
		$fFact = array();
		$subTo = array();
		$mnIVA = array();
		$total = array();
		$acMon = 0;
		$i = 0;
	  if($numResul>0){
		 while($resultados = $db->fetch_array($consulta)){
			   $rows[] = array_map('utf8_encode',$resultados);
			   $fFact[$i] = $resultados[0];
			   $subTo[$i] = $resultados[1];
			   $mnIVA[$i] = $resultados[2];
			   $total[$i] = $resultados[3];
			   $acMon = $acMon + $resultados[3];
			   $i++;
			}
		}	
		
		 $consulta = $db->consulta("select count(distinct(i.id_producto))
									  from tsc_facturas f
									 inner join tsc_detalles_factura d
										on f.id_factura = d.id_factura
									 inner join tiv_items i
										on i.id_item = d.id_rubro
									 where f.fecha_factura between '".$fechaDesde."' and '".$fechaHasta."'");
	
		$numProductos = 0;
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
		  while($resultados = $db->fetch_array($consulta)){ 
			$numProductos = $resultados[0];
		 }
		}
		
		$consulta = $db->consulta("select count(distinct(i.id_item))
									  from tsc_facturas f
									 inner join tsc_detalles_factura d
										on f.id_factura = d.id_factura
									 inner join tiv_items i
										on i.id_item = d.id_rubro
									 where f.fecha_factura between '".$fechaDesde."' and '".$fechaHasta."'");
	
		$numItems = 0;
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
		  while($resultados = $db->fetch_array($consulta)){ 
			$numItems = $resultados[0];
		 }
		}
		
		$consulta = $db->consulta("select count(distinct(f.id_forma_pago)), DATE_FORMAT(now(),'%d-%m-%Y %H:%i')
									  from tsc_facturas f
									 inner join tsc_detalles_factura d
										on f.id_factura = d.id_factura
									 inner join tiv_items i
										on i.id_item = d.id_rubro
									 where f.fecha_factura between '".$fechaDesde."' and '".$fechaHasta."'");
	
		$numFormaPago = 0;
		$generacion   = '';
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
		  while($resultados = $db->fetch_array($consulta)){ 
			$numFormaPago = $resultados[0];
			$generacion   = $resultados[1];   
		 }
		}
		
		$options = array(0 => $rows,
						 1 => $fFact,
						 2 => $subTo,
						 3 => $mnIVA,
						 4 => $total,
						 5 => $i,
						 6 => number_format($acMon,2),
						 7 => $numProductos,
						 8 => $numItems,
						 9 => $numFormaPago,
						10 => $generacion);
	}

	echo json_encode($options);
	   
?>
