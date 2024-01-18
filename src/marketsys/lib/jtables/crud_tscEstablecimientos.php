<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tsc_establecimientos";
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
		$consulta = $db->consulta("INSERT INTO tsc_establecimientos(definicion, codigo_establecimiento, identificador_matriz,".
								                     "id_tipo_establecimiento,direccion,nombre_comercial,id_bodega,estado) ".
											  "VALUES(upper('".utf8_decode($_POST["definicion"])."'),".
		 								   			 "upper('".utf8_decode($_POST["codigo_establecimiento"])."'),".
								   					 "upper('".utf8_decode($_POST["identificador_matriz"])."'),".
								                     "upper('".utf8_decode($_POST["id_tipo_establecimiento"])."'),".
								  					 "upper('".utf8_decode($_POST["direccion"])."'),".	 
								  					 "upper('".utf8_decode($_POST["nombre_comercial"])."'),".
								  					 "upper('".utf8_decode($_POST["id_bodega"])."'),".
								                      "'A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tsc_establecimientos ORDER BY id_establecimiento DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tsc_establecimientos ".
									 "SET definicion = upper('".utf8_decode($_POST["definicion"])."'),".
		 								 "codigo_establecimiento = upper('".utf8_decode($_POST["codigo_establecimiento"])."'),".
								         "id_tipo_establecimiento = '".$_POST["id_tipo_establecimiento"]."',".
								   		 "identificador_matriz = upper('".utf8_decode($_POST["identificador_matriz"])."'),".
								  		 "direccion = upper('".utf8_decode($_POST["direccion"])."'),".	 
								  		 "nombre_comercial = upper('".utf8_decode($_POST["nombre_comercial"])."'),".
								  		 "id_bodega = upper('".utf8_decode($_POST["id_bodega"])."') ".
								   "WHERE id_establecimiento  = ".$_POST["id_establecimiento"].";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tsc_establecimientos SET estado ='I' ".
								   "WHERE id_establecimiento = " . $_POST["id_establecimiento"] . ";");
	    
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