<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tb_parroquias where id_pais = '".$_COOKIE["idpais"]."' AND id_provincia = '".$_COOKIE["idprovincia"]."' and id_canton =".$_COOKIE["idcanton"]." ORDER BY descripcion ASC";
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
		$query = "SELECT ifnull(max(id_parroquia),0)+1 FROM tb_parroquias where id_pais = '".$_COOKIE["idpais"]."' AND id_provincia = '".$_COOKIE["idprovincia"]."' and id_canton ='".$_COOKIE["idcanton"]."'";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		$idParroquia = 0;
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $idParroquia = $resultados[0];					 
			}
		}
		$consulta = $db->consulta("INSERT INTO tb_parroquias(id_pais,id_provincia,id_canton,id_parroquia,descripcion, abreviatura, codigo_parroquia, estado) VALUES('".$_COOKIE["idpais"]."','".$_COOKIE["idprovincia"]."','".$_COOKIE["idcanton"]."','".$idParroquia."',upper('".utf8_decode($_POST["descripcion"])."'),upper('".($_POST["abreviatura"])."'),upper('".($_POST["codigo_parroquia"])."'),'A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tb_parroquias WHERE id_pais = '".$_COOKIE["idpais"]."' AND id_provincia = '".$_COOKIE["idprovincia"]."' and id_canton ='".$_COOKIE["idcanton"]."' ORDER BY id_parroquia DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tb_parroquias SET descripcion = upper('".utf8_decode($_POST["descripcion"])."'), abreviatura = upper('".utf8_decode($_POST["abreviatura"])."'), codigo_parroquia = upper('".utf8_decode($_POST["codigo_parroquia"])."') WHERE id_pais = '".$_COOKIE["idpais"]."' AND id_provincia = '".$_COOKIE["idprovincia"]."' AND id_parroquia = ".$_POST["id_parroquia"]." and id_canton =".$_COOKIE["idcanton"].";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tb_parroquias SET estado ='I' WHERE id_parroquia = ".$_POST["id_parroquia"]." and id_canton =".$_COOKIE["idcanton"]." AND id_pais = '".$_COOKIE["idpais"]."' AND id_provincia = '".$_COOKIE["idprovincia"]."';");
	    
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