<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
        $subtotal = ($_POST['cantidadP']*$_POST['precioUni']);
		$total = ($_POST['previoVta']+$_POST['ivaLineaC']);
        $consulta = $db->consulta("insert into tsc_detalle_compra(".
								            "id_compra,id_secuencia,id_linea,id_producto,descripcion,cantidad,id_cuenta_contable,".
								            "precio_unitario,subtotal,descuento,iva,total,estado,fecha_registro) ".
								     "values('".$_POST['idFactura']."','".$_POST['idMovi']."','".$_POST['secuencia']."','".
								  				$_POST['codigoPro']."','".$_POST['descriPro']."','".$_POST['cantidadP']."','".
								  				$_POST['ctaContab']."','".$_POST['precioUni']."','".$subtotal."','".
								  				$_POST['descuento']."','".$_POST['ivaLineaC']."','".$total."','A',now());");
	
		$array = '';
		$array = array(0 => '0');
		        
		
		echo json_encode($array);
		
?>