<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		
        $consulta = $db->consulta("insert into tsc_detalle_retenciones_compras(".
								            "codigo_retencion,id_linea,id_producto,id_tipo_retencion,id_codigo_retencion,".
								            "base_imponible,valor_retencion,estado,registro) ".
								     "values('".$_POST['idFactura']."','".$_POST['idMovi']."','".$_POST['codigoPro']."','".
								  				$_POST['tipoRet']."','".$_POST['retenRet']."','".$_POST['baseRet']."','".
								  				$_POST['valorRet']."','A',now());");
	
		$array = '';
		$array = array(0 => '0');
		        
		
		echo json_encode($array);
		
?>