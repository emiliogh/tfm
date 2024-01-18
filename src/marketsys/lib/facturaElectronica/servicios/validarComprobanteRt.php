<?php
session_start();
require_once('../src/nusoap.php');
include_once("../../conexion/class.conexion.php");
$db = new MySQL();


header("Content-Type: text/plain");
$content = file_get_contents('../'.$_POST['ruta'].$_POST['nombre']);

$mensaje = base64_encode($content);
$claveAcceso = $_POST['claveAcceso'];
$service = $_POST['service'];

//EndPoint
$consulta = $db->consulta("select t.web_url_autorizacion 
							 from tgn_empresas m
							inner join tgn_empresas_info_tributaria t
							   on t.estado = 'A'
							  and t.id_empresa = m.id_empresa 
							where m.estado = 'A' ");	
$servicio = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl"; //url del servicio
if($db->num_rows($consulta)>=0){
	while($resultados = $db->fetch_array($consulta)){
		$servicio =  $resultados[0];
	}
}

$parametros = array(); //parametros de la llamada
$parametros['xml'] = $mensaje;

$client = new nusoap_client($servicio);


$client->soap_defencoding = 'utf-8';


$result = $client->call("validarComprobante", $parametros, "http://ec.gob.sri.ws.recepcion");
$response = array();

$file = fopen("../log/log.txt", "a+");
fwrite($file, "Servicio: " . $service . PHP_EOL);
fwrite($file, "Clave Acceso: " . $claveAcceso . PHP_EOL);
fwrite($file, "Archivo: " . $_POST['nombre'] . PHP_EOL);

//var_dump($client->getError());die;


$_SESSION['validarComprobante']=$result;

if ($client->fault) {  
    
    $file_error = fopen('../log/errores/'.$claveAcceso.".txt", "w");
    fwrite($file_error, "Servicio: " . $service . PHP_EOL);
    fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
    fwrite($file_error, "Respuesta: " . print_r($result,true) . PHP_EOL);
    fwrite($file_error, "\n__________________________________________________________________\n". PHP_EOL);
    fclose($file_error);
    fwrite($file, "Respuesta: " . print_r($result,true) . PHP_EOL);
	$qry = "update tsc_retenciones_compras set estado_electronico = 'E',
				   log_transaccional = concat(log_transaccional,'\nEnvio de XML: ',now(),'".print_r($result,true)."\n')
			 where autorizacion = '".$_POST['claveAcceso']."'";
	$consulta = $db->consulta($qry);
	
	$consulta = $db->consulta("insert into tsc_log_documentos_electronicos ".
									"(id_documento,archivo,clave_autorizacion,transaccion,respuesta_sri,estado,fecha_registro)".
							  "values('".$_POST['id']."','".$_POST['nombre']."','".$_POST['claveAcceso']."','".$service."','".
										 print_r($result,true)."','A',now());");
    echo serialize($result);
    
} else {
    $error = $client->getError();
    if ($error) {
        fwrite($file, "Respuesta: " . print_r($error,true) . PHP_EOL);
        $file_error = fopen('../log/errores/'.$claveAcceso.".txt", "w");
        fwrite($file_error, "Servicio: " . $service . PHP_EOL);
        fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
        fwrite($file_error, "Respuesta: " . print_r($error,true) . PHP_EOL);
        fwrite($file_error, "\n__________________________________________________________________\n". PHP_EOL);
        fclose($file_error);
		$qry = "update tsc_retenciones_compras set estado_electronico = 'E',
				   log_transaccional = concat(log_transaccional,'\nEnvio de XML: ',now(),'".print_r($error,true)."\n')
			 where autorizacion = '".$_POST['claveAcceso']."'";
		$consulta = $db->consulta($qry);
		$consulta = $db->consulta("insert into tsc_log_documentos_electronicos ".
										"(id_documento,archivo,clave_autorizacion,transaccion,respuesta_sri,estado,fecha_registro)".
								  "values('".$_POST['id']."','".$_POST['nombre']."','".$_POST['claveAcceso']."','".$service."','".
											 print_r($error,true)."','A',now());");
        echo serialize($error);
    } else {
        if ($result['estado']=='RECIBIDA'){
            fwrite($file, "Respuesta: " . print_r($result,true) . PHP_EOL);
        }else {
            fwrite($file, "Respuesta: " . print_r($result,true) . PHP_EOL);
            $file_error = fopen('../log/errores/'.$claveAcceso.".txt", "w");
            fwrite($file_error, "Servicio: " . $service . PHP_EOL);
            fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);            
            fwrite($file_error, "Respuesta: " . print_r($result,true) . PHP_EOL);
			$qry = "update tsc_retenciones_compras set estado_electronico = 'B',
				   log_transaccional = concat(log_transaccional,'\nEnvio de XML: ',now(),'".print_r($result,true)."\n')
			 where autorizacion = '".$_POST['claveAcceso']."'";
			$consulta = $db->consulta($qry);
			
			$consulta = $db->consulta("insert into tsc_log_documentos_electronicos ".
											"(id_documento,archivo,clave_autorizacion,transaccion,respuesta_sri,estado,fecha_registro)".
									  "values('".$_POST['id']."','".$_POST['nombre']."','".$_POST['claveAcceso']."','".$service."','".
												 print_r($result,true)."','A',now());");
            fwrite($file_error, "\n__________________________________________________________________\n". PHP_EOL);
            fclose($file_error);
        }
        echo serialize($result);
        
    }
}
fwrite($file, "\n__________________________________________________________________\n". PHP_EOL);
fclose($file);


