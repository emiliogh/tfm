<?php
session_start();
?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Devengado</title>
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">	
  <link rel="stylesheet" type="text/css" href="../css/styleCajas.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>
  <script type="text/javascript" src="../js/componentes.js"></script>
  <script src="../js/jquery.datetimepicker.full.js"></script>
	
<body bgcolor="#fff" style="left: 0px; overflow-x: hidden;" onLoad="inicioTrx();">
<form id="frm_clientes" method="post" enctype="multipart/form-data"> 
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="7" class="estilo3">
							Devengado bancario
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 120px;">
							Cuenta
					    </td>
						<td colspan="5">
							<select name="cmbCuentasBancarias" id="cmbCuentasBancarias" style="width: 100%; height: 22px;">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						<td rowspan="4" class="clsEtiquetasTable">
							<button type="button" id="btn_guardar" onClick="consultaMovimientos();">
								<img src="../images/icons/busqueda.png" width="30px" alt=""/>
								<br>Consultar movimientos
							</button>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 120px;">
							Tipo transacción
					    </td>
						<td colspan="5">
							<select name="cmbTipoTransaccion" id="cmbTipoTransaccion" style="width: 100%; height: 22px;">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
								<option value="1">Depósitos</option>
								<option value="2">Retiros</option>
							</select>
						</td>	
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 120px;">
							Fecha desde:
					    </td>
						<td>
							<input id="fechaDesde" onFocus="this.blur()" style="height: 22px; width: 99%; text-align: center;" 
								   value="<?php echo date("01/m/Y")?>" placeholder="Fecha desde">
						</td>
						<td style="width: 20px;">
							<img src="../images/icons/calendario.png" width="22px" alt=""/>
						</td>
						<td class="clsEtiquetasTable" style="width: 120px; text-align: right; padding-right: 5px; ">
							Fecha hasta:
						</td>
						<td>
							<input id="fechaHasta" onFocus="this.blur()" style="height: 22px; width: 99%; text-align: center;" 
								   value="<?php echo date("d/m/Y")?>" placeholder="Fecha hasta">
						</td>
						<td style="width: 20px;">
							<img src="../images/icons/calendario.png" width="22px" alt=""/>
						</td>
					</tr>
					<tr>
						<tr>
							<td colspan="7" class="estilo3">
								Movimientos por devengar
							</td>
						</tr>
						<tr>
						<td colspan="7" class="estilo3" style="padding: 0px;">
							<table id="tableMovimientos" style="width: 100%;">
								<thead>
									<tr class="tablaAperturaHead">
										<td style="width: 8%;" >N°</td>
										<td style="width: 15%;">Fecha</td>
										<td style="width: 20%;">Tipo movimiento</td>
										<td style="width: 20%;">Documento</td>
										<td style="width: 20%;">Tipo de transacción</td>
										<td style="width: 15%;">Total</td>
										<td style="width: 2%;" ></td>
									</tr>
								</thead>
								<tbody id="tableMovimientosBody" style="background-color: #FFF; font-size: 11px;">	
								</tbody>		
								<tfoot>	
									<tr class="tablaAperturaFood">
										<td colspan="4">	
										</td>
										<td colspan="2" style="text-align: right;">
											<span id="txtMovimientos" name="txtMovimientos" style="width: 100px;">0.00</span>		
										</td>
										<td>	
										</td>
									</tr>
								</tfoot>		
							</table>
						</td>
					</tr>
				</tbody>	
			</table>
        </div>
    </div>
	
	<div role="dialog" tabindex="-1" class="modal fade" id="modalDevengadoDiv"
		style="padding-top: 140px; margin-right:auto;margin-left:auto; opacity: 1;">
		   <div class="modal-dialog" role="document">
			 <div class="modal-content">
			   <div class="modal-header" style="background-color: #CCD1D1"> <!-- CABECERA -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onClick="cerrarDevengado();">
						<span aria-hidden="true" style="color: red;"><b>X</b></span></button>
					<h4 class="text-left modal-title">Devengado de movimiento bancario</h4>
			   </div>
			   
			    <div class="modal-body" style="height: 350px; "> <!-- CUERPO DEL MENSAJE -->
				    <div class="row form-group">
						<div style="width: calc(100% - 60px); margin-left: 30px;" id="calificacionDiv">
							<table class="table" style="width: 100%;">
								<tr>
									<td>Movimiento
									</td>	
									<td><span id="numeroMovimiento"></span></td>	
								</tr>
								<tr>
									<td>Fecha
									</td>	
									<td><span id="fechaMovimiento"></span></td>	
								</tr>
								<tr>
									<td>Tipo Movimiento
									</td>	
									<td><span id="tipoMovimiento"></span></td>	
								</tr>
								<tr>
									<td>Documento
									</td>	
									<td><span id="transaccionMovimiento"></span></td>	
								</tr>
								<tr>
									<td>Tipo de transacción
									</td>	
									<td><span id="numeroTransaccion"></span></td>	
								</tr>
								<tr>
									<td><span id="tipo">Monto transacción</span>
									</td>	
									<td><span id="montoTransaccion"></span></td>	
								</tr>
								<tr>
									<td>Documento Bancario
									</td>	
									<td><input id="numeroDocumentoBancario" name="numeroDocumentoBancario" autocomplete="off" type="text" 
											   class="form-control" style="width: 100%; height: 24px; text-transform: uppercase;" 
											   onkeypress="return soloNumeros(event)"/>
									</td>	
								</tr>
								<tr>
									<td>Observación 
									</td>	
									<td><textarea id="observacionMovimiento" name="observacionMovimiento" autocomplete="off" type="text" 
											   class="form-control" style="width: 100%; resize: none; text-transform: uppercase;" 
											   onkeypress="return soloNumerosLetras(event);" rows="2"></textarea>
									</td>	
								</tr>
							</table>	
						</div>	
					</div>
					
				</div>

			   <div class="modal-footer" style="padding-right: 40px; margin-right: 0px;"> <!-- PIE -->
				   	<button class="btn btn-default btn btn-primary btn-lg" type="button" data-dismiss="modal" 
							onClick="guardarDevengado();">Guardar </button>
				   
					<button class="btn btn-default btn btn-danger btn-lg" type="button" data-dismiss="modal" 
							onClick="cerrarDevengado();">Cancelar </button>
			   </div>
			</div>
		</div>
	</div>
