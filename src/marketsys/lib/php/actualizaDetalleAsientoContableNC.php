<?php
 include_once("../conexion/class.conexion.php");

  $db = new MySQL();
    $qry = "select id_cuenta ".
		     "from tfn_cuentas_contables ct ".
		    "where codigo = '".$_POST['codigoCuenta']."' ";
	
	//echo $qry; 
	$idCuenta = 0;
	$consulta = $db->consulta($qry);
	$numResul = $db->num_rows($consulta);
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){
			$idCuenta = $resultados[0];
		}
	 }

	$qry = "select id_tipo_transaccion, numero_documento, id_transaccion ".
		     "from tfn_detalle_asiento_contable da ".
		    "where id_asiento  		= '".$_POST['id']."' ".
	   		  "and linea_asiento  	= '".$_POST['idLinea']."' ".
		      "and estado  			= 'A' ";
	
	
	$verificaExiste = 0;
    $idTipoTransaccion   = 0;
    $numeroDocumento 	 = 0;
    $idTransaccion       = 0;
	$consulta = $db->consulta($qry);
	$numResul = $db->num_rows($consulta);	
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){
			  $idTipoTransaccion  = $resultados[0];
    		  $numeroDocumento 	  = $resultados[1];
    		  $idTransaccion      = $resultados[2];
		}
	 }
	
	$ins = "insert into tfn_detalle_asiento_contable (id_asiento,linea_asiento,id_cuenta,id_tipo_transaccion,".
						"numero_documento,id_transaccion,monto_debe,monto_haber,estado,fecha_detalle) values('".
						$_POST['id']."','".$_POST['idLinea']."','".$idCuenta."','".$idTipoTransaccion."','".
						$numeroDocumento."','".$idTransaccion."','".$_POST['valorDebe']."','".$_POST['valorHaber']."','A',now());";
				$consulta = $db->consulta($ins);

	$options = array(0 => '0');
		echo json_encode($options);
?>