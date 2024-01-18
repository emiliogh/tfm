<?php
	include("../conexion/class.conexion.php");
	$db = new MySQL();
      $consulta = $db->consulta("select ifnull(upper(p.descripcion),'SIN ASIGNAR'), ".
									   "case when m.estado = 'A' then 'ACT' else 'INA' end, ".
									   "ifnull(m.fecha_desde,'SIN ASIGNAR'), ".
									   "ifnull(m.fecha_hasta,'SIN ASIGNAR') ".
								  "from tgn_personal r ".
								  "left join tas_usuarios u ".
								    "on r.id_personal = u.id_personal ".
								   "and u.estado = 'A' ".
                                  "left join tas_permisos m ".
									"on m.id_usuario = u.id_usuario ".
                                  "left join tas_perfiles p ".
								    "on p.id_perfil = m.id_perfil ".
								   "and p.estado = 'A' ".
								 "where r.id_personal = ".$_POST["id"]." ".
								 "order by m.estado, m.fecha_creacion desc;");
		
		$tabla = '<table style="width: 350px; padding: 0px; margin: 0px;"><tr><td colspan="4" class="estilo">Permisos Asignados</td></tr>'.
				         '<tr><td class="estilo" style="font-size: 10px;">Perfil</td>'.
			                 '<td class="estilo" style="font-size: 10px;">Estado</td>'.
			                 '<td class="estilo" style="font-size: 10px;">Desde</td>'.
			                 '<td class="estilo" style="font-size: 10px;">Hasta</td></tr>';
		if($db->num_rows($consulta)>=0){
	    
			while($resultados = $db->fetch_array($consulta)){
				  $tabla = $tabla.'<tr>'.
									'<td class="estiloTDSinBG" '.
									    'style="padding: 0px; margin: 0px; font-size: 9px; text-align: center;">'.utf8_encode($resultados[0]).'</td>'.
									'<td class="estiloTDSinBG" '.
					                    'style="padding: 0px; margin: 0px; font-size: 9px; text-align: center;">'.$resultados[1].'</td>'.
									'<td class="estiloTDSinBG" '.
					                     'style="padding: 0px; margin: 0px; font-size: 9px; text-align: center;">'.$resultados[2].'</td>'.
									'<td class="estiloTDSinBG" '.
					                     'style="padding: 0px; margin: 0px; font-size: 9px; text-align: center;">'.$resultados[3].'</td>'.
								    '</tr>';
				}
		}
		
		$tablaUsu = $tabla.'</table>';
        $tabla = '';

	  $consulta = $db->consulta("SELECT ifnull(u.avatar,'0.png'), ".
									   "p.numero_identificacion, ".
									   "p.nombre, ".
									   "p.id_cargo, ".
									   "p.id_departamento, ".
									   "p.id_relacion_laboral, ".
									   "p.correo_personal, ".
									   "p.correo_institucional, ".
									   "p.telefono, ".
								       "u.usuario, ".
								       "ifnull(u.id_usuario,-1), ".
								       "case when u.estado = 'A' then 'ACTIVO' when u.estado = 'I' then 'INACTIVO' else 'SIN USUARIO' end, ".
								       "ifnull(u.estado,'N') ". 
								  "FROM tgn_personal p ".
								  "LEFT JOIN tas_usuarios u ".
								    "ON p.id_personal = u.id_personal ".
								 "where p.id_personal = ".$_POST["id"]);
