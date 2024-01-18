<?php include "../php/sesionSecurityForms.php"; ?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Facturas</title>
  
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">	
  <link rel="stylesheet" type="text/css" href="../css/styleCajas.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-toggle.min.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>	
</head>
<body bgcolor="#fff" style="left: 0px; width: 100%" onLoad="retornaParametros()">
<form id="frm_clientes" method="post" enctype="multipart/form-data"> 
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="5" class="estilo3">
							FACTURA
							<input id="porcentajeIVA" name="porcentajeIVA" type="text" style="display: none;"/>
							<span id="idValorRenta" name="idValorRenta" style="display: none;">0.00</span>
							<span id="idValorIVA" name="idValorIVA" style="display: none;">0.00</span>
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 140px; padding-top: 5px;">
							Cliente:
					    </td>
						<td style="width: 100px;">
							<input onFocus="this.blur()" id="idCliente" name="idCliente" type="text" style="width: 99%; height: 18px;"/>
						</td>
						<td class="clsObjetosTable" colspan="2" style="width: calc(100% - 480px);">
							<input id="cliente" name="cliente" class="required" type="text" style="width: 100%; height: 18px;"/>
							<input id="idTipoCliente" name="idTipoCliente" type="text" style="display: none;"/>
							<input id="idCategoriaCliente" name="idCategoriaCliente" type="text" style="display: none;"/>
							<input id="idPorcentajeCategoria" name="idPorcentajeCategoria" type="text" style="display: none;"/>
						</td>	
						<td style="width: 260px;" rowspan="4">
							<table style="width: 100%;">
							   <tr>
							     <td  style="padding-left: 5px;">
									<button type="button" id="btn_guardar" style="width: 80px; line-height : 14px;" 
											onClick="registraNuevoCliente();">
											<img src="../images/icons/cliente.png" style="width: 45px" alt=""/><br><b>Nuevo Cliente</b>
									 </button>
								 </td>
								 <td style="padding-left: 5px;">
								    <button type="button" id="btn_guardar" style="width: 80px; line-height : 14px;" onClick="registraFactura();">
										<img src="../images/icons/guardar.png" style="width: 45px" alt=""/><br><b>Registra Factura</b>
									 </button>
								 </td>
								 <td  style="padding-left: 5px;">
									<table style="width: 100px; margin-top: 3px">
										<tr style="height: 61px;">
											<td style="padding: 10px; background-color: khaki; text-align: right; ">
												<span id="saldoDeudaCliente" style="font-size: 20px;font-weight: 800;color: red;">0.00</span>
											</td>	
										</tr>
										<tr>
											<td style="text-align: center; font-weight: 700; ">
												<span id="vencimiento" style="font-size: 12px;">-</span>
											</td>	
										</tr>
									</table>	
								 </td>  
								</tr> 
							</table>	
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Identificación:
					    </td>
						<td>
							<input onFocus="this.blur()" id="identificacion" name="identificacion" type="text" 
								   style="width: 99%; height: 18px; font-size: 12px;"/>
						</td>
						<td class="clsEtiquetasTable" style="width: 140px;">
							Dirección:
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="direccion" name="direccion" type="text" style="width: 100%; height: 18px;"/>
						</td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Télefono:
					    </td>
						<td>
							<input onFocus="this.blur()" id="telefono" name="telefono" type="text" 
								   style="width: 99%; height: 18px; font-size: 12px;"/>
						</td>
						<td class="clsEtiquetasTable">
							Correo Electrónico:
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="email" name="email" class="required" type="text" style="width: 100%; height: 18px;"/>
						</td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Forma de pago:
					    </td>
						<td colspan="2" style="padding-bottom: 5px; padding-top: 2px; width: 240px;">
							<select id="formasPagoFactura" style="width: 100%; font-size: 12px;"></select>
						</td>
						<td class="clsEtiquetasTable" style="width: calc(100% - 400px);">
							<table style="width: 100%">
								<tr>
									<td style="width: 100px;" >
										Fecha Factura:
									</td>
									<td>
										<input id="fechaFactura" type="text" autocomplete="off" value="<?php echo date('d/m/Y')?>"
								   			   style="width: 98%; height: 18px; font-size: 12px; text-align: right"/>
									</td>
									<td style="width: 140px;" >
										Número de Proforma:
									</td>
									<td>
										<input id="idProforma" type="text" autocomplete="off"
								   			   style="width: 98%; height: 18px; font-size: 12px; text-align: right"/>
									</td>
									<td>
										<button type="button" class="proforma" style="width: 100%; height: 18px; padding: 0px;">
											<img src="../images/icons/procesarProforma.png" height="12px" alt=""/>
										</button>
									</td>
								</tr>	
							</table>	
					    </td>
					</tr>	
					<tr>
						<td colspan="5" class="estilo3">
							BÚSQUEDA DE ÍTEM
						</td>
					</tr>
					<tr>
						<td colspan="5" style="padding-left: 15px;">
							<table style="width: 100%;">
							   <tr>
									<td style="width: 80px; padding-top: 5px; padding-bottom: 5px;">
										<input onFocus="this.blur()" id="idItem" name="idItem" type="text" style="width: 95%; height: 26px;"/>
										<input id="costoPromedio" name="costoPromedio" type="text" style="display: none;"/>
										<input id="costoIdeal" name="costoIdeal" type="text" style="display: none;"/>
										<input id="descripcionProducto" name="descripcionProducto" type="text" style="display: none;"/>
										<input id="idTipoProducto" name="idTipoProducto" type="text" style="display: none;"/>
										<input id="idGrabaIVA" name="idGrabaIVA" type="text" style="display: none;"/>
										<input id="idVentaSinStock" type="text" style="display: none;"/>
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
						<td colspan="5" class="estilo3">
							DETALLE DE LA FACTURA
						</td>
					</tr>
					<tr>
						<td colspan="5" style="vertical-align: top;">
							<table style="width: 100%; vertical-align: top;">
								<tr>
									<td style="width: calc(100% - 210px); vertical-align: top;">
										<table id="tableMovimientos" id="tableMovimientos" 
											   style="width: 100%;  background-color: #4BA6C0; font-size: 12px;">
											<thead>
												<tr class="tablaAperturaHead">
													<td style="width: 8%;">N°</td>
													<td style="width: 26%; border-left: 1px solid white;" colspan="2">Ítem</td>
													<td style="width: 9%; border-left: 1px solid white;">Stock</td>
													<td style="width: 9%; border-left: 1px solid white;">Costo</td>
													<td style="width: 9%; border-left: 1px solid white;">Promoción</td>
													<td style="width: 9%; border-left: 1px solid white;">Descuento</td>
													<td style="width: 9%; border-left: 1px solid white;">P.V.P.</td>
													<td style="width: 9%; border-left: 1px solid white;">Cantidad</td>
													<td style="width: 12%; border-left: 1px solid white;" colspan="2">Total</td>
												</tr>
											</thead>
											<tbody bgcolor="#fff">	
											</tbody>		
											<tfoot>	
												<tr class="tablaAperturaFood">
													<td colspan="7" bgcolor="#fff" style="border-top: 2px solid #4ea8c1;">	
													</td>
													<td colspan="4">
														<table style="width: 100%">
															<tr>
																<td style="text-align: left; padding-left: 5px;">SUBTOTAL</td>
																<td></td>
																<td style="text-align: right; width: 100px;">
																	<span id="txtSubtotalVenta" name="txtSubtotalVenta">0.00</span>
																</td>	
																<td style="text-align: right;">
																	<img src="../images/botones/creditCard.png" style="width: 35px" alt=""/>
																</td>
															</tr>
															<tr>
																<td style="text-align: left; padding-left: 5px;">IVA 0.00%</td>
																<td><span id="txtVTotalIVA0" name="txtVTotalIVA0">0.00</span></td>
																<td style="text-align: right; width: 100px;">
																	<span id="txtTotalIVA0" name="txtTotalIVA0">0.00</span>
																</td>
																<td style="text-align: right; width: 50px;">
																	<span id="txtSumaTotalIVA0" name="txtSumaTotalIVA0">0.00</span>
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
																<td style="text-align: right; width: 50px;">
																	<span id="txtSumaTotalIVA12" name="txtSumaTotalIVA12">0.00</span>
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
												</tr>
											</tfoot>		
										</table>
									</td>
									<td style="vertical-align: top; width: 210px;">
										<table style="width: 210px; margin-left: 2px;" class="estilo3">
											<tr>
												<td style="width: 175px; background-color: #DC7633;">
													Retenciones
												</td>
												<td>
													<input id="chkRetenciones" type="checkbox" data-toggle="toggle" 
														   data-on="SI" data-off="NO" data-size="mini">
												</td>
											</tr>
											<tr>
												<td colspan="2" id="retencionDetalle" style="background-color: #fff;">
												</td>	
											</tr>	
										</table>	
									</td>
								</tr>
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
									<td><input id="numeroIdentificacionNw" name="numeroIdentificacionNw" autocomplete="off" 
											   type="text" class="form-control" style="width: 100%; height: 22px;" 
											   onkeypress="return soloNumeros(event);"
											   onblur="validarIdentificacion();"
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
											   style="width: 100%; height: 22px; text-transform: uppercase;" 
											   onkeypress="return soloNumerosLetras(event)"/>
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
									<td><input type="checkbox" id="chkGIVA" checked data-toggle="toggle" data-on="SI" 
											   data-off="NO" data-size="mini">
									</td>
									<td style="width: 120px;">Venta sin stock
									</td>	
									<td><input type="checkbox" id="chkVSS" checked data-toggle="toggle" data-on="SI" 
											   data-off="NO" data-size="mini">
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
	
	<div role="dialog" tabindex="-1" class="modal fade" id="modalObservacionDiv"
		style="padding-top: 140px; margin-right:auto;margin-left:auto; opacity: 1;">
		   <div class="modal-dialog" role="document">
			 <div class="modal-content">
			   <div class="modal-header" style="background-color: #CCD1D1"> <!-- CABECERA -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onClick="cerrarObservacion();">
						<span aria-hidden="true" style="color: red;"><b>X</b></span></button>
					<h4 class="text-left modal-title">Observación del ítem</h4>
			   </div>
			   
			    <div class="modal-body" style="height: 160px; padding-top: 0px;"> <!-- CUERPO DEL MENSAJE -->
				    <div class="row form-group">
						<div style="width: calc(100% - 70px); margin-left: 30px;" id="calificacionDiv">
							<table class="table" style="width: 100%;">
								<tr>
									<td>Descripción
									</td>	
									<td colspan="3"><textarea id="descripcionItemAd" autocomplete="off" type="text" 
													 	class="form-control" rows="7"
											   			style="width: 100%;"></textarea>
										<span id="descripcionItemId" style="display: none;"></span>
									</td>
								</tr>
							</table>	
						</div>	
					</div>
					
				</div>

			   <div class="modal-footer"> <!-- PIE -->
				   	<button class="btn btn-default btn btn-primary btn-lg" type="button" data-dismiss="modal" 
							onClick="guardarObservacion();">Guardar </button>
				   
					<button class="btn btn-default btn btn-danger btn-lg" type="button" data-dismiss="modal" 
							onClick="cerrarObservacion();">Cancelar </button>
			   </div>
			</div>
		</div>
	</div>
	
  </form>
	
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui-forms.js"></script>
  <script type="text/javascript" src="../js/jquery.datetimepicker.full.js"></script>
  <script type="text/javascript" src="../js/bootstrap-toggle.min.js"></script>
  <script type="text/javascript" src="../js/componentes.js"></script>
  <script type="text/javascript" src="../js/moment.js"></script>
  <script type="text/javascript" src="../js/fiddle.js"></script>
  <script type="text/javascript" src="../js/forge.min.js"></script>
  <script type="text/javascript" src="../js/buffer.js"></script>	
