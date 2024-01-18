<?php
	SESSION_START();
	
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		$consulta = $db->consulta("select ifnull(max(id_proforma),0) from tsc_proformas ");
		
		$idProforma = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idProforma =  $resultados[0];
				  }
			}
		$idProforma = $idProforma + 1;
		$consulta = $db->consulta("insert into tsc_proformas (id_proforma,id_cliente,descripcion,fecha_proforma,id_usuario,estado,fecha_validez,".
								                              "monto_subtotal,monto_iva_0,monto_iva_12,porcentaje_iva,monto_iva,monto_total) ".
								         "values('".$idProforma."','".$_POST['idCliente']."','".$_POST['descripcion']."',now(),'".
								                    $_SESSION["idUsuario"]."','A',INTERVAL 15 DAY + now(),'".$_POST['txtSubtotalVenta']."','".
								  					$_POST['txtVTotalIVA0']."','".$_POST['txtVTotalIVA12']."','".$_POST['iVAPorcentaje']."','".
								  					$_POST['txtTotalIVA12']."','".$_POST['txtTotalVenta']."');");
		
		$array = '';
		$array = array(0 => $idProforma);
		        
		
		echo json_encode($array);
		
?>