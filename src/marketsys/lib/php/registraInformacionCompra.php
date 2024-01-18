<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		$consulta = $db->consulta("select count(*) ".
									    "from tsc_informacion_rubros_compra ".
									   "where id_proveedor = '".$_POST['idProveedor']."' ".
								         "and id_rubro = '".$_POST['codigoPro']."';");
		
			if($db->num_rows($consulta)>=0){
				while($resultados = $db->fetch_array($consulta)){
					  $idEProveedor =  $resultados[0];
					  }
				}

        $consulta = $db->consulta("insert into tsc_informacion_rubros_compra(".
								            "id_proveedor,id_rubro,id_cuenta_contable,id_retencion_iva,id_retencion_renta,".
								            "estado,fecha_registro) ".
								     "values('".$_POST['idProveedor']."','".$_POST['codigoPro']."','".$_POST['idCuenta']."','".
								  				$_POST['retenIVA']."','".$_POST['retenRet']."','A',now());");

		$array = '';
		$array = array(0 => '0');
		        
		
		echo json_encode($array);
		
?>