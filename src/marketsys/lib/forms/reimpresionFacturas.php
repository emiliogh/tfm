<?php
session_start();
?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Reimpresión de Facturas</title>
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui-forms.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">	
  <link rel="stylesheet" type="text/css" href="../css/styleCajas.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>
  <script type="text/javascript" src="../js/componentes.js"></script>
  <script src="../js/jquery.datetimepicker.full.js"></script>
	<style type="text/css">
	  .botonAprobar{
		padding: 4px;				font-family: arial;
		text-transform: uppercase;	padding-left: 10px;
		padding-right: 10px;		font-weight: 600;
		font-size: 10px;			color: #FFF;
		background-color: #0e9b1d;	width: 100%;
		border: none;
	  }
	  .botonAprobar:hover{
		color: #f4f4f4;				background-color: #70F455;
	  }
	  .botonModificar{
		padding: 4px;				font-family: arial;
		text-transform: uppercase;	padding-left: 10px;
		padding-right: 10px;		font-weight: 600;
		font-size: 10px;			color: #FFF;
		background-color: #58A1D1;	width: 100%;
		border: none;
	  }
	  .botonModificar:hover{
		color: #f4f4f4;				background-color: #6CBFF6;
	  }
	  .botonImprimir{
		padding: 4px;				font-family: arial;
		text-transform: uppercase;	padding-left: 10px;
		padding-right: 10px;		font-weight: 600;
		font-size: 10px;			color: #FFF;
		background-color: #D6B660;	width: 100%;
		border: none;
	  }
	  .botonImprimir:hover{
		color: #f4f4f4;				background-color: #FAD571;
	  }	
	</style>
