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
							<button type="button" onClick="consultaMovimientos();" style="height: 100%;">
								<img src="../images/icons/busqueda.png" width="29px" alt=""/><br>Consultar Facturas</button>
					    </td>
						<td rowspan="3" style="width: 120px;">
							<button type="button" onClick="descargarFacturas();" style="width: 100%;">
								<img src="../images/icons/sriInstitucion.png" height="29px" alt=""/><br>Descargar Información</button>
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
						<td colspan="6" class="estilo3">
							DETALLES DE FACTURAS
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
		var url = '../php/retornaInformacionFacturasSRI.php';
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
	
	function descargarFacturas(){
		fechaDesde 	  = document.getElementById('fechaDesde').value;
		fechaHasta 	  = document.getElementById('fechaHasta').value;
		var page='../reports/listaInformacionFacturas.php';
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
						$a.attr("download","ListaFacturas.xlsx");
						$a[0].click();
						$a.remove();
						parent.document.getElementById('divLoadding').style.display = 'none';
						
					}
				
			});
	}
	
</script>
</body>
</html>