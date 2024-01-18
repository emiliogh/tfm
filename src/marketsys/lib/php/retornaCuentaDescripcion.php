<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
   $query = "select ct.descripcion ".
			  "from tfn_cuentas_contables ct ".
			 "inner join tfn_cuentas_periodo pr ".
				"on pr.id_cuenta_contable = ct.id_cuenta ".
			 "inner join tfn_parametros rt ".
				"on pr.id_periodo = rt.id_periodo_vigente ".
	   		 "where ct.codigo = '".$_POST['id']."' ".
			 "order by 1 ";

	$descripcion = '';
    $existeCuenta = 0;
	$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
			if($numResul>0){
				while($resultados = $db->fetch_array($consulta)){
					  $descripcion = $resultados[0];
						$existeCuenta = 1;
				}
			}
	
	$options = array(0 => $existeCuenta,
					 1 => utf8_encode($descripcion));

	echo json_encode($options);
?>