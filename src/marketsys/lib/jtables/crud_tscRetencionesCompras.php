<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * ".
			       "FROM tsc_tipos_retenciones_compras ".
			      "where id_tipo_retenciones = ifnull('".$_COOKIE["idRetencion"]."',0) and estado = 'A' ";
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
		$consulta = $db->consulta("INSERT INTO tsc_tipos_retenciones_compras(id_tipo_retenciones,".
								            "descripcion,valor,codigo_ats,id_cuenta_contable,estado,fecha_registro)".
								  "VALUES('".$_COOKIE["idRetencion"]."','".utf8_encode($_POST["descripcion"])."','".$_POST["valor"].
								          "','".$_POST["codigo_ats"]."', '".$_POST["id_cuenta_contable"]."','A',now());");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tsc_tipos_retenciones_compras ORDER BY id_retencion DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tsc_tipos_retenciones_compras ".
		                            "SET descripcion = '".utf8_encode($_POST["descripcion"])."', ".
		                                "valor = '".$_POST["valor"]."', ".
		                                "codigo_ats = '".$_POST["codigo_ats"]."', ".
			                            "id_cuenta_contable = '".$_POST["id_cuenta_contable"]."' ".
								  "WHERE id_retencion = ".$_POST["id_retencion"].";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tsc_tipos_retenciones_compras ".
								     "SET estado ='I' ".
								   "WHERE id_retencion = " . $_POST["id_retencion"] . ";");
	    
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