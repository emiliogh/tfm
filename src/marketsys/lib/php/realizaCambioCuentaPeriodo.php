<?php
include_once("../conexion/class.conexion.php");

$db = new MySQL();
	/* Verifica Existencia */
	$qry = "select count(*) ".
			 "from tfn_cuentas_periodo ct ".
			"where id_cuenta_contable = '".$_POST['id']."' ".
		 	  "and id_periodo = '".$_POST['idp']."' ";
	
	$idExiste = 0;
	$consulta = $db->consulta($qry);
				$numResul = $db->num_rows($consulta);
				if($numResul>0){
					while($resultados = $db->fetch_array($consulta)){
						$idExiste = $resultados[0];
					}
				 }
	
	if ($_POST['hab'] == 'A'){
		if ($idExiste == 0){
			$ins = "insert into tfn_cuentas_periodo (id_periodo,id_cuenta_contable,estado,fecha_registro,total_debe,".
													"total_haber,saldo_cuenta) values ('".$_POST['idp']."','".$_POST['id']."','A',".
													 "now(),0,0,0);";

			$consulta = $db->consulta($ins);
		}else{
			$qry = "update tfn_cuentas_periodo ".
					  "set estado = 'A' ". 	
					"where id_cuenta_contable = '".$_POST['id']."' ".
					  "and id_periodo = '".$_POST['idp']."' ";

			$consulta = $db->consulta($qry);
		}
	}else{$qry = "update tfn_cuentas_periodo ".
					"set estado = 'I' ". 	
				  "where id_cuenta_contable = '".$_POST['id']."' ".
				    "and id_periodo = '".$_POST['idp']."' ";

		  $consulta = $db->consulta($qry);
			
	}

	
	

	/* Búsqueda de Cuenta */
	$qry = "select count(*) ".
			 "from tfn_cuentas_periodo ct ".
			"where id_cuenta_contable = '".$_POST['id']."' ";

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