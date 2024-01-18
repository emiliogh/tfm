<?php
 SESSION_START();
 
	include("../conexion/class.conexion.php");
	$db = new MySQL();
		
		$consulta = $db->consulta(" select coalesce(max(p.secuencia),0)
									  from tgn_menu_x_perfiles p
									 where p.id_perfil = ".$_POST["idp"]."
									   and p.id_menu = ".$_POST["idm"].";");
		
		$secuencia = 0;
		if($db->num_rows($consulta)>=0){	    
			while($resultados = $db->fetch_array($consulta)){
				  $secuencia = $resultados[0];		  
				}
		}
		

		if ($_POST["estd"]=='A'){
			$consultax = $db->consulta(" select m.id_menu
										  from tgn_menu_opciones m
										 where m.tipo_menu = 'M'
										   and m.codigo = '".$_POST["codigo"]."';");
			
			$idmenuP = 0;
			if($db->num_rows($consultax)>=0){	    
				while($resultados = $db->fetch_array($consultax)){
					  $idmenuP = $resultados[0];

					   echo $idmenuP.'***';
					}
			}
			
			
				
				$secuenciaP=1;
				$estaP = 'I';
				
				$consulta = $db->consulta(" select coalesce(max(p.secuencia),0),coalesce(p.estado,'I')
											  from tgn_menu_x_perfiles p
											  left join tgn_menu_opciones m
												on m.id_menu = p.id_menu
											 where p.id_perfil = ".$_POST["idp"]."
											   and p.id_menu = ".$idmenuP."
											 group by coalesce(p.estado,'I')
											 order by 1 desc
											 limit 1 offset 0;");
				
				if($db->num_rows($consulta)>=0){	    
					while($resultados = $db->fetch_array($consulta)){
						  $secuenciaP = $resultados[0];
						  $estaP = $resultados[1];	

						  echo 'ASSSS'.$estaP.'*'.$resultados[1];
						}
				}
				
				
			if ($estaP == 'I'){
				$stmt = null;
				
				$secuenciaP++;
				$consulta = $db->consulta("insert into tgn_menu_x_perfiles ".
										  "values(".$_POST["idp"].",".$idmenuP.",".$secuenciaP.",now(),'A','".$_SESSION["idUsuario"]."',null,null);");
				
			}
			
			$secuencia++;
			$consulta = $db->consulta("insert into tgn_menu_x_perfiles ".
									  "values(".$_POST["idp"].",".$_POST["idm"].",".$secuencia.",now(),'A','".$_SESSION["idUsuario"]."',null,null);");
			
			
		}else{$consulta = $db->consulta(" update tgn_menu_x_perfiles
											 set estado = 'I',
												 fecha_revocacion = now(),
												 usuario_revocacion = '".$_SESSION["idUsuario"]."'
										   where id_perfil = ".$_POST["idp"]."
											 and id_menu = ".$_POST["idm"]."
											 and secuencia = ".$secuencia.";");
			  			  
			  $consulta = $db->consulta("select count(*)
										   from tgn_menu_opciones m
										  inner join tgn_menu_x_perfiles p
											 on m.id_menu = p.id_menu
										  where m.tipo_menu = 'S'
										    and p.estado = 'A'
										    and m.codigo = '".$_POST["codigo"]."';");
				$verifica = 0;
				if($db->num_rows($consulta)>=0){	    
					while($resultados = $db->fetch_array($consulta)){
						  $verifica = $resultados[0];		  
						}
				}
				
				if ($verifica==0){
					$consulta = $db->consulta(" update tgn_menu_x_perfiles p
												 inner join tgn_menu_opciones m
													on m.id_menu = p.id_menu
												   set p.estado = 'I',
													   p.fecha_revocacion = now(),
													   usuario_revocacion = '".$_SESSION["idUsuario"]."'
												 where p.id_perfil = ".$_POST["idp"]." 
												   and m.tipo_menu = 'M'
												   and m.codigo = '".$_POST["codigo"]."'
												   and p.estado = 'A';");
				}
			
			  }
		
		
		//$array = array(0 => $tabla);	
		
	
	//echo json_encode($array);
?>