<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
        $descuentoValor = ($_POST['costoM']*$_POST['porcDes']/100)*$_POST['cantiM'];

		$pvp = 0;
		if ($_POST['costoM'] == 0){
			$pvp = ($_POST['subTotalM']/$_POST['cantiM']);
		}else{$pvp = $_POST['costoM'];}


		$consulta = $db->consulta("insert into tsc_detalles_factura(".
								                  "id_factura,linea_factura,id_rubro,descripcion_rubro,costo,cantidad,".
								                  "precio_venta,subtotal,id_promocion,promocion,precio_promocion,".
												  "cantidad_promocion,cantidad_sin_promocion,descuento,porcentaje_descuento,".
								  				  "total,estado, id_producto) ".
								         "values('".$_POST['idFactura']."','".$_POST['idMovi']."','".$_POST['idItem']."','".
								  					$_POST['dsItem']."','".$_POST['costoA']."','".$_POST['cantiM']."','".
								  					$pvp."','".$_POST['subTotalM']."','".$_POST['idProm']."','".
								  					$_POST['dsProm']."','".$_POST['prProm']."','".$_POST['ccProm']."','".
								  					$_POST['csProm']."','".$descuentoValor."','".$_POST['porcDes']."','".
								  					$_POST['TotalM']."','A','".$_POST['idItem']."');");
	


		$array = '';
		$array = array(0 => '0');
		        
		
		echo json_encode($array);
		
?>