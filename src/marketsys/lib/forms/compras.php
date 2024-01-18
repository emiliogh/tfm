<?php include "../php/sesionSecurityForms.php"; ?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Compras</title>
  
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
			<table style="width: 99.9%;">
				<thead>
					<tr>
						<td colspan="5" class="estilo3">
							COMPRA
							<input id="porcentajeIVA" name="porcentajeIVA" type="text" style="display: none;"/>
							<span id="idValorRenta" name="idValorRenta" style="display: none;">0.00</span>
							<span id="idValorIVA" name="idValorIVA" style="display: none;">0.00</span>
							<span id="nombreXML" name="nombreXML" style="display: none;">xml</span>
							<span id="nombrePDF" name="nombrePDF" style="display: none;">pdf</span>
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 140px; padding-top: 5px;">
							Proveedor:
					    </td>
						<td style="width: 100px;">
							<input onFocus="this.blur()" id="idCliente" name="idCliente" type="text" 
								   style="width: 99%; height: 18px; text-align: right; "/>
						</td>
						<td class="clsObjetosTable" colspan="2" style="width: calc(100% - 480px);">
							<input id="cliente" name="cliente" class="required" type="text" style="width: 100%; height: 18px;"/>
							<input id="idPorcentajeCategoria" name="idPorcentajeCategoria" type="text" style="display: none;"/>
						</td>	
						<td class="clsObjetosTable" colspan="2" style="width: calc(100% - 480px);">
							<table style="width: 100%;">
							   <tr>
								    <td class="clsEtiquetasTable" style="width: 140px; padding-top: 5px;">
										Fecha Factura:
									</td>
									<td style="width: 100px;">
										<input onFocus="this.blur()" id="fechaFactura" name="fechaFactura" type="text" 
											   style="width: 99%; height: 18px; font-size: 13px; color: #991814; border: none;"/>
									</td>
							   </tr> 
							</table>
						</td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 140px;">
							Categoría:
					    </td>
						<td class="clsObjetosTable">
							<select id="idCategoriaCliente" style="color: royalblue; width: 100%; font-size: 12px;"
									onChange="cambioInformacion(this)"></select>
						</td>
						<td class="clsEtiquetasTable">
							Tipo de Proveedor:
					    </td>
						<td>
							<select id="idTipoCliente" style="color: royalblue; width: 100%; font-size: 12px;"
									onChange="cambioInformacion(this)"></select>
						</td>
						<td style="width: 260px;" rowspan="5">
							<table style="width: 100%;">
							   <tr>
							     <td  style="padding-left: 5px;">
									<button type="button" id="btn_guardar" style="width: 80px; line-height : 13px;" 
											onClick="registraNuevoCliente();"><br>
											<img src="../images/icons/cliente.png" style="width: 45px" alt=""/><br><br>
												<b>Nuevo Proveedor</b>
									 </button>
								 </td>
								 <td style="padding-left: 5px;">
								    <button type="button" id="btn_guardar" style="width: 80px; line-height : 13px;" 
											onClick="registraFactura();"><br>
										<img src="../images/icons/guardar.png" style="width: 45px" alt=""/><br><br>
											<b>Registra Compra</b>
									 </button>
								 </td>
								 <td  style="padding-left: 5px;">
									<table style="width: 100px; margin-top: 3px">
										<tr style="height: 61px;">
											<td style="padding: 10px; background-color: khaki; text-align: right; ">
												<span id="saldoDeudaCliente" 
													  style="font-size: 20px;font-weight: 800;color: red;">0.00</span>
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
								   style="width: 99%; height: 18px; font-size: 12px;" onChange="buscarProveedorBD();"/>
						</td>
						<td class="clsEtiquetasTable" style="width: 140px;">
							Nombre Comercial:
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="nombreComercial" name="nombreComercial" type="text" 
								   style="width: 100%; height: 18px;"/>
						</td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Tipo Factura:
					    </td>
						<td>
							<input onFocus="this.blur()" id="tipoFactura" name="tipoFactura" type="text" 
								   value="MANUAL" style="width: 99%; height: 18px; font-size: 12px;"/>
						</td>
						<td class="clsEtiquetasTable" style="width: 140px;">
							Dirección:
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="direccion" name="direccion" type="text" 
								   style="width: 100%; height: 18px;"/>
						</td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Factura:
					    </td>
						<td>
							<input id="numFacturaEstablecimiento" type="text" style="display: none;"/>
							<input id="numFacturaPuntoEmision" type="text" style="display: none;"/>
							<input id="numFactura" name="numFactura" type="text" 
								   style="width: 99%; height: 18px; font-size: 12px;"/>
						</td>
						<td class="clsEtiquetasTable">
							N° de autorización:
					    </td>
						<td class="clsObjetosTable">
							<input id="numAutorizacion" name="numAutorizacion" class="required" type="text" 
								   style="width: 100%; height: 18px;"/>
						</td>
					</tr>
					
					<tr>
						<td class="clsEtiquetasTable">
							Forma de pago:
					    </td>
						<td colspan="2" style="padding-bottom: 5px; padding-top: 2px; width: 240px;">
							<table>
								<tr>
									<td>
										<select id="formasPagoFactura" style="color: royalblue; width: 100%; font-size: 12px;"
												onChange="cambioInformacion(this)"></select>
									</td>
									<td>
										<img src="../images/icons/add.png" onClick="mostrarPagosPersonalizados()" 
											 style="height: 19px; padding-left: 4px;" alt=""/>
									</td>	
								</tr>	
							</table>	
							
						</td>
						<td class="clsEtiquetasTable" style="width: calc(100% - 400px); padding-left: 0px;">
							<button type="button" onClick="mostrarCargaArchivos()"
									class="proforma" style="width: 100%; height: 19px; background: lavender;">
								Cargar Información       <img src="../images/icons/procesarProforma.png" height="12px" alt=""/>
							</button>	
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
										<input onFocus="this.blur()" id="idItem" name="idItem" type="text" 
											   style="width: 95%; height: 26px;"/>
										<input id="costoPromedio" name="costoPromedio" type="text" style="display: none;"/>
										<input id="costoIdeal" name="costoIdeal" type="text" style="display: none;"/>
										<input id="descripcionProducto" name="descripcionProducto" type="text" 
											   style="display: none;"/>
										<input id="idTipoProducto" name="idTipoProducto" type="text" style="display: none;"/>
										<input id="idGrabaIVA" name="idGrabaIVA" type="text" style="display: none;"/>
										<input id="idVentaSinStock" type="text" style="display: none;"/>
									</td>
									<td>
										<input id="item" name="item" class="required" type="text" 
											   style="width: 100%; height: 26px;"/>
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
							DETALLE DE LA COMPRA
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
													<td rowspan="2" style="width: 5%;">N°</td>
													<td rowspan="2" style="width: 5%; border-left: 1px solid white;">Código</td>
													<td rowspan="2" colspan="2" 
														style="width: 35%; border-left: 1px solid white;">Ítem</td>
													<td rowspan="2" 
														style="width: 5%; border-left: 1px solid white;">Cantidad</td>
													<td rowspan="2" 
														style="width: 5%; border-left: 1px solid white;">P.Unit</td>
													<td rowspan="2" 
														style="width: 5%; border-left: 1px solid white;">Descuento</td>
													<td rowspan="2" 
														style="width: 5%; border-left: 1px solid white;">IVA</td>
													<td rowspan="2" 
														style="width: 5%; border-left: 1px solid white;">Total sin impuesto</td>
													<td colspan="4" style="width: 15%; border-left: 1px solid white;">
														<table style="width: 100%; margin-left: 2px;" class="estilo3">
															<tr>
																<td style="width: 95%; background-color: #DC7633;">
																	Retenciones
																</td>
																<td>
																	<input id="chkRetenciones" type="checkbox" checked 
																		   onChange="cambioInfoRetencion(this.checked)"
																		   data-toggle="toggle" 
																		   data-on="SI" data-off="NO" data-size="mini">
																</td>
															</tr>	
														</table>
													</td>
												</tr>
												<tr class="tablaAperturaHead" style="padding-left: 2px;">
													<td colspan="2" 
														style="width: 15%; border-left: 1px solid white; background-color: #DC7633;">
														Retención IVA</td>
													<td colspan="2" 
														style="width: 15%; border-left: 1px solid white; background-color: #DC7633;">
														Retención IR</td>
												</tr>	
											</thead>
											<tbody bgcolor="#fff" id="tablaAperturaBody">	
											</tbody>		
											<tfoot>	
												<tr class="tablaAperturaFood">
													<td colspan="6" bgcolor="#fff" style="border-top: 2px solid #4ea8c1;">	
													</td>
													<td colspan="3">
														<table style="width: 99%">
															<tr>
																<td style="text-align: left; padding-left: 5px;">SUBTOTAL</td>
																<td></td>
																<td style="text-align: right; width: 100px;">
																	<span id="txtSubtotalVenta" name="txtSubtotalVenta">0.00</span>
																</td>
															</tr>
															<tr>
																<td style="text-align: left; padding-left: 5px;">DESCUENTO</td>
																<td></td>
																<td style="text-align: right; width: 100px;">
																	<span id="txtDescuentoVenta" name="txtDescuentoVenta">0.00</span>
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
													<td colspan="4" style="vertical-align: top;">
													  <table style="width: 99%; margin-left: 4px;">
													    <tr>
													      <td style="text-align: center; background-color: #DC7633;">
															TOTAL
														  </td>
													      <td style="text-align: right; background-color: #DC7633;">
														    <span id="txtTotalRetIVA" name="txtTotalRetIVA">0.00</span>
													      </td>
													      <td style="text-align: center; background-color: #DC7633;">
														    TOTAL
													      </td>
													      <td style="text-align: right; background-color: #DC7633;">
														    <span id="txtTotalRetRenta" name="txtTotalRetRenta">0.00</span>
													      </td>
														</tr>
													    <tr>
													      <td colspan="3" style="height: 28px;">
													         TOTAL RETENCIÓN	
													      </td>
													      <td>
														    <span id="txtTotalRetenciones" name="txtTotalRetenciones">0.00</span>
													      </td>
												        </tr>
														<tr>
													      <td colspan="3" style="height: 28px;">
													         MONTO A PAGAR	
													      </td>
													      <td>
														    <span id="montoTotalPagar" name="montoTotalPagar"
																  style="font-size: xx-large; color: #DFEA4E;">0.00</span>
													      </td>
												        </tr>  
													 </table>
												   </td>
												</tr>
											</tfoot>		
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
									<td>Tipo Proveedor
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
									<td><input id="numeroIdentificacionNw" name="numeroIdentificacionNw" 
											   autocomplete="off" type="text" 
											   class="form-control" style="width: 100%; height: 22px;" 
											   onkeypress="return soloNumeros(event);"
											   maxlength="10"/>
									</td>	
								</tr>
								<tr>
									<td><span id="tipo">Nombre</span>
									</td>	
									<td><input id="nombreClienteNw" name="nombreClienteNw" autocomplete="off" type="text" 
											   class="form-control"
											   style="width: 100%; height: 22px; text-transform: uppercase;" 
											   onkeypress="return soloLetras(event)"/>
									</td>	
								</tr>
								<tr>
									<td>Dirección
									</td>	
									<td><input id="direccionNw" name="direccionNw" autocomplete="off" type="text" 
											   class="form-control"
											   style="width: 100%; height: 22px; text-transform: uppercase;" 
											   onkeypress="return soloLetras(event)"/>
									</td>	
								</tr>
								<tr>
									<td>Teléfono
									</td>	
									<td><input id="telefonoNw" name="telefonoNw" autocomplete="off" type="text" class="form-control" 
											   style="width: 100%; height: 22px; text-transform: uppercase;" 
											   onkeypress="return soloNumeros(event);"
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
	
	<div role="dialog" tabindex="-1" class="modal fade" id="modalArchivosFacturas"
		style="padding-top: 140px; margin-right:auto;margin-left:auto; opacity: 1;">
		   <div class="modal-dialog" role="document">
			 <div class="modal-content">
			   <div class="modal-header" style="background-color: #CCD1D1"> <!-- CABECERA -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onClick="cerrarModalArchivos();">
						<span aria-hidden="true" style="color: red;"><b>X</b></span></button>
					<h4 class="text-left modal-title">Archivos de Facturas de Compras</h4>
			   </div>
			   
			    <div class="modal-body" style="height: 250px; "> <!-- CUERPO DEL MENSAJE -->
				    <div class="row form-group">
						<div style="width: calc(100% - 70px); margin-left: 30px;" id="calificacionDiv">
							<table style="width: 100%;">
								<tr>
									<td style="width: 50%; text-align: center;">
										Archivo XML
										<input id="fileXML" type="text" style="display: none;"/>
									</td>
									<td style="width: 50%; text-align: center;">
										Archivo PDF
										<input id="filePDF" type="text" style="display: none;"/>
									</td>
								</tr>
								<tr>
									<td style="width: 50%; text-align: center; padding-left: 25px">
										<div width="160px" height="220px" style="margin: 0px;">
										<object id="objPDFPredios" type="text/html" 
												data="../upload/viewXMLFactura.php" 
												style="width: 160px; height: 220px; border:0px">
										</object>
									    </div>
									</td>
									
									<td style="width: 50%; text-align: center; padding-left: 25px">
										<div width="160px" height="220px" style="margin: 0px;">
										<object id="objPDFPredios" type="text/html" 
												data="../upload/viewPDFFactura.php" 
												style="width: 160px; height: 220px; border:0px">
										</object>
									    </div>
									</td>
								</tr>
							</table>	
						</div>	
					</div>
					
				</div>

			   <div class="modal-footer"> <!-- PIE -->
				   	<button class="btn btn-default btn btn-primary btn-lg" type="button" data-dismiss="modal" 
							onClick="procesarXML();">Subir Factura </button>
				   
					<button class="btn btn-default btn btn-danger btn-lg" type="button" data-dismiss="modal" 
							onClick="cerrarModalArchivos();">Cancelar </button>
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
											   			   class="form-control" 
														   style="width: 100%; height: 22px; text-transform: uppercase;" 
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
									<td><input id="precioCostoNw" name="precioCostoNw" autocomplete="off" type="text" 
											   class="form-control"
											   style="width: 100%; height: 22px; text-align: right;" onChange="formatearCampo(this)"
											   maxlength="10" onkeypress='return filterFloat(event,this);'/>
									</td>
									<td>% mínimo gan.
									</td>	
									<td><input id="porcentajeGanMinNw" name="porcentajeGanMinNw" autocomplete="off" 
											   type="text" class="form-control"
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
	
	<div role="dialog" tabindex="-1" class="modal fade" id="modalMultipleFormaPago"
		style="padding-top: 140px; margin-right:auto;margin-left:auto; opacity: 1;">
		   <div class="modal-dialog" role="document">
			 <div class="modal-content">
			   <div class="modal-header" style="background-color: #CCD1D1"> <!-- CABECERA -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" 
							onClick="cerrarPagosPersonalizados();">
						<span aria-hidden="true" style="color: red;"><b>X</b></span></button>
					<h4 class="text-left modal-title">Configuración MúltiForma de Pago</h4>
			   </div>
			   
			    <div class="modal-body" style="height: 280px; "> <!-- CUERPO DEL MENSAJE -->
				    <div class="row form-group">
						<div style="width: calc(100% - 70px); margin-left: 30px;" id="calificacionDiv">
							<table class="table" style="width: 100%;">
								<thead style="display: inherit; width: 100%;">
									<tr>
										<td colspan="5">
											<table style="width: 100%;">
												<tr>
													<td style="width: calc(100% - 180px);">
														<select id="formasPagoFacturaMultiple" 
																style="color: royalblue; width: 100%; font-size: 12px; height:22px"
																onChange="cambioInformacion(this)"></select>
													</td>
													<td style="width: 180px;">
														<button type="button" onClick="anadirFormaPagoMultiple()"
																class="proforma" 
																style="width: 100%; height: 22px; background: lavender;">
															<img src="../images/icons/add.png" height="14px" alt=""/>
															Añadir Forma Pago
														</button>
														<span id="secFP" style="display: none">1</span>
													</td>	
												</tr>	
											</table>
										</td>	
									</tr>	
									<tr>
										<td style="width: 15px;">N°</td>
										<td style="width: 150px;">Forma</td>
										<td style="width: 50px;">Documento</td>
										<td style="width: 100px;">Fecha Pago</td>
										<td style="width: 60px;">Valor</td>
										<td style="width: 15px;">Opciones</td>
									</tr>
								</thead>
								<tbody id="tBodyFormaPago"
									   style="height: 120px; overflow-y: scroll; display: inline-block; width: 100%;"></tbody>
								<tfoot style="display: inherit; width: 100%;">
									<tr>
										<td colspan="3" style="width: 220px;">
											Total
										</td>
										<td>
											<input id="sumaMultiplePago" name="sumaMultiplePago" autocomplete="off" type="text" 
											   class="form-control" onFocus="this.blur()" value="0.00"
											   style="width: 100px; height: 18px; text-align: right; border: none;"/>
										</td>
									</tr>
									<tr>
										<td colspan="3" style="width: 220px;">
											Pendiente
										</td>
										<td>
											<input id="sumaCopiaRetenciones" autocomplete="off" type="text" 
											   class="form-control" onFocus="this.blur()" value="0.00"
											   style="color: #CE2B18;width: 100px; height: 18px; text-align: right; border: none;"/>
										</td>
									</tr>
								</tfoot>
							</table>	
						</div>	
					</div>
					
				</div>

			   <div class="modal-footer"> <!-- PIE -->
				   	<button class="btn btn-default btn btn-info btn-lg" type="button" data-dismiss="modal" 
							onClick="cerrarPagosPersonalizados();">Aceptar </button>
				    <button class="btn btn-default btn btn-danger btn-lg" type="button" data-dismiss="modal" 
							onClick="cancelarPagosPersonalizados();">Cancelar </button>
			   </div>
			</div>
		</div>
	</div>
	
  </form>
	
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui-forms.js"></script>
  <script type="text/javascript" src="../js/bootstrap-toggle.min.js"></script>
  <script type="text/javascript" src="../js/jquery.datetimepicker.full.js"></script>	
  <script type="text/javascript" src="../js/componentes.js"></script>
  <script type="text/javascript" src="../js/moment.js"></script>
  <script type="text/javascript" src="../js/fiddle.js"></script>
  <script type="text/javascript" src="../js/forge.min.js"></script>
  <script type="text/javascript" src="../js/buffer.js"></script>
