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
						<td colspan="6" class="estilo3">
							CONSULTA DE COMPRAS
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Compra
					    </td>
						<td colspan="3" class="clsObjetosTable">
							<input id="idFactura" style="height: 22px; width: 100%; text-align: left;" 
								   placeholder="Información de la factura.">
						</td>
						<td rowspan="3" style="width: 120px;">
							<button type="button" onClick="consultaMovimientos();" style="width: 100%;">
								<img src="../images/icons/busqueda.png" width="29px" alt=""/><br>Consultar Compras</button>
					    </td>
						<td rowspan="3" style="width: 120px;">
							<button type="button" onClick="descargarFacturas();" style="width: 100%;">
								<img src="../images/icons/sriInstitucion.png" height="29px" alt=""/><br>Descargar Información</button>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Proveedor
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
						<td colspan="6" class="estilo3">
							DETALLES DE COMPRAS
						</td>
					</tr>
					<tr>
						<td colspan="6" class="estilo3">
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
		var url = '../php/retornaInformacionCompras.php';
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
	
	function descargarFacturas(){
		fechaDesde 	  = document.getElementById('fechaDesde').value;
		fechaHasta 	  = document.getElementById('fechaHasta').value;
		var page='../reports/listaInformacionCompras.php';
			$.ajax({
				url: page,
				type: 'GET',
				data: 'fechaDesde='+fechaDesde+'&fechaHasta='+fechaHasta,
				dataType:'json'
				}).done(function(data){
					if (data.op == 'ok'){
						var $a = $("<a>");
						$a.attr("href",data.file);
						$("body").append($a);
						$a.attr("download","ListaCompras.xlsx");
						$a[0].click();
						$a.remove();
						parent.document.getElementById('divLoadding').style.display = 'none';
						
					}
				
			});
	}
	
</script>
</body>
</html>