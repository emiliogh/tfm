<?php
session_start();
?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Proforma</title>
  
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">	
  <link rel="stylesheet" type="text/css" href="../css/styleCajas.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-toggle.min.css">

<body bgcolor="#fff" style="left: 0px; width: 100%" onLoad="retornaParametros()">
<form id="frm_clientes" method="post" enctype="multipart/form-data"> 
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="5" style="background-color: #16A085; color: #fff; padding-left: 5px;">
							<b>PROFORMA</b>
							<input id="porcentajeIVA" name="porcentajeIVA" type="text" style="display: none;"/>
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 10%; padding-top: 5px;">
							Cliente:
					    </td>
						<td style="width: 10%;">
							<input onFocus="this.blur()" id="idCliente" name="idCliente" type="text" style="width: 95%; height: 18px;"/>
						</td>
						<td class="clsObjetosTable" colspan="2">
							<input id="cliente" name="cliente" class="required" type="text" 
								   style="width: 100%; height: 18px; text-transform: uppercase;"/>
							<input id="idTipoCliente" name="idTipoCliente" type="text" style="display: none;"/>
							<input id="idCategoriaCliente" name="idCategoriaCliente" type="text" style="display: none;"/>
							<input id="idPorcentajeCategoria" name="idPorcentajeCategoria" type="text" style="display: none;"/>
						</td>	
						<td rowspan="4">
							<table style="width: 100%">
							   <tr>
							     <td  style="padding-left: 5px;">
									<button type="button" id="btn_guardar" style="width: 80px; line-height : 14px;" onClick="registraNuevoCliente();">
										<img src="../images/icons/cliente.png" style="width: 43px" alt=""/><br><b>Nuevo Cliente</b>
									 </button>
								 </td>
								 <td style="padding-left: 5px;">
								    <button type="button" id="btn_guardar" style="width: 80px; line-height : 14px;" onClick="registraProforma();">
										<img src="../images/icons/guardar.png" style="width: 43px" alt=""/><br><b>Registra Proforma</b>
									 </button>
								 </td>
								</tr> 
							</table>	
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Identificación:
					    </td>
						<td style="width: 10%;">
							<input onFocus="this.blur()" id="identificacion" name="identificacion" type="text" 
								   style="width: 95%; height: 18px; font-size: 12px;"/>
						</td>
						<td style="width: 15%;" class="clsEtiquetasTable">
							Dirección:
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="direccion" name="direccion" type="text" 
								   style="width: 100%; height: 18px;text-transform: uppercase;"/>
						</td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Télefono:
					    </td>
						<td style="width: 10%;">
							<input onFocus="this.blur()" id="telefono" name="telefono" type="text" 
								   style="width: 95%; height: 18px; font-size: 12px;"/>
						</td>
						<td class="clsEtiquetasTable">
							Correo Electrónico:
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="email" name="email" class="required" type="text" 
								   style="width: 100%; height: 18px;text-transform: lowercase;"/>
						</td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Descripción:
					    </td>
						<td colspan="3" style="width: 100%; padding-bottom: 5px;">
							<input id="descripcion" name="descripcion" autocomplete="off" type="text" style="width: 100%; height: 18px;"/>
						</td>	
					</tr>	
					<tr>
						<td colspan="5" style="background-color: #16A085; color: #fff; padding-left: 5px;">
							<b>BÚSQUEDA DE ÍTEM</b>
						</td>
					</tr>
					<tr>
						<td colspan="5" style="padding-left: 15px;">
							<table style="width: 100%;">
							   <tr>
									<td style="width: 10%; padding-top: 5px; padding-bottom: 5px;">
										<input onFocus="this.blur()" id="idItem" name="idItem" type="text" style="width: 95%; height: 26px;"/>
										<input id="costoPromedio" name="costoPromedio" type="text" style="display: none;"/>
										<input id="costoIdeal" name="costoIdeal" type="text" style="display: none;"/>
										<input id="descripcionProducto" name="descripcionProducto" type="text" style="display: none;"/>
										<input id="idTipoProducto" name="idTipoProducto" type="text" style="display: none;"/>
										<input id="idGrabaIVA" name="idGrabaIVA" type="text" style="display: none;"/>
										<input id="idVentaSinStock" name="idVentaSinStock" type="text" style="display: none;"/>
									</td>
									<td>
										<input id="item" name="item" class="required" type="text" style="width: 100%; height: 26px;"/>
									</td>
									<td style="width: 10%; text-align: center; padding-left: 5px;">
										<table style="width: 100%;">
										   <tr>
											<td style="width: 30%; text-align: center;">
												<button type="button" class="add-row" style="width: 100%;">
													<img src="../images/icons/add.png" height="18px" alt=""/>
												</button>
											</td>   
											<td style="width: 35%; text-align: center;">
												<button type="button" class="clear-search" style="width: 100%;">
													<img src="../images/icons/clear_.png" height="18px" alt=""/>
												</button>
											</td>
											<td style="width: 35%; text-align: center;">
												<button type="button" class="new-row" style="width: 100%;">
													<img src="../images/icons/nuevo.png" height="18px" alt=""/>
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
						<td colspan="5" style="background-color: #16A085; color: #fff; padding-left: 5px;">
							<b>DETALLE DE LA PROFORMA</b>
						</td>
					</tr>
					<tr>
						<td colspan="5" style="vertical-align: top;">
							<table id="tableMovimientos" id="tableMovimientos" style="width: 100%; background-color: #16A085;">
								<thead>
									<tr class="tablaAperturaHead">
										<td style="width: 8%;">N°</td>
										<td style="width: 30%; border-left: 1px solid white;">Ítem</td>
										<td style="width: 10%; border-left: 1px solid white;">Stock</td>
										<td style="width: 10%; border-left: 1px solid white;">Costo</td>
										<td style="width: 10%; border-left: 1px solid white;">P.V.P.</td>
										<td style="width: 10%; border-left: 1px solid white;">Cantidad</td>
										<td style="width: 10%; border-left: 1px solid white;" colspan="2">Total</td>
									</tr>
								</thead>
								<tbody bgcolor="#fff">	
								</tbody>		
								<tfoot>	
									<tr class="tablaAperturaFood">
										<td colspan="4" bgcolor="#fff" style="border-top: 2px solid #4ea8c1;">	
										</td>
										<td colspan="3">
											<table style="width: 100%" style="background-color: #16A085;">
												<tr>
													<td style="text-align: left; padding-left: 5px;">SUBTOTAL</td>
													<td></td>
													<td style="text-align: right; width: 100px;">
														<span id="txtSubtotalVenta" name="txtSubtotalVenta">0.00</span>
													</td>	
												</tr>
												<tr>
													<td style="text-align: left; padding-left: 5px;">IVA 0.00%</td>
													<td><span id="txtVTotalIVA0" name="txtVTotalIVA0">0.00</span></td>
													<td style="text-align: right; width: 100px;">
														<span id="txtTotalIVA0" name="txtTotalIVA0">0.00</span>
													</td>	
												</tr>
												<tr>
													<td style="text-align: left; padding-left: 5px;">
														IVA <span id="iVAPorcentaje" name="iVAPorcentaje">0.00</span>%
													</td>
													<td><span id="txtVTotalIVA12" name="txtVTotalIVA12">0.00</span></td>
													<td style="text-align: right; width: 100px;">
														<span id="txtTotalIVA12" name="txtTotalIVA12">0.00</span>
													</td>	
												</tr>
												<tr>
													<td style="text-align: left; padding-left: 5px;">TOTAL</td>
													<td></td>
													<td style="text-align: right; width: 100px;">
														<span id="txtTotalVenta" name="txtTotalVenta">0.00</span>
													</td>	
												</tr>
											</table>			
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
	<div role="dialog" tabindex="-1" class="modal fade" id="modalClienteDiv"
		style="padding-top: 140px; margin-right:auto;margin-left:auto; opacity: 1;">
		   <div class="modal-dialog" role="document">
			 <div class="modal-content">
			   <div class="modal-header" style="background-color: #CCD1D1"> <!-- CABECERA -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onClick="cerrarCliente();">
						<span aria-hidden="true" style="color: red;"><b>X</b></span></button>
					<h4 class="text-left modal-title">Creación de clientes</h4>
			   </div>
			   
			    <div class="modal-body" style="height: 350px; "> <!-- CUERPO DEL MENSAJE -->
				    <div class="row form-group">
						<div style="width: calc(100% - 70px); margin-left: 30px;" id="calificacionDiv">
							<table class="table" style="width: 100%;">
								<tr>
									<td>Tipo Cliente
									</td>	
									<td><select id="tiposClientesNw" style="width: 100%;"></select>
									</td>	
								</tr>
								<tr>
									<td>Categoría
									</td>	
									<td><select id="categoriasClientesNw" style="width: 100%;"></select>
									</td>	
								</tr>
								<tr>
									<td>Tipo de identificación
									</td>	
									<td><select id="tiposIdentificacionNw" style="width: 100%;"></select>
									</td>	
								</tr>
								<tr>
									<td>Identificación
									</td>	
									<td><input id="numeroIdentificacionNw" name="numeroIdentificacionNw" autocomplete="off" type="text" 
											   class="form-control" style="width: 100%; height: 22px;" onkeypress="return soloNumeros(event);"
											   maxlength="13"/>
									</td>	
								</tr>
								<tr>
									<td><span id="tipo">Nombre</span>
									</td>	
									<td><input id="nombreClienteNw" name="nombreClienteNw" autocomplete="off" type="text" class="form-control"
											   style="width: 100%; height: 22px; text-transform: uppercase;" onkeypress="return soloLetras(event)"/>
									</td>	
								</tr>
								<tr>
									<td>Dirección
									</td>	
									<td><input id="direccionNw" name="direccionNw" autocomplete="off" type="text" class="form-control"
											   style="width: 100%; height: 22px; text-transform: uppercase;" onkeypress="return soloLetras(event)"/>
									</td>	
								</tr>
								<tr>
									<td>Teléfono
									</td>	
									<td><input id="telefonoNw" name="telefonoNw" autocomplete="off" type="text" class="form-control" 
											   style="width: 100%; height: 22px; text-transform: uppercase;" onkeypress="return soloNumeros(event);"
											   maxlength="10"/>
									</td>	
								</tr>
								<tr>
									<td>Email
									</td>	
									<td><input id="EmailNw" name="EmailNw" autocomplete="off" type="text" class="form-control"
											   style="width: 100%; height: 22px; text-transform: lowercase;"/>
									</td>	
								</tr>
							</table>	
						</div>	
					</div>
					
				</div>

			   <div class="modal-footer"> <!-- PIE -->
				   	<button class="btn btn-default btn btn-primary btn-lg" type="button" data-dismiss="modal" 
							onClick="guardarNuevoCliente();">Guardar </button>
				   
					<button class="btn btn-default btn btn-danger btn-lg" type="button" data-dismiss="modal" 
							onClick="cerrarCliente();">Cancelar </button>
			   </div>
			</div>
		</div>
	</div>
	
	<div role="dialog" tabindex="-1" class="modal fade" id="modalProductoDiv"
		style="padding-top: 140px; margin-right:auto;margin-left:auto; opacity: 1;">
		   <div class="modal-dialog" role="document">
			 <div class="modal-content">
			   <div class="modal-header" style="background-color: #CCD1D1"> <!-- CABECERA -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onClick="cerrarProducto();">
						<span aria-hidden="true" style="color: red;"><b>X</b></span></button>
					<h4 class="text-left modal-title">Creación de productos</h4>
			   </div>
			   
			    <div class="modal-body" style="height: 360px; padding-top: 0px;"> <!-- CUERPO DEL MENSAJE -->
				    <div class="row form-group">
						<div style="width: calc(100% - 70px); margin-left: 30px;" id="calificacionDiv">
							<table class="table" style="width: 100%;">
								<tr>
									<td style="width: 120px;">Tipo Producto
									</td>	
									<td colspan="3"><select id="tiposProductosNw" style="width: 100%;"></select>
									</td>	
								</tr>
								<tr>
									<td>Producto
									</td>	
									<td colspan="3"><select id="productosNw" style="width: 100%;"></select>
									</td>	
								</tr>
								<tr>
									<td>Descripción
									</td>	
									<td colspan="3"><input id="descripcionNw" autocomplete="off" type="text" class="form-control"
											   			   style="width: 100%; height: 22px; text-transform: uppercase;" 
														   onkeypress="return soloNumerosLetras(event)"/>
									</td>
								</tr>
								<tr>	
									<td>Código de barra
									</td>	
									<td colspan="3"><input id="codigoBarraNw" autocomplete="off" type="text" class="form-control"
											   			   style="width: 100%; height: 22px; text-transform: uppercase;" 
														   maxlength="20" onkeypress="return soloNumeros(event);"/>
									</td>	
								</tr>
								<tr>
									<td>Detalle
									</td>	
									<td colspan="3"><input id="detalleProductoNw" autocomplete="off" type="text" 
											   			   class="form-control" style="width: 100%; height: 22px; text-transform: uppercase;" 
											    		   onkeypress="return soloNumerosLetras(event)"/>
									</td>	
								</tr>								
								<tr>
									<td>Fabricante
									</td>	
									<td colspan="3"><select id="idFabricanteNw" style="width: 100%;"></select>
									</td>
								</tr>
								<tr>
									<td>Presentación
									</td>	
									<td colspan="3"><select id="idPresentacionNw" style="width: 100%;"></select>
									</td>	
								</tr>
								<tr>
									<td>Graba IVA
									</td>	
									<td><input type="checkbox" id="chkGIVA" checked data-toggle="toggle" data-on="SI" data-off="NO" data-size="mini">
									</td>
									<td style="width: 120px;">Venta sin stock
									</td>	
									<td><input type="checkbox" id="chkVSS" checked data-toggle="toggle" data-on="SI" data-off="NO" data-size="mini">
									</td>
								</tr>
								<tr>
									<td>Precio costo
									</td>	
									<td><input id="precioCostoNw" name="precioCostoNw" autocomplete="off" type="text" class="form-control"
											   style="width: 100%; height: 22px; text-align: right;" onChange="formatearCampo(this)"
											   maxlength="10" onkeypress='return filterFloat(event,this);'/>
									</td>
									<td>% mínimo gan.
									</td>	
									<td><input id="porcentajeGanMinNw" name="porcentajeGanMinNw" autocomplete="off" type="text" class="form-control"
											   style="width: 100%; height: 22px; text-align: right;" onChange="formatearCampo(this)"
											   maxlength="5" onkeypress='return filterFloat(event,this);'/>
									</td>	
								</tr>
							</table>	
						</div>	
					</div>
					
				</div>

			   <div class="modal-footer"> <!-- PIE -->
				   	<button class="btn btn-default btn btn-primary btn-lg" type="button" data-dismiss="modal" 
							onClick="guardarNuevoProducto();">Guardar </button>
				   
					<button class="btn btn-default btn btn-danger btn-lg" type="button" data-dismiss="modal" 
							onClick="cerrarProducto();">Cancelar </button>
			   </div>
			</div>
		</div>
	</div>
	
  </form>
	
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui-forms.js"></script>
  <script type="text/javascript" src="../js/bootstrap-toggle.min.js"></script>
  <script type="text/javascript" src="../js/componentes.js"></script>
	
