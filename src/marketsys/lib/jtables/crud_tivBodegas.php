<?php
include_once("../../lib/conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT id_bodega, descripcion, ubicacion, permite_despacho, estado FROM tiv_bodegas WHERE estado = 'A'";
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
		$consulta = $db->consulta("INSERT INTO tiv_bodegas(descripcion, ubicacion, permite_despacho, estado) VALUES(upper('".utf8_decode($_POST["descripcion"])."'),upper('".utf8_decode($_POST["ubicacion"])."'),upper('".utf8_decode($_POST["permite_despacho"])."'),'A');");
			$row = array();
			$consulta = $db->consulta("SELECT id_bodega, descripcion, ubicacion, permite_despacho, estado FROM tiv_bodegas ORDER BY id_bodega DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tiv_bodegas SET descripcion = upper('".utf8_decode($_POST["descripcion"])."'), ubicacion = upper('".utf8_decode($_POST["ubicacion"])."'), permite_despacho = upper('".utf8_decode($_POST["permite_despacho"])."') WHERE id_bodega = " . $_POST["id_bodega"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tiv_bodegas SET estado ='I' WHERE id_bodega = " . $_POST["id_bodega"] . ";");
	    
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