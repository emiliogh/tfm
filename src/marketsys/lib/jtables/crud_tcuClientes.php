<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tcu_clientes where id_cliente != 11; ";
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
		$var = $_POST['fecha_nacimiento'];
		$date = str_replace('/', '-', $var);
			$dateNac = date('Y-m-d', strtotime($date));
		
		$consulta = $db->consulta("INSERT INTO tcu_clientes(id_tipo_cliente,id_tipo_identificacion,numero_identificacion,telefono,".
								  "nombre_cliente,direccion,correo_electronico,id_categoria_cliente,estado)".
								  " VALUES(upper('".utf8_decode($_POST["id_tipo_cliente"])."'),".
								  			   "('".utf8_decode($_POST["id_tipo_identificacion"])."'),".
								         	   "('".utf8_decode($_POST["numero_identificacion"])."'),".
								  			   "('".utf8_decode($_POST["telefono"])."'),".
								  		  "upper('".utf8_decode($_POST["nombre_cliente"])."'),".
								  		  "upper('".utf8_decode($_POST["direccion"])."'),".
								  			   "('".utf8_decode($_POST["correo_electronico"])."'),".
								  			   "('".utf8_decode($_POST["id_categoria_cliente"])."'),'A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tcu_clientes ORDER BY id_cliente DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tcu_clientes ".
								     "SET id_tipo_cliente = upper('".utf8_decode($_POST["id_tipo_cliente"])."'),".
								  		 "id_tipo_identificacion = upper('".utf8_decode($_POST["id_tipo_identificacion"])."'), ".
								    	 "numero_identificacion = upper('".utf8_decode($_POST["numero_identificacion"])."'), ".
								  		 "nombre_cliente = upper('".utf8_decode($_POST["nombre_cliente"])."'), ".
								  		 "direccion = upper('".utf8_decode($_POST["direccion"])."'), ".
								         "correo_electronico = upper('".utf8_decode($_POST["correo_electronico"])."'), ".
								         "telefono = upper('".utf8_decode($_POST["telefono"])."'), ".
								         "id_categoria_cliente = upper('".utf8_decode($_POST["id_categoria_cliente"])."') ".
								   "WHERE id_cliente = " . $_POST["id_cliente"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tcu_clientes SET estado ='I' WHERE id_cliente = " . $_POST["id_cliente"] . ";");
	    
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