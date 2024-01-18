<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tsc_puntos_emision where id_establecimiento='".$_COOKIE["idEstablecimiento"].
						"' ORDER BY definicion ASC";
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
		$consulta = $db->consulta("INSERT INTO tsc_puntos_emision(definicion,codigo_punto,id_establecimiento,observacion,estado)". 
								   "VALUES(upper('".utf8_decode($_POST["definicion"])."'),upper('".
								  	($_POST["codigo_punto"])."'),'".$_COOKIE["idEstablecimiento"]."',upper('".				
								    utf8_decode($_POST["observacion"])."'),'A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tsc_puntos_emision ORDER BY id_punto_emision DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tsc_puntos_emision SET definicion = upper('".utf8_decode($_POST["definicion"])."'),".
								  						"observacion = upper('".utf8_decode($_POST["observacion"])."'),".
								  						"codigo_punto = upper('".utf8_decode($_POST["codigo_punto"])."') ".
								  				  "WHERE id_punto_emision = ".$_POST["id_punto_emision"].";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tsc_puntos_emision SET estado='I' WHERE id_punto_emision=".$_POST["id_punto_emision"].";");
	    
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