<script>
	var indx = 0;
	var url = '../../lib/cmb/cmbTivItemsVentaAutoComplete.php';
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
				document.getElementById('idTipoProducto').value = ui.item[6];
				document.getElementById('descripcionProducto').value = ui.item[7];
				document.getElementById('idGrabaIVA').value = ui.item[8];
				document.getElementById('idVentaSinStock').value = ui.item[9];
			});
				
		}
	});
	
	
	var url = '../../lib/cmb/cmbTcuClientesAutoComplete.php';
	document.getElementById('idCliente').value = '';
	document.getElementById('cliente').value = '';
	$.ajax({
		type:'POST',
		url:url,
		data:'id=1',
		success:function(data){
			$( "#cliente" ).autocomplete({
			  source: eval(data)
			});
			$( "#cliente" ).on( "autocompleteselect", function( event, ui ) {
				document.getElementById('idCliente').value = ui.item[0];
				document.getElementById('identificacion').value = ui.item[2];
				document.getElementById('cliente').value = ui.item[3];
				document.getElementById('direccion').value = ui.item[4];
				document.getElementById('telefono').value = ui.item[5];
				document.getElementById('email').value = ui.item[6];
				document.getElementById('idTipoCliente').value = ui.item[7];
				document.getElementById('idCategoriaCliente').value = ui.item[8];
				document.getElementById('idPorcentajeCategoria').value = ui.item[9];
			});
				
		}
	});
	/*Nuevo Producto*/
	$(".new-row").click(function(){
		registraNuevoProducto();
	});
	
	/*Añadir Fila*/
	$(".add-row").click(function(){
	  if($("#identificacion").val() != ''){ 	
		if ($("#idItem").val() != ''){
			var id = $("#idItem").val();
			var name = $("#item").val();
			var costP = $("#costoPromedio").val();
			var costII = parseFloat($("#costoIdeal").val());
			var costI = parseFloat($("#costoIdeal").val())*(1+(parseFloat(document.getElementById('idPorcentajeCategoria').value)/100));
			var descp = $("#descripcionProducto").val();
			var ivaMarca = $("#idGrabaIVA").val();
			//console.log(ivaMarca)
			
			indx ++;
			var idMov = zeroPad(indx,4);
			var res = String.fromCharCode(34);
			
			var markup = "<tr style='color: #000; border-bottom: 1px solid #ddd;' name='TR"+idMov+"'>"+
			                "<td style='text-align: right;'>"+idMov+"</td>"+
							"<td style='display: none;'>" + id + "</td>"+
							"<td style='padding-left: 10px;'>" + descp + "</td>"+
							"<td style='text-align: right;'>" + costP + "</td>"+
							"<td style='text-align: right;'>" + costII.toFixed(4) + "</td>"+
							"<td><input id='costoMovimiento"+idMov+"' name='costoMovimiento"+idMov+"' class='required' "+
								"onChange='calcularValores(this,"+costII+")' type='text' style='text-align: right; width: 100%; height: 25px;' "+
								"value='"+costI.toFixed(4)+"' onkeypress='return filterFloat(event,this);' /></td>"+
							"<td><input id='Cantidad"+idMov+"' name='Cantidad"+idMov+"' class='required' onChange='calcularValores(this)' "+
								"type='text' style='text-align: right; width: 100%; height: 25px;' value='0.00' autocomplete='off' "+
								"onkeypress='return filterFloat(event,this);' ondblclick='limpiarValor(this)'/></td>"+
							"<td><input onFocus='this.blur()' id='totalMovimiento"+idMov+"' name='totalMovimiento"+idMov+"' "+
								"class='required' type='text' style='text-align: right; width: 100%; height: 25px;' value='0.00' "+
								"onkeypress='return filterFloat(event,this);'/></td>"+
							"<td style='width: 26px'>"+
								"<button type='button' style='width: 100%;' class='delete-row' onClick='EliminarFila(this);'>"+
									"<img src='../images/icons/clear.png' style='height: 18px;' alt=''/>"+
								"</button></td>"+
							"<td style='display: none;' id='idRetencionProducto"+idMov+"'></td>"+
							"<td style='display: none;' id='idRetencionProductoI"+idMov+"'></td>"+
							"<td style='display: none;' id='idRetencionProductoR"+idMov+"'></td>"+
							"<td style='display: none;' id='idGrabaIVA"+idMov+"'>"+ivaMarca+"</td></tr>";
			
			//registraRetencion("idRetencionProducto"+idMov,"idRetencionProductoI"+idMov,"idRetencionProductoR"+idMov);
			
			$("#tableMovimientos").append(markup);
			$("#idItem").val('');
			$("#item").val('');
			$("#costoPromedio").val('');
			$("#costoIdeal").val('');
			$("#descripcionProducto").val('');
			$("#idGrabaIVA").val('');
		}else{parent. modalAlertPrincipal(2, 'MarketSys', 'Para proceder con la opción de agregar un producto, '+
										  				  'seleccione un producto de la lista, si su producto no se encuentra registrado, '+
										  				  'puede crear uno nuevo.', 0, 'Aceptar', '');}
		}else{parent. modalAlertPrincipal(2, 'MarketSys', 'Para proceder con la opción de agregar un producto, '+
										  				  'seleccione un cliente, si el cliente no se encuentra registrado, '+
										  				  'puede crear uno nuevo.', 0, 'Aceptar', '');
			 }
	});
	
	
	$(".clear-search").click(function(){
		$("#idItem").val('');
		$("#item").val('');
		$("#costoPromedio").val('');
		$("#costoIdeal").val('');
	});
	
	function limpiarValor(item){
		item.value = '';
		item.focus();
	}
	
	
	function retornaParametros(){
		$.ajax({type:'POST',
				url:'../php/parametrosVenta.php',
				success:function(data){
						data = eval(data);
							parent.document.getElementById('divLoadding').style.display = 'none';
							//console.log(data)
							document.getElementById('porcentajeIVA').value = data[0];
							document.getElementById('iVAPorcentaje').innerHTML = data[0];
						}
			   });
	}
	
	function registraRetencion(id,idValorRenta, idValorIVA){
		//console.log(id+' * '+idValorRenta+' * '+idValorIVA);
		idCliente 	= document.getElementById('idTipoCliente').value;
		idProducto 	= document.getElementById('idTipoProducto').value;
		$.ajax({type:'POST',
				url:'../php/retornaRetencionesProductos.php',
				data:'idCliente='+idCliente+'&idProducto='+idProducto,
				success:function(data){
						data = eval(data);
							//console.log(data)
							document.getElementById(id).innerHTML = data[0];
							document.getElementById(idValorRenta).innerHTML = data[1];
							document.getElementById(idValorIVA).innerHTML = data[2];
						}
			   });
		
	}	
		
	function EliminarFila (r){
		var i = r.parentNode.parentNode.rowIndex;
		var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
		var ValTemp = document.getElementById("txtSubtotalVenta").innerHTML;
		var TotRedu = document.getElementById("totalMovimiento"+id).value;
		    ValTemp = ValTemp - TotRedu;
			var n = parseFloat(ValTemp).toFixed(6);
			document.getElementById("txtSubtotalVenta").innerHTML = n;
		document.getElementById("tableMovimientos").deleteRow(i);
		calculaRetenciones();
	}
	
	function zeroPad(num, places) {
	  var zero = places - num.toString().length + 1;
	  return Array(+(zero > 0 && zero)).join("0") + num;
	}
	
	function calcularValores(r,v){
		if (r.value < v){r.value = v;}
		var i = r.parentNode.parentNode.rowIndex;
		var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
		var ValTemp = document.getElementById("txtSubtotalVenta").innerHTML;
		var TotRedu = document.getElementById("totalMovimiento"+id).value;
		var CantMov = document.getElementById("Cantidad"+id).value;
		var CostMov = document.getElementById("costoMovimiento"+id).value;
		
		var NuevTot = CantMov * CostMov;
		    ValTemp = ValTemp - TotRedu;
			ValTemp = ValTemp + NuevTot;
			var n1 = parseFloat(CantMov).toFixed(2);
			document.getElementById("Cantidad"+id).value = n1;
			var n2 = parseFloat(CostMov).toFixed(4);
			document.getElementById("costoMovimiento"+id).value = n2;
			var n3 = parseFloat(NuevTot).toFixed(2);
			document.getElementById("totalMovimiento"+id).value = n3;
			var n4 = parseFloat(ValTemp);
			document.getElementById("txtSubtotalVenta").innerHTML = n4.toFixed(2);
			
		calculaRetenciones();		
	}
	
	function calculaRetenciones(){
		var tableReg = document.getElementById('tableMovimientos');
			var retencion = [];
		    var tablaRetencion = [];
		    var j = 0;
		    var iva0 = 0;
		    var iva12 = 0;
		    var vIVA = 0;
			for (var i = 1; i < tableReg.rows.length-1; i++){
				 var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
				 
				if (document.getElementById("tableMovimientos").rows[i].cells[12].innerHTML == 0){
					 iva0 = iva0 + parseFloat(document.getElementById("totalMovimiento"+id).value);
					 vIVA = 0;
				     }else{iva12 = iva12 + parseFloat(document.getElementById("totalMovimiento"+id).value);
						   vIVA = document.getElementById('iVAPorcentaje').innerHTML;}
				 }
				
				n1 = iva0;
		        n1 = n1.toFixed(2);
			    document.getElementById("txtVTotalIVA0").innerHTML = n1;
					document.getElementById("txtTotalIVA0").innerHTML = '0.00';
				n1 = iva12;
		        n1 = n1.toFixed(2);
				document.getElementById("txtVTotalIVA12").innerHTML = n1;
					n1 = parseFloat(document.getElementById("txtVTotalIVA12").innerHTML)*vIVA/100;
		        	n1 = n1.toFixed(2);
					document.getElementById("txtTotalIVA12").innerHTML = n1;
				
				n1 = parseFloat(document.getElementById("txtTotalIVA12").innerHTML) + 	
					 parseFloat(document.getElementById("txtSubtotalVenta").innerHTML);
		        n1 = n1.toFixed(2);
				document.getElementById("txtTotalVenta").innerHTML = n1;

	}
	
	function registraProforma(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		
		if (document.getElementById("idCliente").value == ''){
			parent. modalAlertPrincipal(2, 'MarketSys', 'Para proceder con la generación de la proforma es necesario, '+
										                'que se seleccione un cliente, si el cliente no se encuentra registrado, '+
														'proceda a crear uno nuevo.', 0, 'Aceptar', '')
			parent.document.getElementById('divLoadding').style.display = 'none';
			return 0;
		    }else{
			var tableReg = document.getElementById('tableMovimientos');
			var inicio = 0;
			var d = new Date();
				var idCliente 		 = document.getElementById('idCliente').value;
				var descripcion 	 = document.getElementById('descripcion').value;
				var txtSubtotalVenta = document.getElementById('txtSubtotalVenta').innerHTML;
				var txtVTotalIVA0 	 = document.getElementById('txtVTotalIVA0').innerHTML;
				var iVAPorcentaje 	 = document.getElementById('iVAPorcentaje').innerHTML;
				var txtVTotalIVA12 	 = document.getElementById('txtVTotalIVA12').innerHTML;
				var txtTotalIVA12 	 = document.getElementById('txtTotalIVA12').innerHTML;
				var txtTotalVenta 	 = document.getElementById('txtTotalVenta').innerHTML;	
			idProforma = 0;
			$.ajax({type:'POST',
					url:'../php/registroProforma.php',
					data:'idCliente='+idCliente+'&descripcion='+descripcion+'&txtSubtotalVenta='+txtSubtotalVenta+'&txtVTotalIVA0='+txtVTotalIVA0+
					      '&iVAPorcentaje='+iVAPorcentaje+'&txtVTotalIVA12='+txtVTotalIVA12+'&txtTotalIVA12='+txtTotalIVA12+
						  '&txtTotalVenta='+txtTotalVenta,
					success:function(data){
						info = eval(data);
						idProforma = info[0];
						for (var i = 1; i < tableReg.rows.length-1; i++)
							{cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
							 // Recorremos todas las celdas

							 if (i == 1){inicio = 1; d = d.getTime();}else{inicio = 0;}
							     var idMovi = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
							     var idItem = document.getElementById("tableMovimientos").rows[i].cells[1].innerHTML;
							     var dsItem = document.getElementById("tableMovimientos").rows[i].cells[2].innerHTML;
							     var stockA = document.getElementById("tableMovimientos").rows[i].cells[3].innerHTML;
							     var costoA = document.getElementById("tableMovimientos").rows[i].cells[4].innerHTML;
							     var cantiM = document.getElementById("Cantidad"+idMovi).value;	
							     var costoM = document.getElementById("costoMovimiento"+idMovi).value;
							     var totalM = document.getElementById("totalMovimiento"+idMovi).value;
								
							 		$.ajax({type:'POST',
											url:'../php/registroDetalleProforma.php',
											data:'idProforma='+idProforma+'&idMovi='+idMovi+'&idItem='+idItem+'&dsItem='+dsItem+
											      '&stockA='+stockA+'&costoA='+costoA+'&cantiM='+cantiM+'&costoM='+costoM+
												  '&totalM='+totalM,
											success:function(data){}
											});	
							}
						
						parent. modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', 
									   'Su propuesta ha sido registrada de manera correcta.', 0, 
									   'Aceptar', '');
		
						location.reload()
						setTimeout(transaccionCorrecta(idProforma), 6000);
					
					}
				});	
				
				

		}
	}
	
	function transaccionCorrecta(idProforma){
		window.open('../reports/proformaPDF.php?idproforma='+idProforma);
	}
	
	function registraNuevoCliente(){
		var cmbTiposClientes = new componente.cmb; 
			cmbTiposClientes.ini('tiposClientesNw');
			cmbTiposClientes.loadFromUrl('../cmb/cmbTiposClientes.php');
		
		var cmbCategoriasClientes = new componente.cmb; 
			cmbCategoriasClientes.ini('categoriasClientesNw');
			cmbCategoriasClientes.loadFromUrlAd('../cmb/cmbCategoriasClientes.php');
		
		var cmbTiposIdentificacion = new componente.cmb; 
			cmbTiposIdentificacion.ini('tiposIdentificacionNw');
			cmbTiposIdentificacion.loadFromUrl('../cmb/cmbTiposIdentificacion.php');
		
		document.getElementById("tiposClientesNw").value 		= 0;
		document.getElementById("categoriasClientesNw").value 	= 0;
		document.getElementById("tiposIdentificacionNw").value 	= 0;
		document.getElementById("numeroIdentificacionNw").value = '';
		document.getElementById("nombreClienteNw").value 		= '';	
		document.getElementById("direccionNw").value 			= '';
		document.getElementById("telefonoNw").value 			= '';
		document.getElementById("EmailNw").value 				= '';
		document.getElementById("modalClienteDiv").style.display = 'block';
	} 
	
	function cerrarCliente(){
		document.getElementById("modalClienteDiv").style.display = 'none';
	}
	
	function registraNuevoProducto(){
		var cmbTipoProductos = new componente.cmb; 
			cmbTipoProductos.ini('tiposProductosNw');
			cmbTipoProductos.loadFromUrl('../cmb/cmbTivCategoriasProductos.php');
			cmbTipoProductos.setChangeFunction(dataProvincias)

			var cmbProductos = new componente.cmb; 
				cmbProductos.ini('productosNw');		
				function dataProvincias(){
					cmbProductos.clear();
					cmbProductos.loadFromUrlAd('../cmb/cmbTivProductos.php',{id:cmbTipoProductos.getSelectedValue()});
					
				}
				
		var cmbFabricantes = new componente.cmb; 
			cmbFabricantes.ini('idFabricanteNw');
			cmbFabricantes.loadFromUrl('../cmb/cmbTivFabricantes.php');
		
		var cmbPresentaciones = new componente.cmb; 
			cmbPresentaciones.ini('idPresentacionNw');
			cmbPresentaciones.loadFromUrl('../cmb/cmbTivPresentaciones.php');
		
		document.getElementById("tiposProductosNw").value	= 0;
		document.getElementById("productosNw").value		= 0;
		document.getElementById("descripcionNw").value		= '';
		document.getElementById("codigoBarraNw").value		= '';
		document.getElementById("detalleProductoNw").value	= '';	
		document.getElementById("idFabricanteNw").value		= 0;
		document.getElementById("idPresentacionNw").value	= 0;
		document.getElementById("chkGIVA").checked			= true;
		document.getElementById("chkVSS").checked			= true;
		document.getElementById("precioCostoNw").value		= '';
		document.getElementById("porcentajeGanMinNw").value	= '';
		document.getElementById("modalProductoDiv").style.display = 'block';
	}
	
	function cerrarProducto(){
		document.getElementById("modalProductoDiv").style.display = 'none';
	}
	
	function resultadoMovimiento(e){
		
	}
	
	function guardarNuevoProducto(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var tipoProducto  = document.getElementById("tiposProductosNw").value;
		var producto 	  = document.getElementById("productosNw").value;
		var descripcion   = document.getElementById("descripcionNw").value;
		var codigoBarra   = document.getElementById("codigoBarraNw").value;
		var detalleProd   = document.getElementById("detalleProductoNw").value;	
		var idFabricante  = document.getElementById("idFabricanteNw").value;
		var idPresentacion= document.getElementById("idPresentacionNw").value;
		var chkGrabaIVA   = document.getElementById("chkGIVA").checked;
		var chkVentaSStock= document.getElementById("chkVSS").checked;
		var precioCosto   = document.getElementById("precioCostoNw").value;
		var porcentajeMin = document.getElementById("porcentajeGanMinNw").value;
		
		$.ajax({type:'POST',
				url:'../php/registraProductoNuevo.php',
				data:'tipoProducto='+tipoProducto+'&producto='+producto+'&descripcion='+descripcion+'&codigoBarra='+codigoBarra+
					 '&detalleProd='+detalleProd+'&idFabricante='+idFabricante+'&idPresentacion='+idPresentacion+'&chkGrabaIVA='+chkGrabaIVA+
					 '&chkVentaSStock='+chkVentaSStock+'&precioCosto='+precioCosto+'&porcentajeMin='+porcentajeMin,
				success:function(data){
					data = eval(data);
					if (data[0] == 0){
					    parent. modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', 
												   	   'Se ha registrado correctamente el producto.', 0, 
												   	   'Aceptar', '');
						
						document.getElementById("tiposProductosNw").value	= 0;
						document.getElementById("productosNw").value		= 0;
						document.getElementById("descripcionNw").value		= '';
						document.getElementById("codigoBarraNw").value		= '';
						document.getElementById("detalleProductoNw").value	= '';	
						document.getElementById("idFabricanteNw").value		= 0;
						document.getElementById("idPresentacionNw").value	= 0;
						document.getElementById("chkGIVA").checked			= true;
						document.getElementById("chkVSS").checked			= true;
						document.getElementById("precioCostoNw").value		= '';
						document.getElementById("porcentajeGanMinNw").value	= '';
						
						var url = '../../lib/cmb/cmbTivItemsVentaAutoComplete.php';
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
									document.getElementById('idTipoProducto').value = ui.item[6];
									document.getElementById('descripcionProducto').value = ui.item[7];
									document.getElementById('idGrabaIVA').value = ui.item[8];
									document.getElementById('idVentaSinStock').value = ui.item[9];
								});

							}
						});
						
					}else{
						parent. modalAlertPrincipal(1, 'MarketSys [Información Registrada]', 
												   	   'El producto se encuentra registrado en el sistema', 0, 
												   	   'Aceptar', '');
						
						document.getElementById("tiposProductosNw").value	= 0;
						document.getElementById("productosNw").value		= 0;
						document.getElementById("descripcionNw").value		= '';
						document.getElementById("codigoBarraNw").value		= '';
						document.getElementById("detalleProductoNw").value	= '';	
						document.getElementById("idFabricanteNw").value		= 0;
						document.getElementById("idPresentacionNw").value	= 0;
						document.getElementById("chkGIVA").checked			= true;
						document.getElementById("chkVSS").checked			= true;
						document.getElementById("precioCostoNw").value		= '';
						document.getElementById("porcentajeGanMinNw").value	= '';
					}
					parent.document.getElementById('divLoadding').style.display = 'none';
					document.getElementById("modalProductoDiv").style.display = 'none';
				}
			});
	}
	
	function guardarNuevoCliente(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var tipoCliente  = document.getElementById("tiposClientesNw").value;
		var categCliente = document.getElementById("categoriasClientesNw").value;
		var tipoIdentCli = document.getElementById("tiposIdentificacionNw").value;
		var numIdentific = document.getElementById("numeroIdentificacionNw").value;
		var nombreClient = document.getElementById("nombreClienteNw").value;	
		var direccionCli = document.getElementById("direccionNw").value;
		var telefonoClie = document.getElementById("telefonoNw").value;
		var emailCliente = document.getElementById("EmailNw").value;
		
		$.ajax({type:'POST',
				url:'../php/registraClienteNuevo.php',
				data:'tipoCliente='+tipoCliente+'&categCliente='+categCliente+'&tipoIdentCli='+tipoIdentCli+'&numIdentific='+numIdentific+
				'&nombreClient='+nombreClient+'&direccionCli='+direccionCli+'&telefonoClie='+telefonoClie+'&emailCliente='+emailCliente,
				success:function(data){
					data = eval(data);
					if (data[0] == 0){
					    parent. modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', 
												   	   'Se ha registrado correctamente el cliente.', 0, 
												   	   'Aceptar', '');
						document.getElementById('idCliente').value 		= data[1];
						document.getElementById('identificacion').value = numIdentific.toUpperCase();
						document.getElementById('cliente').value 		= nombreClient.toUpperCase();
						document.getElementById('direccion').value 		= direccionCli.toUpperCase();
						document.getElementById('telefono').value 		= telefonoClie.toUpperCase();
						document.getElementById('email').value 			= emailCliente.toUpperCase();
						document.getElementById('idTipoCliente').value 	= tipoCliente.toUpperCase();
						document.getElementById('idCategoriaCliente').value = categCliente.toUpperCase();
						
						document.getElementById("tiposClientesNw").value 		= 0;
						document.getElementById("categoriasClientesNw").value 	= 0;
						document.getElementById("tiposIdentificacionNw").value 	= 0;
						document.getElementById("numeroIdentificacionNw").value = '';
						document.getElementById("nombreClienteNw").value 		= '';	
						document.getElementById("direccionNw").value 			= '';
						document.getElementById("telefonoNw").value 			= '';
						document.getElementById("EmailNw").value 				= '';
						
						
					}else{
						parent. modalAlertPrincipal(1, 'MarketSys [Información Registrada]', 
												   	   'El cliente identificado se encuentra registrado en el sistema', 0, 
												   	   'Aceptar', '');
						document.getElementById("tiposClientesNw").value 		= 0;
						document.getElementById("categoriasClientesNw").value 	= 0;
						document.getElementById("tiposIdentificacionNw").value 	= 0;
						document.getElementById("numeroIdentificacionNw").value = '';
						document.getElementById("nombreClienteNw").value 		= '';	
						document.getElementById("direccionNw").value 			= '';
						document.getElementById("telefonoNw").value 			= '';
						document.getElementById("EmailNw").value 				= '';
					}
					
					parent.document.getElementById('divLoadding').style.display = 'none';
					document.getElementById("modalClienteDiv").style.display = 'none';
				}
			   });
	}
	
	function formatearCampo(item){
		var num = item.value;
			num = parseFloat(num);
			item.value = num.toFixed(2);
	}
	
	function valideKey(evt){
    var code = (evt.which) ? evt.which : evt.keyCode;
    //backspace
	if(code==8){return true;}
       else if(code>=48 && code<=57) {
            //is a number
            return true;
                   }else{return false;}
  	}
	
	function filterFloat(evt,input){
		// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
		var key = window.Event ? evt.which : evt.keyCode;    
		var chark = String.fromCharCode(key);
		var tempValue = input.value+chark;
		if(key >= 48 && key <= 57){
			if(filter(tempValue)=== false){
				return false;
			}else{       
				return true;
			}
		}else{
			  if(key == 8 || key == 13 || key == 0) {     
				  return true;              
			  }else if(key == 46){
					if(filter(tempValue)=== false){
						return false;
					}else{       
						return true;
					}
			  }else{
				  return false;
			  }
		}
	}
	function filter(__val__){
		var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
		if(preg.test(__val__) === true){
			return true;
		}else{
		   return false;
		}

	}
	
	function soloLetras(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
		especiales = [8, 37, 39, 46];

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