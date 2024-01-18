<?php
session_start();
?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Ajuste de inventario</title>
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui-forms.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/styleCajas.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
  <script type="text/javascript" src="../js/componentes.js"></script>
	<script>
		function enviarAjax(tipo,url_, data_, funcion_){
				$.ajax({
					type:tipo,
					dataType: 'json',
					url: url_,
					data: data_,
					success:funcion_
				})
			}
			
		$(document).ready(function () {	
			var cmb=new componente.cmb
				cmb.ini('cmbTipoMovimiento')
				cmb.loadFromUrl('../cmb/cmbTivTipoMovimiento.php')

			var cmb=new componente.cmb
				cmb.ini('cmbBodegaDespacho')
				cmb.loadFromUrl('../cmb/cmbTivBodegas.php')		
		});		
	</script>	
<body bgcolor="#fff" style="left: 0px;" onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="4" class="estilo3">
							AJUSTES EN EL INVENTARIO
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 10%;">
							Movimiento
					    </td>
						<td class="clsObjetosTable">
							<select name="cmbTipoMovimiento" id="cmbTipoMovimiento" style="width: 100%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						<td rowspan="3" style="width: 120px;">
							<button type="button" id="btn_guardar" onClick="registraMovimientos();" style="width: 100%;"><br>
								<img src="../images/icons/movimiento.png" width="35px" alt=""/><br>Registrar Ajuste</button>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 10%;">
							Bodega
					    </td>
						<td class="clsObjetosTable">
							<select name="cmbBodegaDespacho" id="cmbBodegaDespacho" style="width: 100%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						</td>	
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Observación
					    </td>
						<td class="clsObjetosTable">
							<textarea id="observacionMovimiento" class="required" type="text" style="width: 99%; height: 30px;"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="4" class="estilo3">
							BÚSQUEDA DE ÍTEM
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<table style="width: 100%;">
								<tr>
									<td style="width: 80px; padding-top: 5px; padding-bottom: 5px;">
										<input onFocus="this.blur()" id="idItem" name="idItem" type="text" style="width: 95%; height: 21px;"/>
										<input id="costoPromedio" name="costoPromedio" type="text" style="display: none;"/>
										<input id="costoIdeal" name="costoIdeal" type="text" style="display: none;"/>
										<input id="descripcionProducto" name="descripcionProducto" type="text" style="display: none;"/>
										<input id="idTipoProducto" name="idTipoProducto" type="text" style="display: none;"/>
										<input id="idGrabaIVA" name="idGrabaIVA" type="text" style="display: none;"/>
										<input id="idVentaSinStock" type="text" style="display: none;"/>
									</td>
									<td>
										<input id="item" name="item" class="required" type="text" style="width: 100%; height: 21px;"/>
									</td>
									<td style="width: 10%; text-align: center;">
										<table style="width: 100%;">
										   <tr>
											<td style="width: 30%; text-align: center;">
												<button type="button" class="add-row" style="width: 100%;">
													<img src="../images/icons/add.png" height="18px" alt=""/>
												</button>
											</td>   
											<td style="width: 35%; text-align: center;">
												<button type="button" class="new-row" style="width: 100%;">
													<img src="../images/icons/nuevo.png" height="18px" alt=""/>
												</button>
											</td>
											<td style="width: 35%; text-align: center;">
												<button type="button" class="clear-search" style="width: 100%;">
													<img src="../images/icons/clear_.png" height="18px" alt=""/>
												</button>
											</td>
										   </tr>
										</table>	
									</td>
								   </tr>
								</table>   
							</td>
						</tr>
						<tr>
							<td colspan="4" class="estilo3">
								DETALLE DEL AJUSTE DE INVENTARIO
							</td>
						</tr>
						<tr>
						  <td colspan="4" class="estilo2">
							<table id="tableMovimientos" id="tableMovimientos" style="width: 100%;">
								<thead>
									<tr class="tablaAperturaHead">
										<td style="width: 8%;">N°</td>
										<td style="width: 40%;" colspan="2">Ítem</td>
										<td style="width: 10%;">Stock Actual</td>
										<td style="width: 10%;">Costo Promedio</td>
										<td style="width: 10%;">Cantidad</td>
										<td style="width: 10%;">Costo</td>
										<td style="width: 10%;">Total</td>
										<td style="width: 2%;"></td>
									</tr>
								</thead>
								<tbody bgcolor="#fff">	
								</tbody>		
								<tfoot>	
									<tr class="tablaAperturaFood">
										<td colspan="7">	
										</td>
										<td  style="text-align: right;">
											<span id="txtVTApertura" name="txtVTApertura" style="width: 100px;">0.000000</span>		
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
<script>
	var indx = 0;
	var url = '../../lib/cmb/cmbTivItemsAutoComplete.php';
	document.getElementById('idItem').value = '';
	document.getElementById('item').value = '';
	$.ajax({
		type:'POST',
		url:url,
		data:'id=1',
		success:function(data){
			$( "#item" ).autocomplete({
			  source: eval(data)
			});
			$( "#item" ).on( "autocompleteselect", function( event, ui ) {
				document.getElementById('idItem').value = ui.item[0];
				document.getElementById('costoPromedio').value = ui.item[5];
				document.getElementById('costoIdeal').value = ui.item[4];
			});
				
		}
	});
	
	/*Añadir Fila*/
	$(".add-row").click(function(){
		if ($("#idItem").val() != ''){
			var id = $("#idItem").val();
			var name = $("#item").val();
			var costP = $("#costoPromedio").val();
			var costI = $("#costoIdeal").val();
			
			indx ++;
			var idMov = zeroPad(indx,4);
			var res = String.fromCharCode(34);
			
			var markup = "<tr style='color: #000;' name='TR"+idMov+"'>"+
							"<td style='text-align: right;'>"+idMov+"</td>"+
							"<td>" + id + "</td><td>" + name + "</td>"+
							"<td style='text-align: right;'>" + costP + "</td>"+
							"<td style='text-align: right;'>" + costI + "</td>"+
							"<td><input id='Cantidad"+idMov+"' name='Cantidad"+idMov+"' class='required' onChange='calcularValores(this)' "+
							     "type='text' style='text-align: right; width: 94%; height: 14px;' value='0.00'/></td>"+
							"<td><input id='costoMovimiento"+idMov+"' name='costoMovimiento"+idMov+"' class='required' "+
								 "onChange='calcularValores(this)' type='text' style='text-align: right; width: 94%; height: 14px;' "+
								 "value='"+ costI +"'/></td>"+
							"<td><input onFocus='this.blur()' id='totalMovimiento"+idMov+"' name='totalMovimiento"+idMov+"' "+
								 "class='required' type='text' style='text-align: right; width: 94%; height: 14px;' value='0.000000'/></td>"+
							"<td><button type='button' class='delete-row' onClick='EliminarFila(this);'>"+
								"<img src='../images/icons/clear.png' height='20px' alt=''/></button></td></tr>";
			$("#tableMovimientos").append(markup);
			$("#idItem").val('');
			$("#item").val('');
			$("#costoPromedio").val('');
			$("#costoIdeal").val('');
		}
	});
	
	
	$(".clear-search").click(function(){
		$("#idItem").val('');
		$("#item").val('');
		$("#costoPromedio").val('');
		$("#costoIdeal").val('');
	});
	
	function EliminarFila (r){
		var i = r.parentNode.parentNode.rowIndex;
		var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
		var ValTemp = document.getElementById("txtVTApertura").innerHTML;
		var TotRedu = document.getElementById("totalMovimiento"+id).value;
		    ValTemp = ValTemp - TotRedu;
			var n = parseFloat(ValTemp).toFixed(6);
			document.getElementById("txtVTApertura").innerHTML = n;
		document.getElementById("tableMovimientos").deleteRow(i);
	}
	
	function zeroPad(num, places) {
	  var zero = places - num.toString().length + 1;
	  return Array(+(zero > 0 && zero)).join("0") + num;
	}
	
	function calcularValores(r){
		var i = r.parentNode.parentNode.rowIndex;
		var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
		var ValTemp = document.getElementById("txtVTApertura").innerHTML;
		var TotRedu = document.getElementById("totalMovimiento"+id).value;
		var CantMov = document.getElementById("Cantidad"+id).value;
		var CostMov = document.getElementById("costoMovimiento"+id).value;
		
		var NuevTot = CantMov * CostMov;
		    ValTemp = ValTemp - TotRedu;
			ValTemp = ValTemp + NuevTot;
			var n1 = parseFloat(CantMov).toFixed(2);
			document.getElementById("Cantidad"+id).value = n1;
			var n2 = parseFloat(CostMov).toFixed(6);
			document.getElementById("costoMovimiento"+id).value = n2;
			var n3 = parseFloat(NuevTot).toFixed(6);
			document.getElementById("totalMovimiento"+id).value = n3;
			var n4 = parseFloat(ValTemp).toFixed(6);
			document.getElementById("txtVTApertura").innerHTML = n4;
			
		
	}
	
	function registraMovimientos(){
		
		if (document.getElementById("cmbTipoMovimiento").value == 0){
			parent. modalAlertPrincipal(2, 'MarketSys', 'Para almacenar los movimientos deberá escoger el Tipo de Movimiento por el cual se esta realizando el ajuste.', 0, 'Aceptar', '')
			return 0;
		}else{
			if (document.getElementById("cmbBodegaDespacho").value == 0){
				parent. modalAlertPrincipal(2, 'MarketSys', 'Para almacenar los movimientos deberá escoger la bodega en la cual se esta realizando el ajuste.', 0, 'Aceptar', '')
				return 0;
			}
			var tableReg = document.getElementById('tableMovimientos');
			var inicio = 0;
			var d = new Date();
			for (var i = 1; i < tableReg.rows.length-1; i++)
				{cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
				 // Recorremos todas las celdas
				 
				 if (i == 1){inicio = 1; d = d.getTime();}else{inicio = 0;}
				 var tipoMv = document.getElementById("cmbTipoMovimiento").value;
				 var idBode = document.getElementById("cmbBodegaDespacho").value;
				 var obserM = document.getElementById("observacionMovimiento").value;
				 var idMovi = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
				 var idItem = document.getElementById("tableMovimientos").rows[i].cells[1].innerHTML;
				 var stockA = document.getElementById("tableMovimientos").rows[i].cells[3].innerHTML;
				 var costoA = document.getElementById("tableMovimientos").rows[i].cells[4].innerHTML;
				 var cantiM = document.getElementById("Cantidad"+idMovi).value;	
				 var costoM = document.getElementById("costoMovimiento"+idMovi).value;
				 var totalM = document.getElementById("totalMovimiento"+idMovi).value;
				 
				 	
					 enviarAjax("POST",
								"../../lib/php/registraMovimientosInventario.php", 
							   {dn:d, ini:inicio, idbode:idBode, tipomv:tipoMv, obserm:obserM, iditem:idItem, stocka:stockA, costoa:costoA, cantim:cantiM, costom:costoM, totalm:totalM}, 
								resultadoMovimiento);	 
				 
			}
		}
	}
	
	function resultadoMovimiento(e){
		
	}
</script>
</body>
</html>