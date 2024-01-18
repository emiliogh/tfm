<?php

$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];

$fechaInicio = substr($fechaInicio,4, 11);
$fechaInicio = date('Y-m-d',strtotime($fechaInicio));


$fechaFin = substr($fechaFin,4, 11);
$fechaFin= date('Y-m-d',strtotime($fechaFin));


$fechaActual=date('Y-m-d');

	if($fechaActual <= $fechaFin){
		$array = array(0 => 3,
					   1 => "Certificado Vigente",
					   2 => $fechaFin);

	}else{
		/*$file = fopen("../error_log", "a+");
		$date = date('m/d/Y h:i:s a', time());
		fwrite($file, "Error: " .$date. ' Fecha vencimiento del certificado excedida'. PHP_EOL);*/
		$array = array(0 => 1,
					   1 => "Valide las fechas de vencimiento del certificado",
					   2 => $fechaFin);
	}

	echo json_encode($array);