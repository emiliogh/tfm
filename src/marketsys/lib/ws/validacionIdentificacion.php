<?php
	$tipo = $_POST['tipo'];
	$usuario =  $_POST['num'];

    if ($tipo==1){
		$ch = curl_init();
		// definimos la URL a la que hacemos la petición
		curl_setopt($ch, CURLOPT_URL,"http://certificados.ministeriodegobierno.gob.ec/gestorcertificados/antecedentes/data.php");
		// indicamos el tipo de petición: POST
		curl_setopt($ch, CURLOPT_POST, TRUE);
		// definimos cada uno de los parámetros
		curl_setopt($ch, CURLOPT_POSTFIELDS, "tipo=getDataWs&ci=".$usuario."&tp=C&ise=SI");
		// recibimos la respuesta y la guardamos en una variable
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		// cerramos la sesión cURL
		curl_close ($ch);
		// hacemos lo que queramos con los datos recibidos	
		$cadena = preg_replace('([^A-Za-z0-9", /])', '', $remote_server_output);
		$cadena = str_replace("u00d1", "Ñ", $cadena);

			$i = count(explode(",", $cadena));

			$datos = explode(',', $cadena, $i);
			//echo ($cadena);
		
			$error 		= 	strtoupper(str_replace("error", "", (str_replace('"', "", $datos[0]))));
			$ci 		= 	strtoupper(str_replace("identity", "", (str_replace('"', "", $datos[1]))));
			$nombre		= 	strtoupper(str_replace("name", "", (str_replace('"', "", $datos[2]))));
			
			$array = array(0 => utf8_encode($errores),
						   1 => utf8_encode($ci),
						   2 => $nombre);
							
			echo json_encode($array);				
		}

	function getNombreSplit($nombreCompleto, $apellido_primero = false){
		  /* separar el nombre completo en espacios */
		  $tokens = explode(' ', trim($nombreCompleto));
		  /* arreglo donde se guardan las "palabras" del nombre */
		  $names = array();
		  /* palabras de apellidos (y nombres) compuetos */
		  $special_tokens = array('DE LOS','DA', 'DE', 'DEL', 'LA', 'LAS', 'LOS', 'MAC', 'MC', 'VAN', 'VON', 'Y', 'I', 'SAN', 'SANTA');
		  
		  $prev = "";
		  foreach($tokens as $token) {
			  $_token = strtolower($token);
			  if(in_array($_token, $special_tokens)) {
				  $prev .= "$token ";
			  } else {
				  $names[] = $prev. $token;
				  $prev = "";
			  }
		  }
		  
		  $num_nombres = count($names);
		  $nombres = $apellidos = "";
		  switch ($num_nombres) {
			  case 0:
				  $nombres = '';
				  break;
			  case 1: 
				  $nombres = $names[0];
				  break;
			  case 2:
				  $nombres    = $names[0];
				  $apellidos  = $names[1];
				  break;
			  case 3:
				  $apellidos = $names[0] . ' ' . $names[1];
				  $nombres   = $names[2];
			  default:
				  $apellidos = $names[0] . ' '. $names[1];
				  unset($names[0]);
				  unset($names[1]);
				  
				  $nombres = implode(' ', $names);
				  break;
		  }
		  
		  $nombres    = mb_convert_case($nombres, MB_CASE_UPPER, 'UTF-8');
		  $apellidos  = mb_convert_case($apellidos, MB_CASE_UPPER, 'UTF-8');
		  
		  
		  // LIMPIEZA DE ESPACIOS
			$nombre["Materno"] = trim($apellidos);
			$nombre["Paterno"] = trim($nombres);
			
			return $nombre;
		  
		  
	}

?>
