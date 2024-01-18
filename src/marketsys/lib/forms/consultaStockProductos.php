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
  <script type="text/javascript" src="../js/componentes.js"></script>
</head>	
<body bgcolor="#fff" style="left: 0px;" onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="4" class="estilo3">
							CONSULTA DE STOCK
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 10%;">
							Bodega
					    </td>
						<td class="clsObjetosTable">
							<select name="cmbBodegaDespacho" id="cmbBodegaDespacho" style="width: 100%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						</td>
						<td rowspan="3" style="width: 120px;">
							<button type="button" onClick="consultaMovimientos();" style="width: 100%;"><br>
								<img src="../images/icons/busqueda.png" width="25px" alt=""/><br>Consultar Stock</button>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 10%;">
							Clasificación
					    </td>
						<td class="clsObjetosTable">
							<select name="cmbClasificacionProductos" id="cmbClasificacionProductos" style="width: 100%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						</td>	
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 10%;">
							Producto
					    </td>
						<td class="clsObjetosTable">
							<select name="cmbProductos" id="cmbProductos" style="width: 100%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						</td>	
					</tr>
					<tr>
							<td colspan="4" class="estilo3">
								DETALLES DEL STOCK
							</td>
						</tr>
						<tr>
						  <td colspan="4" class="estilo2">
							<table id="tableMovimientos" id="tableMovimientos" style="width: 100%;">
								<thead>
									<tr class="tablaAperturaHead">
										<td style="width: 5%;">N°</td>
										<td style="width: 20%;">Ítem</td>
										<td style="width: 20%;">Presentación</td>
										<td style="width: 20%;">Fabricante</td>
										<td style="width: 10%;">C.Barra</td>
										<td style="width: 5%;">Cantidad</td>
										<td style="width: 5%;">Cost.Pomed</td>
										<td style="width: 5%;">Cost.Intel</td>
										<td style="width: 5%;">Mont.Pomed</td>
										<td style="width: 5%;">Mont.Intel</td>
									</tr>
								</thead>
								<tbody style="background: #fff; font-size: 10px;" id="tBodyStockProductos">	
								</tbody>		
								<tfoot>	
									<tr class="tablaAperturaFood">
										<td colspan="8">	
										</td>
										<td  style="text-align: right;">
											<span id="txtMontoPromedio" name="txtMontoPromedio" style="width: 100px;">0.000000</span>		
										</td>
										<td  style="text-align: right;">
											<span id="txtMontoInteligente" name="txtMontoInteligente" style="width: 100px;">0.000000</span>		
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
	}
	
	function consultaMovimientos(){
		var url = '../php/retornaStockMovimientos.php';
			idBodega 	= document.getElementById('cmbBodegaDespacho').value;
			idCategoria = document.getElementById('cmbClasificacionProductos').value;
			idProducto 	= document.getElementById('cmbProductos').value;
		$.ajax({
			type:'POST',
			url:url,
			data:'idBodega='+idBodega+'&idCategoria='+idCategoria+'&idProducto='+idProducto,
			success:function(data){
				data = eval(data);
				document.getElementById('tBodyStockProductos').innerHTML = data[0];
				document.getElementById('txtMontoPromedio').innerHTML = data[1];
				document.getElementById('txtMontoInteligente').innerHTML = data[2];
			}
		});
	}
</script>
</body>
</html>