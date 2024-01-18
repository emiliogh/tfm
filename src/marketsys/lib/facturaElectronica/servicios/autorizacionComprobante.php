<?php
session_start();
require_once('../src/nusoap.php');
require_once('../generarPDF.php');
include_once("../../conexion/class.conexion.php");
require_once('../enviarMailFactura.php');
$db = new MySQL();


$claveAcceso = $_POST['claveAcceso'];
$service = $_POST['service'];


//EndPoint
$consulta = $db->consulta("select t.web_url_aprobacion,
								  m.razon_social
							 from tgn_empresas m
							inner join tgn_empresas_info_tributaria t
							   on t.estado = 'A'
							  and t.id_empresa = m.id_empresa 
							where m.estado = 'A' ");	
$servicio = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl"; //url del servicio
$nmbEmpresa = ''; 
if($db->num_rows($consulta)>=0){
	while($resultados = $db->fetch_array($consulta)){
		$servicio  =  $resultados[0];
		$nmbEmpresa = $resultados[1];
	}
}

$parametros = array(); //parametros de la llamada
$parametros['claveAccesoComprobante'] = $claveAcceso;

$client = new nusoap_client($servicio);


$error = $client->getError();



$client->soap_defencoding = 'utf-8';


$result = $client->call("autorizacionComprobante", $parametros, "http://ec.gob.sri.ws.autorizacion");
$_SESSION['autorizacionComprobante'] = $result;
$response = array();

$file = fopen("../log/log.txt", "a+");
fwrite($file, "Servicio: " . $service . PHP_EOL);
fwrite($file, "Clave Acceso: " . $claveAcceso . PHP_EOL);




if ($client->fault) {

    fwrite($file, "Respuesta: " . print_r($result, true) . PHP_EOL);

    $file_error = fopen('../log/errores/' . $claveAcceso . ".txt", "w");
    fwrite($file_error, "Servicio: " . $service . PHP_EOL);
    fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
    fwrite($file_error, "Respuesta: " . print_r($result, true) . PHP_EOL);
    fwrite($file_error, "\n__________________________________________________________________\n" . PHP_EOL);
    fclose($file_error);
	$qry = "update tsc_facturas set estado_electronico = 'R',
				   log_transaccional = concat(log_transaccional,'\nError Fault de XML: ',now(),'".print_r($error,true)."\n')
			 where numero_autorizacion = '".$_POST['claveAcceso']."'";
	$consulta = $db->consulta($qry);

	$consulta = $db->consulta("insert into tsc_log_documentos_electronicos ".
							  "(id_documento,archivo,clave_autorizacion,transaccion,respuesta_sri,estado,fecha_registro)".
							  "values('".$_POST['id']."','".$_POST['nombre']."','".$_POST['claveAcceso']."','".$service."','".
							  print_r($error,true)."','A',now());");
	
    echo serialize($result);
} else {
    $error = $client->getError();
    if ($error) {

        fwrite($file, "Respuesta: " . print_r($error, true) . PHP_EOL);

        $file_error = fopen('../log/errores/' . $claveAcceso . ".txt", "w");
        fwrite($file_error, "Servicio: " . $service . PHP_EOL);
        fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
        fwrite($file_error, "Respuesta: " . print_r($error, true) . PHP_EOL);
        fwrite($file_error, "\n__________________________________________________________________\n" . PHP_EOL);
        fclose($file_error);
		$qry = "update tsc_facturas set estado_electronico = 'R',
					   log_transaccional = concat(log_transaccional,'\nError de XML: ',now(),'".print_r($error,true)."\n')
				 where numero_autorizacion = '".$_POST['claveAcceso']."'";
		$consulta = $db->consulta($qry);

		$consulta = $db->consulta("insert into tsc_log_documentos_electronicos ".
								  "(id_documento,archivo,clave_autorizacion,transaccion,respuesta_sri,estado,fecha_registro)".
								  "values('".$_POST['id']."','".$_POST['nombre']."','".$_POST['claveAcceso']."','".$service."','".
								  print_r($error,true)."','A',now());");
		
        echo serialize($error);
    } else {

       echo serialize($result);
        fwrite($file, "Respuesta: " . print_r($result, true) . PHP_EOL);
        if ($result['autorizaciones']['autorizacion']['estado'] != 'AUTORIZADO') {

            $file_error = fopen('../log/errores/' . $claveAcceso . ".txt", "w");
            fwrite($file_error, "Servicio: " . $service . PHP_EOL);
            fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
            fwrite($file_error, "Respuesta: " . print_r($result, true) . PHP_EOL);
            fwrite($file_error, "\n__________________________________________________________________\n" . PHP_EOL);
            fclose($file_error);
			$qry = "update tsc_facturas set estado_electronico = 'R',
						   log_transaccional = concat(log_transaccional,'\nRechazado de XML: ',now(),' Mensaje: ','".print_r($result,true)."\n')
					 where numero_autorizacion = '".$_POST['claveAcceso']."'";
			$consulta = $db->consulta($qry);

			$consulta = $db->consulta("insert into tsc_log_documentos_electronicos ".
											"(id_documento,archivo,clave_autorizacion,transaccion,respuesta_sri,estado,fecha_registro)".
									  "values('".$_POST['id']."','".$_POST['nombre']."','".$_POST['claveAcceso']."','".$service."','".
												 print_r($result,true)."','A',now());");
			
        } else {
            if (!empty($result['autorizaciones']['autorizacion']['comprobante'])) {
				
				$qry = "update tsc_facturas set estado_electronico = 'A', fecha_autorizacion_electronico = now(),
						   log_transaccional = concat(log_transaccional,'\nAutorizacion de XML: ',now())
					 where numero_autorizacion = '".$_POST['claveAcceso']."'";
				$consulta = $db->consulta($qry);
				/************ XML **********/
				$qry = "select SUBSTRING(xml_nombre,1,17), id_factura, nombre_cliente, correo_electronico
				          from tsc_facturas f
						 inner join tcu_clientes cl
							ON cl.id_cliente = f.id_cliente
					     where f.numero_autorizacion = '".$_POST['claveAcceso']."'";
				$consulta = $db->consulta($qry);
				$idArchivo = $claveAcceso;
				$idFactura = 0;
				$nombreCliente = '';
				$correoCliente = '';
				if($db->num_rows($consulta)>=0){
	  				while($resultados = $db->fetch_array($consulta)){
						$idArchivo = $resultados[0];
						$idFactura = $resultados[1];
						$nombreCliente = $resultados[2];
						$correoCliente = $resultados[3];
					}
				}
				
                $file_comprobante = fopen('../autorizados/'.$idArchivo.".xml", "w");
                $comprobante = $client->responseData;


                $simplexml = simplexml_load_string($comprobante);
                $dom = new DOMDocument('1.0');
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $xml = str_replace(['&lt;', '&gt;'], ['<', '>'], $comprobante);

                fwrite($file_comprobante, $xml . PHP_EOL);
                fclose($file_comprobante);
                

                $dataComprobante = simplexml_load_string($result['autorizaciones']['autorizacion']['comprobante']);
                if ($dataComprobante->infoFactura) {
                    var_dump($dataComprobante->infoFactura);
					$facturaPDF = new generarPDF();
                    $facturaPDF->facturaPDF($dataComprobante, $idArchivo,$idFactura);
					
					$sendMail = multi_attach_mail($correoCliente, $nombreCliente, $idArchivo, $nmbEmpresa);
					
                }
                if ($dataComprobante->infoNotaCredito) {
                    //     var_dump($dataComprobante->infoFactura);
                    //$facturaPDF = new generarPDF();
                    //$facturaPDF->notaCreditoPDF($dataComprobante, $claveAcceso);
                }
                if ($dataComprobante->infoCompRetencion) {
                    //     var_dump($dataComprobante->infoFactura);
					
                    //$facturaPDF = new generarPDF();
                    //$facturaPDF->comprobanteRetencionPDF($dataComprobante, $claveAcceso);
                }
                if ($dataComprobante->infoGuiaRemision) {
                    //     var_dump($dataComprobante->infoFactura);
                    
					//$facturaPDF = new generarPDF();
                    //$facturaPDF->guiaRemisionPDF($dataComprobante, $claveAcceso);
                }

                if ($dataComprobante->infoNotaDebito) {
                    //     var_dump($dataComprobante->infoFactura);
					
                    //$facturaPDF = new generarPDF();
                    //$facturaPDF->notaDebitoPDF($dataComprobante, $claveAcceso);
                }
            }
        }
    }
}
fwrite($file, "\n__________________________________________________________________\n" . PHP_EOL);
fclose($file);





