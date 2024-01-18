<?php
//include_once 'conexion_prueba.php';
include("conexion_prueba");
$db = new MySQL();		
$consultaR = $db->consulta("select * from users");
if($db->num_rows($consultaR)>=0){
	while($resultados = $db->fetch_array($consultaR)){
	echo utf8_decode ($resultados[0]);
	echo utf8_decode ($resultados[1]);
	echo utf8_decode ($resultados[2]);
	}
}
?>