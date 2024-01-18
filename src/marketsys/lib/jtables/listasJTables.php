<?php
include("../conexion/class.conexion.php");
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
	
	if($_GET["action"] == "listTFNNiveles") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_nivel, descripcion FROM tfn_niveles WHERE estado = 'A' ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_nivel']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTFNCatalogoContable") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_cuenta, concat('[',codigo,'] ',descripcion) descripcion FROM tfn_cuentas_contables WHERE estado = 'A' AND id_nivel = 2 ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_cuenta']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTIVClasificacionProductos") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_clasificacion, descripcion FROM tiv_clasificacion_productos WHERE estado = 'A' ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_clasificacion']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTSCIntitucionesFinancieras") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_institucion, nombre_institucion FROM tsc_instituciones_financieras WHERE estado = 'A' ORDER BY nombre_institucion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['nombre_institucion']);
				  $eil["Value"] = utf8_encode($resultados['id_institucion']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTSCBodegas") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_bodega, descripcion FROM tiv_bodegas WHERE estado = 'A' ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_bodega']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTSCCuentasBancarias") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_cuenta, concat(cuenta,'-',descripcion) descripcion ".
			       "FROM tsc_cuentas_bancarias ".
			      "WHERE estado = 'A' ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_cuenta']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTSCHorarios") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_cuenta, concat(cuenta,'-',descripcion) descripcion ".
			       "FROM tsc_cuentas_bancarias ".
			      "WHERE estado = 'A' ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_cuenta']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if ($_GET["action"] == "tiposIdentificacion") {   
		$etiqueta = array("0" => "Seleccione una opcion...");
		$rows = array();

		$consulta = $db->consulta("SELECT descripcion, id_tipo_identificacion FROM tb_tipos_identificacion WHERE estado = 'A' ORDER BY 2 ASC;");

		$rows = array();
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){ 
				$eil = array();
				$eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				$eil["Value"] = $resultados['id_tipo_identificacion'];
				$rows[] = $eil;
			}
		}

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   

	}
	
	if ($_GET["action"] == "generosSexuales") {   
		$etiqueta = array("0" => "Seleccione una opcion...");
		$rows = array();

		$consulta = $db->consulta("SELECT descripcion, id_genero FROM tb_generos WHERE estado = 'A' ORDER BY 2 ASC;");

		$rows = array();
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){ 
				$eil = array();
				$eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				$eil["Value"] = $resultados['id_genero'];
				$rows[] = $eil;
			}
		}

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if ($_GET["action"] == "estadosCiviles") {   
		$etiqueta = array("0" => "Seleccione una opcion...");
		$rows = array();

		$consulta = $db->consulta("SELECT descripcion, id_estado FROM tb_estados_civiles WHERE estado = 'A' ORDER BY 2 ASC;");

		$rows = array();
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){ 
				$eil = array();
				$eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				$eil["Value"] = $resultados['id_estado'];
				$rows[] = $eil;
			}
		}

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if ($_GET["action"] == "cargos") {   
		$etiqueta = array("0" => "Seleccione una opcion...");
		$rows = array();

		$consulta = $db->consulta("SELECT descripcion, id_cargo FROM tgn_cargos WHERE estado = 'A' ORDER BY 2 ASC;");

		$rows = array();
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){ 
				$eil = array();
				$eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				$eil["Value"] = $resultados['id_cargo'];
				$rows[] = $eil;
			}
		}

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if ($_GET["action"] == "departamentos") {   
		$etiqueta = array("0" => "Seleccione una opcion...");
		$rows = array();

		$consulta = $db->consulta("SELECT descripcion, id_departamento FROM tgn_departamentos WHERE estado = 'A' ORDER BY 2 ASC;");

		$rows = array();
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){ 
				$eil = array();
				$eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				$eil["Value"] = $resultados['id_departamento'];
				$rows[] = $eil;
			}
		}

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}

	if ($_GET["action"] == "tiposContratos") {   
		$etiqueta = array("0" => "Seleccione una opcion...");
		$rows = array();

		$consulta = $db->consulta("SELECT descripcion, id_tipo_contrato FROM tb_tipo_contratos WHERE estado = 'A' ORDER BY 2 ASC;");

		$rows = array();
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){ 
				$eil = array();
				$eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				$eil["Value"] = $resultados['id_tipo_contrato'];
				$rows[] = $eil;
			}
		}

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if ($_GET["action"] == "listTIVCategorias") {   
		$etiqueta = array("0" => "Seleccione una opcion...");
		$rows = array();

		$consulta = $db->consulta("SELECT descripcion, id_clasificacion FROM tiv_clasificacion_productos WHERE estado = 'A' ORDER BY 2 ASC;");
		
		$rows = array();
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){ 
				$eil = array();
				$eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				$eil["Value"] = $resultados['id_clasificacion'];
				$rows[] = $eil;
			}
		}

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if ($_GET["action"] == "listTIVProductos") {   
		$etiqueta = array("0" => "Seleccione una opcion...");
		$rows = array();

		$consulta = $db->consulta("SELECT nombre, id_producto FROM tiv_productos ".
								   "WHERE estado = 'A' AND id_categoria =  coalesce(".$_POST['id'].",0) ORDER BY 2 ASC;");

		$rows = array();
		/*Recorrido de Datos*/
		if($db->num_rows($consulta)>=0){
			while($resultados = $db->fetch_array($consulta)){ 
				$eil = array();
				$eil["DisplayText"] = utf8_encode($resultados['nombre']);
				$eil["Value"] = $resultados['id_producto'];
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
	
	if($_GET["action"] == "listTBEstadosCiviles") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_estado, descripcion FROM tb_estados_civiles WHERE estado = 'A' ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_estado']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTCUTiposCliente") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_tipo_cliente, descripcion FROM tcu_tipos_clientes WHERE estado = 'A' ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_tipo_cliente']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTCUCategoriasCliente") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_categoria_cliente, definicion FROM tcu_categorias_clientes WHERE estado = 'A' ORDER BY definicion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['definicion']);
				  $eil["Value"] = utf8_encode($resultados['id_categoria_cliente']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTCUTiposProveedores") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_tipo_proveedor, descripcion FROM tsc_tipos_proveedores WHERE estado = 'A' ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_tipo_proveedor']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	if($_GET["action"] == "listTCUCategoriasProveedores") {   
		$etiqueta = array("0" => "Seleccione una opcion");
		$rows = array();
		$query = "SELECT id_categoria, descripcion FROM tsc_categorias_proveedor WHERE estado = 'A' ORDER BY descripcion ASC";
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
				  $eil = array();
				  $eil["DisplayText"] = utf8_encode($resultados['descripcion']);
				  $eil["Value"] = utf8_encode($resultados['id_categoria']);
				  
				  $rows[] = $eil;		
				  
			}
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options'] = array_merge($etiqueta, $rows); 
		print json_encode( $jTableResult);   
	}
	
	
}
catch(Exception $ex){
    $jTableResult = array();
    $jTableResult['Result'] = "ERROR";
    $jTableResult['Message'] = $ex->getMessage();
    print json_encode($jTableResult);
}

?>