</form>
<script>
	$.datetimepicker.setLocale('es');
	$('#fechaDesde').datetimepicker({
		dayOfWeekStart : 1,
		timepicker:false,
		format:'d/m/Y',
		formatDate:'Y/m/d'
	});
	$('#fechaHasta').datetimepicker({
		dayOfWeekStart : 1,
		timepicker:false,
		format:'d/m/Y',
		formatDate:'Y/m/d'
	});
	
	var cmb=new componente.cmb
		cmb.ini('cmbCuentasBancarias')
		cmb.loadFromUrlAd('../cmb/cmbCuentasBancarias.php')
	
	
	function inicioTrx(){
		parent.document.getElementById('divLoadding').style.display = 'none';
		}
	
	function consultaMovimientos(){
		url = '../php/retornaMovimientoBancarios.php';
		if (document.getElementById("cmbCuentasBancarias").value != 0){
			parent.document.getElementById('divLoadding').style.display = 'block';
			$.ajax({
				type:'POST',
				url:url,
				data: 'idCuenta='+document.getElementById("cmbCuentasBancarias").value+
				      '&idTipoTransaccion='+document.getElementById("cmbTipoTransaccion").value+
					  '&fechaDesde='+document.getElementById("fechaDesde").value+
				      '&fechaHasta='+document.getElementById("fechaHasta").value,
				success:function(data){
					  $('#tableMovimientos tbody').html(data);
					  parent.document.getElementById('divLoadding').style.display = 'none';
					  }
				});
			}else{parent. modalAlertPrincipal(2, 'MarketSys [Información Incompleta]', 
												 'Por favor seleccione una cuenta para consultar los movimientos.', 0, 
												 'Aceptar', '');
				
			}
	}
	
	function abrirDevengado(r){
		var i = r.parentNode.rowIndex;
		
		    document.getElementById("numeroMovimiento").innerHTML 		= document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
		 	document.getElementById("fechaMovimiento").innerHTML 		= document.getElementById("tableMovimientos").rows[i].cells[1].innerHTML;
			document.getElementById("tipoMovimiento").innerHTML 		= document.getElementById("tableMovimientos").rows[i].cells[2].innerHTML;
			document.getElementById("transaccionMovimiento").innerHTML 	= document.getElementById("tableMovimientos").rows[i].cells[3].innerHTML;
			document.getElementById("numeroTransaccion").innerHTML 		= document.getElementById("tableMovimientos").rows[i].cells[4].innerHTML;
			document.getElementById("montoTransaccion").innerHTML 		= document.getElementById("tableMovimientos").rows[i].cells[5].innerHTML;
			document.getElementById("numeroDocumentoBancario").value	= '';
			document.getElementById("observacionMovimiento").value		= '';
		document.getElementById("modalDevengadoDiv").style.display = 'block';
	}
	
	function cerrarDevengado(){
		document.getElementById("modalDevengadoDiv").style.display = 'none';
	}
	
	function guardarDevengado(){
		url = '../php/registraDevengadoMovimientoBancario.php';
		$.ajax({
				type:'POST',
				url:url,
				data: 'idMovimiento='+document.getElementById("numeroMovimiento").innerHTML+
				      '&documentoBancario='+document.getElementById("numeroDocumentoBancario").value+
					  '&observacionBancaria='+document.getElementById("observacionMovimiento").value+
					  '&idCuentaBancaria='+document.getElementById("cmbCuentasBancarias").value+
					  '&tipoTransaccion='+document.getElementById("numeroTransaccion").innerHTML+
					  '&montoTransaccion='+document.getElementById("montoTransaccion").innerHTML,
				success:function(data){
					    $('#tableMovimientos tbody').html(data);
					    parent. modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', 
												       'Se ha devengado el movimiento bancario seleccionado.', 0, 
												       'Aceptar', '');
					    consultaMovimientos();
					    document.getElementById('modalDevengadoDiv').style.display = 'none';
					  }
				});
	}
	function soloNumeros(e) {
		// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "0123456789";
		especiales = [8];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}
	
	function soloNumerosLetras(e) {
		// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "0123456789 áéíóúabcdefghijklmnñopqrstuvwxyz";
		especiales = [8, 37, 39, 44, 46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}
	
</script>
</body>
</html>