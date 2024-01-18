<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		$id_cuenta_contable = '0';
			$id_retencion_iva = '0';
				$id_retencion_renta = '0';
					$cuenta_contable = '';

		$consulta = $db->consulta("select i.id_cuenta_contable,i.id_retencion_iva,i.id_retencion_renta, ".
								         "CONCAT('[',c.codigo,'] ',c.descripcion) ".
									"from tsc_informacion_rubros_compra i ".
								   "inner join tfn_cuentas_contables c ".
								      "on c.id_cuenta = i.id_cuenta_contable ".
								   "where i.id_proveedor = '".$_POST['idcl']."' ".
							         "and i.id_rubro = '".$_POST['idpr']."' limit 1;");
		
			if($db->num_rows($consulta)>=0){
				while($resultados = $db->fetch_array($consulta)){
					 $id_cuenta_contable = $resultados[0];
						$id_retencion_iva = $resultados[1];
							$id_retencion_renta = $resultados[2];
								$cuenta_contable = $resultados[3];
					  }
				}

        
		$array = '';
		$array = array(0 => $id_cuenta_contable,
					   1 => $id_retencion_iva,
					   2 => $id_retencion_renta,
					   3 => utf8_encode($cuenta_contable));
		        
		
		echo json_encode($array);
		
?>