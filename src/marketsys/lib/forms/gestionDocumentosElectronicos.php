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
							CONSULTA DE DOCUMENTOS ELECTRÓNICOS
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Tipo de Documento
					    </td>
						<td class="clsObjetosTable">
							<select id="tipoDocumento" style="width: 100%; font-size: 12px;">
								<option value='0'>Seleecione un tipo de documento</option>
								<option value='1'>Facturas</option>
								<option value='7'>Retenciones</option>
							</select>
						</td>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Estado Electrónico
					    </td>
						<td class="clsObjetosTable">
							<select id="estadoElectronico" style="width: 100%; font-size: 12px;">
								<option value='N'>Seleecione un estado del documento</option>
								<option value='G'>GENERADO</option>
								<option value='B'>DEVUELTO</option>
								<option value='R'>RECHAZADO</option>
								<option value='A'>AUTORIZADO</option>
							</select>
						</td>
						<td rowspan="2" style="width: 120px;">
							<button type="button" onClick="consultaMovimientos();" style="width: 100%;">
								<img src="../images/icons/busqueda.png" width="20px" alt=""/><br>Consultar</button>
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
							DETALLES DE DOCUMENTOS ELECTRÓNICOS
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
	
	<div role="dialog" tabindex="-1" class="modal fade" id="modalObservacionDiv"
		style="padding-top: 140px; margin-right:auto;margin-left:auto; opacity: 1;">
		   <div class="modal-dialog" role="document">
			 <div class="modal-content">
			   <div class="modal-header" style="background-color: #CCD1D1"> <!-- CABECERA -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onClick="cerrarObservacion();">
						<span aria-hidden="true" style="color: red;"><b>X</b></span></button>
					<h4 class="text-left modal-title">Detalle Electrónico</h4>
			   </div>
			   
			    <div class="modal-body" style="height: 350px; padding-top: 0px;"> <!-- CUERPO DEL MENSAJE -->
					<div style="width: calc(100% - 20px); margin-left: 10px;" id="calificacionDiv">
						<table class="table" style="width: 100%;">
							<tr>
								<td colspan="3"><textarea id="descripcionItemAd" autocomplete="off" type="text" 
														  class="form-control" rows="16" disabled
														  style="width: 100%;"></textarea>
								</td>
							</tr>
						</table>	
					</div>
				</div>

			   <div class="modal-footer"> <!-- PIE -->
				   <button class="btn btn-default btn btn-danger btn-lg" type="button" data-dismiss="modal" 
							onClick="cerrarObservacion();">Cancelar </button>
			   </div>
			</div>
		</div>
	</div>
	
  <script type="text/javascript" src="../js/moment.js"></script>
  <script type="text/javascript" src="../js/fiddle.js"></script>
  <script type="text/javascript" src="../js/forge.min.js"></script>
  <script type="text/javascript" src="../js/buffer.js"></script>	
	
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
	
	function  observacionItem(id){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var url = '../php/retornaInformacionElectronica.php';
		$.ajax({
			type:'GET',
			url:url,
			async: false,
			data:'idfactura='+id,
			success:function(data){
				data = eval(data);
				document.getElementById("descripcionItemAd").value = data[0];
			}
		});
		
		
		document.getElementById("modalObservacionDiv").style.display = 'block';
		parent.document.getElementById('divLoadding').style.display = 'none';
	}
	
	function  observacionItemRt(id){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var url = '../php/retornaInformacionElectronicaRt.php';
		$.ajax({
			type:'GET',
			url:url,
			async: false,
			data:'idfactura='+id,
			success:function(data){
				data = eval(data);
				document.getElementById("descripcionItemAd").value = data[0];
			}
		});
		
		
		document.getElementById("modalObservacionDiv").style.display = 'block';
		parent.document.getElementById('divLoadding').style.display = 'none';
	}
	
	function cerrarObservacion(){
		document.getElementById("modalObservacionDiv").style.display = 'none';
	}
	
	function consultaMovimientos(){
		if (document.getElementById('tipoDocumento').value == 0){
			
			return;}
		parent.document.getElementById('divLoadding').style.display = 'block';
			//idTipoAsiento = document.getElementById('cmbTiposAsientos').value;
		    //idNumAsiento  = document.getElementById('cmbDetalleAsiento').value;
		    fechaDesde 	  = document.getElementById('fechaDesde').value;
		    fechaHasta 	  = document.getElementById('fechaHasta').value;
		if (document.getElementById('tipoDocumento').value == 1){
			var url = '../php/retornaRegistrosFactura.php';
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
		if (document.getElementById('tipoDocumento').value == 7){
			var url = '../php/retornaRegistrosRetenciones.php';
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
	}
	
	function registraFacturaElectronica(idFactura){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var url = '../php/generaFacturaElectronica.php';
		$.ajax({
			type:'GET',
			url:url,
			async: false,
			data:'idfactura='+idFactura,
			success:function(data){
				data = eval(data);
				obtenerComprobanteFirmado_sri(idFactura,data[4],atob(data[2]),data[6], data[5],data[3]);
				parent.document.getElementById('divLoadding').style.display = 'none';
			}
		});
	}
	
	function registraRetencionElectronica(idFactura){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var url = '../php/generaRetencionElectronica.php';
		$.ajax({
			type:'GET',
			url:url,
			async: false,
			data:'idfactura='+idFactura,
			success:function(data){
				data = eval(data);
				obtenerComprobanteFirmado_sri_rt_(idFactura,data[4],atob(data[2]),data[6], data[5],data[3]);
				parent.document.getElementById('divLoadding').style.display = 'none';
			}
		});
	}
	
</script>
</body>
</html>