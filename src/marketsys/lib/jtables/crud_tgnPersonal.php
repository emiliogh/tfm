<?php
include_once("../conexion/class.conexion.php");
try
{
	$db = new MySQL();
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT * FROM tgn_personal where visible = 'S' order by nombre";
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
		$consulta = $db->consulta("INSERT INTO tgn_personal(tipo_identificacion,numero_identificacion,nombre,id_estado_civil,id_cargo,id_departamento,id_relacion_laboral,fecha_nacimiento,visible,id_genero,correo_personal,correo_institucional,telefono,telefono_convencional,direccion,estado) VALUES('".$_POST["tipo_identificacion"]."','".$_POST["numero_identificacion"]."',upper('".utf8_decode($_POST["nombre"])."'),'".$_POST["id_estado_civil"]."','".$_POST["id_cargo"]."','".$_POST["id_departamento"]."','".$_POST["id_relacion_laboral"]."','".$_POST["fecha_nacimiento"]."','S','".$_POST["id_genero"]."','".utf8_decode($_POST["correo_personal"])."','".utf8_decode($_POST["correo_institucional"])."','".utf8_decode($_POST["telefono"])."','".utf8_decode($_POST["telefono_convencional"])."',upper('".utf8_decode($_POST["direccion"])."'),'A');");
		    $row = array();
			$consulta = $db->consulta("SELECT * FROM tgn_personal ORDER BY id_personal DESC LIMIT 1");
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
		$consulta = $db->consulta("UPDATE tgn_personal SET tipo_identificacion = '".$_POST["tipo_identificacion"]."',numero_identificacion = '".$_POST["numero_identificacion"]."',nombre = upper('".utf8_decode($_POST["nombre"])."'),id_estado_civil = '".$_POST["id_estado_civil"]."',id_cargo = '".$_POST["id_cargo"]."',id_departamento = '".$_POST["id_departamento"]."',fecha_nacimiento = '".$_POST["fecha_nacimiento"]."',id_relacion_laboral = '".$_POST["id_relacion_laboral"]."',id_genero = '".$_POST["id_genero"]."',correo_personal = '".utf8_decode($_POST["correo_personal"])."',correo_institucional = '".utf8_decode($_POST["correo_institucional"])."', telefono = '".$_POST["telefono"]."', telefono_convencional = '".$_POST["telefono_convencional"]."', direccion = upper('".utf8_decode($_POST["direccion"])."') WHERE id_personal = " . $_POST["id_personal"] . ";");
	    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tgn_personal SET estado ='I' WHERE id_personal = " . $_POST["id_personal"] . ";");
	    
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