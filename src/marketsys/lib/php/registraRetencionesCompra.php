<?php
    SESSION_START();
	include("../conexion/class.conexion.php"); 
	
	$db = new MySQL();
		$idEstablecimiento  = 0;
		$codEstablecimiento = 0;
		$idPuntoEmision     = 0;
		$codPuntoEmision    = 0;
		$secFactura 		= 0;
		$codigoFactura      = '';
		if ($_POST['idRetenc']==0){
			$consulta = $db->consulta("select e.id_establecimiento, ".
											 "e.codigo_establecimiento, ".
											 "p.id_punto_emision, ".
											 "p.codigo_punto, ".
											 "LPAD(p.secuencia,9,'0') ".  
										"from tsc_personal_punto_emision a ".
									   "inner join tsc_establecimientos e ".
										  "on e.id_establecimiento = a.id_establecimiento ".
										 "and e.id_tipo_establecimiento = 2 ".
									  "inner join tsc_puntos_emision p ".
										  "on p.id_establecimiento = a.id_establecimiento ".
										 "and p.id_punto_emision = a.id_punto_emision ".
									   "where a.id_personal = '".$_SESSION["idUsuario"]."' ".
										 "and a.estado = 'A'");
			
			if($db->num_rows($consulta)>0){
				while($resultados = $db->fetch_array($consulta)){
					  $idEstablecimiento  = $resultados[0];
					  $codEstablecimiento = $resultados[1];
					  $idPuntoEmision     = $resultados[2];
					  $codPuntoEmision    = $resultados[3];
					  $secFactura 		  = $resultados[4];
					  $codigoFactura      = $codEstablecimiento.'-'.$codPuntoEmision.'-'.$secFactura;
					  }
				}else if($db->num_rows($consulta)==0){
						 $array = array(0 => '-1');
						 echo json_encode($array);
						 return;}
			}

        $subtotal = ($_POST['cantidadP']*$_POST['precioUni']);
		$total = ($_POST['previoVta']+$_POST['ivaLineaC']);
        $consulta = $db->consulta("insert into tsc_retenciones_compras(".
								            "id_establecimiento,id_punto_emision,id_cajero,secuencia,codigo_retencion,autorizacion,". 
								            "fecha_emision,id_compra,estado,fecha_registro,monto_retencion) ".
								     "values('".$idEstablecimiento."','".$idPuntoEmision."','".$_SESSION["idUsuario"]."','".
								  				$secFactura."','".$codigoFactura."','',now(),'".$_POST['idFactura']."','A',now(),".
								                $_POST['montoRetencion'].");");
	
		$secuenciaRt = $secFactura+1;
		$consulta = $db->consulta("update tsc_puntos_emision ".
									 "set secuencia = '".$secuenciaRt."' ".
								   "where id_punto_emision = '".$idPuntoEmision."' ".
								     "and id_establecimiento = '".$idEstablecimiento."' ");	

		$array = '';
		$array = array(0 => $secFactura);
		        
		
		echo json_encode($array);
		
?>