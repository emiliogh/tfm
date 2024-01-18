<?php
include("../../lib/conexion/class.conexion.php");
try {
     $db = new MySQL();
     $sqlAperturaCaja="insert into tsc_denominacion_apertura (id_establecimiento, id_punto_emision, id_personal, id_apertura, id_denominacion, cantidad, total, estado,tipo_apertura) VALUES(".$_POST["idEstablecimiento"].",".$_POST["idPuntoEmision"].",".$_POST["idPersonal"].",".$_POST["idApertura"].",".$_POST["idDenominacion"].",".$_POST["cantidad"].",'".$_POST["total"]."','A',".$_POST["tipo"].");";

     $consulta = $db->consulta($sqlAperturaCaja);
     if(substr($consulta,0,11) == 'MySQL Error'){
        $array = array(0 =>$consulta,
                       1 =>10,
                       2 => 0);
        echo json_encode($array);
        return;			   
     }
}catch (PDOException $e) {
        $array = array(0 =>$e->getMessage(),
                       1 =>10,
                       2 => 0);

        echo json_encode($array);}
	
?>
