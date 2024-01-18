<?php
SESSION_START();
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$rows = array();
	$query = "SELECT pr.numero_identificacion, ".
					"pr.nombre, ".
					"ifnull(gn.descripcion,'-'), ".
					"ifnull(ec.descripcion,'NO REGISTRADO'), ".
					"ifnull(cg.descripcion,'NO REGISTRADO'), ".
					"ifnull(dp.descripcion,'NO REGISTRADO'), ".
					"ifnull(ct.descripcion,'NO REGISTRADO'), ".
					"case when pr.correo_personal = '' then 'NO REGISTRADO' else pr.correo_personal end, ".
					"case when pr.correo_institucional = '' then 'NO REGISTRADO' else pr.correo_institucional end, ".
					"case when pr.telefono = '' then 'NO REGISTRADO' else pr.telefono end, ".
					"case when pr.telefono_convencional = '' then 'NO REGISTRADO' else pr.telefono_convencional end, ".
					"case when pr.direccion = '' then 'NO REGISTRADO' else pr.direccion end, ".
					"us.usuario, ".
					"us.avatar, ".
					"pm.fecha_desde, ".
					"ifnull(pm.fecha_hasta,'SIN CADUCIDAD'), ".
					"pf.descripcion ".
			   "FROM tas_usuarios us ".
			  "INNER JOIN tgn_personal pr ".
				 "ON us.id_personal = pr.id_personal ".
			  "INNER JOIN tas_permisos pm ".
			 	 "ON pm.id_usuario = us.id_usuario ".
				"AND pm.estado = 'A' ".
			  "INNER JOIN tas_perfiles pf ".
				 "ON pf.id_perfil = pm.id_perfil ".
			   "LEFT JOIN tgn_cargos cg ".
				 "ON cg.id_cargo = pr.id_cargo ". 
			   "LEFT JOIN tgn_departamentos dp ".
			 	 "ON dp.id_departamento = pr.id_departamento ".
			   "LEFT JOIN tb_tipo_contratos ct ".
			   	 "ON ct.id_tipo_contrato = pr.id_relacion_laboral ".
			   "LEFT JOIN tb_generos gn ".
			 	 "ON gn.id_genero = pr.id_genero ".
		 	   "LEFT JOIN tb_estados_civiles ec ".
			 	 "ON ec.id_estado = pr.id_genero ".
			  "WHERE us.id_personal = ".$_SESSION["idUsuario"];

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){ 
			$rows[] = array_map('utf8_encode',$resultados);					 
		}
	}

	print json_encode($rows);


?>