<?php
   SESSION_START();
   crearFactura($_GET['idfactura']);
	date_default_timezone_set('America/Guayaquil');
   //crearFactura(14);

function crearFactura($idfactura){
    include_once("../conexion/class.conexion.php");
	//include_once("../facturaElectronica/procesaFacturaElectronica.php");
	$db = new MySQL();
	$upd = "update tsc_facturas
			   set monto_descuento = (select sum(d.descuento)
										from tsc_detalles_factura d
									   where d.id_factura = '".$idfactura."')
			 where id_factura = '".$idfactura."';";
	$consulta = $db->consulta($upd);
	
	$qry = "select m.numero_identificacion,
				   m.razon_social,
				   m.nombre_comercial,
				   m.abreviatura,
				   t.id_ambiente,
				   t.id_tipo_emision,
				   ifnull(t.id_contribuyente_especial,0),
				   case when t.obligado_contabilidad = 'S' then 'SI' when t.obligado_contabilidad = 'N' then 'NO' end,
				   t.id_moneda,
				   t.codigo_facturacion,
				   t.url_documentos_generados,
				   e.codigo_establecimiento,
				   z.direccion,
				   e.direccion,
				   p.codigo_punto,
				   LPAD(f.secuencia_factura,9,'0'),
				   f.numero_factura,
				   DATE_FORMAT(f.fecha_factura,'%d/%m/%Y'),
				   '01',
				   concat(DATE_FORMAT(f.fecha_factura,'%d%m%Y'),'01',m.numero_identificacion,t.id_ambiente,".
		                  "e.codigo_establecimiento,p.codigo_punto,LPAD(f.secuencia_factura,9,'0'),t.codigo_facturacion,".
						  "t.id_tipo_emision),
				   s.codigo_identificacion,
				   c.numero_identificacion,
				   c.nombre_cliente,
				   ifnull(c.direccion,'SIN DIRECCION REGISTRADA'),
				   c.correo_electronico,
				   c.telefono,
				   f.fecha_factura,
				   f.id_forma_pago,
				   f.monto_subtotal,
				   f.monto_descuento descuentos,
				   f.monto_subtotal0,
				   f.monto_subtotal_impuesto,
				   f.porcentaje_impuesto,
				   f.monto_impuesto,
				   f.monto_total,
				   f.monto_retenciones,
				   f.saldo_pendiente,
				   'DOLAR',
				   g.codigo,
				   g.tiempo_vigencia,
				   concat('01',e.codigo_establecimiento,p.codigo_punto,LPAD(f.secuencia_factura,9,'0')),
				   d.linea_factura,
				   d.id_rubro,
				   d.id_producto,
				   i.descripcion,
				   d.descripcion_rubro,
				   d.cantidad,
				   d.precio_venta,
				   d.subtotal,
				   d.descuento,
				   id_graba_iva,
				   f.porcentaje_impuesto,
				   f.porcentaje_impuesto*d.total/100,
				   d.total,
				   t.url_firma_electronica,
				   t.contrasena_firma,
				   t.url_documentos_firmados
			  from tsc_facturas f
			 inner join tsc_detalles_factura d
				on f.id_factura = d.id_factura
			 inner join tsc_formas_pago g
			    on g.id_forma_pago = f.id_forma_pago
			 inner join tcu_clientes c
				on c.id_cliente = f.id_cliente
			 inner join tb_tipos_identificacion s
			    on s.id_tipo_identificacion = c.id_tipo_identificacion
			 inner join tiv_items i
				on d.id_rubro = i.id_item
			 inner join tsc_establecimientos z
				on z.identificador_matriz = 'S' 
			   and z.id_tipo_establecimiento = 1	
			   and z.estado = 'A'
			 inner join tsc_establecimientos e
				on f.id_establecimiento = e.id_establecimiento
			   and e.id_tipo_establecimiento = 1
			   and e.estado = 'A'
			 inner join tsc_puntos_emision p
				on p.id_establecimiento = f.id_establecimiento
			   and p.id_punto_emision = f.id_puntos_venta
			   and p.estado = 'A'
			 inner join tgn_empresas m
				on m.estado = 'A'
			 inner join tgn_empresas_info_tributaria t
				on t.estado = 'A'
			   and t.id_empresa = m.id_empresa
			 where f.id_factura = '".$idfactura."'";
	
	$consulta = $db->consulta($qry);
	$i = 0;
	$url = '';
	$nmbXML = '';
	$firma	= '';
	$urlFirma = '';
	$contasena = '';
	$correo = '';
	$telefono = '';
	$clvAccesoSri = '';
	/*Recorrido de Datos*/
	if($db->num_rows($consulta)>=0){
	  $detalles = '';	
	  while($resultados = $db->fetch_array($consulta)){ 
	      if ($i == 0){
			  $xml = new DomDocument('1.0', 'UTF-8');
				$factura = $xml->createElement('factura');
					$factura->setAttribute('id', 'comprobante'); $factura->setAttribute('version','1.0.0');
					$factura = $xml->appendChild($factura);

					$infoTributaria = $xml->createElement('infoTributaria');
						$infoTributaria = $factura->appendChild($infoTributaria); 

						$ambiente = $xml->createElement('ambiente',$resultados[4]);
							$ambiente = $infoTributaria->appendChild($ambiente);
						$tipoEmision = $xml->createElement('tipoEmision',$resultados[5]);
							$tipoEmision = $infoTributaria->appendChild($tipoEmision);
						$razonSocial = $xml->createElement('razonSocial',$resultados[1]);
							$razonSocial = $infoTributaria->appendChild($razonSocial);
						if ($resultados[2] != ''){
			                $nombreComercial = $xml->createElement('nombreComercial',$resultados[2]);
							   $nombreComercial = $infoTributaria->appendChild($nombreComercial);}
						$ruc = $xml->createElement('ruc',$resultados[0]);
							$ruc = $infoTributaria->appendChild($ruc);
			            $digitoVerificador = obtenerSumaPorDigitos(invertirCadena($resultados[19]));
						$claveAcceso = $xml->createElement('claveAcceso',$resultados[19].$digitoVerificador);
			 			$clvAccesoSri = $resultados[19].$digitoVerificador;
			               $claveAcceso = $infoTributaria->appendChild($claveAcceso);
						$codDoc = $xml->createElement('codDoc',$resultados[18]);
							$codDoc = $infoTributaria->appendChild($codDoc);	
						$estab = $xml->createElement('estab',$resultados[11]);
							$estab = $infoTributaria->appendChild($estab);
						$ptoEmi = $xml->createElement('ptoEmi',$resultados[14]);
							$ptoEmi = $infoTributaria->appendChild($ptoEmi);
						$secuencial = $xml->createElement('secuencial',$resultados[15]);
							$secuencial = $infoTributaria->appendChild($secuencial);
						$dirMatriz = $xml->createElement('dirMatriz',sanear_string(utf8_encode($resultados[12])));
							$dirMatriz = $infoTributaria->appendChild($dirMatriz);

					$infoFactura = $xml->createElement('infoFactura');
						$infoFactura = $factura->appendChild($infoFactura);

						$fechaEmision = $xml->createElement('fechaEmision',$resultados[17]);
							$fechaEmision = $infoFactura->appendChild($fechaEmision);
				        $dirEstablecimiento = $xml->createElement('dirEstablecimiento',sanear_string(utf8_encode($resultados[13])));
							$dirEstablecimiento = $infoFactura->appendChild($dirEstablecimiento);
						if ($resultados[6] != '0'){
			 			    $contribuyenteEspecial = $xml->createElement('contribuyenteEspecial',$resultados[6]);
							    $contribuyenteEspecial = $infoFactura->appendChild($contribuyenteEspecial);}
						$obligadoContabilidad = $xml->createElement('obligadoContabilidad',$resultados[7]);
							$obligadoContabilidad = $infoFactura->appendChild($obligadoContabilidad);
						$tipoIdentificacionComprador = $xml->createElement('tipoIdentificacionComprador',$resultados[20]);
							$tipoIdentificacionComprador = $infoFactura->appendChild($tipoIdentificacionComprador);
						$razonSocialComprador = $xml->createElement('razonSocialComprador',$resultados[22]);
							$razonSocialComprador = $infoFactura->appendChild($razonSocialComprador);
						$identificacionComprador = $xml->createElement('identificacionComprador',$resultados[21]);
							$identificacionComprador = $infoFactura->appendChild($identificacionComprador);	
						$dirCmp = '';
			            if ($resultados[23] == ''){$dirCmp='SIN DIRECCION REGISTRADA';}else{$dirCmp = $resultados[23];}
			            $direccionComprador = $xml->createElement('direccionComprador',$dirCmp);
							$direccionComprador = $infoFactura->appendChild($direccionComprador);
						$totalSinImpuestos = $xml->createElement('totalSinImpuestos',$resultados[28]);
							$totalSinImpuestos = $infoFactura->appendChild($totalSinImpuestos);
						$totalDescuento = $xml->createElement('totalDescuento',number_format($resultados[29],2));
							$totalDescuento = $infoFactura->appendChild($totalDescuento);

							$totalConImpuestos = $xml->createElement('totalConImpuestos');
								$totalConImpuestos = $infoFactura->appendChild($totalConImpuestos);
			 					if ($resultados[30] > 0 ){
									$totalImpuesto = $xml->createElement('totalImpuesto');
									$totalImpuesto = $totalConImpuestos->appendChild($totalImpuesto);
										$codigo = $xml->createElement('codigo','2');
											$codigo = $totalImpuesto->appendChild($codigo);
										$codigoPorcentaje = $xml->createElement('codigoPorcentaje','0');
											$codigoPorcentaje = $totalImpuesto->appendChild($codigoPorcentaje);
									    /*$descuentoAdicional = $xml->createElement('descuentoAdicional','0');
											$descuentoAdicional = $totalImpuesto->appendChild($descuentoAdicional);*/
										$baseImponible = $xml->createElement('baseImponible',number_format($resultados[30],2,".",""));
											$baseImponible = $totalImpuesto->appendChild($baseImponible);
									    $tarifa = $xml->createElement('tarifa','0');
											$tarifa = $totalImpuesto->appendChild($tarifa);
										$valor = $xml->createElement('valor','0');
											$valor = $totalImpuesto->appendChild($valor);
									}
			 					if ($resultados[31] > 0 ){
									$totalImpuesto = $xml->createElement('totalImpuesto');
									$totalImpuesto = $totalConImpuestos->appendChild($totalImpuesto);
										$codigo = $xml->createElement('codigo','2');
											$codigo = $totalImpuesto->appendChild($codigo);
										$codigoPorcentaje = $xml->createElement('codigoPorcentaje','2');
											$codigoPorcentaje = $totalImpuesto->appendChild($codigoPorcentaje);
									     //$descuentoAdicional = $xml->createElement('descuentoAdicional','0');
											//$descuentoAdicional = $totalImpuesto->appendChild($descuentoAdicional);
										$baseImponible = $xml->createElement('baseImponible',$resultados[31]);
											$baseImponible = $totalImpuesto->appendChild($baseImponible);
									    $tarifa = $xml->createElement('tarifa',$resultados[51]);
											$tarifa = $totalImpuesto->appendChild($tarifa);
										$valor = $xml->createElement('valor',$resultados[33]);
											$valor = $totalImpuesto->appendChild($valor);	
								}
			 
						$propina = $xml->createElement('propina','0.00');
							$propina = $infoFactura->appendChild($propina);
						$importeTotal = $xml->createElement('importeTotal',$resultados[34]);
							$importeTotal = $infoFactura->appendChild($importeTotal);
						$moneda = $xml->createElement('moneda',$resultados[37]);
							$moneda = $infoFactura->appendChild($moneda);

							$pagos = $xml->createElement('pagos');
								$pagos = $infoFactura->appendChild($pagos);
								$pago = $xml->createElement('pago');
								$pago = $pagos->appendChild($pago);
									$formaPago = $xml->createElement('formaPago',$resultados[38]);
										$formaPago = $pago->appendChild($formaPago);
									$total = $xml->createElement('total',$resultados[34]);
										$total = $pago->appendChild($total);
									$plazoPago = $xml->createElement('plazo',$resultados[39]);
										$plazoPago = $pago->appendChild($plazoPago);	
									$unidadTiempo = $xml->createElement('unidadTiempo','dias');
										$unidadTiempo = $pago->appendChild($unidadTiempo);
		 	 			$i = 1;
			            $url = $resultados[10];
			 			$nmbXML = $resultados[40];
		 				$firma	= $resultados[54];
						$urlFirma = $resultados[56];
						$contasena = $resultados[55];
		 				$correo = $resultados[24];
						$telefono = $resultados[25];
			  
		  		$detalles = $xml->createElement('detalles');
		  			$detalles = $factura->appendChild($detalles);
		  }
		  
		  //Detalles de Factura
		     $detalle = $xml->createElement('detalle');
				$detalle = $detalles->appendChild($detalle);
				$codigoPrincipal = $xml->createElement('codigoPrincipal',$resultados[42]);
					$codigoPrincipal = $detalle->appendChild($codigoPrincipal);
		        $codigoAuxiliar = $xml->createElement('codigoAuxiliar',$resultados[43]);
					$codigoAuxiliar = $detalle->appendChild($codigoAuxiliar);
				$descripcion = $xml->createElement('descripcion',sanear_string(utf8_encode($resultados[44])));
					$descripcion = $detalle->appendChild($descripcion);	
				$cantidad = $xml->createElement('cantidad',$resultados[46]);
					$cantidad = $detalle->appendChild($cantidad);
				$precioUnitario = $xml->createElement('precioUnitario',$resultados[47]);
					$precioUnitario = $detalle->appendChild($precioUnitario);
				$descuento = $xml->createElement('descuento',number_format($resultados[49],2));
					$descuento = $detalle->appendChild($descuento);
				$precioTotalSinImpuesto = $xml->createElement('precioTotalSinImpuesto',$resultados[48]);
					$precioTotalSinImpuesto = $detalle->appendChild($precioTotalSinImpuesto);
					
					$impuestos = $xml->createElement('impuestos');
						$impuestos = $detalle->appendChild($impuestos);
						if ($resultados[50] == 1){
							$impuesto = $xml->createElement('impuesto');
								$impuesto = $impuestos->appendChild($impuesto);
								$codigo = $xml->createElement('codigo','2');
									$codigo = $impuesto->appendChild($codigo);
								$codigoPorcentaje = $xml->createElement('codigoPorcentaje','2');
									$codigoPorcentaje = $impuesto->appendChild($codigoPorcentaje);
								$tarifa = $xml->createElement('tarifa',$resultados[51]);
									$tarifa = $impuesto->appendChild($tarifa);
								$baseImponible = $xml->createElement('baseImponible',$resultados[48]);
									$baseImponible = $impuesto->appendChild($baseImponible);
								$valor = $xml->createElement('valor',number_format($resultados[52],2));
									$valor = $impuesto->appendChild($valor);
							}else{
								$impuesto = $xml->createElement('impuesto');
								$impuesto = $impuestos->appendChild($impuesto);
								$codigo = $xml->createElement('codigo','2');
									$codigo = $impuesto->appendChild($codigo);
								$codigoPorcentaje = $xml->createElement('codigoPorcentaje','0');
									$codigoPorcentaje = $impuesto->appendChild($codigoPorcentaje);
								$tarifa = $xml->createElement('tarifa','0');
									$tarifa = $impuesto->appendChild($tarifa);
								$baseImponible = $xml->createElement('baseImponible',$resultados[48]);
									$baseImponible = $impuesto->appendChild($baseImponible);
								$valor = $xml->createElement('valor','0');
									$valor = $impuesto->appendChild($valor);
						}
	 		}
	}
	
	$infoAdicional = $xml->createElement('infoAdicional');
		$infoAdicional = $factura->appendChild($infoAdicional);
		if ($correo == ''){$correo = 'sin correo registrado';}
			$campoAdicional = $xml->createElement('campoAdicional',$correo);
			$campoAdicional = $infoAdicional->appendChild($campoAdicional);
			$campoAdicional->setAttribute('nombre','Email');
			
			
	
	$xml->formatOutput = true;
    $el_xml = $xml->saveXML();
    $xml->save(''.$url.'/'.$nmbXML.'.xml');
	
	
	/***************************/
	$qry = "update tsc_facturas set xml_nombre = '".$nmbXML.".xml',
	               numero_autorizacion = '".$clvAccesoSri."',
				   estado_electronico = 'G',
				   log_transaccional = concat('Generación de Archivo: ',now(),'\n')
			 where id_factura = '".$idfactura."'";
	
	$consulta = $db->consulta($qry);
	
	$options = array(0 => $nmbXML,
					 1 => $firma,
					 2 => base64_encode($contasena),
					 3 => '../'.$url.'/'.$nmbXML.'.xml', 
					 4 => '../facturaElectronica/firmaElectronica/'.$firma,
					 5 => $nmbXML.'.xml',
					 6 => $urlFirma.'/');
	
	echo json_encode($options);
	
	/***************************/
	/*$ejecutar = new ejecutar();
	$ejecutar->firmarFactura($idfactura,
							 '../'.$url.'/'.$nmbXML.'.xml',
							 '../facturaElectronica/firmaElectronica/'.$firma,
							  $contasena,
							  $nmbXML.'.xml',
							  $urlFirma.'/');*/
	
	
	
  }


  function invertirCadena($cadena) {
        $cadenaInvertida = "";
        for ($x = strlen($cadena) - 1; $x >= 0; $x--) {
            $cadenaInvertida = $cadenaInvertida.substr($cadena,$x,1);
        }
        return $cadenaInvertida;
    }

  function obtenerSumaPorDigitos($cadena) {
        $pivote = 2;
        $longitudCadena = strlen($cadena);
        $cantidadTotal = 0;
        $b = 1;
        for ($i = 0; $i < $longitudCadena; $i++) {
            if ($pivote == 8) {
                $pivote = 2;
            }
            $temporal = substr($cadena,$i, 1);
            $b++;
            $temporal = $temporal * $pivote;
            $pivote++;
            $cantidadTotal = $cantidadTotal + $temporal;
        }
	  
        $cantidadTotal = 11 - $cantidadTotal % 11;
        if ($cantidadTotal==11)$cantidadTotal=0;
        if ($cantidadTotal==10)$cantidadTotal=1;
        
        return $cantidadTotal;
    }

	function sanear_string($string)
	{

		$string = trim($string);

		$string = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$string
		);

		$string = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$string
		);

		$string = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$string
		);

		$string = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$string
		);

		$string = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$string
		);

		$string = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C',),
			$string
		);

		//Esta parte se encarga de eliminar cualquier caracter extraño
		$string = str_replace(
			array("¨", "º", "-", "~",
				 "#", "@", "|", "!", '"',
				 "·", "$", "%", "&", "/",
				 "(", ")", "?", "'", "¡",
				 "¿", "[", "^", "<code>", "]",
				 "+", "}", "{", "¨", "´",
				 ">", "< ", ";", ",", ":",
				 "."),
			'',
			$string
		);


		return $string;
	}