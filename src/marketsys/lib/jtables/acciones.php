<?php
include_once("../../lib/conexion/class.conexion.php");
try
{
    $db = new MySQL();
    if($_GET["action"] == "listTFNTiposCuentas") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_tipo_cuenta, descripcion FROM tfn_tipos_cuentas WHERE estado = 'A' ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_tipo_cuenta']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTIVProductos") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_producto, nombre FROM tiv_productos WHERE estado = 'A' AND id_categoria = ifnull(".$_GET["idCategoria"].",0) ORDER BY nombre ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['nombre']);
				  $eil["Value"] = utf8_encode($resultados['id_producto']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	 if($_GET["action"] == "listTIVFabricantes") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_fabricante, nombre_comercial FROM tiv_fabricantes WHERE estado = 'A' ORDER BY nombre_comercial ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['nombre_comercial']);
				  $eil["Value"] = utf8_encode($resultados['id_fabricante']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTIVPresentaciones") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_presentacion, medida FROM tiv_presentacion WHERE estado = 'A' ORDER BY medida ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['medida']);
				  $eil["Value"] = utf8_encode($resultados['id_presentacion']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	 

}catch(Exception $ex){
    $jTableResult = array();
    $jTableResult['Result'] = "ERROR";
    $jTableResult['Message'] = $ex->getMessage();
    print json_encode($jTableResult);
}

?>