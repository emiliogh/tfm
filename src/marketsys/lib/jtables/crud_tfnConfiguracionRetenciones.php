<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tiv_retenciones_tipos_clientes_tipos_productos where id_tipo_cliente = ifnull('".$_COOKIE["idTipoCliente"]."',0) and estado = 'A' ";
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
		$consulta = $db->consulta("INSERT INTO tiv_retenciones_tipos_clientes_tipos_productos(id_tipo_cliente,id_clasificacion_producto,fecha_desde,fecha_hasta,porcentaje_retencion_renta,id_cuenta_contable_renta,porcentaje_retencion_iva,id_cuenta_contable_iva,estado) VALUES('".$_COOKIE["idTipoCliente"]."','".$_POST["id_clasificacion_producto"]."','".$_POST["fecha_desde"]."','".$_POST["fecha_hasta"]."', '".$_POST["porcentaje_retencion_renta"]."','".$_POST["id_cuenta_contable_renta"]."','".$_POST["porcentaje_retencion_iva"]."','".$_POST["id_cuenta_contable_iva"]."','A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tiv_retenciones_tipos_clientes_tipos_productos ORDER BY id_configuracion DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tiv_retenciones_tipos_clientes_tipos_productos 
		SET id_clasificacion_producto = '".$_POST["id_clasificacion_producto"]."',
		    fecha_desde = '".$_POST["fecha_desde"]."',
		    fecha_hasta = '".$_POST["fecha_hasta"]."',
			porcentaje_retencion_renta = '".$_POST["porcentaje_retencion_renta"]."',
			id_cuenta_contable_renta = '".$_POST["id_cuenta_contable_renta"]."',
		    porcentaje_retencion_iva = '".$_POST["porcentaje_retencion_iva"]."',
			id_cuenta_contable_iva = '".$_POST["id_cuenta_contable_iva"]."' WHERE id_configuracion = ".$_POST["id_configuracion"].";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tiv_retenciones_tipos_clientes_tipos_productos SET estado ='I' WHERE id_configuracion = " . $_POST["id_configuracion"] . ";");
	    
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