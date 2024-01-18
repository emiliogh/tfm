<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		$consulta = $db->consulta("insert into tsc_detalle_proforma (id_proforma,id_linea_proforma,id_producto,descripcion_rubro,costo,cantidad,".
								                        			"precio_venta,subtotal,descuento,total,estado) ".
								         "values('".$_POST['idFactura']."','".$_POST['idMovi']."','".$_POST['idItem']."','".
								  					$_POST['dsItem']."','".$_POST['costoA']."','".$_POST['cantiM']."','".
								  					$_POST['costoM']."','".$_POST['totalM']."',0,'".$_POST['totalM']."','A');");
		$array = '';
		$array = array(0 => '0');
		        
		
		echo json_encode($array);
		
?>