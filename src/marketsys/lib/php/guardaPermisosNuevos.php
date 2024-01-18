<?php
	include("../conexion/class.conexion.php");
	
	$db = new MySQL();
	
	$consulta = $db->consulta("update tas_permisos ".
							     "set estado = 'I', fecha_hasta = now(), fecha_revocacion=now() ".
							   "where id_usuario = '".$_POST['idusua']."' and estado = 'A'; ");

	
    /************************ACTUALIZACIÓN USUARIO **************************/
	$hasta = '';
    if ($_POST['idhast'] == ''){
		$hasta = 'NULL';
	    }else{echo strtotime($_POST['idhast']);
		      $hasta = "'".date("Y-m-d", strtotime(str_replace("/","-",$_POST['idhast'])))."'";}

    $consulta = $db->consulta("insert into tas_permisos ".
								    "(id_usuario, secuencia, fecha_creacion, fecha_desde, fecha_hasta, estado, id_perfil) ".
							 "values ('".$_POST['idusua']."',1,now(),now(),".$hasta.",'A','".$_POST['idperf']."');");

	 $retorno = 0;
	 $mensaje = 'Se ha procedido a realizar la asignación de nuevos permisos al usuario seleccionado.';					
	
	$options = array(0 => $retorno,
					 1 => $mensaje);

	echo json_encode($options);
	
?>