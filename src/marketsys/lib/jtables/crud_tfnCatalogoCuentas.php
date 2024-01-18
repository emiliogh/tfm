<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tfn_cuentas_contables where ifnull(id_cuenta_padre,0) = ifnull('".$_COOKIE["idPadre"]."',0) and estado = 'A' ";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $rows[] = array_map('utf8_encode',$resultados);					 
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	else if($_GET["action"] == "create")
	{
		$consulta = $db->consulta("INSERT INTO tfn_cuentas_contables(codigo,descripcion,estado,id_tipo_cuenta,id_nivel,id_cuenta_padre) VALUES(upper('".utf8_decode($_POST["codigo"])."'),upper('".utf8_decode($_POST["descripcion"])."'),'A','".$_POST["id_tipo_cuenta"]."','".$_POST["id_nivel"]."','".$_COOKIE["idPadre"]."');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tfn_cuentas_contables ORDER BY id_cuenta DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tfn_cuentas_contables 
		SET codigo = upper('".utf8_decode($_POST["codigo"])."'),
		    descripcion = upper('".utf8_decode($_POST["descripcion"])."'),
		    id_tipo_cuenta = upper('".utf8_decode($_POST["id_tipo_cuenta"])."'),
		    id_nivel = upper('".utf8_decode($_POST["id_nivel"])."') WHERE id_cuenta = ".$_POST["id_cuenta"].";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tfn_cuentas_contables SET estado ='I' WHERE id_cuenta = " . $_POST["id_cuenta"] . ";");
	    
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