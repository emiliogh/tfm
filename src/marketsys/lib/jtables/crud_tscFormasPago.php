<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tsc_formas_pago";
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
		$consulta = $db->consulta("INSERT INTO tsc_formas_pago(descripcion,id_destino_transaccional,id_detalle_destino,".
								  "id_cuenta_contable,tiempo_vigencia,aplicable_facturas,aplicable_compras,codigo,estado)".
								  " VALUES(upper('".utf8_decode($_POST["descripcion"])."'),upper('".
								  					utf8_decode($_POST["id_destino_transaccional"])."'),upper('".
								         			utf8_decode($_POST["id_detalle_destino"])."'),upper('".
								  					utf8_decode($_POST["id_cuenta_contable"])."'),upper('".
								  					utf8_decode($_POST["tiempo_vigencia"])."'),upper('".
								  					utf8_decode($_POST["aplicable_facturas"])."'),upper('".
								  					utf8_decode($_POST["aplicable_compras"])."'),'".
								  					utf8_decode($_POST["codigo"])."','A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tsc_formas_pago ORDER BY id_forma_pago DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tsc_formas_pago SET descripcion = upper('".utf8_decode($_POST["descripcion"])."'),".
								  		 "id_destino_transaccional = upper('".utf8_decode($_POST["id_destino_transaccional"])."'), ".
								    	 "id_detalle_destino = upper('".utf8_decode($_POST["id_detalle_destino"])."'), ".
								  		 "id_cuenta_contable = upper('".utf8_decode($_POST["id_cuenta_contable"])."'), ".
								  		 "tiempo_vigencia = upper('".utf8_decode($_POST["tiempo_vigencia"])."'), ".
								  		 "aplicable_facturas = upper('".utf8_decode($_POST["aplicable_facturas"])."'), ".
								         "codigo = upper('".utf8_decode($_POST["codigo"])."'), ".
								         "aplicable_compras = upper('".utf8_decode($_POST["aplicable_compras"])."') ".
								   "WHERE id_forma_pago = " . $_POST["id_forma_pago"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tsc_formas_pago SET estado ='I' WHERE id_forma_pago = " . $_POST["id_forma_pago"] . ";");
	    
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