<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tiv_clasificacion_productos ";
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
		$consulta = $db->consulta("INSERT INTO tiv_clasificacion_productos(descripcion, estado,id_cuenta_contable,id_cuenta_contable_iva,".
								  										   "id_cuenta_contable_desc) ".
								        "VALUES(upper('".utf8_decode($_POST["descripcion"])."'),'A','".$_POST["id_cuenta_contable"]."','".
								 						 $_POST["id_cuenta_contable_iva"]."','".$_POST["id_cuenta_contable_desc"]."');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tiv_clasificacion_productos ORDER BY id_clasificacion DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tiv_clasificacion_productos ".
								  	 "SET descripcion = upper('".utf8_decode($_POST["descripcion"])."'), ".
								  	     "id_cuenta_contable = upper('".$_POST["id_cuenta_contable"]."'), ".
								  		 "id_cuenta_contable_iva = upper('".$_POST["id_cuenta_contable_iva"]."'), ".
								  		 "id_cuenta_contable_desc = upper('".$_POST["id_cuenta_contable_iva"]."') ". 
								   "WHERE id_clasificacion = ".$_POST["id_clasificacion"].";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tiv_clasificacion_productos SET estado ='I' WHERE id_clasificacion = " . $_POST["id_clasificacion"] . ";");
	    
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