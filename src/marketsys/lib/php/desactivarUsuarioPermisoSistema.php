<?php
	include("../conexion/class.conexion.php");
	
	$db = new MySQL();
	
	$consulta = $db->consulta("update tas_permisos ".
							     "set estado = 'I', fecha_hasta = now(), fecha_revocacion=now() ".
							   "where id_usuario = '".$_POST['idusua']."' and estado = 'A'; ");
	

	$consulta = $db->consulta("update tas_usuarios ".
							     "set estado = 'I' ".
							   "where id_usuario = '".$_POST['idusua']."' and estado = 'A'; ");


	 $retorno = 0;
	 $mensaje = 'Se ha procedido a realizar la desactivación de los permisos y el usuario seleccionado.';					
	
	$options = array(0 => $retorno,
					 1 => $mensaje);

	echo json_encode($options);
	
?>