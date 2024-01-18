<?php
   SESSION_START();
	date_default_timezone_set('America/Guayaquil');

   crearFactura($_GET['idfactura']);
   //crearFactura(3);

function crearFactura($idfactura){
    include_once("../conexion/class.conexion.php");
	//include_once("../facturaElectronica/procesaFacturaElectronica.php");
	$db = new MySQL();
	
	$qry = "select m.numero_identificacion,
				   m.razon_social,
				   m.nombre_comercial,
				   m.abreviatura,
				   i.id_ambiente,
				   i.id_tipo_emision,
				   ifnull(i.id_contribuyente_especial,0) contribuyente,
				   case when i.obligado_contabilidad= 'S' then 'SI' when i.obligado_contabilidad = 'N' then 'NO' end contabilidad,
				   i.codigo_facturacion,
				   i.url_documentos_generados,
				   e.codigo_establecimiento,
				   z.direccion,
				   e.direccion,
				   u.codigo_punto,
				   LPAD(r.secuencia,9,'0'),
				   r.codigo_retencion,
				   DATE_FORMAT(r.fecha_emision,'%d/%m/%Y'),
				   '07',
				   concat(DATE_FORMAT(r.fecha_emision,'%d%m%Y'),'07',m.numero_identificacion,i.id_ambiente,
									  e.codigo_establecimiento,u.codigo_punto,LPAD(r.secuencia,9,'0'),i.codigo_facturacion,
									  i.id_tipo_emision) codigo,
					s.codigo_identificacion,
				    p.numero_identificacion,
				    p.nombre_proveedor,
				    ifnull(p.direccion,'SIN DIRECCION REGISTRADA'),
				    p.correo_electronico,
				    p.telefono,
					DATE_FORMAT(r.fecha_emision,'%m/%Y') periodo,
					tr.id_tipo_retenciones codigo,  
					tr.codigo_ats,
					sum(d.base_imponible),
					tr.valor,
					sum(valor_retencion),
					'01',
					concat(c.establecimiento,c.punto_emision,c.numero_factura),
					c.fecha_compra,
					i.url_firma_electronica,
				    i.contrasena_firma,
				    i.url_documentos_firmados,
					concat('07',e.codigo_establecimiento,u.codigo_punto,LPAD(r.secuencia,9,'0'))
			   from tsc_compras c
			  inner join tsc_proveedores p
				 on p.id_proveedor = c.id_proveedor
			  inner join tb_tipos_identificacion s
				 on s.id_tipo_identificacion = p.id_tipo_identificacion
			  inner join tsc_retenciones_compras r
				 on r.id_compra = c.id_compra
			  inner join tsc_detalle_retenciones_compras d
				 on d.codigo_retencion = r.secuencia
			  inner join tsc_tipos_retenciones_compras tr
				 on tr.id_retencion = d.id_codigo_retencion
			  inner join tsc_establecimientos z
				 on z.identificador_matriz = 'S' 
			    and z.id_tipo_establecimiento = 2	
			  inner join tsc_establecimientos e
				 on r.id_establecimiento = e.id_establecimiento
			    and e.id_tipo_establecimiento = 2	
			  inner join tsc_puntos_emision u
				 on u.id_establecimiento = r.id_establecimiento
			    and u.id_punto_emision = r.id_punto_emision
			  inner join tgn_empresas m
				 on m.estado = 'A'
			  inner join tgn_empresas_info_tributaria i
				 on i.estado = 'A'
			    and i.id_empresa = m.id_empresa
			  where c.id_compra = '".$idfactura."'
			 group by m.numero_identificacion,
				   m.razon_social,
				   m.nombre_comercial,
				   m.abreviatura,
				   i.id_ambiente,
				   i.id_tipo_emision,
				   ifnull(i.id_contribuyente_especial,0),
				   case when i.obligado_contabilidad= 'S' then 'SI' when i.obligado_contabilidad = 'N' then 'NO' end,
				   i.codigo_facturacion,
				   i.url_documentos_generados,
				   e.codigo_establecimiento,
				   z.direccion,
				   e.direccion,
				   u.codigo_punto,
				   LPAD(r.secuencia,9,'0'),
				   r.codigo_retencion,
				   DATE_FORMAT(r.fecha_emision,'%d/%m/%Y'),
				   '07',
				   concat(DATE_FORMAT(r.fecha_emision,'%d%m%Y'),'07',m.numero_identificacion,i.id_ambiente,
									  e.codigo_establecimiento,u.codigo_punto,LPAD(r.secuencia,9,'0'),i.codigo_facturacion,
									  i.id_tipo_emision),
					s.codigo_identificacion,
				    p.numero_identificacion,
				    p.nombre_proveedor,
				    ifnull(p.direccion,'SIN DIRECCION REGISTRADA'),
				    p.correo_electronico,
				    p.telefono,
				    DATE_FORMAT(r.fecha_emision,'%m/%Y'),
				    tr.id_tipo_retenciones,  
				    tr.codigo_ats";
	
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
	$idAmbiente = '';
	$idEmision	= '';
	/*Recorrido de Datos*/
	if($db->num_rows($consulta)>=0){
	  $detalles = '';		
	  while($resultados = $db->fetch_array($consulta)){ 
	      if ($i == 0){
			  $xml = new DomDocument('1.0', 'UTF-8');
				$factura = $xml->createElement('comprobanteRetencion');
					$factura->setAttribute('id', 'comprobante'); $factura->setAttribute('version','1.0.0');
					$factura = $xml->appendChild($factura);

					$infoTributaria = $xml->createElement('infoTributaria');
						$infoTributaria = $factura->appendChild($infoTributaria); 

						$ambiente = $xml->createElement('ambiente',$resultados[4]);
							$ambiente = $infoTributaria->appendChild($ambiente);
			  				$idAmbiente = $resultados[4];	
						$tipoEmision = $xml->createElement('tipoEmision',$resultados[5]);
							$tipoEmision = $infoTributaria->appendChild($tipoEmision);
			  				$idEmision = $resultados[5];
						$razonSocial = $xml->createElement('razonSocial',$resultados[1]);
							$razonSocial = $infoTributaria->appendChild($razonSocial);
						if ($resultados[2] != ''){
			                $nombreComercial = $xml->createElement('nombreComercial',$resultados[2]);
							   $nombreComercial = $infoTributaria->appendChild($nombreComercial);}
						$ruc = $xml->createElement('ruc',$resultados[0]);
							$ruc = $infoTributaria->appendChild($ruc);
			            $digitoVerificador = obtenerSumaPorDigitos(invertirCadena($resultados[18]));
						$claveAcceso = $xml->createElement('claveAcceso',$resultados[18].$digitoVerificador);
			 			$clvAccesoSri = $resultados[18].$digitoVerificador;
			               $claveAcceso = $infoTributaria->appendChild($claveAcceso);
						$codDoc = $xml->createElement('codDoc',$resultados[17]);
							$codDoc = $infoTributaria->appendChild($codDoc);	
						$estab = $xml->createElement('estab',$resultados[10]);
							$estab = $infoTributaria->appendChild($estab);
						$ptoEmi = $xml->createElement('ptoEmi',$resultados[13]);
							$ptoEmi = $infoTributaria->appendChild($ptoEmi);
						$secuencial = $xml->createElement('secuencial',$resultados[14]);
							$secuencial = $infoTributaria->appendChild($secuencial);
						$dirMatriz = $xml->createElement('dirMatriz',sanear_string(utf8_encode($resultados[11])));
							$dirMatriz = $infoTributaria->appendChild($dirMatriz);

					$infoFactura = $xml->createElement('infoCompRetencion');
						$infoFactura = $factura->appendChild($infoFactura);

						$fechaEmision = $xml->createElement('fechaEmision',$resultados[16]);
							$fechaEmision = $infoFactura->appendChild($fechaEmision);
			  			$dirEstablecimiento = $xml->createElement('dirEstablecimiento',sanear_string(utf8_encode($resultados[12])));
							$dirEstablecimiento = $infoFactura->appendChild($dirEstablecimiento);
			  			if ($resultados[6] != '0'){
			 			    $contribuyenteEspecial = $xml->createElement('contribuyenteEspecial',$resultados[6]);
							    $contribuyenteEspecial = $infoFactura->appendChild($contribuyenteEspecial);}
			  
				        $obligadoContabilidad = $xml->createElement('obligadoContabilidad',$resultados[7]);
							$obligadoContabilidad = $infoFactura->appendChild($obligadoContabilidad);
			  
						$tipoIdentificacionComprador = $xml->createElement('tipoIdentificacionSujetoRetenido',$resultados[19]);
							$tipoIdentificacionComprador = $infoFactura->appendChild($tipoIdentificacionComprador);
						$razonSocialComprador = $xml->createElement('razonSocialSujetoRetenido',$resultados[21]);
							$razonSocialComprador = $infoFactura->appendChild($razonSocialComprador);
						$identificacionComprador = $xml->createElement('identificacionSujetoRetenido',$resultados[20]);
							$identificacionComprador = $infoFactura->appendChild($identificacionComprador);	
			            $periodoFiscal = $xml->createElement('periodoFiscal',$resultados[25]);
							$periodoFiscal = $infoFactura->appendChild($periodoFiscal);	
			  			//$dirEstablecimiento = $xml->createElement('dirEstablecimiento',sanear_string(utf8_encode($resultados[22])));
						//	$dirEstablecimiento = $infoFactura->appendChild($dirEstablecimiento);

		 	 			$i = 1;
			            $url = $resultados[9];
			 			$nmbXML = $resultados[37];
		 				$firma	= $resultados[34];
						$urlFirma = $resultados[36];
						$contasena = $resultados[35];
		 				$correo = $resultados[22];
						$telefono = $resultados[24];
		  
			  $detalles = $xml->createElement('impuestos');
		  		$detalles = $factura->appendChild($detalles);}
		  
		  //Detalles Impuestos
			$detalle = $xml->createElement('impuesto');
				$detalle = $detalles->appendChild($detalle);
				$codigo = $xml->createElement('codigo',$resultados[26]);
					$codigo = $detalle->appendChild($codigo);
		        $codigoRetencion = $xml->createElement('codigoRetencion',$resultados[27]);
					$codigoRetencion = $detalle->appendChild($codigoRetencion);
				$baseImponible = $xml->createElement('baseImponible',number_format($resultados[28],2,".",""));
					$baseImponible = $detalle->appendChild($baseImponible);	
				$porcentajeRetener = $xml->createElement('porcentajeRetener',number_format($resultados[29],2));
					$porcentajeRetener = $detalle->appendChild($porcentajeRetener);
				$valorRetenido = $xml->createElement('valorRetenido',number_format($resultados[30],2));
					$valorRetenido = $detalle->appendChild($valorRetenido);
				$codDocSustento = $xml->createElement('codDocSustento',$resultados[31]);
					$codDocSustento = $detalle->appendChild($codDocSustento);
				$numDocSustento = $xml->createElement('numDocSustento',$resultados[32]);
					$numDocSustento = $detalle->appendChild($numDocSustento);
				$fechaEmisionDocSustento = $xml->createElement('fechaEmisionDocSustento',$resultados[33]);
					$fechaEmisionDocSustento = $detalle->appendChild($fechaEmisionDocSustento);
						
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
	$qry = "update tsc_retenciones_compras set xml_nombre = '".$nmbXML.".xml',
	               autorizacion = '".$clvAccesoSri."',
				   ambiente = '".$idAmbiente."',
				   emision = '".$idEmision."',
				   estado_electronico = 'G',
				   log_transaccional = concat('Generación de Archivo: ',now(),'\n')
			 where id_compra = '".$idfactura."'";
	
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