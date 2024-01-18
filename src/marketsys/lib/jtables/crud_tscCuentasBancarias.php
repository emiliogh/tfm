<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tsc_cuentas_bancarias";
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
		$consulta = $db->consulta("INSERT INTO tsc_cuentas_bancarias(cuenta,id_tipo_cuenta,descripcion,id_institucion_financiera,estado) VALUES('".
								  $_POST["cuenta"]."','".$_POST["id_tipo_cuenta"]."',upper('".utf8_decode($_POST["descripcion"])."'),'".
								  $_POST["id_institucion_financiera"]."','A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tsc_cuentas_bancarias ORDER BY id_cuenta DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tsc_cuentas_bancarias SET descripcion = upper('".utf8_decode($_POST["descripcion"])."'), ".
																   "cuenta = upper('".utf8_decode($_POST["cuenta"])."'), ".
																   "id_tipo_cuenta = upper('".utf8_decode($_POST["id_tipo_cuenta"])."'), ".	
																   "id_institucion_financiera = upper('".($_POST["id_institucion_financiera"])."') ".
															 "WHERE id_cuenta = " . $_POST["id_cuenta"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tsc_cuentas_bancarias SET estado ='I' WHERE id_cuenta = " . $_POST["id_cuenta"] . ";");
	    
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