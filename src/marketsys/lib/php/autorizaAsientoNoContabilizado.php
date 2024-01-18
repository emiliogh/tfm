<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
	/* Autoriza Asiento */
	$qry = "update tfn_asiento_contable ".
			  "set estado_autorizacion = 1, ".
				  "fecha_autorizacion = now() ". 	
			"where id_asiento = '".$_POST['id']."' ";
		$consulta = $db->consulta($qry);

	/* Búsqueda de Cuenta */
	$qry = "select id_cuenta ".
			 "from tfn_cuentas_contables ct ".
			"where codigo = '".$_POST['codigoCuenta']."' ";

		$idCuenta = 0;
		$idCuentaPadre = 0;

			$consulta = $db->consulta($qry);
				$numResul = $db->num_rows($consulta);
				if($numResul>0){
					while($resultados = $db->fetch_array($consulta)){
						$idCuenta = $resultados[0];
						autorizaCuentaMayor($idCuenta, $_POST['valorDebe'], $_POST['valorHaber']);
					}
				 }
		
		echo '0';

/* Función recursiva */
function autorizaCuentaMayor($idMayor, $mntDebe, $mntHaber){
	$db = new MySQL();
		 $qry = "update tfn_cuentas_periodo pr ".
			     "inner join tfn_parametros rt ".
				    "on pr.id_periodo = rt.id_periodo_vigente ".
			    "set pr.total_debe = pr.total_debe + '".$mntDebe."', ".
			 		   "pr.total_haber = pr.total_haber + '".$mntHaber."', ".
			 		   "pr.saldo_cuenta = pr.saldo_cuenta + '".$mntDebe."' - '".$mntHaber."' ".
				"where id_cuenta_contable = '".$idMayor."' ";
		$consulta = $db->consulta($qry);
	
	     $qry = "select id_cuenta, id_cuenta_padre ".
				 "from tfn_cuentas_contables ct ".
				"where id_cuenta = '".$idMayor."' ";

			$idCuenta = 0;
			$idCuentaPadre = 0;
			$consulta = $db->consulta($qry);
			$numResul = $db->num_rows($consulta);
			if($numResul>0){
				while($resultados = $db->fetch_array($consulta)){
					$idCuenta = $resultados[0];
					$idCuentaPadre = $resultados[1];
					
				}
			 }
		
		
		if ($idCuentaPadre > 0){	
			return autorizaCuentaMayor($idCuentaPadre,$mntDebe, $mntHaber);
			
		}
					
	
}

?>