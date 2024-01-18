<?php
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	  $consulta = $db->consulta("select upper(u.usuario), 
										case when u.estado = 'A' then 'ACT' else 'INA' end,
										m.fecha_desde,
										m.fecha_hasta
								   from tgn_personal p
                                  inner join tas_usuarios u
                                     on u.id_personal = p.id_personal
                                    and u.estado = 'A' 
								  inner join tas_permisos m 
									 on m.id_usuario = u.id_usuario
                                    and m.estado = 'A' 
								  where m.id_perfil = ".$_POST["id"]."
								  order by m.estado, m.fecha_desde;");
		
		$tabla = '<table style="width: 350px; padding: 0px; margin: 0px;"><tr><td colspan="4" class="estilo">Usuarios Asignados</td></tr>'.
				         '<tr><td class="estilo" style="font-size: 10px;">Usuario</td><td class="estilo" style="font-size: 10px;">Estado</td><td class="estilo" style="font-size: 10px;">Desde</td><td class="estilo" style="font-size: 10px;">Hasta</td></tr>';
		if($db->num_rows($consulta)>=0){
	    
			while($resultados = $db->fetch_array($consulta)){
				  $tabla = $tabla.'<tr>
									<td class="estiloTDSinBG" style="padding: 0px; margin: 0px; font-size: 9px; text-align: left;">'.utf8_decode($resultados[0]).'</td>
									<td class="estiloTDSinBG" style="padding: 0px; margin: 0px; font-size: 9px; text-align: center;">'.$resultados[1].'</td>
									<td class="estiloTDSinBG" style="padding: 0px; margin: 0px; font-size: 9px; text-align: right;">'.$resultados[2].'</td>
									<td class="estiloTDSinBG" style="padding: 0px; margin: 0px; font-size: 9px; text-align: right;">'.$resultados[3].'</td>
								 </tr>';		  
				}
		}
		
		$tabla = $tabla.'</table>';
		
	$array = array(0 => $tabla);	
		
	
	echo json_encode($array);
?>