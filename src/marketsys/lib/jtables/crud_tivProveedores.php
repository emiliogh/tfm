<?php
include_once("../../lib/conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT p.id_proveedor, p.identificacion, p.razon_social, p.nombre_comercial, p.estado, p.credito, p.tiempo_credito, p.id_categoria, p.vendedor FROM tiv_proveedores p inner join tiv_categorias c ON c.id_categoria = p.id_categoria WHERE p.estado = 'A'";
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
		$consulta = $db->consulta("INSERT INTO tiv_proveedores(identificacion, razon_social, nombre_comercial, estado, credito, tiempo_credito, id_categoria, vendedor) VALUES(upper('".utf8_decode($_POST["identificacion"])."'),'".utf8_decode($_POST["razon_social"])."',upper('".utf8_decode($_POST["nombre_comercial"])."'),'A',upper('".utf8_decode($_POST["credito"])."'),'".utf8_decode($_POST["tiempo_credito"])."','".utf8_decode($_POST["id_categoria"])."',upper('".utf8_decode($_POST["vendedor"])."'));");
			$row = array();
			$consulta = $db->consulta("SELECT p.id_proveedor, p.identificacion, p.razon_social, p.nombre_comercial, p.estado, p.credito, p.tiempo_credito, p.id_categoria, p.vendedor FROM tiv_proveedores p inner join tiv_categorias c ON c.id_categoria = p.id_categoria ORDER BY id_categoria DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tiv_proveedores SET identificacion = upper('".utf8_decode($_POST["identificacion"])."'), razon_social = upper('".utf8_decode($_POST["razon_social"])."'), nombre_comercial = upper('".utf8_decode($_POST["nombre_comercial"])."'), credito = upper('".utf8_decode($_POST["credito"])."'), tiempo_credito = '".utf8_decode($_POST["tiempo_credito"])."', id_categoria = '".utf8_decode($_POST["id_categoria"])."', vendedor = upper('".utf8_decode($_POST["vendedor"])."') WHERE id_proveedor = " . $_POST["id_proveedor"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tiv_proveedores SET estado ='I' WHERE id_proveedor = " . $_POST["id_proveedor"] . ";");
	    
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