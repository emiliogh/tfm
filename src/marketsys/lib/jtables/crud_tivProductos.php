<?php
include_once("../../lib/conexion/class.conexion.php");
try
{
	$db = new MySQL();	
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT id_producto, id_categoria, nombre, descripcion, perecible, stock_minimo, estado FROM tiv_productos WHERE estado = 'A' and id_categoria =".$_COOKIE["idCategoria"]." ORDER BY nombre ASC";
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
		if( $_COOKIE["idCategoria"] == 0)
		{
			$jTableResult = array();
	        $jTableResult['Result'] = "ERROR";
	        $jTableResult['Message'] = "Selecciona una Categoría";
	        print json_encode($jTableResult);
		}
       	else
		{
		 $consulta = $db->consulta("INSERT INTO tiv_productos(id_categoria, nombre, descripcion, perecible, stock_minimo, estado) VALUES('".$_COOKIE["idCategoria"]."',upper('".$_POST["nombre"]."'),upper('".$_POST["descripcion"]."'),upper('".$_POST["perecible"]."'),".$_POST["stock_minimo"].",'ACT');");
	     $row = array();
		 $consulta = $db->consulta("SELECT * FROM tiv_productos ORDER BY id_producto DESC LIMIT 1");
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
	}
	else if($_GET["action"] == "update")
	{
		if( $_POST["id_categoria"] == 0)
		{
			$jTableResult = array();
	        $jTableResult['Result'] = "ERROR";
	        $jTableResult['Message'] = "Selecciona un pais";
	        print json_encode($jTableResult);
		}
       	else
		{
		 $consulta = $db->consulta("UPDATE tiv_productos SET id_categoria = '".$_POST["id_categoria"]."', nombre = upper('".$_POST["nombre"]."'), descripcion = upper('".$_POST["descripcion"]."'), perecible = upper('".$_POST["perecible"]."'), stock_minimo = '". $_POST["stock_minimo"] ."' WHERE id_producto = ".$_POST["id_producto"].";");
	     
		 $jTableResult = array();
		 $jTableResult['Result'] = "OK";
		 print json_encode($jTableResult);
	    }
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tiv_productos SET estado ='I' WHERE id_producto = ".$_POST["id_producto"].";");
	    
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