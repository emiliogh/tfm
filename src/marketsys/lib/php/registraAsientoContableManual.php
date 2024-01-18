<?php
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
	/*** Secuencia ***/
	$consulta = $db->consulta("select ifnull(max(id_asiento),0) from tfn_asiento_contable ");
		
	$idAsiento = 0;
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){
				  $idAsiento =  $resultados[0];
				  }
			}
	
	/*** Registro de Asiento Contable ***/
	$idAsiento = $idAsiento + 1;
	$consulta = $db->consulta("insert into tfn_asiento_contable (id_asiento,id_tipo_asiento,numero_documento,descripcion,glosa,".
							              "fecha_asiento,estado,monto_debe,monto_haber,estado_autorizacion) ".
							       "values(".$idAsiento.",'".$_POST['tipo']."','','".$_POST['desc']."','".$_POST['glos']."',".
							               "now(),'A','".$_POST['debe']."','".$_POST['habe']."','P');");

	$array = '';
	$array = array(0 => '0',
				   1 => $idAsiento);

	echo json_encode($array);
		
?>
