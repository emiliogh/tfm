<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tb_provincias where id_pais = '".$_COOKIE["idpais"]."' ORDER BY descripcion ASC";
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
		$consulta = $db->consulta("INSERT INTO tb_provincias(id_pais,descripcion, abreviatura, codigo_provincia, estado) VALUES('".$_COOKIE["idpais"]."',upper('".utf8_decode($_POST["descripcion"])."'),upper('".($_POST["abreviatura"])."'),upper('".($_POST["codigo_provincia"])."'),'A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tb_provincias ORDER BY id_provincia DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tb_provincias SET descripcion = upper('".utf8_decode($_POST["descripcion"])."'), abreviatura = upper('".utf8_decode($_POST["abreviatura"])."'), codigo_provincia = upper('".utf8_decode($_POST["codigo_provincia"])."') WHERE id_provincia = " . $_POST["id_provincia"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tb_provincias SET estado ='I' WHERE id_provincia = " . $_POST["id_provincia"] . ";");
	    
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