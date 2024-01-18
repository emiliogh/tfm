<?php
SESSION_START();
include("../../lib/conexion/class.conexion.php");
try {
	$db = new MySQL();
	if (is_null($_SESSION["usuarioMS"])){
		$array = array(0 =>"Existe problemas con su usuario: ".$_SESSION["usuarioMS"].". Comuniquese con su administrador.",
					   1 =>10);
		echo json_encode($array);
		return;			   
		}

	    $idTrx = 0;
	
	$monto = 0;
	$query = "SELECT cantidad_actual ".
			   "FROM tiv_movimientos m ".
			  "where m.id_item = '".$_POST["iditem"]."' ".
		        "and m.id_movimiento IN (select max(s.id_movimiento) ".
										  "from tiv_movimientos s ".
										 "where s.id_item = m.id_item);";
			$consulta = $db->consulta($query);
			$numResul = $db->num_rows($consulta);
			if($numResul>0){
				while($resultados = $db->fetch_array($consulta)){ 
					  $monto = $resultados[0];
				}
			  }
	
	if ($monto > $_POST["cantim"]){
	
		if ($_POST["ini"] == 1){
			$query = "SELECT ifnull(max(id_trx),0)+1 FROM tiv_movimientos;";
			$consulta = $db->consulta($query);
			$numResul = $db->num_rows($consulta);
			if($numResul>0){
				while($resultados = $db->fetch_array($consulta)){ 
					  $_SESSION["itrx"] = $resultados[0];
					  $_SESSION["curSesTrx"] = $_POST["dn"];
				}
			  }
			}
		$tipo = '';
		$cantidad = 0;
		$promedio = ($_POST["costoa"] + $_POST["costom"])/2;
		$ci = 0;
		if ($_POST["tipomv"] == 1 || $_POST["tipomv"] == 2){
			$tipo = '+';
			$cantidad = $_POST["stocka"] + $_POST["cantim"];
		}else if ($_POST["tipomv"] == 3){
			$tipo = '-';
			$cantidad = $_POST["stocka"] - $_POST["cantim"];
		}
		if ($_POST["costoa"] > $_POST["costom"]){
			$ci = $_POST["costoa"];
		}else{$ci = $_POST["costom"];}
			
		$sqlAperturaCaja="insert into tiv_movimientos (id_item, id_usuario, id_trx, fecha_movimiento, id_tipo_movimiento, cantidad_anterior, cantidad_movimiento, cantidad_actual, costo_anterior, costo_movimiento, costo_promedio, costo_inteligente, estado, id_bodega, id_bodega_despacho, observacion) VALUES (".$_POST["iditem"].",".$_SESSION["idUsuario"].",".$_SESSION["itrx"].",now(), ".$_POST["tipomv"].",".$_POST["stocka"].",".$_POST["cantim"].",".$cantidad.",".$_POST["costoa"].",".$_POST["costom"].",".$promedio.",".$ci.",'A','".$_POST["idbode"]."','".$_POST["idbode"]."',upper('".$_POST["obserm"]."'));";
	   
		$rowqryApertura = $db->consulta($sqlAperturaCaja);
		
		if (substr($rowqryApertura,0,11) == 'MySQL Error'){
			$array = array(0 =>$rowqryApertura,
						   1 =>10);
			echo json_encode($array);
			return;			   
		}
	 }
	 
	 $array = array(0 => 0,
					1 => '');
	
	} catch (PDOException $e) {
		 $array = array(0 =>$e->getMessage(),
						1 =>10);
	}
	
	echo json_encode($array);
?>
