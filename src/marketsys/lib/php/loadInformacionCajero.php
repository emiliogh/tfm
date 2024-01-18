<?php
SESSION_START();

//include_once("../conexion/conexion.class.php");

include_once("../../lib/conexion/class.conexion.php");
$db = new MySQL();
$query = "select pr.id_personal, 
				 pr.numero_identificacion, 
				 UPPER(pr.nombre) nombre,
				 e.id_establecimiento, 
				 e.definicion establecimiento, 
				 e.codigo_establecimiento, 
				 p.id_punto_emision, 
				 p.definicion punto_emision, 
				 p.codigo_punto 
			from tgn_personal pr 
		   inner join tas_usuarios u 
			  on pr.id_personal = u.id_personal 
		   inner join tsc_personal_punto_emision pe 
			  on pr.id_personal = pe.id_personal 
			 and pe.estado = 'A' 
		   inner join tsc_puntos_emision p 
			  on pe.id_establecimiento = p.id_establecimiento 
			 and pe.id_punto_emision = p.id_punto_emision 
			 and p.estado = 'A'
		   inner join tsc_establecimientos e 
			  on e.id_establecimiento = pe.id_establecimiento
			 and e.id_tipo_establecimiento = 1  
			 and e.estado = 'A' 
		   WHERE u.usuario = '".$_SESSION["usuarioMS"]."';";
	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	$options =array();
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){ 
		      array_push($options,array_map('utf8_encode',$resultados));
		      }
	   }	
	
	echo json_encode($options);
	   
?>
