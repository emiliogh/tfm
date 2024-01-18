<?php

include("../conexion/class.conexion.php");
$db = new MySQL();

try
{
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tsc_personal_punto_emision ".
			        "where id_establecimiento = '".$_COOKIE["idEstablecimiento"]."' ".
			          "AND id_punto_emision = '".$_COOKIE["idPuntoEmision"]."' ".
					  "AND id_personal = '".$_COOKIE["idPersonal"]."' ORDER BY id_personal ASC";	
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $rows[] = array_map('utf8_encode',$resultados);					 
			}
		}else{
			
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	else if($_GET["action"] == "create")
	{
		$query = "SELECT ifnull(max(secuencia),0)+1 FROM tsc_personal_punto_emision ".
			      "where id_establecimiento = '".$_COOKIE["idEstablecimiento"]."' ".
			        "AND id_punto_emision = '".$_COOKIE["idPuntoEmision"]."' ".
			        "AND id_personal = '".$_COOKIE["idPersonal"]."'";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		$idSecuencia = 0;
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $idSecuencia = $resultados[0];					 
			}
		}
		$query = "UPDATE tsc_personal_punto_emision ".
			        "set estado = 'I', finalizacion_acceso = now() ".
			      "where id_establecimiento = '".$_COOKIE["idEstablecimiento"]."' ".
			        "AND id_punto_emision = '".$_COOKIE["idPuntoEmision"]."' ".
			        "AND id_personal = '".$_COOKIE["idPersonal"]."'".
			        "AND estado = 'A'";
		$consulta = $db->consulta($query);
		
		$consulta = $db->consulta("INSERT INTO tsc_personal_punto_emision(id_establecimiento,id_punto_emision,id_personal,secuencia,".
								   "inicio_acceso,finalizacion_acceso,estado,id_horario_acceso,descripcion)".		                    								    "VALUES('".$_COOKIE["idEstablecimiento"]."','".$_COOKIE["idPuntoEmision"]."','".
								               $_COOKIE["idPersonal"]."','".$idSecuencia."','".
								               $_POST["inicio_acceso"]."','".$_POST["finalizacion_acceso"]."','A',1,upper('".
								               utf8_decode($_POST["descripcion"])."'));");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tsc_personal_punto_emision ".
									    "where id_establecimiento = '".$_COOKIE["idEstablecimiento"]."' ".
			                              "AND id_punto_emision = '".$_COOKIE["idPuntoEmision"]."' ".
			                              "AND id_personal = '".$_COOKIE["idPersonal"]."' ".
									    "ORDER BY secuencia DESC LIMIT 1");
			$numResul = $db->num_rows($consulta);
			if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
					  $row = array_map('utf8_encode',$resultados);					 
				}
			}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	else if($_GET["action"] == "update")
	{
		$consulta = $db->consulta("UPDATE tsc_personal_punto_emision ".
								     "SET descripcion = upper('".utf8_decode($_POST["descripcion"])."'), ".
								         "inicio_acceso = upper('".utf8_decode($_POST["inicio_acceso"])."'), ".
								         "finalizacion_acceso = upper('".utf8_decode($_POST["finalizacion_acceso"])."') ".
								     "where id_establecimiento = '".$_COOKIE["idEstablecimiento"]."' ".
			                           "AND id_punto_emision = '".$_COOKIE["idPuntoEmision"]."' ".
			                           "AND id_personal = '".$_COOKIE["idPersonal"]."' " .
								       "AND secuencia = ".$_POST["secuencia"].";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{	$query = "SELECT ifnull(max(secuencia),0) FROM tsc_personal_punto_emision ".
			      "where id_establecimiento = '".$_COOKIE["idEstablecimiento"]."' ".
			        "AND id_punto_emision = '".$_COOKIE["idPuntoEmision"]."' ".
			        "AND id_personal = '".$_COOKIE["idPersonal"]."'";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		$idSecuencia = 0;
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $idSecuencia = $resultados[0];					 
			}
		}
	 
		$consulta = $db->consulta("UPDATE tsc_personal_punto_emision SET estado ='I', finalizacion_acceso = now() ".
								  "where id_establecimiento = '".$_COOKIE["idEstablecimiento"]."' ".
			                        "AND id_punto_emision = '".$_COOKIE["idPuntoEmision"]."' ".
			                        "AND id_personal = '".$_COOKIE["idPersonal"]."' " .
								    "AND secuencia = ".$idSecuencia.";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
}
catch(Exception $ex)
{
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
	
?>