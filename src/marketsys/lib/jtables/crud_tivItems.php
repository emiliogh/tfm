<?php
include_once("../../lib/conexion/class.conexion.php");
try
{
	$db = new MySQL();	
	if($_GET["action"] == "list")
	{
		$rows = array();
		$query = "SELECT i.id_item,i.id_producto,i.id_clasificacion,i.descripcion,i.observacion,i.codigo_barra,porcentaje_gan_min, ".
						"i.precio_costo,i.id_fabricante,f.nombre_comercial fabricante,i.id_presentacion,p.medida presentacion, ".
			            "id_venta_sin_stock,id_graba_iva, i.estado ".
			       "FROM tiv_items i left join tiv_fabricantes f on f.id_fabricante = i.id_fabricante ".
			       "left join tiv_presentacion p on p.id_presentacion = i.id_presentacion ".
				  "WHERE i.estado = 'A' and i.id_producto =".$_COOKIE["id_producto"]." ORDER BY i.descripcion ASC";
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
		if( $_COOKIE["id_categoria"] == 0)
		{
			$jTableResult = array();
	        $jTableResult['Result'] = "ERROR";
	        $jTableResult['Message'] = "Selecciona una Categoría";
	        print json_encode($jTableResult);
		}
       	else if($_COOKIE["id_producto"] == 0){
			$jTableResult = array();
	        $jTableResult['Result'] = "ERROR";
	        $jTableResult['Message'] = "Selecciona un Producto";
	        print json_encode($jTableResult);
		}
		else
		{
		 $consulta = $db->consulta("INSERT INTO tiv_items(id_producto,id_clasificacion,descripcion,observacion,codigo_barra,id_fabricante,
		 												   id_presentacion,id_venta_sin_stock,id_graba_iva,porcentaje_gan_min,precio_costo,estado) 
													VALUES('".$_COOKIE["id_producto"]."','".$_COOKIE["id_categoria"]."',upper('".
								   						   $_POST["descripcion"]."'),upper('".$_POST["observacion"]."'),upper('".
								   						   $_POST["codigo_barra"]."'),0,0,".
								   						   $_POST["id_venta_sin_stock"].",".$_POST["id_graba_iva"].",'".
								   						   $_POST["porcentaje_gan_min"]."','".$_POST["precio_costo"]."','A');");
	     $row = array();
			
		 $consulta = $db->consulta("SELECT i.id_item, i.id_producto, i.id_clasificacion, i.descripcion, i.observacion, i.codigo_barra, 
		 								   i.id_fabricante, f.nombre_comercial fabricante, i.id_presentacion, p.medida presentacion,
										   id_venta_sin_stock,id_graba_iva,porcentaje_gan_min,precio_costo,i.estado 
									  FROM tiv_items i left join tiv_fabricantes f on f.id_fabricante = i.id_fabricante 
									 left join tiv_presentacion p on p.id_presentacion = i.id_presentacion WHERE i.estado = 'A' 
									   and i.id_producto =".$_COOKIE["id_producto"]." and i.id_clasificacion =".$_COOKIE["id_categoria"]." 
									 ORDER BY i.id_item DESC LIMIT 1");
			
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
		if( $_COOKIE["id_categoria"] == 0)
		{
			$jTableResult = array();
	        $jTableResult['Result'] = "ERROR";
	        $jTableResult['Message'] = "Selecciona una Categoría";
	        print json_encode($jTableResult);
		}
       	else if($_COOKIE["id_producto"] == 0){
			$jTableResult = array();
	        $jTableResult['Result'] = "ERROR";
	        $jTableResult['Message'] = "Selecciona un Producto";
	        print json_encode($jTableResult);
		}
       	else
		{
		 $consulta = $db->consulta("UPDATE tiv_items SET descripcion 		= upper('".$_POST["descripcion"]."'), 
		 												 observacion 		= upper('".$_POST["observacion"]."'), 
														 codigo_barra 		= upper('".$_POST["codigo_barra"]."'), 
														 id_fabricante 		= '". $_POST["id_fabricante"] ."', 
														 id_presentacion 	= '". $_POST["id_presentacion"] ."',
														 porcentaje_gan_min = '". $_POST["porcentaje_gan_min"] ."',
														 precio_costo 		= '". $_POST["precio_costo"] ."',
														 id_venta_sin_stock = '". $_POST["id_venta_sin_stock"] ."',
														 id_graba_iva  		= '". $_POST["id_graba_iva"] ."'
												   WHERE id_item = ".$_POST["id_item"].";");
	     
		 $jTableResult = array();
		 $jTableResult['Result'] = "OK";
		 print json_encode($jTableResult);
	    }
	}	
	else if($_GET["action"] == "delete")
	{
		$consulta = $db->consulta("UPDATE tiv_items SET estado ='I' WHERE id_item = ".$_POST["id_item"].";");
	    
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