<script>
	$.datetimepicker.setLocale('es');
	$('#fechaFactura').datetimepicker({
		dayOfWeekStart : 1,
		timepicker:false,
		format:'d/m/Y',
		formatDate:'Y/m/d'
	});
	
	var cmbFormasPago = new componente.cmb; 
		cmbFormasPago.ini('formasPagoFactura');
		cmbFormasPago.loadFromUrlAd('../cmb/cmbTscFormasPago.php');
	
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
				
				if (ui.item[10] > 0){
					document.getElementById('saldoDeudaCliente').innerHTML = ui.item[10];
					document.getElementById('vencimiento').innerHTML = ui.item[11];
				    }else{document.getElementById('saldoDeudaCliente').innerHTML = '0.00';
						  document.getElementById('vencimiento').innerHTML = '-';}
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
			var costP = parseFloat($("#costoPromedio").val());
			var costII = parseFloat($("#costoIdeal").val());
			    //costII = costII.toFixed(2);
			var costI = parseFloat($("#costoIdeal").val())*(1+(parseFloat(document.getElementById('idPorcentajeCategoria').value)/100));
			var descp = $("#descripcionProducto").val();
			var ivaMarca = $("#idGrabaIVA").val();
			var ventaSST = $("#idVentaSinStock").val();
			
			if (ventaSST == 0 && costP == 0){
				parent. modalAlertPrincipal(2, 'MarketSys', 'El producto seleccionado no se puede vender sin stock disponible, '+
										  				    'deberá seleccionar otro producto para poder continuar.', 0, 'Aceptar', '');
				return 0;
				} 
			
			indx ++;
			var idMov = zeroPad(indx,4);
			var res = String.fromCharCode(34);
			
			var descripcionProm = '';
			var cantidadPromocion = 0;
			var porcentajePromocion = 0;
			var maxPromociones = 0;
			var idPromocion = 0;
			$.ajax({type:'POST',
					url:'../php/consultaParametrosPromociones.php',
					async: false,
					data:'id='+id,
					success:function(data){
									 if (data != '[]'){
										 data = eval(data);
										 maxPromociones		 = data[3];
										 descripcionProm 	 = data[0]+'(max '+maxPromociones+')';
										 cantidadPromocion 	 = data[1];
										 porcentajePromocion = data[2];
										 idPromocion		 = data[4]
									 	}
							}
				   });
					
			var markup = "<tr style='color: #000; border-bottom: 1px solid #ddd;' name='TR"+idMov+"'>"+
			                "<td style='text-align: right;'>"+idMov+"</td>"+
							"<td style='display: none;'>" + id + "</td>"+
							"<td style='padding-left: 10px;'>" + descp + "</td>"+
				            "<td style='padding-left: 10px;'>"+
				                "<span id='descripcion"+idMov+"' style='display: none;'>" + descp + "</span>"+
								"<button type='button' style='width: 100%;' onClick='observacionItem("+'"'+idMov+'"'+");'>"+
									"<img src='../images/icons/iconoObservacion.png' style='height: 18px;' alt=''/>"+
								"</button></td>"+    
							"<td style='text-align: right;'>" + costP.toFixed(2) + "</td>"+
							"<td style='text-align: right;'>" + costII.toFixed(2) + "</td>"+
				            "<td style='text-align: center;'>" + descripcionProm + "</td>"+
							"<td><input <?php if($_SESSION["spUs"]!=1){echo " onFocus='this.blur()' ";} ?>"+
								"id='descuentoMovimiento"+idMov+"' name='descuentoMovimiento"+idMov+"' class='required' "+
								"onChange='calcularValores(this,"+costII+")' type='text' style='text-align: right; width: 100%; height: 25px;' "+
								"value='0.00' onkeypress='return filterFloat(event,this);' autocomplete='off' /></td>"+	
							"<td><input <?php if($_SESSION["spUs"]!=1){echo " onFocus='this.blur()' ";} ?>"+
								"id='costoMovimiento"+idMov+"' name='costoMovimiento"+idMov+"' class='required' "+
								"onChange='calcularValores(this,"+costII.toFixed(2)+")' style='text-align: right; width: 100%; height: 25px;' "+
								"value='"+costII.toFixed(2)+"' onkeypress='return filterFloat(event,this);' autocomplete='off' /></td>"+
							"<td><input id='Cantidad"+idMov+"' name='Cantidad"+idMov+"' onChange='calcularValores(this,"+costII+")' "+
								"type='text' style='text-align: right; width: 100%; height: 25px;' autocomplete='off' "+
								"onkeypress='return filterFloat(event,this);' ondblclick='limpiarValor(this)' value='1.00'/></td>"+
							"<td><input onFocus='this.blur()' id='totalMovimiento"+idMov+"' name='totalMovimiento"+idMov+"' "+
								"class='required' type='text' style='text-align: right; width: 100%; height: 25px;' value='"+costII.toFixed(2)+"' "+
								"onkeypress='return filterFloat(event,this);'/></td>"+
							"<td style='width: 26px'>"+
								"<button type='button' style='width: 100%;' class='delete-row' onClick='EliminarFila(this);'>"+
									"<img src='../images/icons/clear.png' style='height: 18px;' alt=''/>"+
								"</button></td>"+
							"<td style='display: none;' id='idRetencionProducto"+idMov+"'></td>"+
							"<td style='display: none;' id='idRetencionProductoI"+idMov+"'></td>"+
							"<td style='display: none;' id='idRetencionProductoR"+idMov+"'></td>"+
							"<td style='display: none;' id='idGrabaIVA"+idMov+"'>"+ivaMarca+"</td>"+
							"<td style='display: none;' id='cantidadPromocion"+idMov+"'>"+cantidadPromocion+"</td>"+
							"<td style='display: none;' id='maximoPromocion"+idMov+"'>"+maxPromociones+"</td>"+
							"<td style='display: none;' id='descuentoPromocion"+idMov+"'>"+porcentajePromocion+
							"<td style='display: none;' id='cantidadConPromocion"+idMov+"'>"+maxPromociones+"</td>"+
							"<td style='display: none;' id='cantidadSinPromocion"+idMov+"'>"+maxPromociones+"</td>"+
							"<td style='display: none;' id='promocionValor"+idMov+"'>"+porcentajePromocion+"</td>"+
							"<td style='display: none;' id='idPromocion"+idMov+"'>"+idPromocion+"</td>"+
							"<td style='display: none;' id='idVentaSinStock"+idMov+"'>"+ventaSST+"</td></tr>";
			
			registraRetencion("idRetencionProducto"+idMov,"idRetencionProductoI"+idMov,"idRetencionProductoR"+idMov);
			
			$("#tableMovimientos").append(markup);
			
			$("#idItem").val('');
			$("#item").val('');
			$("#costoPromedio").val('');
			$("#costoIdeal").val('');
			$("#descripcionProducto").val('');
			$("#idGrabaIVA").val('');
			$("#idVentaSinStock").val('');
			
			
			document.getElementById('Cantidad'+idMov).focus();
			//calculaTablaValoresTodos();
			
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
							calculaRetenciones();
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
	
	function calcularValores(r,val){
		var i = r.parentNode.parentNode.rowIndex;
		var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
		var promoDs = document.getElementById("tableMovimientos").rows[i].cells[6].innerHTML;
		var ValTemp = document.getElementById("txtSubtotalVenta").innerHTML;
		var TotRedu = document.getElementById("totalMovimiento"+id).value;
		var CantKrd = document.getElementById("tableMovimientos").rows[i].cells[4].innerHTML;
		var CantMov = document.getElementById("Cantidad"+id).value;
		var CostMov = document.getElementById("costoMovimiento"+id).value;
		var DescMov = document.getElementById("descuentoMovimiento"+id).value;
		if (CantMov == 0){CantMov = 1;}
			if (parseFloat(DescMov) > 5){
				DescMov = 5;
				document.getElementById("descuentoMovimiento"+id).value = 5;}
			if (DescMov == ''){
				DescMov = 0;
				document.getElementById("descuentoMovimiento"+id).value = '0.00';}
			if (document.getElementById("Cantidad"+id).value == ''){
				CantMov = 1;}
			if (document.getElementById("idVentaSinStock"+id).innerHTML == 0){
				if (parseInt(CantMov)>parseInt(CantKrd)){
					resta = parseInt(CantMov) - parseInt(CantKrd);
					parent. modalAlertPrincipal(1, 'MarketSys', 'El ítem seleccionado, no se puede vender sin existencia de Stock, '+
										               			'la diferencia que se indentifica en comparación es de <b>'+resta+
																'</b> unidades.<br>La cantidad se ajustará a lo disponible.', 0, 'Aceptar', '');
					CantMov = CantKrd;
				}
			}
			if (parseFloat(CostMov) < val || CostMov == ''){
				//console.log(document.getElementById("costoMovimiento"+id).value +' * '+ val + ' * ' + CostMov)
				CostMov = val;
				document.getElementById("costoMovimiento"+id).value = val;}

			/*if (document.getElementById("idVentaSinStock"+id).innerHTML){
				console.log(CantMov+' *** '+document.getElementById("tableMovimientos").rows[i].cells[3].innerHTML)
				}*/

			if (promoDs == ''){
				var NuevTot = CantMov * CostMov;
					NuevTot = parseFloat(NuevTot) - (parseFloat(NuevTot)*parseFloat(DescMov)/100)
					ValTemp = parseFloat(ValTemp) - parseFloat(TotRedu);
					ValTemp = parseFloat(ValTemp) + parseFloat(NuevTot);
					var n1 = parseFloat(CantMov).toFixed(2);
					document.getElementById("Cantidad"+id).value = n1;
					var n2 = parseFloat(CostMov).toFixed(2);
					document.getElementById("costoMovimiento"+id).value = n2;
					var n3 = parseFloat(NuevTot).toFixed(2);
					document.getElementById("totalMovimiento"+id).value = n3;
					var n4 = parseFloat(ValTemp).toFixed(2);
					document.getElementById("txtSubtotalVenta").innerHTML = n4;

					document.getElementById("promocionValor"+id).innerHTML = 0;
					document.getElementById("cantidadConPromocion"+id).innerHTML = 0;
					document.getElementById("cantidadSinPromocion"+id).innerHTML = CantMov;

			  }else{var cantMPro = document.getElementById("cantidadPromocion"+id).innerHTML;
					var maxProm = document.getElementById("maximoPromocion"+id).innerHTML;
					var descMPro = document.getElementById("descuentoPromocion"+id).innerHTML;
						document.getElementById("descuentoMovimiento"+id).value = '0.00';
					var cantAPro = CantMov/parseFloat(cantMPro);
						cantAPro = Math.trunc(cantAPro);
						if (cantAPro > maxProm){
							cantAPro = maxProm;
							}
						cantAPro = cantAPro*parseFloat(cantMPro);
					var cantSPro = CantMov - cantAPro;

					var NuevTot = cantSPro * CostMov;
					var NuevoTt = cantAPro * (CostMov*descMPro/100);
						document.getElementById("promocionValor"+id).innerHTML = NuevoTt;
						document.getElementById("cantidadConPromocion"+id).innerHTML = cantAPro;
						document.getElementById("cantidadSinPromocion"+id).innerHTML = cantSPro;

						NuevTot = NuevTot + NuevoTt;
						ValTemp = ValTemp - TotRedu;
						ValTemp = ValTemp + NuevTot;
						var n1 = parseFloat(CantMov).toFixed(2);
						document.getElementById("Cantidad"+id).value = n1;
						var n2 = parseFloat(CostMov).toFixed(2);
						document.getElementById("costoMovimiento"+id).value = n2;
						var n3 = parseFloat(NuevTot).toFixed(2);
						document.getElementById("totalMovimiento"+id).value = n3;
						var n4 = parseFloat(ValTemp).toFixed(2);
						document.getElementById("txtSubtotalVenta").innerHTML = n4;
			}
			calculaRetenciones();		
	}
	
	function calculaTablaValoresTodos(){
		var tableReg = document.getElementById('tableMovimientos');
			var retencion = [];
		    var tablaRetencion = [];
		    var j = 0;
		    var iva0 = 0;
		    var iva12 = 0;
		    var vIVA = 0;
		    var acum = 0;
			for (var i = 1; i < tableReg.rows.length-1; i++){
				 var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
				 
				 var cantidad = document.getElementById("Cantidad"+id).value; 
				 var pvp = document.getElementById("costoMovimiento"+id).value; 
				 	 var rcal = parseFloat(cantidad)*parseFloat(pvp);
				     rcal = rcal.toFixed(2);
				
					 document.getElementById("totalMovimiento"+id).value = rcal;
					 acum = acum + rcal;
				
				if (document.getElementById("idGrabaIVA"+id).innerHTML == 0){
					 iva0 = iva0 + parseFloat(document.getElementById("totalMovimiento"+id).value);
					 vIVA = 0;
				     }else{iva12 = iva12 + parseFloat(document.getElementById("totalMovimiento"+id).value);
						   vIVA = document.getElementById('iVAPorcentaje').innerHTML;}
				 }
		
			n1 = parseFloat(acum);
			n1 = n1.toFixed(2);
			document.getElementById("txtSubtotalVenta").innerHTML = n1;
				
			n1 = parseFloat(iva0);
			n1 = n1.toFixed(2);
			document.getElementById("txtVTotalIVA0").innerHTML = n1;
			document.getElementById("txtTotalIVA0").innerHTML = '0.00';
			n1 = iva12;
			n1 = n1.toFixed(2);
			document.getElementById("txtVTotalIVA12").innerHTML = n1;
			n1 = parseFloat(document.getElementById("txtVTotalIVA12").innerHTML)*vIVA/100;
			n1 = n1.toFixed(2);
			document.getElementById("txtTotalIVA12").innerHTML = n1;

			n1 = parseFloat(document.getElementById("txtTotalIVA12").innerHTML)+
				parseFloat(document.getElementById("txtSubtotalVenta").innerHTML);
			n1 = n1.toFixed(2);
		    
			document.getElementById("txtSumaTotalIVA0").innerHTML = document.getElementById("txtVTotalIVA0").innerHTML;	
		    s = parseFloat(document.getElementById("txtVTotalIVA12").innerHTML)+parseFloat(document.getElementById("txtTotalIVA12").innerHTML);
		    document.getElementById("txtSumaTotalIVA12").innerHTML = s.toFixed(2);
			document.getElementById("txtTotalVenta").innerHTML = n1;
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
				 //console.log(i)
				var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
				var rs = retencion.indexOf(document.getElementById("idRetencionProducto"+id).innerHTML);
				if (document.getElementById("idGrabaIVA"+id).innerHTML == 0){
					 iva0 = iva0 + parseFloat(document.getElementById("totalMovimiento"+id).value);
					 //vIVA = 0; SE BLOQUEA LINEA POR PROBLEMAS DEL IVA
				     }else{iva12 = iva12 + parseFloat(document.getElementById("totalMovimiento"+id).value);
						   vIVA = document.getElementById('iVAPorcentaje').innerHTML;}
					}
		
			for (var i = 1; i < tableReg.rows.length-1; i++){
				 var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
				 var rs = retencion.indexOf(document.getElementById("idRetencionProducto"+id).innerHTML);
				 if (document.getElementById("idRetencionProducto"+id).innerHTML != 0){
					if (rs == -1){
						var tRetencion = { };
							tRetencion[0] = document.getElementById("tableMovimientos").rows[i].cells[12].innerHTML;
							tRetencion[1] = document.getElementById("tableMovimientos").rows[i].cells[13].innerHTML;
							tRetencion[2] = document.getElementById("tableMovimientos").rows[i].cells[14].innerHTML;
							tRetencion[3] = parseFloat(document.getElementById("totalMovimiento"+id).value)*vIVA/100;
							tRetencion[4] = document.getElementById("totalMovimiento"+id).value;
							tRetencion[5] = document.getElementById("totalMovimiento"+id).value;

							tablaRetencion.push(tRetencion);
						 	j++;
						 }else{	tablaRetencion[rs][3] = parseFloat(tablaRetencion[rs][3]) 
														+ (parseFloat(document.getElementById("totalMovimiento"+id).value)*vIVA/100);
								tablaRetencion[rs][4] = parseFloat(tablaRetencion[rs][4]) 
														+ parseFloat(document.getElementById("totalMovimiento"+id).value);
								tablaRetencion[rs][5] = parseFloat(tablaRetencion[rs][5]) 
														+ parseFloat(document.getElementById("totalMovimiento"+id).value);
						 }
					}
				 }
				
				n1 = parseFloat(iva0)+parseFloat(iva12);
		        n1 = n1.toFixed(2);
				document.getElementById("txtSubtotalVenta").innerHTML = n1;
				
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
				
				n1 = parseFloat(document.getElementById("txtTotalIVA12").innerHTML)+
					 parseFloat(document.getElementById("txtSubtotalVenta").innerHTML);
		        n1 = n1.toFixed(2);
				
		        document.getElementById("txtSumaTotalIVA0").innerHTML = document.getElementById("txtVTotalIVA0").innerHTML;	
				s = parseFloat(document.getElementById("txtVTotalIVA12").innerHTML)+parseFloat(document.getElementById("txtTotalIVA12").innerHTML);
				document.getElementById("txtSumaTotalIVA12").innerHTML = s.toFixed(2);
		        document.getElementById("txtTotalVenta").innerHTML = n1;
				
				tbl = '<table id="tableDetalleRetencion" class="table table-sm" style="color: #56acc4; width: 210px;">'+
						'<tr><td style="padding: 2px; width: 55px;"><b>Tipo</b></td>'+
							'<td style="padding: 2px; text-align: right; width: 50px;"><b>Monto</b></td>'+
							'<td style="padding: 2px; text-align: right; width: 50px;"><b>%</b></td>'+
							'<td style="padding: 2px; text-align: right; width: 55px;"><b>Valor</b></td></tr>';
		        acumRet = 0;
		        for (var i= 0; i < j; i++){
					  lineaRet = (tablaRetencion[i][4] * tablaRetencion[i][2])/100;
					  acumRet = acumRet + lineaRet;
					  monto = parseFloat(tablaRetencion[i][4]);		
					  		tbl = tbl + '<tr style="font-weight: 100;">'+
								           	'<td style="display: none;">'+tablaRetencion[i][0]+'</td>'+
											'<td style="display: none;">1</td>'+
											'<td style="padding: 0px; text-align: left; width: 55px;"><b>Fuente</b></td>'+
											'<td style="padding: 0px; text-align: right; width: 50px;">'+monto.toFixed(2)+'</td>'+
											'<td style="padding: 0px; text-align: right; width: 50px;">'+tablaRetencion[i][2]+'</td>'+
											'<td style="padding: 0px; text-align: right; width: 55px;">'+lineaRet.toFixed(2)+'</td></tr>';
					  
					  
					  monto = parseFloat(tablaRetencion[i][3]);
					  lineaRet = parseFloat(tablaRetencion[i][3])*parseFloat(tablaRetencion[i][1])/100;
					  acumRet = acumRet + lineaRet;
					  		tbl = tbl + '<tr style="font-weight: 100;">'+
											'<td style="display: none;">'+tablaRetencion[i][0]+'</td>'+
											'<td style="display: none;">2</td>'+
											'<td style="padding: 0px; text-align: left; width: 55px;"><b>IVA</b></td>'+
											'<td style="padding: 0px; text-align: right; width: 50px;">'+monto.toFixed(2)+'</td>'+
											'<td style="padding: 0px; text-align: right; width: 50px;">'+tablaRetencion[i][1]+'</td>'+
											'<td style="padding: 0px; text-align: right; width: 55px;">'+lineaRet.toFixed(2)+'</td></tr>';
				 	 }
					tbl = tbl + '<td colspan="3" style="padding: 0px;">TOTAL</td>'+
							    '<td id="txtTotalRetencion" style="padding: 0px; text-align: right;">'+acumRet.toFixed(2)+'</td></table>';
				document.getElementById("retencionDetalle").innerHTML = tbl; 
				//console.log(tablaRetencion)
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
	
	function  observacionItem(id){
		document.getElementById("descripcionItemAd").value = document.getElementById("descripcion"+id).innerHTML;
		document.getElementById("descripcionItemId").innerHTML = "descripcion"+id;
		document.getElementById("modalObservacionDiv").style.display = 'block';
	}
	
	function cerrarObservacion(){
		document.getElementById("modalObservacionDiv").style.display = 'none';
	}
	
	function guardarObservacion(){
		descripcion = document.getElementById("descripcionItemId").innerHTML;
		document.getElementById(descripcion).innerHTML = document.getElementById("descripcionItemAd").value;
		document.getElementById("modalObservacionDiv").style.display = 'none';
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
		validarIdentificacion();
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
	
	function registraFactura(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		
		if (document.getElementById("idCliente").value == ''){
			parent. modalAlertPrincipal(2, 'MarketSys', 'Para proceder con la generación de la factura es necesario, '+
										                'que se seleccione un cliente, si el cliente no se encuentra registrado, '+
														'proceda a crear uno nuevo.', 0, 'Aceptar', '')
			parent.document.getElementById('divLoadding').style.display = 'none';
			return 0;
		    }else{
			if (document.getElementById("formasPagoFactura").value == 0){
				parent. modalAlertPrincipal(2, 'MarketSys', 'Para proceder con la generación de la factura es necesario, '+
															'que se seleccione una forma de pago.', 0, 'Aceptar', '')
				parent.document.getElementById('divLoadding').style.display = 'none';
				return 0;
				}	
				
			var tableReg = document.getElementById('tableMovimientos');
			var inicio = 0;
			var d = new Date();
				var idCliente 		 = document.getElementById('idCliente').value;
				var idFormaPago 	 = document.getElementById('formasPagoFactura').value;
				var fechaFactura	 = document.getElementById('fechaFactura').value;
				var vigenciaFormaPago= $('option:selected', document.getElementById('formasPagoFactura')).attr('codigo');
				var txtSubtotalVenta = document.getElementById('txtSubtotalVenta').innerHTML;
				var txtVTotalIVA0 	 = document.getElementById('txtVTotalIVA0').innerHTML;
				var iVAPorcentaje 	 = document.getElementById('iVAPorcentaje').innerHTML;
				var txtVTotalIVA12 	 = document.getElementById('txtVTotalIVA12').innerHTML;
				var txtTotalIVA12 	 = document.getElementById('txtTotalIVA12').innerHTML;
				var txtTotalVenta 	 = document.getElementById('txtTotalVenta').innerHTML;
				var txtRetencion	 = document.getElementById('txtTotalRetencion').innerHTML;
				var txtAplicaRet	 = 0;
				if (document.getElementById('chkRetenciones').checked == true){
					txtAplicaRet = 1;
					}
				var txtRetencion	 = document.getElementById('txtTotalRetencion').innerHTML;
				
			idProforma = 0;	
			$.ajax({type:'POST',
					url:'../php/registroFactura.php',
					data:'idCliente='+idCliente+'&idFormaPago='+idFormaPago+'&vigenciaFormaPago='+vigenciaFormaPago+
					      '&txtSubtotalVenta='+txtSubtotalVenta+'&txtVTotalIVA0='+txtVTotalIVA0+'&fechaFactura='+fechaFactura+
					      '&iVAPorcentaje='+iVAPorcentaje+'&txtVTotalIVA12='+txtVTotalIVA12+'&txtTotalIVA12='+txtTotalIVA12+
						  '&txtTotalVenta='+txtTotalVenta+'&txtTotalRetenciones='+txtRetencion+'&txtAplicaRet='+txtAplicaRet,
					success:function(data){
						    info = eval(data);
						    if(info[0] == '-2'){
							   parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									   'Se ha presentando un error, comuniquese con el administrador. ERROR:['+info[1]+']', 0, 
									   'Aceptar', '');
									   parent.document.getElementById('divLoadding').style.display = 'none';
								       return;
							  }
							if(info[0] == '-1'){
							   parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									   'Usted no ha realizado la apertura de caja, es necesario que realize la apertura, para poder continuar.', 0, 
									   'Aceptar', '');
									   parent.document.getElementById('divLoadding').style.display = 'none';
								       return;
							  }else{var idFactura = info[0];
									for (var i = 1; i < tableReg.rows.length-1; i++)
										{cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
										 // Recorremos todas las celdas
											var tbl = document.getElementById("tableMovimientos");
										 if (i == 1){inicio = 1; d = d.getTime();}else{inicio = 0;}
											 var idMovi = tbl.rows[i].cells[0].innerHTML;
										 	 var idItem = tbl.rows[i].cells[1].innerHTML;
										     var dsItem = document.getElementById("descripcion"+idMovi).innerHTML;
										     var cantSt = tbl.rows[i].cells[4].innerHTML;
										     var costoA = tbl.rows[i].cells[5].innerHTML;
										     var idProm = document.getElementById("idPromocion"+idMovi).innerHTML;
										     var dsProm = tbl.rows[i].cells[6].innerHTML;
										     var prProm = document.getElementById("descuentoPromocion"+idMovi).innerHTML;
										     var ccProm = document.getElementById("cantidadConPromocion"+idMovi).innerHTML;
										     var csProm = document.getElementById("cantidadSinPromocion"+idMovi).innerHTML;
											 var porcDes = document.getElementById("descuentoMovimiento"+idMovi).value;
											 var cantiM = document.getElementById("Cantidad"+idMovi).value;	
											 var costoM = document.getElementById("costoMovimiento"+idMovi).value;
											 var subTotalM = document.getElementById("totalMovimiento"+idMovi).value;
										     var totalM = document.getElementById("totalMovimiento"+idMovi).value;
											    /** Registra Detalle Factura **/
												$.ajax({type:'POST',
														url:'../php/registroDetalleFactura.php',
														async: false,
														data:'idFactura='+idFactura+'&idMovi='+idMovi+'&idItem='+idItem+'&dsItem='+dsItem+
															  '&costoA='+costoA+'&cantiM='+cantiM+'&costoM='+costoM+'&subTotalM='+subTotalM+
															  '&idProm='+idProm+'&dsProm='+dsProm+'&prProm='+prProm+'&ccProm='+ccProm+
														      '&csProm='+csProm+'&dscItm='+porcDes+'&porcDes='+porcDes+'&TotalM='+totalM+
															  '&cantSt='+cantSt,
														success:function(data){}
														});	
										 		
										 		/** Registra movimiento inventario **/
										 		 $.ajax({type:'POST',
														 url:'../php/registraMovimientoInventario.php',
														 async: false,
														 data:'idFactura='+idFactura+'&idMovi='+idMovi+'&idItem='+idItem+'&tipoTra=2'+
														      '&costoA='+costoA+'&cantiM='+cantiM+'&costoM='+costoM+'&subTotalM='+subTotalM,
														 success:function(data){}
														});	
										}
									/** registra retención **/
									$.ajax({type:'POST',
											url:'../php/registroRetencionesFactura.php',
											async: false,
											data:'idFactura='+idFactura,
											success:function(data){
													info = eval(data);
													var tableRet = document.getElementById('tableDetalleRetencion');
													if (txtAplicaRet == 1){
														for (var i = 1; i < tableRet.rows.length-1; i++)
															{idRetencion = info[0];
															 idTRetencion = tableRet.rows[i].cells[0].innerHTML;
															 idTipoRetencion = tableRet.rows[i].cells[1].innerHTML;
															 porcentajeRetencion = tableRet.rows[i].cells[4].innerHTML;
															 montoARetencion = tableRet.rows[i].cells[3].innerHTML;
															 montoRetencion = tableRet.rows[i].cells[5].innerHTML;
															 $.ajax({type:'POST',
																	 url:'../php/registroDetalleRetencionesFactura.php',
																	 async: false,
																	 data:'idRetencion='+idRetencion+'&lineaRetencion='+i+
																	      '&idTRetencion='+idTRetencion+'&idTipoRetencion='+idTipoRetencion+
																	 	  '&porcentajeRetencion='+porcentajeRetencion+
																	 	  '&montoARetencion='+montoARetencion+'&montoRetencion='+montoRetencion,
																	 success:function(data){}
																           });
															}
														}
													}
										   });
									
									registraFacturaElectronica(idFactura);
									registraMovimientoBancario(idFormaPago,idFactura);	   
									registraAsientoContable(idFormaPago,idFactura);
									
						}
					}
				});	
				
				

		}
	}
	
	function registraMovimientoBancario(idFormaPago,idFactura){
		var url = '../../lib/php/registraMovimientoBancario.php';
		tipoMovimiento 	= '1';
		idTrx			= '1';
		var movimientoBancario = 0;
		if (document.getElementById('chkRetenciones').checked == true){
			var montoVenta = document.getElementById('txtTotalVenta').innerHTML;
			var montoRetencion = document.getElementById('txtTotalRetencion').innerHTML;
				movimientoBancario = parseFloat(montoVenta) - parseFloat(montoRetencion);
		    }else{
				movimientoBancario = document.getElementById('txtTotalVenta').innerHTML;
			}
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+idFormaPago+'&tipoMovimiento='+tipoMovimiento+'&idFactura='+idFactura+'&idTrx='+idTrx+'&monto='+movimientoBancario,
			success:function(data){ 
			}
		});	

	}
	
	function registraAsientoContable(idFormaPago,idFactura){
		var url = '../../lib/php/registraAsientoContableVenta.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'idFormaPago='+idFormaPago+'&idFactura='+idFactura,
			success:function(data){ 
			}
		});
	}
	
	function registraFacturaElectronica(idFactura){
		var url = '../php/generaFacturaElectronica.php';
		$.ajax({
			type:'GET',
			url:url,
			async: false,
			data:'idfactura='+idFactura,
			success:function(data){
				data = eval(data);
				obtenerComprobanteFirmado_sri(idFactura,data[4],atob(data[2]),data[6], data[5],data[3]);
				
				parent.modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', 
											   'Su factura ha sido registrada de manera correcta.', 0, 
											   'Aceptar', '');

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
		especiales = [8, 37, 39, 44, 45, 46, 47];

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
	
	function validarIdentificacion(){
			var msjError = '0';
			numero = document.getElementById("numeroIdentificacionNw").value;
			var suma = 0;
			var residuo = 0;
			var pri = false;
			var pub = false;
			var nat = false;
			var numeroProvincias = 24;
			var modulo = 11;

			if (document.getElementById("numeroIdentificacionNw").value == '')
			   {msjError = 'Por favor digite un número de cédula válido.';
				//console.log(msjError);
				parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									           msjError, 0, 
									           'Aceptar', '');
				document.getElementById('tiposIdentificacionNw').focus();
			    return;}

			/* Aqui almacenamos los digitos de la cedula en variables. */
			d1 = numero.substr(0,1);
			d2 = numero.substr(1,1);
			d3 = numero.substr(2,1);
			d4 = numero.substr(3,1);
			d5 = numero.substr(4,1);
			d6 = numero.substr(5,1);
			d7 = numero.substr(6,1);
			d8 = numero.substr(7,1);
			d9 = numero.substr(8,1);
			d10 = numero.substr(9,1);
			/* El tercer digito es: */ 
				/* 9 para sociedades privadas y extranjeros */
				/* 6 para sociedades publicas */
				/* menor que 6 (0,1,2,3,4,5) para personas naturales */

			if (d3==7 || d3==8){
				msjError = 'El tercer digito no es correcto. Por favor verificar.';
				//console.log(msjError);
				document.getElementById('numeroIdentificacionNw').focus();
			    parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									            msjError, 0, 
									           'Aceptar', '');
			    return;}

			if (document.getElementById("tiposIdentificacionNw").value == '1')
				{if(numero.length != 10)
					{msjError = 'El número de digitos es Incorrecto. Debe tener 10 digitos.';
					 //console.log(msjError);
					 document.getElementById('numeroIdentificacionNw').focus();
					 parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
													 msjError, 0, 
												    'Aceptar', '');
			    	return;}
				} else if (document.getElementById("tiposIdentificacionNw").value == '2')
							{if(numero.length != 13)
								{msjError = 'El número de digitos es Incorrecto. Debe tener 13 digitos.';
								 //console.log(msjError);
								 document.getElementById('numeroIdentificacionNw').focus();
								 parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
																 msjError, 0, 
															    'Aceptar', '');
			    				 return;}
							}
							else if (document.getElementById("tiposIdentificacionNw").value == '0')
									{msjError = 'El tipo de identificación Incorrecto.';
									 //console.log(msjError);
									 document.getElementById('tiposIdentificacionNw').focus();
									 parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
																	 msjError, 0, 
																    'Aceptar', '');
									 return;}

			/*if (msjError != '0'){
				document.getElementById(msjDiv).innerHTML = '<h3>Error Validación Identificación</h3><p>'+msjError+'</p>';
				tooltip.pop(number, '#'+msjDiv+'');
				return false;
			   }*/

			/* Solo para personas naturales (modulo 10) */
			if (d3 < 6){
				nat = true;
				p1 = d1 * 2; if (p1 >= 10) p1 -= 9;
				p2 = d2 * 1; if (p2 >= 10) p2 -= 9;
				p3 = d3 * 2; if (p3 >= 10) p3 -= 9;
				p4 = d4 * 1; if (p4 >= 10) p4 -= 9;
				p5 = d5 * 2; if (p5 >= 10) p5 -= 9;
				p6 = d6 * 1; if (p6 >= 10) p6 -= 9;
				p7 = d7 * 2; if (p7 >= 10) p7 -= 9;
				p8 = d8 * 1; if (p8 >= 10) p8 -= 9;
				p9 = d9 * 2; if (p9 >= 10) p9 -= 9;
				modulo = 10;
			}

			/* Solo para sociedades publicas (modulo 11) */
			/* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
			else if(d3 == 6){
				pub = true;
				p1 = d1 * 3;
				p2 = d2 * 2;
				p3 = d3 * 7;
				p4 = d4 * 6;
				p5 = d5 * 5;
				p6 = d6 * 4;
				p7 = d7 * 3;
				p8 = d8 * 2;
				p9 = 0;
			}

			/* Solo para entidades privadas (modulo 11) */
			else if(d3 == 9) {
				pri = true;
				p1 = d1 * 4;
				p2 = d2 * 3;
				p3 = d3 * 2;
				p4 = d4 * 7;
				p5 = d5 * 6;
				p6 = d6 * 5;
				p7 = d7 * 4;
				p8 = d8 * 3;
				p9 = d9 * 2;
			}

			suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;
			residuo = suma % modulo;
			/* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
			digitoVerificador = residuo==0 ? 0: modulo - residuo;
			/* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/
			if (pub==true){
				if (digitoVerificador != d9){
					msjError = 'El ruc de la empresa del sector público es incorrecto.';
					//console.log(msjError);
					parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									           		msjError, 0, 
									          	   'Aceptar', '');
			    	return;
				}
			/* El ruc de las empresas del sector publico terminan con 0001*/
			if ( numero.substr(9,4) != '0001' ){
				 msjError = 'El ruc de la empresa del sector público debe terminar con 0001';
				 //console.log(msjError);
				 parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									             msjError, 0, 
									            'Aceptar', '');
			     return;
				}
			}
			else if(pri == true){
					if (digitoVerificador != d10){
						msjError = 'El ruc de la empresa del sector privado es incorrecto.';
						//console.log(msjError);
						parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									            		msjError, 0, 
									        		   'Aceptar', '');
			    		return;
						}
					if ( numero.substr(10,3) != '001' ){
						msjError = 'El ruc de la empresa del sector privado debe terminar con 001.';
						//console.log(msjError);
						parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									          			msjError, 0, 
									        		   'Aceptar', '');
			    		return;
						}
					}
			else if(nat == true){
					if (digitoVerificador != d10){
						msjError = 'El número de cédula de la persona natural es incorrecto.';
						//console.log(msjError);
						parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
														msjError, 0, 
													   'Aceptar', '');
						return;
						}
					if (numero.length >10 && numero.substr(10,3) != '001' ){
						msjError = 'El ruc de la persona natural debe terminar con 001.';
						//console.log(msjError);				
						parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
														msjError, 0, 
													   'Aceptar', '');
						return;
						}
				}

			/*if (msjError != '0'){
				setTimeout(function(){document.getElementById('numeroIdentificacionNw').focus();}, 10);

				document.getElementById(msjDiv).innerHTML = '<h3>Error Validación Identificación</h3><p>'+msjError+'</p>';
				tooltip.pop(number, '#'+msjDiv+'');	
				return false;
			   }*/
			var url = '../../lib/ws/validacionIdentificacion.php';
				$.ajax({
					type:'POST',
					url:url,
					data:'tipo='+document.getElementById("tiposIdentificacionNw").value+
					     '&num='+document.getElementById("numeroIdentificacionNw").value,
					success:function(data){ 
						data = eval(data);
						if (data[0]==''){
							document.getElementById("nombreClienteNw").value = data[2];
							}
					}
				});
			return true;
		}
	
</script>
</body>
</html>