<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
   if ($_POST['id']==0){
	   $options = array(0 => '');
		echo json_encode($options);
	   	 return;
   }
   $query = "select ct.codigo, 
					ct.descripcion, 
					ifnull(pr.total_debe,0), 
					ifnull(pr.total_haber,0),
					ifnull(pr.estado,'I'),
					(select count(*) 
           			  from tfn_cuentas_contables s 
         			 where s.id_cuenta_padre = ct.id_cuenta),
					 ct.id_cuenta
			   from tfn_cuentas_contables ct
			   left join tfn_cuentas_periodo pr 
				 on pr.id_cuenta_contable = ct.id_cuenta
			    and pr.id_periodo = '".$_POST['id']."'
			  order by ct.codigo, ct.id_cuenta_padre";

	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	
    $tabla = '';
	$i = 1;
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){
			$schk = '';
			$styl = '';
			  if ($resultados[5] == '0'){
				  $styl = ' font-weight: 200;';
				  if ($resultados[4] == 'A'){
					  $schk = '<table style="width:60px; vertical-align: middle; font-size: 9px;">'.
									'<tr><td>NO</td><td>'.
										'<label class="switch">'.
											'<input type="checkbox" id="chk'.$resultados[6].'" checked '.
						  						'onChange="guardaCambioCuenta('.$resultados[6].','.
						  													    $resultados[2].','.
						  													    $resultados[3].')">'.
												'<span class="slider round"></span></label></td>'.
									 '<td>SI</td></tr></table>';
				  	}else{
					  $schk = '<table style="width:60px; vertical-align: middle; font-size: 9px;">'.
									'<tr><td>NO</td><td>'.
										'<label class="switch">'.
											'<input type="checkbox" id="chk'.$resultados[6].'" '.
						  						'onChange="guardaCambioCuenta('.$resultados[6].','.
						  													    $resultados[2].','.
						  													    $resultados[3].')">'.
												'<span class="slider round"></span></label></td>'.
									 '<td>SI</td></tr></table>';
				  }
			  	}else{$styl = 'background: #ADD0F9;';}
			
			  $tabla = $tabla.'<tr style="color: #000; border: 1px solid #4ba6c0;">'.
				   				  '<td style="text-align: center;'.$styl.'">'.$i.'</td>'.
				  				  '<td style="text-align: left;'.$styl.'">'.$resultados[0].'</td>'.
								  '<td style="text-align: left;'.$styl.'">'.utf8_encode($resultados[1]).'</td>'.
				  				  '<td style="text-align: right;'.$styl.'">'.number_format($resultados[2],2).'</td>'.
				  				  '<td style="text-align: right;'.$styl.'">'.number_format($resultados[3],2).'</td>'.
				  				  '<td style="text-align: center;'.$styl.'">'.$schk.'</td></tr>';
			$i++;
		}
	}	

	
	$options = array(0 => $tabla);

	echo json_encode($options);
	   
?>
