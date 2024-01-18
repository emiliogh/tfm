<?php 
  include("lib/conexion/class.conexion.php");
    $db = new MySQL();
      $query = "SELECT m.script_html, m.script_html2, m.tipo_menu ".
				 "FROM tgn_menu_x_perfiles p ".
				"INNER JOIN tgn_menu_opciones m ".
				   "ON m.id_menu = p.id_menu ".
				  "AND p.estado = 'A' ".
				"WHERE p.id_perfil = ".$_SESSION["idperfil"]." ".
				"ORDER BY m.codigo, m.tipo_menu, m.orden;";

    //echo  $query;            
    $consulta = $db->consulta($query);
    
    $dev = ''; 
    $numInt = 0;
	$finLine = '';
    $numResul = $db->num_rows($consulta);
    if($numResul>0){
       while($resultados = $db->fetch_array($consulta)){ 	 
			 if (!strcmp($resultados[2],'M')){
				 $dev = $dev.$finLine;
				 $finLine = $resultados[1];
				}
			$dev = $dev.$resultados[0];		
       }
    }

  echo utf8_encode($dev.$finLine);

  ?>
  
  