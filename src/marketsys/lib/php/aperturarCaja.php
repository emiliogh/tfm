<?php
SESSION_START();

include_once("../conexion/class.conexion.php");
try {
	   $db = new MySQL();
	
	   $options = array();
	   $query = "SELECT count(*),'x' ".
		   		  "FROM tsc_personal_punto_emision f ".
		         "inner join tsc_establecimientos e ".
					"on e.id_establecimiento = f.id_establecimiento ".
				   "and e.id_tipo_establecimiento = 1 ".   
		   		 "WHERE f.id_personal = ".$_SESSION["idUsuario"]." ".
				   "AND f.estado = 'A' ".
				   "AND now() BETWEEN f.inicio_acceso AND f.finalizacion_acceso;";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
	    $permisosPunto = 0;
    	if($numResul>0){
		   while($resultados = $db->fetch_array($consulta)){
			     $permisosPunto = $resultados[0]; 
		   		}
			}
			if (is_null($permisosPunto))
			   {$array = array(0 =>"Usted no cuenta con permisos vigentes. Comuniquese con su administrador.",
							   1 => 1,
							   2 => 0);
				echo json_encode($array);
				return;}
				else {if ($permisosPunto == 0)
					 {$array = array(0 =>"Usted no cuenta con permisos vigentes. Comuniquese con su administrador.",
									 1 => 1,
									 2 => 0);
									 echo json_encode($array);
									 return;}
									 else{if ($permisosPunto > 1)
										 {$array = array(0 =>"Sus permisos vigentes no estan correctos. Comuniquese con su administrador.",
													     1 => 1,
														 2 => 0);
														 echo json_encode($array);
														 return;}
										   }
										 }	
															 
	   $sqlQryApertura = "select a.id_apertura, a.estado, a.fecha_apertura ".
		             	   "from tsc_aperturas_caja a ".
		                  "inner join tsc_establecimientos e ".
							 "on e.id_establecimiento = a.id_establecimiento ".
							"and e.id_tipo_establecimiento = 1 ".   
		   				  "where a.id_establecimiento=".$_POST["idEstablecimiento"]." ".
		   					"and a.id_punto_emision = ".$_POST["idPuntoEmision"]." ".
		   					"and a.id_personal = ".$_POST["idPersonal"]." ".
		   					"and a.id_apertura IN (select max(s.id_apertura) ".
		   										    "from tsc_aperturas_caja s ".
		   										   "inner join tsc_establecimientos e ".
								                      "on e.id_establecimiento = s.id_establecimiento ".
								                     "and e.id_tipo_establecimiento = 1 ".	
		   										   "where s.id_establecimiento=".$_POST["idEstablecimiento"]." ".
		   										     "and s.id_punto_emision = ".$_POST["idPuntoEmision"]." ".
		   										     "and s.id_personal = ".$_POST["idPersonal"].");";
	   //echo $sqlQryApertura;
	   $idApertura = 0;
	   $estadoApertura = '';
	
	   $consulta = $db->consulta($sqlQryApertura);
	   $numResul = $db->num_rows($consulta);
	   $permisosPunto = 0;
    	if($numResul>0){
		   while($resultados = $db->fetch_array($consulta)){
			     $idApertura = $resultados[0];
				 $estadoApertura = $resultados[1];
				 $fechaApertura = $resultados[2];
			     
			     
			     if ($fechaApertura == date('Y-m-d') AND $estadoApertura =='A')
				    {$array = array(0 =>"Usted cuenta con una apertura de caja el día de hoy,  por favor revisar.",
									1 => 1,
									2 => 0);
				 					echo json_encode($array);
				 					return;}
			   
				 if ($fechaApertura != date('Y-m-d') AND $estadoApertura =='A')
					{$array = array(0 =>"Usted tiene una apertura pendiente con fecha: ".$fechaApertura.
										", por favor revisar y realizar el cierre de respectivo.",
									1 => 1,
									2 => 0);
				 					echo json_encode($array);
				 					return;}
				 
			}
			if ($idApertura == null)
				{$idApertura = 0;}
			}

		$idApertura = $idApertura + 1;
		$sqlAperturaCaja="insert into tsc_aperturas_caja (id_establecimiento, id_punto_emision, id_personal, fecha_apertura, ".
							"estado, total_apertura, total_recaudado, total_cierre, id_apertura)".
			         "VALUES(".$_POST["idEstablecimiento"].",".$_POST["idPuntoEmision"].",".
			                  $_POST["idPersonal"].",now(),'A','".$_POST["apertura"]."',0,'".$_POST["apertura"]."',".$idApertura.");";

		$consultaInsert = $db->consulta($sqlAperturaCaja);
		$array = array(0 =>"Información de Apertura Caja de Recaudación. &&&&   Fecha: ".
					   date('d/m/Y')." &&   Hora: ".date('h:i:s')." &&   Valor Apertura: ".
					   $_POST["apertura"]." USD.",
					   1 => 0,
					   2 => $idApertura);
	   
	
	} catch (PDOException $e) {
		 $array = array(0 =>$e->getMessage(),
						1 =>10,
						2 => 0);
	}
	
	echo json_encode($array);
?>
