<?php
include_once("../../lib/conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT id_fabricante, nombre_comercial, ruc, ubicacion, estado FROM tiv_fabricantes WHERE estado = 'A'";
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
		$consulta = $db->consulta("INSERT INTO tiv_fabricantes(nombre_comercial, ruc, ubicacion, estado) VALUES(upper('".utf8_decode($_POST["nombre_comercial"])."'),upper('".utf8_decode($_POST["ruc"])."'),upper('".utf8_decode($_POST["ubicacion"])."'),'A');");
			$row = array();
			$consulta = $db->consulta("SELECT id_fabricante, nombre_comercial, ruc, ubicacion, estado FROM tiv_fabricantes ORDER BY id_fabricante DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tiv_fabricantes SET nombre_comercial = upper('".utf8_decode($_POST["nombre_comercial"])."'), ruc = upper('".utf8_decode($_POST["ruc"])."'), ubicacion = upper('".utf8_decode($_POST["ubicacion"])."') WHERE id_fabricante = " . $_POST["id_fabricante"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tiv_fabricantes SET estado ='I' WHERE id_fabricante = " . $_POST["id_fabricante"] . ";");
	    
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