<?php
SESSION_START();
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	
	$options = array();	

	  
	  $consulta = $db->consulta("update tgn_personal ".
								   "set numero_identificacion = '".$_POST['numidn']."',".
									   "nombre 				  = '".utf8_decode($_POST['nmbrus'])."',".
								       "id_cargo 			  = '".$_POST['idcarg']."',".
								       "id_departamento 	  = '".$_POST['idept']."',".
								       "id_relacion_laboral   = '".$_POST['idcont']."',".
								       "correo_personal 	  = '".$_POST['emailp']."',".
								       "correo_institucional  = '".$_POST['emailc']."',".
								       "telefono 			  = '".$_POST['telefp']."' ".
								 "where id_personal 		  = '".$_POST['idusua']."';");
			
			
	$options = array(0 => '0');	

	echo json_encode($options);
	
?>