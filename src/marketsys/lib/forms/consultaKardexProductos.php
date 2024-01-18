<?php
session_start();
?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Consulta de Stock Productos</title>
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui-forms.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/styleCajas.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>
  <script type="text/javascript" src="../js/componentes.js"></script>
  <script src="../js/jquery.datetimepicker.full.js"></script>
</head>	
<body bgcolor="#fff" style="left: 0px;" onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="5" class="estilo3">
							CONSULTA DE STOCK
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Bodega
					    </td>
						<td colspan="3" class="clsObjetosTable">
							<select name="cmbBodegaDespacho" id="cmbBodegaDespacho" style="width: 100%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						</td>
						<td rowspan="6" style="width: 120px;">
							<button type="button" onClick="consultaMovimientos();" style="width: 100%;"><br>
								<img src="../images/icons/busqueda.png" width="65px" alt=""/><br><br>Consultar Movimientos</button>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Clasificación
					    </td>
						<td colspan="3" class="clsObjetosTable">
							<select name="cmbClasificacionProductos" id="cmbClasificacionProductos" style="width: 100%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						</td>	
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Producto
					    </td>
						<td colspan="3" class="clsObjetosTable">
							<select name="cmbProductos" id="cmbProductos" style="width: 100%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						</td>	
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Ítem
					    </td>
						<td colspan="3" class="clsObjetosTable">
							<select name="cmbItem" id="cmbItem" style="width: 100%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						</td>	
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Tipo movimiento
					    </td>
						<td colspan="3" class="clsObjetosTable">
							<select name="cmbTipoMovimiento" id="cmbTipoMovimiento" style="width: 100%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 150px;">
							Fecha desde
					    </td>
						<td class="clsObjetosTable">
							<input id="fechaDesde" onFocus="this.blur()" style="height: 16px; width: 99%; text-align: center;" 
								   value="<?php echo date("01/m/Y")?>" placeholder="Fecha desde">
						</td>
						<td class="clsEtiquetasTable" style="width: 120px;">
							Fecha hasta
					    </td>
						<td class="clsObjetosTable">
							<input id="fechaHasta" onFocus="this.blur()" style="height: 16px; width: 99%; text-align: center;" 
								   value="<?php echo date("d/m/Y")?>" placeholder="Fecha hasta">
						</td>
					</tr>
					<tr>
						<td colspan="5" class="estilo3">
							DETALLES DE LOS MOVIMIENTOS
						</td>
					</tr>
					<tr>
						<td colspan="5" class="estilo2">
							<table id="tableMovimientos" id="tableMovimientos" style="width: 100%;">
								<thead>
									<tr class="tablaAperturaHead">
										<td style="width: 5%;"  rowspan="2">N°</td>
										<td style="width: 10%;" rowspan="2">Fecha</td>
										<td style="width: 10%;" rowspan="2">Ítem</td>
										<td style="width: 25%;" rowspan="2">Observación</td>
										<td style="width: 10%;" rowspan="2">Transacción</td>
										<td style="width: 10%; background: #48A5E5;" colspan="2">Entradas</td>
										<td style="width: 10%; background: #F1948A;" colspan="2">Salidas</td>
										<td style="width: 10%; background: #6CCC40;" colspan="2">Saldo</td>
										<td style="width: 10%; background: #48A5E5;" colspan="2">Costo Unitario</td>
									</tr>
									<tr class="tablaAperturaHead">
										<td style="width: 5%; background:#558CB9;">Cantidad</td>
										<td style="width: 5%; background:#558CB9;">Costo</td>
										<td style="width: 5%; background:#CF705B;">Cantidad</td>
										<td style="width: 5%; background:#CF705B;">Costo</td>
										<td style="width: 5%; background:#64BB3C;">Cantidad</td>
										<td style="width: 5%; background:#64BB3C;">Costo</td>
										<td style="width: 5%;">Promedio</td>
										<td style="width: 5%;">Ajustado</td>
									</tr>
								</thead>
								<tbody style="background: #fff; font-size: 10px;" id="tBodyStockProductos">	
								</tbody>		
								<tfoot>	
									<tr class="tablaAperturaFood">
										<td colspan="5">	
										</td>
										<td  style="text-align: right; background:#558CB9;">
											<span id="txtCantidadIn" style="width: 100px;">0.00</span>		
										</td>
										<td  style="text-align: right; background:#558CB9;">
											<span id="txtCMontoIn" style="width: 100px;">0.00</span>		
										</td>
										<td  style="text-align: right; background:#CF705B;">
											<span id="txtCantidadOut" style="width: 100px;">0.00</span>		
										</td>
										<td  style="text-align: right; background:#CF705B;">
											<span id="txtCMontoOut" style="width: 100px;">0.00</span>		
										</td>
										<td  style="text-align: right; background:#64BB3C;">
											<span id="txtCantidadSal" style="width: 100px;">0.00</span>		
										</td>
										<td  style="text-align: right; background:#64BB3C;">
											<span id="txtCMontoSal" style="width: 100px;">0.00</span>		
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
		cmb.ini('cmbTipoMovimiento')
		cmb.loadFromUrl('../cmb/cmbTivTipoMovimientoTodos.php')
	
	var cmb=new componente.cmb
		cmb.ini('cmbBodegaDespacho')
		cmb.loadFromUrl('../cmb/cmbTivBodegas.php')	
	
	var cmb=new componente.cmb
		cmb.ini('cmbClasificacionProductos')
		cmb.loadFromUrl('../cmb/cmbTivCategoriasProductos.php')
		cmb.setChangeFunction(dataProductos);
	
	function dataProductos(){
		var cmbpr=new componente.cmb
			cmbpr.ini('cmbProductos')
		cmbpr.clear();
		cmbpr.loadFromUrl('../cmb/cmbTivProductos.php',
						  {id:document.getElementById("cmbClasificacionProductos").value});
		cmbpr.setChangeFunction(dataItems);
	}
	
	function dataItems(){
		var cmbIt=new componente.cmb
			cmbIt.ini('cmbItem')
		cmbIt.clear();
		cmbIt.loadFromUrl('../cmb/cmbTivItems.php',
						  {id:document.getElementById("cmbProductos").value});
	} 
	
	function consultaMovimientos(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var url = '../php/retornaMovimientosKardex.php';
			idBodega 	= document.getElementById('cmbBodegaDespacho').value;
			idCategoria = document.getElementById('cmbClasificacionProductos').value;
			idProducto 	= document.getElementById('cmbProductos').value;
		    idItem 		= document.getElementById('cmbItem').value;
		    idTipoMov 	= document.getElementById('cmbTipoMovimiento').value;
		    fechaDesde 	= document.getElementById('fechaDesde').value;
		    fechaHasta 	= document.getElementById('fechaHasta').value;
		$.ajax({
			type:'POST',
			url:url,
			data:'idBodega='+idBodega+'&idCategoria='+idCategoria+
			     '&idProducto='+idProducto+'&idItem='+idItem+
			     '&idTipoMov='+idTipoMov+'&fechaDesde='+fechaDesde+'&fechaHasta='+fechaHasta,
			success:function(data){
				data = eval(data);
				document.getElementById('tBodyStockProductos').innerHTML = data[0];
				document.getElementById('txtCantidadIn').innerHTML 	= data[1];
				document.getElementById('txtCMontoIn').innerHTML 	= data[2];
				document.getElementById('txtCantidadOut').innerHTML = data[3];
				document.getElementById('txtCMontoOut').innerHTML 	= data[4];
				document.getElementById('txtCantidadSal').innerHTML = data[5];
				document.getElementById('txtCMontoSal').innerHTML 	= data[6];
				parent.document.getElementById('divLoadding').style.display = 'none';
			}
		});
	}
</script>
</body>
</html>