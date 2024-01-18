<?php
	SESSION_START();
	include_once("../conexion/class.conexion.php");

	$db = new MySQL();
		$query = "select ifnull(max(id_retencion),0) ".
				   "from tsc_retenciones_facturas;";
	$array = '';
	$idRetencion = 0;	
	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
		if($numResul>0){
		   while($resultados = $db->fetch_array($consulta)){
			     $idRetencion = $resultados[0];
		   		 }
			}
			$idRetencion = $idRetencion + 1;
		
		$query = "insert into tsc_retenciones_facturas ".
						    "(id_retencion,id_tipo_documento,numero_documento,fecha_retencion,estado) ".
			          "values('".$idRetencion."',1,'".$_POST["idFactura"]."', now(), 'A');";
		$consulta = $db->consulta($query);

	$array = array(0 => $idRetencion);
	echo json_encode($array);

?>