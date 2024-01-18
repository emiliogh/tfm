<?php
SESSION_START();
include("../../lib/conexion/class.conexion.php");
try {
	   $db = new MySQL();
	   $query = "select ifnull(sum(p.monto_pago),0) monto,
						max(ap.id_apertura) id_apertura
				   from tsc_aperturas_caja ap
				  INNER JOIN tas_usuarios us
					 ON us.id_personal = ap.id_personal
					AND us.estado = 'A'
				   left JOIN tsc_pagos p
					 ON ap.id_personal = p.id_personal
					AND DATE_FORMAT(p.fecha_pago,'%d/%m/%Y') = DATE_FORMAT(now(),'%d/%m/%Y')
					AND p.estado = 'A' 
				  WHERE ap.estado = 'A'
					AND us.usuario = UPPER('".$_SESSION["usuarioMS"]."');";
			// echo $query;							
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $monto = $resultados["monto"];
				  $idApertura = $resultados["id_apertura"];
			}
		}
		
				
		$consulta = $db->consulta("update tsc_aperturas_caja
									  set fecha_cierre = now(),
										  estado = 'C',
										  total_cierre = coalesce($monto,0)+total_apertura,
										  total_recaudado = coalesce($monto,0)
									where estado = 'A'
									  and id_personal = ".$_POST["idPersonal"]."
									  and id_apertura = ".$idApertura."
									  and id_establecimiento = ".$_POST["idEstablecimiento"]."
                                      and id_punto_emision = ".$_POST["idPuntoEmision"].";");
	
	   $array = array(0 =>"Información de Cierre Caja de Recaudación. &&&&   Fecha: ".date('d/m/Y')." &&   Hora: ".date('h:i:s')." &&   Valor Cierre: ".$monto." USD.",
					  1 => 0,
					  2 => $idApertura);
	
	} catch (PDOException $e) {
		 $array = array(0 =>$e->getMessage(),
						1 =>10,
						2 => 0);
	}
	
	echo json_encode($array);

?>
