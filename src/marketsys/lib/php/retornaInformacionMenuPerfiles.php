<?php
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	  $consulta = $db->consulta("SELECT m.id_menu,
										coalesce(p.estado,'I'),
										upper(m.definicion),
										upper(m.definicion),
										m.orden,
										m.codigo
								   FROM tgn_menu_opciones m
								   LEFT join tgn_menu_x_perfiles p
									 ON p.id_menu = m.id_menu
									AND p.estado = 'A'
									AND p.id_perfil = ".$_POST['idp']." 
								  WHERE m.estado = 'A'
									AND m.tipo_menu = 'S'
									AND m.codigo = '".$_POST['idm']."' 
								  ORDER BY orden");
		
		$tabla = '<table style="width: 100%; padding: 0px; margin: 0px;">'.
						'<tr><td class="estilo" style="font-size: 10px;">MENÚ</td><td class="estilo" style="font-size: 10px;">OBSERVACIÓN</td><td class="estilo" style="font-size: 10px;">HABILITADO</td></tr>';;
			
		if($db->num_rows($consulta)>=0){
	    
			while($resultados = $db->fetch_array($consulta)){
				  $schk = '';
				  if ($resultados[1] == 'A'){
					  $schk = '<table style="width:60px; vertical-align: middle; font-size: 9px;"><tr><td>NO</td><td><label class="switch"><input id="chk'.$_POST['idp'].utf8_encode($resultados[0]).'" type="checkbox" checked onChange="guardaMenuPerfil('.$_POST['idp'].','.utf8_encode($resultados[0]).','.chr(39).'chk'.$_POST['idp'].utf8_encode($resultados[0]).chr(39).','.chr(39).utf8_encode($resultados[5]).chr(39).')"><span class="slider round"></span></label></td><td>SI</td></tr></table>';
				  }else{$schk = '<table style="width:60px; vertical-align: middle; font-size: 9px;"><tr><td>NO</td><td><label class="switch"><input id="chk'.$_POST['idp'].utf8_encode($resultados[0]).'" type="checkbox" onChange="guardaMenuPerfil('.$_POST['idp'].','.utf8_encode($resultados[0]).','.chr(39).'chk'.$_POST['idp'].utf8_encode($resultados[0]).chr(39).','.chr(39).utf8_encode($resultados[5]).chr(39).')"><span class="slider round"></span></label></td><td>SI</td></tr></table>';}
					  
					$tabla = $tabla.'<tr>
										<td class="estiloTDSinBG" style="padding: 0px; margin: 0px; width: 30%; font-size: 9px; text-align: left;">'.utf8_encode($resultados[2]).'</td>
										<td class="estiloTDSinBG" style="padding: 0px; margin: 0px; font-size: 9px; text-align: left;">'.utf8_encode($resultados[3]).'</td>
										<td class="estiloTDSinBG" style="padding: 0px; margin: 0px; width: 65px; text-align: center;">'.$schk.'</td>
									 </tr>';		  
				}		
		}	
		
		$tabla = $tabla.'</table>';
		
	
	$array = array(0 => $tabla);	
		
	
	echo json_encode($array);
?>