$idCrg = 0;
$idDpto = 0;
$idTpCtt = 0;
if($db->num_rows($consulta)>=0){
while($resultados = $db->fetch_array($consulta)){
      $idCrg = $resultados[3];
	  $idDpto = $resultados[4];
	  $idTpCtt = $resultados[5];
	  $tabla = '<table '.
		          'style="width: 100%; padding: 0px; margin: 0px;">'.
		           '<tr><td colspan="4" class="estilo" style="color: #34495E; text-align: left;">Ficha del Personal</td></tr>'.
		           '<tr><td class="estilo" style="color: #34495E; font-size: 10px;">Avatar</td>'.
		            '<td class="estilo" style="color: #34495E; font-size: 10px; width: 20%; text-align: left;">Identificación</td>'.
		            '<td class="estiloTDSinBG" style="padding: 0px; margin: 0px; font-size: 10px; text-align: left;">'.
		                ''.$resultados[1].'</td></tr>'.
		           '<tr><td class="estiloTDSinBG" '.
		             'style="color: #34495E; padding: 0px; margin: 0px; font-size: 10px; text-align: center; width: 200px;" rowspan="7">'.
		               '<img src="../images/avatar/'.$resultados[0].'" style="height: 160px; width: 180px;"></td>'.
		             '<td class="estilo" style="color: #34495E; padding: 0px; margin: 0px; font-size: 10px; text-align: left;">Nombre</td>'.
		             '<td class="estiloTDSinBG" '.
					    'style="padding: 0px; margin: 0px; font-size: 9px; text-align: left;">'.
		                  ''.utf8_encode($resultados[2]).'</td></tr>'.
		             '<tr><td class="estilo" style="color: #34495E; padding: 0px; margin: 0px; font-size: 10px; text-align: left;">Perfil</td>
		               <td class="estiloTDSinBG" style="padding: 0px; margin: 0px; font-size: 9px; text-align: left;">'.
		                '<select id="idCargoUsuario" style="width: 100%; height: 100%;" disabled></select></td></tr>'.
		             '<tr><td class="estilo" style="color: #34495E; padding: 0px; margin: 0px; font-size: 10px; text-align: left;">Unidad</td>'.
		               '<td class="estiloTDSinBG" style="padding: 0px; margin: 0px; font-size: 9px; text-align: left;">'.
		                '<select id="idDepartamentoUsuario" style="width: 100%; height: 100%;" disabled></select></td></tr>'.
		             '<tr><td class="estilo" style="color: #34495E;padding:0px;margin:0px; font-size:10px;text-align:left;">Email personal</td>'.
		               '<td class="estiloTDSinBG" '.
		                 'style="padding: 0px; margin: 0px; font-size: 9px; text-align: left;">'.
		                    ''.$resultados[6].'</td></tr>'.
		             '<tr><td class="estilo" style="color: #34495E; padding: 0px; margin: 0px; font-size: 10px; text-align: left;">'.
		                   'Email notificación</td>'
		                 .'<td class="estiloTDSinBG" '.
		                  'style="padding: 0px; margin: 0px; font-size: 9px; text-align: left;">'.
		                    ''.$resultados[7].'</td></tr>'.
		              '<tr><td class="estilo" style="color: #34495E; padding: 0px; margin: 0px; font-size: 10px; text-align: left;">'.
		                'Telefóno Contacto</td>'
		                 .'<td class="estiloTDSinBG" '.
		                    'style="padding: 0px; margin: 0px; font-size: 9px; text-align: left;">'.
		                     ''.$resultados[8].'</td></tr>'.
		              '<tr><td colspan="3" class="estilo" style="color: #34495E; text-align: left;">Ficha del Usuario</td></tr>'. 
		              '<tr><td colspan="3"><table style="width: 100%">'.
		                       '<tr><td class="estilo" style="color: #34495E; padding: 0px; margin: 0px; font-size: 10px; text-align: left;">Usuario:</td>'.
		                           '<td class="estiloTDSinBG" style="padding: 0px; margin: 0px; text-align: left;">'.
		                             ''.utf8_encode($resultados[9]).'</td>'.
		                           '<td class="estilo" style="color: #34495E; padding: 0px; margin: 0px; font-size: 10px; text-align: left;">Estado</td>'.
		   						   '<td class="estiloTDSinBG" style="text-align: left;">'.
		                             '<input type="text" id="idUsuarioPrl" style="display: none;" value="'.$resultados[10].'"/>'.
		  						       $resultados[11].'</td>'.
		                       '</tr></table></td></tr>'.
		              '<tr><td colspan="3" style="height: 20p;"><br><br></td></tr>'. 
		              '<tr><td colspan="3" class="estilo">Ficha de Permisos asignados al usuario</td></tr>'. 
		              '<tr><td colspan="3"><table style="width: 100%">'.
		                       '<tr><td class="estilo">Perfil:</td>'.
		                           '<td class="estiloTDSinBG" style="padding: 0px; margin: 0px;">'.
		                             '<select id="idPerfilUsuario" style="width: 100%; height: 100%;"></select></td>'.
		                           '<td class="estilo">Hasta (opcional):</td>'.	
		                           '<td class="estiloTDSinBG" style="padding: 0px; margin: 0px;">'.
		                             '<input id="fechaHasta" onFocus="this.blur()" class="form-control" style="width: 100%"></td>'.
		                       '</tr></table></td></tr>'.      
		              '<tr><td colspan="3"><table style="width: 100%">'.
		                       '<tr><td style="width: 33%"><button class="button" onClick="nuevosPermisos();" style="width: 100%">ASIGNAR <br>NUEVOS PERMISOS</button></td>'.
		  						  '<td style="width: 33%"><button class="button button3" onClick="desactivarPermisos();" style="width: 100%">DESACTIVAR <br>PERMISOS</button></td>'.
		                           '<td style="width: 34%"><button class="button button4" onClick="desactivarUPermisos();" style="width: 100%">DESACTIVAR PERMISOS/USUARIO</button></td>'.
		                        '</tr></table></td></tr>';		  
				}
		}
		
		$tabla = $tabla.'</table>'.
			              '<script>var cmbCrg=new componente.cmb; '.
			                          'cmbCrg.ini("idCargoUsuario"); '.
			                          'cmbCrg.loadFromUrlMod("../cmb/cmbCargos.php",{v:'.$idCrg.'});'.
								  'var cmbDpto=new componente.cmb; '.
			                          'cmbDpto.ini("idDepartamentoUsuario"); '.
			                          'cmbDpto.loadFromUrlMod("../cmb/cmbDepartamentos.php",{v:'.$idDpto.'});'.
								  'var cmbPerf=new componente.cmb; '.
			                          'cmbPerf.ini("idPerfilUsuario"); '.
			                          'cmbPerf.loadFromUrl("../cmb/cmbPerfiles.php");'.
			                      '$.datetimepicker.setLocale("es");'.
									'$("#fechaHasta").datetimepicker({'.
										'dayOfWeekStart : 1,'.
										'timepicker:false,'.
										'format:"d/m/Y",'.
										'formatDate:"Y/m/d"'.
									'});'.
			              '</script>';
		
	$array = array(0 => ($tablaUsu),
				   1 => ($tabla));	
		
	
	echo json_encode($array);
?>