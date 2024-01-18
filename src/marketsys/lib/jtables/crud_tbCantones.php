<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tb_cantones where id_pais = '".$_COOKIE["idpais"]."' AND id_provincia = '".$_COOKIE["idprovincia"]."' ORDER BY descripcion ASC";
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
		$query = "SELECT ifnull(max(id_canton),0)+1 FROM tb_cantones where id_pais = '".$_COOKIE["idpais"]."' AND id_provincia = '".$_COOKIE["idprovincia"]."'";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		$idCanton = 0;
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $idCanton = $resultados[0];					 
			}
		}
		$consulta = $db->consulta("INSERT INTO tb_cantones(id_pais,id_provincia,id_canton,descripcion, abreviatura, codigo_canton, estado) VALUES('".$_COOKIE["idpais"]."','".$_COOKIE["idprovincia"]."','".$idCanton."',upper('".utf8_decode($_POST["descripcion"])."'),upper('".($_POST["abreviatura"])."'),upper('".($_POST["codigo_canton"])."'),'A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tb_cantones WHERE id_pais = '".$_COOKIE["idpais"]."' AND id_provincia = '".$_COOKIE["idprovincia"]."' ORDER BY id_canton DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tb_cantones SET descripcion = upper('".utf8_decode($_POST["descripcion"])."'), abreviatura = upper('".utf8_decode($_POST["abreviatura"])."'), codigo_canton = upper('".utf8_decode($_POST["codigo_canton"])."') WHERE id_pais = '".$_COOKIE["idpais"]."' AND id_provincia = '".$_COOKIE["idprovincia"]."' AND id_canton = ".$_POST["id_canton"].";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tb_cantones SET estado ='I' WHERE id_canton = ".$_POST["id_canton"]." AND id_pais = '".$_COOKIE["idpais"]."' AND id_provincia = '".$_COOKIE["idprovincia"]."';");
	    
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