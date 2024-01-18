<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tcu_categorias_clientes";
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
		$consulta = $db->consulta("INSERT INTO tcu_categorias_clientes(definicion,descuento,porcentaje_ganancia,estado)".
								       "VALUES(upper('".utf8_decode($_POST["definicion"])."'),'".
								  						$_POST["descuento"]."','".
								  						$_POST["porcentaje_ganancia"]."','A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tcu_categorias_clientes ORDER BY id_categoria_cliente DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tcu_categorias_clientes 
		                              SET definicion 		  = upper('".utf8_decode($_POST["definicion"])."'),
									      descuento  		  = ('".($_POST["descuento"])."'),
										  porcentaje_ganancia = ('".($_POST["porcentaje_ganancia"])."') 
									WHERE id_categoria_cliente = " . $_POST["id_categoria_cliente"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tcu_categorias_clientes SET estado ='I' WHERE id_categoria_cliente = " . $_POST["id_categoria_cliente"] . ";");
	    
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