<script>
	var cmbFormasPago = new componente.cmb; 
		cmbFormasPago.ini('formasPagoFactura');
		cmbFormasPago.loadFromUrlAd('../cmb/cmbTscFormasPagoCompras.php');
	
	var cmbFormasPagoM = new componente.cmb; 
		cmbFormasPagoM.ini('formasPagoFacturaMultiple');
		cmbFormasPagoM.loadFromUrlAd('../cmb/cmbTscFormasPagoMultipleCompras.php');
	 
	var cmbTipoCliente = new componente.cmb; 
		cmbTipoCliente.ini('idTipoCliente');
		cmbTipoCliente.loadFromUrlAd('../cmb/cmbTiposProveedores.php');
	
	var cmbCategoriaCliente = new componente.cmb; 
		cmbCategoriaCliente.ini('idCategoriaCliente');
		cmbCategoriaCliente.loadFromUrlAd('../cmb/cmbCategoriasProveedores.php');
	
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
	
	//document.getElementById('fechaFactura').value = '';
	$("#fechaFactura").val( moment().format('DD/MM/YYYY') );
	
	var url = '../../lib/cmb/cmbTcuProveedoresAutoComplete.php';
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
			var costP =parseFloat($("#costoPromedio").val());
			var costII=parseFloat($("#costoIdeal").val());
			var costI =parseFloat($("#costoIdeal").val())*(1+(parseFloat(document.getElementById('idPorcentajeCategoria').value)/100));
			var descp = $("#descripcionProducto").val();
			var ivaMarca = $("#idGrabaIVA").val();
			var ventaSST = $("#idVentaSinStock").val();
			
			if (ventaSST == 0 && costP == 0){
				parent. modalAlertPrincipal(2,'MarketSys','El producto seleccionado no se puede vender sin stock disponible, '+
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
							"<td style='text-align: right;'>" + costP.toFixed(2) + "</td>"+
							"<td style='text-align: right;'>" + costII.toFixed(2) + "</td>"+
				            "<td style='text-align: center;'>" + descripcionProm + "</td>"+
							"<td><input <?php if($_SESSION["spUs"]!=1){echo " onFocus='this.blur()' ";} ?>"+
								"id='descuentoMovimiento"+idMov+"' name='descuentoMovimiento"+idMov+"' class='required' "+
								"onChange='calcularValores(this,"+costII+")' type='text' "+
				                "style='text-align: right; width: 100%; height: 25px;' "+
								"value='0.00' onkeypress='return filterFloat(event,this);' autocomplete='off' /></td>"+	
							"<td><input <?php if($_SESSION["spUs"]!=1){echo " onFocus='this.blur()' ";} ?>"+
								"id='costoMovimiento"+idMov+"' name='costoMovimiento"+idMov+"' class='required' "+
								"onChange='calcularValores(this,"+costII+")' type='text' "+
				                "style='text-align: right; width: 100%; height: 25px;' "+
								"value='"+costI.toFixed(2)+"' onkeypress='return filterFloat(event,this);' "+
				                "autocomplete='off' /></td>"+
							"<td><input id='Cantidad"+idMov+"' name='Cantidad"+idMov+"' "+
				                  "onChange='calcularValores(this,"+costII+")' "+
								  "type='text' style='text-align: right; width: 100%; height: 25px;' autocomplete='off' "+
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
	
	function EliminarFilafp (r){
		var i = (r.parentNode.parentNode.rowIndex)-2;
		console.log(i)
		
		/*var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
		var ValTemp = document.getElementById("txtSubtotalVenta").innerHTML;
		var TotRedu = document.getElementById("totalMovimiento"+id).value;
		    ValTemp = ValTemp - TotRedu;
			var n = parseFloat(ValTemp).toFixed(6);
			document.getElementById("txtSubtotalVenta").innerHTML = n;*/
		document.getElementById("tBodyFormaPago").deleteRow(i);
		/*calculaRetenciones();*/
		calculaValoresFP();
	}
	
	function zeroPad(num, places) {
	  var zero = places - num.toString().length + 1;
	  return Array(+(zero > 0 && zero)).join("0") + num;
	}
	
	function calcularValores(r,val){
		var i = r.parentNode.parentNode.rowIndex;
		var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
		var promoDs = document.getElementById("tableMovimientos").rows[i].cells[5].innerHTML;
		var ValTemp = document.getElementById("txtSubtotalVenta").innerHTML;
		var TotRedu = document.getElementById("totalMovimiento"+id).value;
		var CantMov = document.getElementById("Cantidad"+id).value;
		var CostMov = document.getElementById("costoMovimiento"+id).value;
		var DescMov = document.getElementById("descuentoMovimiento"+id).value;
		if (parseFloat(DescMov) > 5){
			DescMov = 5;
		    document.getElementById("descuentoMovimiento"+id).value = 5;}
		if (DescMov == ''){
			DescMov = 0;
		    document.getElementById("descuentoMovimiento"+id).value = '0.00';}
		if (CantMov == ''){
			CantMov = 0;}
		if (parseFloat(CostMov) < val || CostMov == ''){
			//console.log(document.getElementById("costoMovimiento"+id).value +' * '+ val + ' * ' + CostMov)
			CostMov = val;
			document.getElementById("costoMovimiento"+id).value = val;}
		
		if (document.getElementById("idVentaSinStock"+id).innerHTML){
			console.log(CantMov+' *** '+document.getElementById("tableMovimientos").rows[i].cells[3].innerHTML)
			}
		
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
				 var rs = retencion.indexOf(document.getElementById("tableMovimientos").rows[i].cells[11].innerHTML);
				 var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
				 
				if (document.getElementById("tableMovimientos").rows[i].cells[14].innerHTML == 0){
					 iva0 = iva0 + parseFloat(document.getElementById("totalMovimiento"+id).value);
					 vIVA = 0;
				     }else{iva12 = iva12 + parseFloat(document.getElementById("totalMovimiento"+id).value);
						   vIVA = document.getElementById('iVAPorcentaje').innerHTML;}
				
				if (rs == -1){
					 retencion.push(document.getElementById("tableMovimientos").rows[i].cells[11].innerHTML);
					 var tRetencion = { };
					     tRetencion[0] = document.getElementById("tableMovimientos").rows[i].cells[11].innerHTML;
					     tRetencion[1] = document.getElementById("tableMovimientos").rows[i].cells[12].innerHTML;
					     tRetencion[2] = document.getElementById("tableMovimientos").rows[i].cells[13].innerHTML;
					     tRetencion[3] = parseFloat(document.getElementById("totalMovimiento"+id).value)*vIVA/100;
					     tRetencion[4] = document.getElementById("totalMovimiento"+id).value;
					 	 tRetencion[5] = document.getElementById("totalMovimiento"+id).value;
					 tablaRetencion.push(tRetencion);
					 j++;
				 	 }else{	
					 		tablaRetencion[rs][3] = parseFloat(tablaRetencion[rs][3]) 
													+ (parseFloat(document.getElementById("totalMovimiento"+id).value)*vIVA/100);
						    tablaRetencion[rs][4] = parseFloat(tablaRetencion[rs][4]) 
													+ parseFloat(document.getElementById("totalMovimiento"+id).value);
						    tablaRetencion[rs][5] = parseFloat(tablaRetencion[rs][5]) 
													+ parseFloat(document.getElementById("totalMovimiento"+id).value);
					 }
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
				
				n1 = parseFloat(document.getElementById("txtTotalIVA12").innerHTML)+
					 parseFloat(document.getElementById("txtSubtotalVenta").innerHTML);
		        n1 = n1.toFixed(2);
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
					    tbl = tbl+'<tr style="font-weight: 100;">'+
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
				tbl =tbl+'<td colspan="3" style="padding: 0px;">TOTAL</td>'+
						 '<td id="txtTotalRetencion" style="padding: 0px; text-align: right;">'+acumRet.toFixed(2)+'</td></table>';
				document.getElementById("retencionDetalle").innerHTML = tbl; 
				//console.log(tablaRetencion)
	}
	
	function mostrarCargaArchivos(){
		document.getElementById("modalArchivosFacturas").style.display = 'block';
	}
	
	function cerrarModalArchivos(){
		document.getElementById("modalArchivosFacturas").style.display = 'none';
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
					 '&detalleProd='+detalleProd+'&idFabricante='+idFabricante+'&idPresentacion='+idPresentacion+
				     '&chkGrabaIVA='+chkGrabaIVA+'&chkVentaSStock='+chkVentaSStock+'&precioCosto='+precioCosto+
				     '&porcentajeMin='+porcentajeMin,
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
				data:'tipoCliente='+tipoCliente+'&categCliente='+categCliente+'&tipoIdentCli='+tipoIdentCli+
				'&numIdentific='+numIdentific+'&nombreClient='+nombreClient+'&direccionCli='+direccionCli+
				'&telefonoClie='+telefonoClie+'&emailCliente='+emailCliente,
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
			parent. modalAlertPrincipal(1, 'MarketSys', 'Para proceder con el registro de su compra es necesario, '+
										                'que se seleccione un cliente, si el cliente no se encuentra registrado, '+
														'proceda a crear uno nuevo.', 0, 'Aceptar', '')
			parent.document.getElementById('divLoadding').style.display = 'none';
			return 0;
		    }else{
			if (document.getElementById("formasPagoFactura").value == '0'){
				parent. modalAlertPrincipal(1, 'MarketSys', 'Para proceder con el registro de la compra es necesario, '+
															'que se seleccione una forma de pago.', 0, 'Aceptar', '')
				parent.document.getElementById('divLoadding').style.display = 'none';
				return 0;
			}else 
			  if(document.getElementById("formasPagoFactura").value == '-1'){
				 if (document.getElementById("sumaMultiplePago").value != document.getElementById("montoTotalPagar").innerHTML){
						  parent. modalAlertPrincipal(1, 'MarketSys', 'Para proceder con el registro de la compra es necesario, '+
																	  'que los valores de la compra, sean igual a los escogidos '+
													                  'en las formas de pago.', 0, 'Aceptar', '')
							parent.document.getElementById('divLoadding').style.display = 'none';
							return 0;
							}	
						}
				
				if (parseFloat(document.getElementById("txtTotalVenta").value) == 0){
					parent. modalAlertPrincipal(1, 'MarketSys', 'Para proceder con el registro de la compra es necesario, '+
													'que esta pueda tener rubros y valores seleccionados.', 0, 'Aceptar', '')
					parent.document.getElementById('divLoadding').style.display = 'none';
					return 0;
					}	
			
			if (document.getElementById("idCategoriaCliente").value == 0){
				parent. modalAlertPrincipal(1, 'MarketSys', 'Para proceder seleccione una categoria de cliente, '+
															'para el cliente registrado.', 0, 'Aceptar', '')
				parent.document.getElementById('divLoadding').style.display = 'none';
				return 0;
				}
			
			if (document.getElementById("idTipoCliente").value == 0){
				parent. modalAlertPrincipal(1, 'MarketSys', 'Para proceder seleccione un tipo de cliente, '+
															'para el cliente registrado.', 0, 'Aceptar', '')
				parent.document.getElementById('divLoadding').style.display = 'none';
				return 0;
				}
				
			var tableReg = document.getElementById('tableMovimientos');
				for (var i = 2; i < tableReg.rows.length-1; i++)
				{let idMovi = tableReg.rows[i].cells[0].innerHTML;
				 let idCuenta = document.getElementById("idCuenta"+idMovi).value;
				 let retenIVA = document.getElementById("rtIva"+idMovi).value;
				 let retenRet = document.getElementById("rtRen"+idMovi).value;

				 if (idCuenta == 0){
					 parent. modalAlertPrincipal(1, 'MarketSys', 'Existe un detalle de la compra sin registrar su cuenta contable, '+
															     'Verifique para poder continuar.', 0, 'Aceptar', '')
				     parent.document.getElementById('divLoadding').style.display = 'none';
				     return 0;
				     }
				 
				 }

			/*** Creación de Cliente ***/	
			var inicio = 0;
			var d = new Date();
				/*** Información Cliente ***/
				var idCliente 		 = document.getElementById('idCliente').value;
				var cliente          = document.getElementById('cliente').value; 
				var idCategoria 	 = document.getElementById('idCategoriaCliente').value;
				var idTipoCliente 	 = document.getElementById('idTipoCliente').value;
				var identificacion 	 = document.getElementById('identificacion').value;
				var nombreComercial  = document.getElementById('nombreComercial').value;
				var direccionCliente = document.getElementById('direccion').value;
				var fileXML 		 = document.getElementById('fileXML').value;
				var filePDF 		 = document.getElementById('filePDF').value;
				
				/*** Información Compra ***/
				let tipoFactura = 0;
				if (document.getElementById('tipoFactura').value == 'MANUAL'){
					tipoFactura = 0;
				    }else{tipoFactura = 1;}
				var txtAplicaRet	 = 0;
				if (document.getElementById('chkRetenciones').checked == true){
					txtAplicaRet	 = 1;}
				var fechaFactura 	  = document.getElementById('fechaFactura').value;
				var numFactura 		  = document.getElementById('numFactura').value;
				var numEstablecimiento= document.getElementById('numFacturaEstablecimiento').value;
				var numPuntoEmision   = document.getElementById('numFacturaPuntoEmision').value;	
				var numAutorizacion   = document.getElementById('numAutorizacion').value;
				var txtSubtotalVenta  = document.getElementById('txtSubtotalVenta').innerHTML;
				var txtDescuentoVenta = document.getElementById('txtDescuentoVenta').innerHTML;
				var txtVTotalIVA0 	  = document.getElementById('txtVTotalIVA0').innerHTML;
				var iVAPorcentaje 	  = document.getElementById('iVAPorcentaje').innerHTML;
				var txtVTotalIVA12 	  = document.getElementById('txtVTotalIVA12').innerHTML;
				var txtTotalIVA12 	  = document.getElementById('txtTotalIVA12').innerHTML;
				var txtTotalVenta 	  = document.getElementById('txtTotalVenta').innerHTML;
				
				if (document.getElementById('chkRetenciones').checked == true){
					txtAplicaRet = 1;
					}
				var txtRetencion	  = document.getElementById('txtTotalRetenciones').innerHTML;
				
			idProforma = 0;	
			var idFactura = 0;	
			$.ajax({type:'POST',
					url:'../php/registroCompra.php',
					data: 'idCliente='+idCliente+'&idCategoria='+idCategoria+'&idTipoCliente='+idTipoCliente+
					      '&identificacion='+identificacion+'&nombreComercial='+nombreComercial+
					      '&direccionCliente='+direccionCliente+'&cliente='+cliente+'&tipoFactura='+tipoFactura+
					      '&fechaFactura='+fechaFactura+'&numFactura='+numFactura+'&numAutorizacion='+numAutorizacion+
					      '&txtSubtotalVenta='+txtSubtotalVenta+'&txtDescuentoVenta'+txtDescuentoVenta+
					      '&txtVTotalIVA0='+txtVTotalIVA0+'&iVAPorcentaje='+iVAPorcentaje+'&txtVTotalIVA12='+txtVTotalIVA12+
					      '&txtTotalIVA12='+txtTotalIVA12+'&txtTotalVenta='+txtTotalVenta+'&txtRetencion='+txtRetencion+
					      '&txtAplicaRet='+txtAplicaRet+'&numEstablecimiento='+numEstablecimiento+
					      '&numPuntoEmision='+numPuntoEmision+'&fileXML='+fileXML+'&filePDF='+filePDF,
					success:function(data){
						    info = eval(data);
						    if(info[0] == '-2'){
							   parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									   'Se ha presentando un error, comuniquese con el administrador. ERROR:['+info[1]+']', 0, 
									   'Aceptar', '');
									   parent.document.getElementById('divLoadding').style.display = 'none';
								       return;
							  }
							if(info[2] == '1'){
							   parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									   'La factura de compra, ya se encuentra registrada. ', 0, 
									   'Aceptar', '');
									   parent.document.getElementById('divLoadding').style.display = 'none';
								       return;
							  }
						    
						    idFactura = info[0];
						    var idProveedor = info[3];
						    var tableReg = document.getElementById('tableMovimientos');
						    var idRetenc = 0;
                            
							/** registra retención compra**/
							if (document.getElementById('chkRetenciones').checked == true){
						        var montoRetencion = document.getElementById("txtTotalRetenciones").innerHTML;
								$.ajax({type:'POST',
										url:'../php/registraRetencionesCompra.php',
										async: false,
										data:'idFactura='+idFactura+'&montoRetencion='+montoRetencion,
										success:function(data){
												info = eval(data);
												idRetenc = info[0];}
									   });
							}
						     
							/** registra pago **/
						    var idPago = 0;
							var monto 		= document.getElementById("txtTotalVenta").innerHTML;
						 	var retencion 	= document.getElementById("txtTotalRetenciones").innerHTML;
							var saldo 		= document.getElementById("montoTotalPagar").innerHTML;
							$.ajax({type:'POST',
									url:'../php/registraPagoCompras.php',
									async: false,
									data:'idFactura='+idFactura+'&monto='+monto+'&retencion='+retencion+'&saldo='+saldo,
									success:function(data){
										info = eval(data);
										idPago = info[0];}
								   });
							

							 for (var i = 2; i < tableReg.rows.length-1; i++)
								 {if (i == 2){inicio = 1; d = d.getTime();}else{inicio = 0;}
								  var idMovi = tableReg.rows[i].cells[0].innerHTML;
								  
								  var secuencia = document.getElementById("sc"+idMovi).innerHTML;
								  var codigoPro = document.getElementById("cp"+idMovi).innerHTML;
								  var idCuenta  = document.getElementById("idCuenta"+idMovi).value;
								  var descriPro = document.getElementById("dp"+idMovi).innerHTML;
								  var cantidadP = document.getElementById("ct"+idMovi).innerHTML;
								  var precioUni = document.getElementById("pu"+idMovi).innerHTML;
								  var descuento = document.getElementById("ds"+idMovi).innerHTML;
								  var ivaLineaC = document.getElementById("il"+idMovi).innerHTML;
								  var previoVta = document.getElementById("pv"+idMovi).innerHTML;
								  
								  /** Registra Detalle Factura **/
								  $.ajax({type:'POST',
										  url:'../php/registroDetalleCompra.php',
										  async: false,
										  data:'idFactura='+idFactura+'&idMovi='+idMovi+
										  '&secuencia='+secuencia+'&codigoPro='+codigoPro+'&descriPro='+descriPro+
										  '&cantidadP='+cantidadP+'&precioUni='+precioUni+'&descuento='+descuento+
										  '&ivaLineaC='+ivaLineaC+'&previoVta='+previoVta+'&i='+i+'&ctaContab='+idCuenta,
										  success:function(data){}
										 });
								  
								  /** Registra Información Rubro **/
								  var idCuenta = document.getElementById("idCuenta"+idMovi).value;
								  var retenIVA = document.getElementById("rtIva"+idMovi).value;
								  var retenRet = document.getElementById("rtRen"+idMovi).value;
								  
								  $.ajax({type:'POST',
										  url:'../php/registraInformacionCompra.php',
										  async: false,
										  data:'idProveedor='+idProveedor+'&codigoPro='+codigoPro+
										  	   '&idCuenta='+idCuenta+'&retenIVA='+retenIVA+
										       '&retenRet='+retenRet,
										  success:function(data){}
										 });	
								  
								if (document.getElementById('chkRetenciones').checked == true){
								/** registra retención renta**/
									var baseRet = document.getElementById("pv"+idMovi).innerHTML;
									var valorRet = document.getElementById("vr"+idMovi).innerHTML;
									$.ajax({type:'POST',
											  url:'../php/registraDetalleRetencionesCompra.php',
											  async: false,
											  data:'idFactura='+idRetenc+'&codigoPro='+codigoPro+'&idMovi='+idMovi+
												   '&tipoRet=1&retenRet='+retenRet+'&baseRet='+baseRet+'&valorRet='+valorRet,
											  success:function(data){}
											 });

									/** registra retención iva **/
									var baseRet = document.getElementById("il"+idMovi).innerHTML;
									var valorRet = document.getElementById("ir"+idMovi).innerHTML;
									$.ajax({type:'POST',
											  url:'../php/registraDetalleRetencionesCompra.php',
											  async: false,
											  data:'idFactura='+idRetenc+'&codigoPro='+codigoPro+'&idMovi='+idMovi+
												   '&tipoRet=2&retenRet='+retenIVA+'&baseRet='+baseRet+'&valorRet='+valorRet,
											  success:function(data){}
											 });  
								}	
							}
							
							// alert(parseInt(document.getElementById("formasPagoFactura").value));
							if (parseInt(document.getElementById("formasPagoFactura").value) == '-1'){
								var tableFormaPago = document.getElementById('tBodyFormaPago');
								for (var i = 0; i < tableFormaPago.rows.length; i++){
									 idMovi = tableFormaPago.rows[i].cells[0].innerHTML;
									 console.log(idMovi);
									 console.log(document.getElementById("forpagMul"+idMovi).value);
									 
									  var forpagMul 	= document.getElementById("forpagMul"+idMovi).value;
									  var nroFormaPago 	= document.getElementById("nroFormaPago"+idMovi).value;
									  var fFormaPago 	= document.getElementById("fFormaPago"+idMovi).value;
									  var mFormaPago 	= document.getElementById("mFormaPago"+idMovi).value;

									  $.ajax({type:'POST',
											  url:'../php/registraDetallePagoCompra.php',
											  async: false,
											  data:'idPago='+idPago+'&forpagMul='+forpagMul+'&nroFormaPago='+nroFormaPago+
											  '&fFormaPago='+fFormaPago+'&mFormaPago='+mFormaPago,
											  success:function(data){}
											 });  

									 }
								}else{var forpagMul 	= document.getElementById("formasPagoFactura").value;
									  var nroFormaPago 	= '';
									  var fFormaPago 	= '';
									  var mFormaPago 	= parseFloat(document.getElementById("montoTotalPagar").innerHTML); 
									  $.ajax({type:'POST',
											  url:'../php/registraDetallePagoCompra.php',
											  async: false,
											  data:'idPago='+idPago+'&forpagMul='+forpagMul+'&nroFormaPago='+nroFormaPago+
											  '&fFormaPago='+fFormaPago+'&mFormaPago='+mFormaPago,
											  success:function(data){}
											 });}
		
							/** Registra Asiento Contable Compra **/
						    let txtTotalRetenciones = document.getElementById("txtTotalRetenciones").innerHTML;
						    let txtTotalVenta 		= document.getElementById("txtTotalVenta").innerHTML;
						    var montoTotalPagar 	= parseFloat(txtTotalVenta) - parseFloat(txtTotalRetenciones);
						
							$.ajax({type:'POST',
									url:'../php/registraAsientoContableCompra.php',
									async: false,
									data:'idFactura='+idFactura+'&montoTotalPagar='+montoTotalPagar,
									success:function(data){}
								   });
						
							/** Registra Asiento Contable Pago Compra **/
							$.ajax({type:'POST',
									url:'../php/registraAsientoContablePagoCompra.php',
									async: false,
									data:'idFactura='+idFactura+'&idPago='+idPago,
									success:function(data){}
								   });
							
						    if (document.getElementById("chkRetenciones").checked == true){
							    registraFacturaElectronica(idFactura, idRetenc);
							 	}else{
									location.reload();
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
			data:'id='+idFormaPago+'&tipoMovimiento='+tipoMovimiento+'&idFactura='+idFactura+
			'&idTrx='+idTrx+'&monto='+movimientoBancario,
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
	
	function registraFacturaElectronica(idFactura,idRetenc){
		var url = '../php/generaRetencionElectronica.php';
		$.ajax({
			type:'GET',
			url:url,
			async: false,
			data:'idfactura='+idFactura,
			success:function(data){
				data = eval(data);
				obtenerComprobanteFirmado_sri_rt(idFactura,data[4],atob(data[2]),data[6], data[5],data[3],idRetenc);
				
				parent. modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', 
													'Su compra ha sido registrada de manera correcta.', 0, 
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
	
	function procesarXML(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			  informacionFactura(this);
				//informacionFactura(this)
				parent.document.getElementById('divLoadding').style.display = 'none';
				
							  
			}
		  };
		  xmlhttp.open("GET", "../respaldos_compras/xml/"+document.getElementById('fileXML').value, true);
		  xmlhttp.send();
		
		document.getElementById("modalArchivosFacturas").style.display = 'none';
		
	}
	
	function informacionFactura(xml) {
	   var x, i, xmlDoc, txt, ini, fin;
	   /*** Transformar XML to String ***/
		
		xmlDoc = xml.responseXML;
		x = new XMLSerializer().serializeToString(xmlDoc);
		  ini = x.indexOf("<![CDATA[");
		  fin = x.indexOf("]]>");
		  x = x.substring(ini, fin);
		  txt = x.replace("<![CDATA[", "").replace("]]>", "");
		    
		  /*** Transformar String to XML ***/
		    	parser = new DOMParser();
				xmlDoc = parser.parseFromString(txt,"text/xml");

		  /*** Información de Factura ***/
		  txt = "";					  
		  x = xmlDoc.getElementsByTagName("razonSocial");
			  for(i = 0; i< x.length; i++) {txt = x[i].childNodes[0].nodeValue;}
			  	  document.getElementById('cliente').value = txt.toUpperCase();
		
		  txt = "";					  
		  x = xmlDoc.getElementsByTagName("nombreComercial");
		      for(i = 0; i< x.length; i++) {txt = x[i].childNodes[0].nodeValue;}
			      document.getElementById('nombreComercial').value = txt.toUpperCase();
			
		  txt = "";
		  x = xmlDoc.getElementsByTagName("ruc");
		      for(i = 0; i< x.length; i++) {txt = x[i].childNodes[0].nodeValue;}
		          document.getElementById('identificacion').value = txt.toUpperCase();
				  identificacion = document.getElementById('identificacion').value;
				  var url = '../../lib/php/busquedaProveedor.php';
					$.ajax({
						type:'POST',
						url:url,
						async: false,
						data:'identificacion='+identificacion,
						success:function(data){ 
							datos = eval(data);
							  datos = eval(datos[0]);
								document.getElementById('idCliente').value = datos[0];
								document.getElementById('idTipoCliente').value = datos[2];
								document.getElementById('idCategoriaCliente').value = datos[1];
							    document.getElementById('saldoDeudaCliente').innerHTML = datos[3];
							    document.getElementById('vencimiento').innerHTML = datos[4];
						}
					});
		
		  txt = "";
		  x = xmlDoc.getElementsByTagName("dirEstablecimiento");
		      for(i = 0; i< x.length; i++) {txt = x[i].childNodes[0].nodeValue;}
			      document.getElementById('direccion').value = txt.toUpperCase();	
		
		  txt = "";
		  x = xmlDoc.getElementsByTagName("secuencial");
		      for(i = 0; i< x.length; i++) {txt = x[i].childNodes[0].nodeValue;}
			      document.getElementById('numFactura').value = txt.toUpperCase();	
		
		 txt = "";
		  x = xmlDoc.getElementsByTagName("estab");
		      for(i = 0; i< x.length; i++) {txt = x[i].childNodes[0].nodeValue;}
			      document.getElementById('numFacturaEstablecimiento').value = txt.toUpperCase();
		
        txt = "";
		  x = xmlDoc.getElementsByTagName("ptoEmi");
		      for(i = 0; i< x.length; i++) {txt = x[i].childNodes[0].nodeValue;}
			      document.getElementById('numFacturaPuntoEmision').value = txt.toUpperCase();
						 
									 
		  txt = "";
		  x = xmlDoc.getElementsByTagName("claveAcceso");
		      for(i = 0; i< x.length; i++) {txt = x[i].childNodes[0].nodeValue;}
			      document.getElementById('numAutorizacion').value = txt.toUpperCase();	
		          var url = '../../lib/php/busquedaFacturaExiste.php';
					$.ajax({
						type:'POST',
						url:url,
						data:'numeroAutorizacion='+document.getElementById('numAutorizacion').value+
                             '&numFactura='+document.getElementById('numFactura').value,
						success:function(data){ 
							datos = eval(data);
							datos = eval(datos[0]);
							    if (datos[0] == '1'){
									parent.parent.document.getElementById("divLoadding").style.display = 'none';
									parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									                     'La factura de compra, ya se encuentra registrada. ', 0, 
									                     'Aceptar', '');
									location.reload();
								}
						}
					});
		
			      document.getElementById('tipoFactura').value = 'ELECTRÓNICA';
		  
	      /*** Detalles de Factura ***/	
		  var tabla = '';
          x = xmlDoc.getElementsByTagName("detalle");
		      for(i = 0; i< x.length; i++) {
				  let sec = parseInt(i) + 1;
				  
				  let dXML = xmlDoc.getElementsByTagName("detalle")[i];
				  
				  let cod = 0;
				  if (dXML.getElementsByTagName("codigoPrincipal").length > 0) {
				      cod = dXML.getElementsByTagName("codigoPrincipal")[0].childNodes[0].nodeValue;}
				      else{cod = i;}
				      //document.getElementById('txtTotalVenta').innerHTML = total; 
					  //document.getElementById('montoTotalPagar').innerHTML = total;
				  
				  let des = dXML.getElementsByTagName("descripcion")[0].childNodes[0].nodeValue;
				  let cnt = dXML.getElementsByTagName("cantidad")[0].childNodes[0].nodeValue;
				  let pun = dXML.getElementsByTagName("precioUnitario")[0].childNodes[0].nodeValue;
				  let dct = dXML.getElementsByTagName("descuento")[0].childNodes[0].nodeValue;
				  let psi = dXML.getElementsByTagName("precioTotalSinImpuesto")[0].childNodes[0].nodeValue;
				  
				  
				  let iXML = dXML.getElementsByTagName("impuestos")[0];
				  let tim  = iXML.getElementsByTagName("valor")[0].childNodes[0].nodeValue;
				  let tar  = iXML.getElementsByTagName("tarifa")[0].childNodes[0].nodeValue;
				  let bas  = iXML.getElementsByTagName("baseImponible")[0].childNodes[0].nodeValue;
				  	  if (tim == 0){
				  	  	  tim  = parseFloat(tar)*parseFloat(bas)/100;
						  tim  = parseFloat(tim);
				  		  tim  = tim.toFixed(2);
					  	  }
				  
				  tabla = tabla+'<tr><td id="sc'+sec+'" style="text-align: center;">'+sec+
					  			'</td><td id="cp'+sec+'" style="text-align: center;">'+cod+
					  			'</td><td id="dp'+sec+'" style="text-align: left;">'+des+
					            '</td><td id="cn'+sec+'" style="text-align: right;">'+
					              '<input id="idCuenta'+sec+'" type="text" style="display: none;"/>'+
					              '<input id="item'+sec+'" name="item'+sec+'" class="required" type="text" '+
											   'style="width: 100%; height: 26px;"/>'+
					  			'</td><td id="ct'+sec+'" style="text-align: right;">'+cnt+
					  			'</td><td id="pu'+sec+'" style="text-align: right;">'+pun+
					  			'</td><td id="ds'+sec+'" style="text-align: right;">'+dct+
					            '</td><td id="il'+sec+'" style="text-align: right;">'+tim+    
					            '</td><td id="pv'+sec+'" style="text-align: right;">'+psi+
					            '</td><td style="text-align: right;">'+
					             '<select id="rtIva'+sec+'" style="color: royalblue; width: 100%; font-size: 12px; border: none;" '+
									 'onChange="calculaRetIva(this,'+sec+','+tim+')"></select>'+
								'</td><td id="ir'+sec+'" style="text-align: right;">0.00'+
								'</td><td style="text-align: right;">'+
					              '<select id="rtRen'+sec+'" style="color: royalblue; width: 100%; font-size: 12px; border: none;" '+
									 'onChange="calculaRetRet(this,'+sec+','+psi+')"></select>'+
					            '</td><td id="vr'+sec+'" style="text-align: right;">0.00</td></tr>';	 
				  }
			      
				document.getElementById('tablaAperturaBody').innerHTML = tabla;
		
		        x = xmlDoc.getElementsByTagName("detalle");
				for(i = 0; i< x.length; i++) {
					let sec = parseInt(i) + 1;
					
					let cmbRetRet = new componente.cmb;
						cmbRetRet.ini('rtRen'+sec);
						cmbRetRet.loadFromUrlAd('../cmb/cmbTscRetencionesCompraRenta.php');
                   
					let cmbRetIva = new componente.cmb; 
						cmbRetIva.ini('rtIva'+sec);
						cmbRetIva.loadFromUrlAd('../cmb/cmbTscRetencionesCompraIVA.php');
					 
					var url = '../../lib/cmb/cmbTfnCatalogoAutocomplete.php';
						$.ajax({
							type:'POST',
							url:url,
							data:'id=1',
							success:function(data){
								$( "#item"+sec ).autocomplete({
								  source: eval(data)
								});
								$( "#item"+sec ).on( "autocompleteselect", function( event, ui ) {
									document.getElementById('idCuenta'+sec).value = ui.item[2];
									//document.getElementById('idCuenta').value = ui.item[2];
									//document.getElementById('codigoCuenta').value = ui.item[3];
									//document.getElementById('descripcionCuenta').value = ui.item[4];
								});

							}
						});
						
				}
		
		
			  x = xmlDoc.getElementsByTagName("totalImpuesto");
		      for(i = 0; i< x.length; i++) {
				  let dXML = xmlDoc.getElementsByTagName("totalImpuesto")[i];
				  let cod = dXML.getElementsByTagName("codigoPorcentaje")[0].childNodes[0].nodeValue;
				  if (cod == 0){
					  let valor = dXML.getElementsByTagName("baseImponible")[0].childNodes[0].nodeValue;
					      document.getElementById('txtVTotalIVA0').innerHTML = valor;
				     }
				  if (cod == 2){
					  let valor = dXML.getElementsByTagName("baseImponible")[0].childNodes[0].nodeValue;
					      document.getElementById('txtVTotalIVA12').innerHTML = valor;
					  let monto = dXML.getElementsByTagName("valor")[0].childNodes[0].nodeValue;
					  	  document.getElementById('txtTotalIVA12').innerHTML = monto;
				     }	 
				  }
				
				let subtotal = 0;
				if (xmlDoc.getElementsByTagName("totalSinImpuestos").length > 0) {
				    subtotal = xmlDoc.getElementsByTagName("totalSinImpuestos")[0].childNodes[0].nodeValue;}
				    document.getElementById('txtSubtotalVenta').innerHTML = subtotal;
					
		
				let descuento = 0;
				if (xmlDoc.getElementsByTagName("totalDescuento").length > 0) {
				    descuento = xmlDoc.getElementsByTagName("totalDescuento")[0].childNodes[0].nodeValue;}
				    document.getElementById('txtDescuentoVenta').innerHTML = descuento;
		
		        let total = 0;
		        if (xmlDoc.getElementsByTagName("importeTotal").length > 0) {
				    total = xmlDoc.getElementsByTagName("importeTotal")[0].childNodes[0].nodeValue;}
				    document.getElementById('txtTotalVenta').innerHTML = total; 
					document.getElementById('montoTotalPagar').innerHTML = total;
		
		        let fecha = xmlDoc.getElementsByTagName("fechaEmision")[0].childNodes[0].nodeValue;
					document.getElementById('fechaFactura').value = fecha;
					
					fechaActual = moment(Date.now());
					fechaCompra = moment(fecha, "DD-MM-YYYY");
					diasCompra  = fechaActual.diff(fechaCompra, 'days')
					if (diasCompra > 5){
						$('#chkRetenciones').bootstrapToggle('off');
						}else{$('#chkRetenciones').bootstrapToggle('on');}
									 
								
		//console.log(alert(datediff(parseDate(date), parseDate(Date()))));
								
		
									 
				x = xmlDoc.getElementsByTagName("detalle");
				for(i = 0; i< x.length; i++) {
					let sec = parseInt(i) + 1;
					var url = '../../lib/php/retornaInformacionRubro.php';
					  
					  let cod = document.getElementById('cp'+sec).innerHTML;
					
					  let idCuentaContable 	= 0;
					  let idRetencionIva 	= 0;
					  let idRetencionRenta 	= 0;
					  let cuentaContable 	= '';
						$.ajax({
							type:'POST',
							url:url,
							data:'idcl='+document.getElementById('idCliente').value+
								 '&idpr='+cod,
							success:function(data){ 
								datos = eval(data);
								//datos = eval(datos[0]);
								   idCuentaContable = datos[0];
								   idRetencionIva   = datos[1];
								   idRetencionRenta = datos[2];
								   cuentaContable 	= datos[3];
								
								    document.getElementById('rtRen'+sec).value = idRetencionRenta;
								    calculaRetRet(document.getElementById('rtRen'+sec), sec, 
												  document.getElementById('pv'+sec).innerHTML)
								
					    			document.getElementById('rtIva'+sec).value = idRetencionIva;
								    calculaRetIva(document.getElementById('rtIva'+sec), sec, 
												  document.getElementById('il'+sec).innerHTML)
								
								    document.getElementById('idCuenta'+sec).value = idCuentaContable;
					    			document.getElementById('item'+sec).value = cuentaContable;
							}
						});					
						
				}						 

		}
	
	function parseDate(str) {
		var mdy = str.split('/');
		return new Date(mdy[2], mdy[0]-1, mdy[1]);
	}

	function datediff(first, second) {
		// Take the difference between the dates and divide by milliseconds per day.
		// Round to nearest whole number to deal with DST.
		return Math.round((second-first)/(1000*60*60*24));
	}

		

	function calculaRetRet(elem, id, pventa){
		//console.log(elem +' * '+elem.value +' * '+ id +' * '+ pventa)
		if (elem.value == 0){
			document.getElementById('vr'+id).innerHTML = '0.00';
			document.getElementById('rtRen'+id).style.color = 'royalblue';
		}else{
			porceRet = $('option:selected', elem).attr('codigo');
		    //console.log(porceRet);
			valorRet = parseFloat(porceRet)*parseFloat(pventa)/100;
			//console.log(valorRet);
		    valorRet = valorRet.toFixed(2);
		    document.getElementById('vr'+id).innerHTML = valorRet;
			document.getElementById('rtRen'+id).style.color = 'black';}
		
		sumarRetRenta();
	}
	
	function calculaRetIva(elem, id, pventa){
		//console.log(elem +' * '+elem.value +' * '+ id +' * '+ pventa)
		if (elem.value == 0){
			document.getElementById('ir'+id).innerHTML = '0.00';
			document.getElementById('rtIva'+id).style.color = 'royalblue';
		}else{
			porceRet = $('option:selected', elem).attr('codigo');
			valorRet = parseFloat(porceRet)*parseFloat(pventa)/100;
			valorRet = valorRet.toFixed(2);
			document.getElementById('ir'+id).innerHTML = valorRet;
			document.getElementById('rtIva'+id).style.color = 'black';}
		
		sumarRetIva();
		
	}
	
	function calculaValoresFP(){
		tableReg = document.getElementById('tBodyFormaPago');
		acum = 0;
		for(i = 0; i< tableReg.rows.length; i++) {
			n = tableReg.rows[i].cells[0].innerHTML;
			  m = document.getElementById("mFormaPago"+n).value;
			  m = parseFloat(m);
			      document.getElementById("mFormaPago"+n).value = m.toFixed(2);
			acum = acum + parseFloat(m)
			}
		acum = parseFloat(acum);
		document.getElementById("sumaMultiplePago").value = acum.toFixed(2);
		nvalor = parseFloat(document.getElementById("montoTotalPagar").innerHTML) - acum;
		nvalor = parseFloat(nvalor);
		document.getElementById("sumaCopiaRetenciones").value = nvalor.toFixed(2);
		
	}	

	function anadirFormaPagoMultiple(){
		tableReg = document.getElementById('tBodyFormaPago');
		idx = tableReg.rows.length + 1;
		idx = document.getElementById('secFP').innerHTML;
		ifp = document.getElementById("formasPagoFacturaMultiple").value;
		sel = document.getElementById("formasPagoFacturaMultiple");
		ofp = $('option:selected', sel ).attr('value');
		if (ifp != 0){
			//dfp = sel.options[sel.selectedIndex].text
			//dfp = $('option:selected', ).attr('codigo');
			var markup = "<tr style='color: #000; border-bottom: 1px solid #ddd;' name='FPP"+idx+"'>"+
							"<td style='text-align: right; width: 15px;'>"+idx+"</td>"+
							"<td style='display: none;'>"+ifp+"</td>"+
							"<td style='text-align: right; width: 200px;'>"+
							  "<select id='forpagMul"+idx+"' style='color: royalblue; width: 100%; font-size: 12px; border: none;' "+
								 "></select></td>"+
				  			"<td style='text-align: right; width: 80px;'>"+
							  "<input id='nroFormaPago"+idx+"' name='nroFormaPago"+idx+"' class='required' "+
								"type='text' style='text-align: right; width: 80px; height: 25px; border: none;' /></td>"+
							"<td style='text-align: right;'>"+
							    "<input id='fFormaPago"+idx+"' name='fFormaPago"+idx+"' value='<?php echo date("d/m/Y")?>' "+
								"class='required' type='text' style='text-align: right; width: 80px; height: 25px; border: none;' "+
								"onkeypress='return filterFloat(event,this);'/></td>"+
							 "<td style='padding-left: 10px; text-align: right;'>"+
				                "<input id='mFormaPago"+idx+"' name='mFormaPago"+idx+"' value='0.00' "+
								"class='required' type='text' style='text-align: right; width: 60px; height: 25px; border: none;' "+
								"onkeypress='return filterFloat(event,this);' ondblclick='limpiarValor(this)' "+
				 				"onChange='calculaValoresFP();'/></td>"+
							"<td style='width: 26px'>"+
								"<button type='button' style='width: 100%;' class='delete-row' onClick='EliminarFilafp(this);'>"+
								"<img src='../images/icons/clear.png' style='height: 18px;' alt=''/>"+
								"</button></td></tr>";

			document.getElementById("formasPagoFacturaMultiple").value = 0;
			document.getElementById('secFP').innerHTML = parseInt(idx) + 1;
			
				$("#tBodyFormaPago").append(markup);
				
				let cmbFormasPagoM = new componente.cmb; 
					cmbFormasPagoM.ini('forpagMul'+idx);
					cmbFormasPagoM.loadFromUrlMod('../cmb/cmbTscFormasPagoMultipleCompras.php',{v: ofp});	
			
				$('#fFormaPago'+idx).datetimepicker({
					dayOfWeekStart : 1,
					timepicker:false,
					format:'d/m/Y',
					formatDate:'Y/m/d'
				});

		}

	}

	function mostrarPagosPersonalizados(){
		document.getElementById("formasPagoFactura").value = '-1';
		document.getElementById("modalMultipleFormaPago").style.display = 'block';
	}
	
	function cancelarPagosPersonalizados(){
		document.getElementById("formasPagoFactura").value = '0';
		document.getElementById("modalMultipleFormaPago").style.display = 'none';
	}	

    function cerrarPagosPersonalizados(){
		if (document.getElementById("sumaMultiplePago").value > document.getElementById("montoTotalPagar").innerHTML){
			parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									       'El monto de la forma de pago, no puede ser mayor al valor a cancelar. ', 0, 
									       'Aceptar', '');
			return;
		}
		if (document.getElementById("sumaMultiplePago").value < document.getElementById("montoTotalPagar").innerHTML){
			parent. modalAlertPrincipal(1, 'MarketSys [Error]', 
									       'El monto de la forma de pago, no puede ser menor al valor a cancelar. ', 0, 
									       'Aceptar', '');
			return;
		}		

		document.getElementById("modalMultipleFormaPago").style.display = 'none';
	}

    function cambioInformacion(elem){
		if (elem.value == -1){mostrarPagosPersonalizados();}
		if (elem.value == 0){
			elem.style.color = 'royalblue';
		}else{
			elem.style.color = 'black';}		
	}
	
	function cambioInfoRetencion(valChk){
		if (valChk == true){
			sumarRetIva();
			sumarRetRenta();
		}else{
			document.getElementById('txtTotalRetenciones').innerHTML = '0.00';
			document.getElementById('montoTotalPagar').innerHTML = document.getElementById('txtTotalVenta').innerHTML;
		
			document.getElementById("sumaCopiaRetenciones").value = '0.00';
		}
	}
	
	function sumarRetIva(){
		tableReg = document.getElementById('tablaAperturaBody');
		   	var sumRet = 0;
				for(i = 0; i< tableReg.rows.length; i++) {
					let sec = parseInt(i) + 1;
					sumRet = sumRet + parseFloat(document.getElementById('ir'+sec).innerHTML);
				}
		
		document.getElementById('txtTotalRetIVA').innerHTML = sumRet.toFixed(2);
		ret = document.getElementById('txtTotalRetRenta').innerHTML;
		x = sumRet + parseFloat(ret);
		document.getElementById('txtTotalRetenciones').innerHTML = x.toFixed(2);
		v = parseFloat(document.getElementById('txtTotalVenta').innerHTML) - x;
		document.getElementById('montoTotalPagar').innerHTML = v.toFixed(2);
		
		document.getElementById("sumaCopiaRetenciones").value = x.toFixed(2);
		
		if (document.getElementById('chkRetenciones').checked == false){
			document.getElementById('txtTotalRetenciones').innerHTML = '0.00';
			document.getElementById('montoTotalPagar').innerHTML = document.getElementById('txtTotalVenta').innerHTML;
		
			document.getElementById("sumaCopiaRetenciones").value = '0.00';
		}
												   
	}
			
	function sumarRetRenta(){
		tableReg = document.getElementById('tablaAperturaBody');
		   	var sumRet = 0;
				for(i = 0; i< tableReg.rows.length; i++) {
					let sec = parseInt(i) + 1;
					sumRet = sumRet + parseFloat(document.getElementById('vr'+sec).innerHTML);
				}
		
		document.getElementById('txtTotalRetRenta').innerHTML = sumRet.toFixed(2);
		ret = document.getElementById('txtTotalRetIVA').innerHTML;
		x = sumRet + parseFloat(ret);
		document.getElementById('txtTotalRetenciones').innerHTML = x.toFixed(2);
		v = parseFloat(document.getElementById('txtTotalVenta').innerHTML) - x;
		document.getElementById('montoTotalPagar').innerHTML = v.toFixed(2);
		
		document.getElementById("sumaCopiaRetenciones").value = x.toFixed(2);
		
		if (document.getElementById('chkRetenciones').checked == false){
			document.getElementById('txtTotalRetenciones').innerHTML = '0.00';
			document.getElementById('montoTotalPagar').innerHTML = document.getElementById('txtTotalVenta').innerHTML;
		
			document.getElementById("sumaCopiaRetenciones").value = '0.00';
		}
		
	}
	
	function informacionFacturaDetalle(xml) {
		  var x, i, xmlDoc, txt;
		  xmlDoc = xml.responseXML;
		  txt = "";
		  x = xmlDoc.getElementsByTagName("nombreComercial");
			  for (i = 0; i< x.length; i++) {
				txt += x[i].childNodes[0].nodeValue;
			  }
			  document.getElementById('cliente').value = txt;
		  
		  x = '';
		  x = xmlDoc.getElementsByTagName("ruc")[0].childNodes[0].nodeValue;
			  document.getElementById('identificacion').value = x;
		
		  x = '';
		  x = xmlDoc.getElementsByTagName("dirEstablecimiento")[0].childNodes[0].nodeValue;
		   	  document.getElementById('direccion').value = x;

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