</head>	
<body bgcolor="#fff" style="left: 0px; width: 99.5%" onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="5" class="estilo3">
							CONSULTA DE FACTURAS
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Factura
					    </td>
						<td colspan="3" class="clsObjetosTable">
							<input id="idFactura" style="height: 22px; width: 100%; text-align: left;" 
								   placeholder="Información de la factura.">
						</td>
						<td rowspan="3" style="width: 120px;">
							<button type="button" onClick="consultaMovimientos();" style="width: 100%;">
								<img src="../images/icons/busqueda.png" width="29px" alt=""/><br>Consultar Facturas</button>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Cliente
					    </td>
						<td colspan="3" class="clsObjetosTable">
							<input id="idCliente" style="height: 22px; width: 100%; text-align: left;" 
								   placeholder="Información del Cliente.">
						</td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Fecha desde
					    </td>
						<td class="clsObjetosTable">
							<input id="fechaDesde" onFocus="this.blur()" style="height: 22px; width: 100%; text-align: center;" 
								   value="<?php echo date("01/m/Y")?>" placeholder="Fecha desde">
						</td>
						<td class="clsEtiquetasTable" style="width: 120px;">
							Fecha hasta
					    </td>
						<td class="clsObjetosTable">
							<input id="fechaHasta" onFocus="this.blur()" style="height: 22px; width: 100%; text-align: center;" 
								   value="<?php echo date("d/m/Y")?>" placeholder="Fecha hasta">
						</td>
					</tr>
					<tr>
						<td colspan="5" class="estilo3">
							DETALLES DE FACTURAS PARA REIMPRESIÓN
						</td>
					</tr>
					<tr>
						<td colspan="5" class="estilo3">
							<table id="tableMovimientos" id="tableMovimientos" style="width: 100%;">
								<tbody style="background: #fff; font-size: 11px;" id="tBodyStockProductos">	
								</tbody>		
							</table>
						</td>
					</tr>
				</tbody>	
			</table>
        </div>
    </div>

	<div role="dialog" tabindex="-1" class="modal fade" id="modalAutorizacionAsiento"
		style="padding-top: 140px; margin-right:auto;margin-left:auto; opacity: 1;">
		   <div class="modal-dialog" role="document">
			 <div class="modal-content">
			   <div class="modal-header" style="background-color: #CCD1D1"> <!-- CABECERA -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onClick="cerrarAutorizacion();">
						<span aria-hidden="true" style="color: red;"><b>X</b></span></button>
					<h4 class="text-left modal-title">Autorización de Asiento</h4>
			   </div>
			   
			    <div class="modal-body" style="height: 350px; "> <!-- CUERPO DEL MENSAJE -->
				    <div class="row form-group">
						<div style="width: calc(100% - 40px); margin-left: 20px;">
							<span id="idAsientoAutorizacion" style="display: none;"></span>
							<table id="tableAsientoContable" id="tableAsientoContable" 
								   style="width: 100%; font-size: 11px; padding: 2px;">
							</table>
						</div>	
					</div>
				</div>

			   <div class="modal-footer"> <!-- PIE -->
				   	<button class="btn btn-default btn btn-primary btn-lg" type="button" data-dismiss="modal" 
							onClick="autorizaAsientoContable();">Autorizar </button>
				   
					<button class="btn btn-default btn btn-danger btn-lg" type="button" data-dismiss="modal" 
							onClick="cerrarAutorizacion();">Cancelar </button>
			   </div>
			</div>
		</div>
	</div>
	
	<div role="dialog" tabindex="-1" class="modal fade" id="modalModificaAsiento"
		style="padding-top: 140px; margin-right:auto;margin-left:auto; opacity: 1;">
		   <div class="modal-dialog" role="document">
			 <div class="modal-content">
			   <div class="modal-header" style="background-color: #CCD1D1"> <!-- CABECERA -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onClick="cerrarModifica();">
						<span aria-hidden="true" style="color: red;"><b>X</b></span></button>
					<h4 class="text-left modal-title">Modificación de Asiento</h4>
			   </div>
			   
			    <div class="modal-body" style="height: 350px; "> <!-- CUERPO DEL MENSAJE -->
				    <div class="row form-group">
						<div style="width: calc(100% - 40px); margin-left: 20px; overflow-y: scroll; height: 330px; 
									overflow-x: hidden;">
							<table id="tableAsientoContableMod" id="tableAsientoContableMod" 
								   style="width: 100%; font-size: 11px; padding: 2px; he">
							</table>
						</div>	
					</div>
				</div>

			   <div class="modal-footer"> <!-- PIE -->
				   	<button class="btn btn-default btn btn-success btn-lg" type="button" data-dismiss="modal" 
							onClick="guardarCambiosAsiento();">Guardar </button>
				   
				   <button class="btn btn-default btn btn-primary btn-lg" type="button" data-dismiss="modal" 
							onClick="anadirLineaAsientoContable();">Añadir </button>
				   
					<button class="btn btn-default btn btn-danger btn-lg" type="button" data-dismiss="modal" 
							onClick="cerrarModifica();">Cancelar </button>
			   </div>
			</div>
		</div>
	</div>
	
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
	
	/*var cmb=new componente.cmb
		cmb.ini('cmbTiposAsientos')
		cmb.loadFromUrl('../cmb/cmbTfnTiposAsientos.php')
		cmb.setChangeFunction(dataDetalleAsientos);*/
	
	function dataDetalleAsientos(){
		var cmbpr=new componente.cmb
			cmbpr.ini('cmbDetalleAsiento')
		cmbpr.clear();
		cmbpr.loadFromUrl('../cmb/cmbTfnDetalleAsientos.php',
						  {id:document.getElementById("cmbTiposAsientos").value});
	}
	
	function consultaMovimientos(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var url = '../php/retornaInformacionFacturas.php';
			//idTipoAsiento = document.getElementById('cmbTiposAsientos').value;
		    //idNumAsiento  = document.getElementById('cmbDetalleAsiento').value;
		    fechaDesde 	  = document.getElementById('fechaDesde').value;
		    fechaHasta 	  = document.getElementById('fechaHasta').value;
		$.ajax({
			type:'POST',
			url:url,
			data:'fechaDesde='+fechaDesde+'&fechaHasta='+fechaHasta,
			success:function(data){
				data = eval(data);
				document.getElementById('tBodyStockProductos').innerHTML = data[0];
				parent.document.getElementById('divLoadding').style.display = 'none';
			}
		});
	}
	
	function abrirAutorizaAsiento(id){
		document.getElementById('modalAutorizacionAsiento').style.display = 'block';
		  parent.document.getElementById('divLoadding').style.display = 'block';
			var url = '../php/retornaAsientoNoContabilizado.php';
		    document.getElementById('idAsientoAutorizacion').innerHTML = id;
			$.ajax({
				type:'POST',
				url:url,
				data:'id='+id,
				success:function(data){
					data = eval(data);
					document.getElementById('tableAsientoContable').innerHTML = data[0];
					parent.document.getElementById('divLoadding').style.display = 'none';
				}
			});
		
	}
	
	function cerrarAutorizacion(){
		document.getElementById('modalAutorizacionAsiento').style.display = 'none';
	}
	
	function modificaAsiento(id){
		document.getElementById('modalModificaAsiento').style.display = 'block';
		  parent.document.getElementById('divLoadding').style.display = 'block';
			var url = '../php/retornaAsientoNoContabilizadoMod.php';
			$.ajax({
				type:'POST',
				url:url,
				data:'id='+id,
				success:function(data){
					data = eval(data);
					document.getElementById('tableAsientoContableMod').innerHTML = data[0];
					parent.document.getElementById('divLoadding').style.display = 'none';
				}
			});
	}
	
	function cerrarModifica(){
		document.getElementById('modalModificaAsiento').style.display = 'none';
	}
	
	function eliminarLineaAsiento(e){
		if (confirm('Está seguro de querer eliminar el registro?')) {
			var row = e.parentNode.parentNode;
				row.parentNode.removeChild(row);
				calculaSaldosTotales();
			}
	}
	
	function cambioCuenta(id){
		var url = '../php/retornaCuentaDescripcion.php';
			var idCod = document.getElementById('sp2'+id).value;
			$.ajax({
				type:'POST',
				url:url,
				data:'id='+idCod,
				success:function(data){
					data = eval(data);
						if(data[0] == '0'){
						   document.getElementById('sp3'+id).innerHTML = '';
							alert('El código indicado no se encuentra disponible, por favor verifique.');
						}else{document.getElementById('sp3'+id).innerHTML = data[1];}
				},
				error: function (jqXHR, exception) {
					var msg = '';
					if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
					$('#post').html(msg);
				}
			});
	}
	
	function anadirLineaAsientoContable(){
		const rowNumber = document.getElementById('tablaAsientoDetalles').rows.length - 1;
		var x=document.getElementById('tablaAsientoDetalles').insertRow(rowNumber);
			var a = x.insertCell(0);
			var b = x.insertCell(1);
		    var c = x.insertCell(2);
		    var d = x.insertCell(3);
		    var e = x.insertCell(4);
		    var f = x.insertCell(5);
				
				a.innerHTML = rowNumber;
				  a.style= "text-align: center; border: 1px solid #4ba6c0;"; 	
				b.innerHTML = "<input id='sp2"+rowNumber+"' style='width: 100%' onChange='cambioCuenta("+rowNumber+");'/>";
				  b.style= "text-align: left; border: 1px solid #4ba6c0;"; 	
				c.innerHTML = "<span  id='sp3"+rowNumber+"'></span>";
				  c.style= "text-align: left; border: 1px solid #4ba6c0;"; 	
				d.innerHTML = "<input id='sp4"+rowNumber+"' value='0.00' style='width: 100%; text-align: right;' "+
								 "onChange='calculaDebe("+rowNumber+");'/>";
				  d.style= "text-align: center; border: 1px solid #4ba6c0;"; 	
				e.innerHTML = "<input id='sp5"+rowNumber+"' value='0.00' style='width: 100%; text-align: right;' "+
								 "onChange='calculaHaber("+rowNumber+");'/>";
				  e.style= "text-align: center; border: 1px solid #4ba6c0;"; 
		
				f.innerHTML = "<img onClick='eliminarLineaAsiento(this);' src='../images/icons/eliminarLinea.png' height='20'>";

	}
	
	function guardarCambiosAsiento(){
		document.getElementById('modalModificaAsiento').style.display = 'block';
			calculaSaldosTotales();
			if (document.getElementById('mtDbAsiento').value != document.getElementById('mtHbAsiento').value){
				parent. modalAlertPrincipal(1, 'MarketSys [Transacción Éxitosa]', 
												'El monto del debe no coincide con el monto del haber.', 0, 
												'Aceptar', '');
				return;
				}
		
			var idAsiento = document.getElementById('idAsiento').innerHTML;
		    var dscAsiento = document.getElementById('dscAsiento').value;
		    var glsAsiento = document.getElementById('glsAsiento').value;
			var mtDbAsiento = document.getElementById('mtDbAsiento').value;
			var mtHbAsiento = document.getElementById('mtHbAsiento').value;
			
			var url = '../php/actualizaAsientoContableNC.php';
		 	$.ajax({
				type:'POST',
				url:url,
				data:'id='+idAsiento+'&dscAsiento='+dscAsiento+'&glsAsiento='+glsAsiento+
					 '&mtDbAsiento='+mtDbAsiento+'&mtHbAsiento='+mtHbAsiento,
				success:function(data){
					data = eval(data);
					document.getElementById('modalModificaAsiento').style.display = 'block';
					
					var tblDetAsCon = document.getElementById('tablaAsientoDetalles');
					for(var i = 1; i < (tblDetAsCon.rows.length-1); i++){
						idAsiento 	= document.getElementById('idAsiento').innerHTML;
							var idLinea 	 = tblDetAsCon.rows[i].cells[0].innerHTML;
							var codigoCuenta = document.getElementById('sp2'+idLinea).value;
							var valorDebe	 = document.getElementById('sp4'+idLinea).value;
							var valorHaber	 = document.getElementById('sp5'+idLinea).value;
						
							var url = '../php/actualizaDetalleAsientoContableNC.php';
							$.ajax({
								type:'POST',
								url:url,
								async: false,
								data:'id='+idAsiento+'&idLinea='+idLinea+'&codigoCuenta='+codigoCuenta+
									 '&valorDebe='+valorDebe+'&valorHaber='+valorHaber,
								success:function(data){	
									},
									error: function (jqXHR, exception) {
										var msg = '';
										if (jqXHR.status === 0) {
											msg = 'Not connect.\n Verify Network.';
										} else if (jqXHR.status == 404) {
											msg = 'Requested page not found. [404]';
										} else if (jqXHR.status == 500) {
											msg = 'Internal Server Error [500].';
										} else if (exception === 'parsererror') {
											msg = 'Requested JSON parse failed.';
										} else if (exception === 'timeout') {
											msg = 'Time out error.';
										} else if (exception === 'abort') {
											msg = 'Ajax request aborted.';
										} else {
											msg = 'Uncaught Error.\n' + jqXHR.responseText;
										}
										$('#post').html(msg);
									}
								});
						
						}
					consultaMovimientos();
					document.getElementById('modalModificaAsiento').style.display = 'none';
						
				},
				error: function (jqXHR, exception) {
					var msg = '';
					if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
						document.getElementById('modalModificaAsiento').style.display = 'none';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
						document.getElementById('modalModificaAsiento').style.display = 'none';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
						document.getElementById('modalModificaAsiento').style.display = 'none';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
						document.getElementById('modalModificaAsiento').style.display = 'none';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
						document.getElementById('modalModificaAsiento').style.display = 'none';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
						document.getElementById('modalModificaAsiento').style.display = 'none';
					} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
						document.getElementById('modalModificaAsiento').style.display = 'none';
					}
					alert(msg);
				}
			});
			
	}
	
	function calculaDebe(id){
		nv = parseFloat($("#sp4"+id).val());
			 document.getElementById('sp4'+id).value = nv.toFixed(2)
		
		if (document.getElementById('sp4'+id).value != 0){
			document.getElementById('sp5'+id).value  = '0.00'}
		
		calculaSaldosTotales();
	}
	
	function calculaHaber(id){
		nv = parseFloat($("#sp5"+id).val());
			 document.getElementById('sp5'+id).value = nv.toFixed(2);
		
		if (document.getElementById('sp5'+id).value != 0){
			document.getElementById('sp4'+id).value  = '0.00'}
		    
		calculaSaldosTotales();
	}
	
	function calculaSaldosTotales(){
		var tblDetAsCon = document.getElementById('tablaAsientoDetalles');
			montoDebe = 0;
		    montoHaber = 0;
			for(var i = 1; i < (tblDetAsCon.rows.length-1); i++){
				var idLinea 	 = tblDetAsCon.rows[i].cells[0].innerHTML;
				montoDebe = montoDebe + parseFloat(document.getElementById('sp4'+idLinea).value);
				montoHaber=	montoHaber+ parseFloat(document.getElementById('sp5'+idLinea).value);
			}
		document.getElementById('mtDbAsiento').value = montoDebe.toFixed(2);
		document.getElementById('mtHbAsiento').value = montoHaber.toFixed(2);
	}
	
	function autorizaAsientoContable(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var id = document.getElementById('idAsientoAutorizacion').innerHTML;
		var tblDetAsCon = document.getElementById('tablaAsientoDetalleAut');
		for(var i = 1; i < (tblDetAsCon.rows.length-1); i++){
			var codigoCuenta = tblDetAsCon.rows[i].cells[1].innerHTML;
				var valorDebe	 = tblDetAsCon.rows[i].cells[3].innerHTML;
				var valorHaber	 = tblDetAsCon.rows[i].cells[4].innerHTML;
						
			var url = '../php/autorizaAsientoNoContabilizado.php';
			$.ajax({
				type:'POST',
				url:url,
				data:'codigoCuenta='+codigoCuenta+'&valorDebe='+valorDebe+'&valorHaber='+valorHaber+'&id='+id,
				success:function(data){
					//data = eval(data);

					parent.document.getElementById('divLoadding').style.display = 'none';
				}
			});
		}
		document.getElementById('modalAutorizacionAsiento').style.display = 'none';
	}
	
	function imprimeAsiento(id){
		window.open('../reports/asientoContablePDF.php?id='+id);
	}
	
</script>
</body>
</html>