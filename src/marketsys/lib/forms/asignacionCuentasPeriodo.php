<?php
session_start();
?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Asignación de cuentas por período</title>
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui-forms.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/switchOnOff.css"/>	
  <link rel="stylesheet" type="text/css" href="../css/styleCajas.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
  <script type="text/javascript" src="../js/componentes.js"></script>
  <script type="text/javascript" src="../js/componentes.js"></script>	
</head>	
<body bgcolor="#fff" style="left: 0px;" onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<table style="width: 100%;">
		<thead>
			<tr>
				<td colspan="4" class="estilo3">
					PERÍODOS FINANCIEROS
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="clsEtiquetasTable" style="width: 10%;">
					Período
				</td>
				<td class="clsObjetosTable">
					<select name="cmbPeriodo" id="cmbPeriodo" onChange="busquedaCuentasPeriodos();" style="width: 100%">
						<option value="0" SELECTED>Seleccione una Opción.</option>
					</select>
				</td>
			</tr>

			<tr>
				<td colspan="4" class="estilo3">
					CUENTAS CONTABLES
				</td>
			</tr>
			<tr>
				<td colspan="4" class="estilo2">
					<table id="tableMovimientos" style="width: 100%;">
						<thead>
							<tr class="tablaAperturaHead">
								<td style="width: 8%;">N°</td>
								<td style="width: 15%;">Cuenta</td>
								<td style="width: 50%;">Descripción</td>
								<td style="width: 10%;">Debe</td>
								<td style="width: 10%;">Haber</td>
								<td style="width: 7%;">Disponible</td>
							</tr>
						</thead>
						<tbody id="tableMovimientosBody" bgcolor="#fff">	
						</tbody>				
					</table>
				</td>
			</tr>
		</tbody>	
	</table>
  <script>
	var cmbFormasPago = new componente.cmb; 
		cmbFormasPago.ini('cmbPeriodo');
		cmbFormasPago.loadFromUrlAd('../cmb/cmbTfnPeriodos.php');
	  
	function busquedaCuentasPeriodos(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var id = document.getElementById('cmbPeriodo').value;
		$.ajax({type:'POST',
				url:'../php/retornaAsignacionCuentasPeriodo.php',
				data:'id='+id,
				success:function(data){
					     data = eval(data)
						 document.getElementById('tableMovimientosBody').innerHTML = data[0];
						 parent.document.getElementById('divLoadding').style.display = 'none';
						}
			   });
	} 
	 
	function guardaCambioCuenta(id, sde, shb){
		if (document.getElementById('chk'+id).checked == false){
			if (parseFloat(sde) != 0 || parseFloat(shb) != 0){
				document.getElementById('chk'+id).checked = true;
				parent. modalAlertPrincipal(1, 'MarketSys [Opción no disponible]', 
											   'La cuenta seleccionada no puede ser inactivada, ya que registra movimientos.', 0, 
											   'Aceptar', '');
				return;
				}
			}	
		
		idp = document.getElementById('cmbPeriodo').value;
		hab = document.getElementById('chk'+id).checked;
		if (hab == true)
		   {hab='A';}else{hab='I';}
		$.ajax({type:'POST',
				url:'../php/realizaCambioCuentaPeriodo.php',
				data:'id='+id+'&hab='+hab+'&idp='+idp,
				success:function(data){
					    }
			   });
		
	}  
	  
  </script>	
</body>
</html>