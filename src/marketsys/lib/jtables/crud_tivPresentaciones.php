<?php
include_once("../../lib/conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT id_presentacion, descripcion, medida, valor_medida, estado FROM tiv_presentacion WHERE estado = 'A'";
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
		$consulta = $db->consulta("INSERT INTO tiv_presentacion(descripcion, medida, valor_medida, estado) VALUES(upper('".utf8_decode($_POST["descripcion"])."'),upper('".utf8_decode($_POST["medida"])."'),'".utf8_decode($_POST["valor_medida"])."','A');");
			$row = array();
			$consulta = $db->consulta("SELECT id_presentacion, descripcion, medida, valor_medida, estado FROM tiv_presentacion ORDER BY id_presentacion DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tiv_presentacion SET descripcion = upper('".utf8_decode($_POST["descripcion"])."'), medida = upper('".utf8_decode($_POST["medida"])."'), valor_medida = '".utf8_decode($_POST["valor_medida"])."' WHERE id_presentacion = " . $_POST["id_presentacion"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tiv_presentacion SET estado ='I' WHERE id_presentacion = " . $_POST["id_presentacion"] . ";");
	    
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