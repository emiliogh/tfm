<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tsc_proveedores where estado = 'A'; ";
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
		
		$consulta = $db->consulta("INSERT INTO tsc_proveedores(id_tipo_identificacion,id_tipo_proveedor,".
								  		  "id_categoria_proveedor,numero_identificacion,nombre_proveedor,".
								  		  "nombre_comercial,direccion,telefono,correo_electronico,estado,fecha_registro)".
								  " VALUES(upper('".utf8_decode($_POST["id_tipo_identificacion"])."'),".
								  			   "('".utf8_decode($_POST["id_tipo_proveedor"])."'),".
								         	   "('".utf8_decode($_POST["id_categoria_proveedor"])."'),".
								  			   "('".utf8_decode($_POST["numero_identificacion"])."'),".
								  		  "upper('".utf8_decode($_POST["nombre_proveedor"])."'),".
								  		  "upper('".utf8_decode($_POST["nombre_comercial"])."'),".
								  		  "upper('".utf8_decode($_POST["direccion"])."'),".
								  			   "('".utf8_decode($_POST["telefono"])."'),".
								  			   "('".utf8_decode($_POST["correo_electronico"])."'),'A',now());");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tsc_proveedores ORDER BY id_proveedor DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tsc_proveedores ".
								     "SET id_tipo_proveedor = upper('".utf8_decode($_POST["id_tipo_proveedor"])."'),".
								  		 "id_tipo_identificacion = upper('".utf8_decode($_POST["id_tipo_identificacion"])."'), ".
								  		 "id_categoria_proveedor = upper('".utf8_decode($_POST["id_categoria_proveedor"])."'), ".
								    	 "numero_identificacion = upper('".utf8_decode($_POST["numero_identificacion"])."'), ".
								  		 "nombre_proveedor = upper('".utf8_decode($_POST["nombre_proveedor"])."'), ".
								  		 "nombre_comercial = upper('".utf8_decode($_POST["nombre_comercial"])."'), ".
								  		 "direccion = upper('".utf8_decode($_POST["direccion"])."'), ".
								         "correo_electronico = upper('".utf8_decode($_POST["correo_electronico"])."'), ".
								         "telefono = upper('".utf8_decode($_POST["telefono"])."') ".
								   "WHERE id_proveedor = " . $_POST["id_proveedor"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tsc_proveedores SET estado ='I' WHERE id_proveedor = " . $_POST["id_proveedor"] . ";");
	    
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