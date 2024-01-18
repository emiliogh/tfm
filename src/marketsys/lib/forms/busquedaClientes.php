<?php
session_start();
?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>BúsquedaClientes</title>
  <script type="text/javascript" src="../jquery/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="../js/componentes.js"></script>
  <script type="text/javascript" src="../js/jquery.datetimepicker.full.js"></script>
  <script type="text/javascript" src="../js/funciones.busqueda.js"></script>
  <link rel="stylesheet" type="text/css" media="all" href="../css/jquery.datetimepicker.css"/>
  <link rel="stylesheet" type="text/css" media="all" href="../css/styleBusqueda.css">
<body bgcolor="#fff" style="left: 0px; overflow:hidden;" onLoad="parent.document.getElementById('divLoadding').style.display = 'none';"> 
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="2" class="estilo3">
							Búsqueda de Ciudadanos	
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" 
							style="height: 20px; text-align: center; padding: 0px; margin: 0px; display: table-cell; vertical-align: middle;">
							<table>
								<tr>
									<td style="width: 20%;">Información
									</td>
									<td style="width: 80%;"><input id="busqueda" name="busqueda" class="required" type="text" autocomplete="off" 
										onkeypress="enterBusqueda(event);" style="width: 100%; height: 20px;"/>
									</td>
									<td><button type="button" class="bBusqueda" id="btn_buscar" 
										onClick="buscarInformacion(document.getElementById('busqueda').value);"></button>
									</td>
								</tr>
							</table>
					    </td>
						<td rowspan="3" class="clsEtiquetasTable" style="vertical-align: top;">
							<table style="width: 100%; background: #fff;">
								<tr>
									<td colspan="5" class="estilo3" style="height: 18px;">Información Cliente</td>
								</tr>
								<tr class="clsEtiquetasTable">
									<td style="width: 15%; padding-left: 15px;">Tipo Cliente</td>
									<td class="tdBorder" style="width: 30%;">
										<span id="tipoCliente" style="font-size: 10px; width: 250px; height: 12px;"></span>
										<span id="idCliente" 	style="display: none;"></span>
									</td>
									<td style="width: 20%; padding-left: 15px;">Tipo Identificación</td>
									<td class="tdBorder" style="width: 35%;">
										<span id="tipoIdentificacion" style="font-size: 10px; width: 280px; height: 12px;">&nbsp;</span>
									</td>
									<td rowspan="5" style="padding-left: 5px; height: 100%; background-color: khaki;">
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
								<tr class="clsEtiquetasTable">
									<td style="padding-left: 15px;">Identificación</td>
									<td class="tdBorder">
										<span id="identificacion" style="font-size: 10px; width: 300px; height: 12px;">&nbsp;</span>
									</td>
									<td style="padding-left: 15px;">Categoría</td>
									<td class="tdBorder">
										<span id="categoriaCliente" style="font-size: 10px; width: 250px; height: 12px;">&nbsp;</span>
									</td>
								</tr>
								<tr class="clsEtiquetasTable">
									<td style="padding-left: 15px;">Nombre Cliente</td>
									<td class="tdBorder" colspan="3">
										<span id="nombreCliente" style="font-size: 10px; width: 250px; height: 12px;">&nbsp;</span>
									</td>
								</tr>
								<tr class="clsEtiquetasTable">
									<td style="padding-left: 15px;">Dirección</td>
									<td class="tdBorder" colspan="3">
										<span id="direccionCliente" style="font-size: 10px; width: 99%; height: 12px;">&nbsp;</span>
									</td>
								</tr>
								<tr class="clsEtiquetasTable">
									<td style="padding-left: 15px;">Email:</td>
									<td class="tdBorder">
										<span id="emailCliente" style="font-size: 10px; width: 250px; height: 12px;">&nbsp;</span>
									</td>
									<td style="padding-left: 15px;">Teléfono:</td>
									<td class="tdBorder">
										<span id="telefonoCliente" style="font-size: 10px; width: 300px; height: 12px;">&nbsp;</span>
									</td>
								</tr>
								<tr id="tituloDetFactura" class="estilo3" style="display: none; background-size: 600px 25px; height: 25px; border-left: 3px solid #7EC1DB; border-top: 2px solid #7EC1DB; border-bottom: 1px solid #7EC1DB;" onClick="muestraTR('trFacturas')">
									<td colspan="5" style="height: 25px;">Facturas Emitidas</td>
								</tr>
								<tr id="trFacturas" style="display: none;">
									<td colspan="5" style="width: 100%;">
										<table class="tablaAperturaBodymin2" id="tableFacturas" style="width: 100%;">
											<tbody  id="cont" bgcolor="#fff" style="overflow: auto; width: 100%;">
											</tbody>		
										</table>
									</td>
								</tr>
								<tr id="tituloDetPagos" class="estilo3" style="display: none; background-size: 600px 25px; height: 25px; border-left: 3px solid #7EC1DB; border-top: 1px solid #7EC1DB; border-bottom: 1px solid #7EC1DB;" onClick="muestraTR('trPagos')">
									<td colspan="5" style="height: 25px;">Pagos Realizados</td>
								</tr>
								<tr id="trPagos" style="display: none;">
									<td colspan="5">
										<table class="tablaAperturaBodymin2" id="tablePagos" style="width: 100%; height: 100%;">
											<tbody  id="cont" bgcolor="#fff" style="overflow: auto; width: 100%;">
											</tbody>
										</table>
									</td>
								</tr>
							</table>
					    </td>
					</tr>
					<tr>
						<td class="estilo3">
							Resultados de la Búsqueda
						</td>
					</tr>
					<tr>
						<td width="250px" class="estilo2" style="vertical-align: top;">
							<table class="tablaAperturaBodymin2" id="tableBusqueda" style="width: 250px;height: 100vh; ">
								<tbody  id="cont" bgcolor="#fff" style="display: inline-block; overflow: auto; width: 250px;">
								</tbody>		
							</table>
						</td>	
					</tr>
				</tbody>	
			</table>
        </div>
    </div>
  </div>
  <div id="myPopupFactura" name="myPopupFactura" class="modal">
	  <div class="divPopUpCambio">
			<table style="border-style: none; width: 485px; margin-left: 10px; overflow: hidden;">
				<tr>
					<td style="text-align:left; height: 25px; vertical-align: middle; text-align: right; padding: 0px;">
						<input class="bCerrarVentana" type="submit" name="bCerrarVentana" value="" onClick="cerrarVentanaFactura();">
					</td>
				<tr>
				<tr>
					<td style="text-align:left; padding-top: 10px; margin: 0px;  vertical-align: bottom;">
						<table style="padding-left: 5px; border-style: none; width: 450px; overflow: hidden; font-size: 12px;">
							<tr>
								<td style="text-align:left; width: 60%; vertical-align: bottom; padding: 0px; height: 15px;">
									<table style="width: 460px;">
										<tr >
											<td colspan="3" style="padding-left: 20px;">N° Factura: <b><span id="nroFacturaIndividual" name="nroFacturaIndividual"></span></b></td>
											<td>Emisión:</td>
											<td colspan="2"><span id="emisionFacturaIndividual" name="emisionFacturaIndividual"></span></td>
										</tr>
										<tr >
											<td class="estilo3" style="width: 175px; height: 15px;">Rubros</td>
											<td class="estilo3" style="width: 50px; height: 15px;">P.U.</td>
											<td class="estilo3" style="width: 50px; height: 15px;">Cant</td>
											<td class="estilo3" style="width: 60px; height: 15px;">Subt</td>
											<td class="estilo3" style="width: 50px; height: 15px;">Desc</td>
											<td class="estilo3" style="width: 60px; height: 15px;">Total</td>
										</tr>	
										<tr>
											<td colspan="6" style="padding: 0px; border-spacing: 0px;">
												<div style="height: 198px; overflow-y : scroll;">
													<table id="tableRubrosFactura" style="padding: 0px; border-spacing: 0px;">
														<tbody></tbody>
													</table>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="3" class="estiloTD" style="align: right; height: 18px; padding-right: 20px;">TOTAL</td>
											<td class="estiloTD" style="align: right; padding-right: 5px;"><span id="tfSubtotal">0.00</span></td>
											<td class="estiloTD" style="align: right; padding-right: 5px;"><span id="tfDescuento">0.00</span></td>
											<td class="estiloTD" style="align: right; padding-right: 5px;"><span id="tfTotal">0.00</span></td>
										</tr>
									</table>
								</td>
							<tr>
						</table>
					</td>
				<tr>
			</table>	
		</div>
	</div>
	
	<div id="myPopupPago" name="myPopupPago" class="modal">
	  <div class="divPopUpPago">
			<table style="border-style: none; width: 410px; margin-left: 10px; overflow: hidden;">
				<tr>
					<td style="text-align:left; height: 25px; vertical-align: middle; text-align: right; padding: 0px;">
						<input class="bCerrarVentana" type="submit" name="bCerrarVentana" value="" onClick="cerrarVentanaPago();">
					</td>
				<tr>
				<tr>
					<td style="text-align:left; padding-top: 10px; margin: 0px;  vertical-align: bottom;">
						<table style="padding-left: 5px; border-style: none; width: 390px; overflow: hidden; font-size: 12px;">
							<tr>
								<td style="text-align:left; vertical-align: bottom; padding: 0px; height: 15px;">
									<table style="width: 380px;">
										<tr>
											<td colspan="3" class="estilo3" style="height: 15px;">
												Detalle de la Factura
											</td>
										</tr>
										<tr>
											<td>Factura: </td>
											<td><span id="idFacturaPago" name="idFacturaPago" style="display:none;"></span>
												<span id="nroFacturaPago" name="nroFacturaPago"></span></td>
											<td rowspan="3" style="background-color: khaki; text-align: right;"><span id="saldoPendienteFactura" name="saldoPendienteFactura" style="font-size: 20px;font-weight: 800;color: red;"></span></td>
										</tr>
										<tr>
											<td>Fecha:</td>
											<td><span id="fechaEmisionFactura" name="fechaEmisionFactura"></span></td>
										</tr>
										<tr>
											<td>Monto factura:</td>
											<td><span id="montoEmisionFactura" name="montoEmisionFactura"></span></td>
										</tr>
										<tr>
											<td colspan="3" class="estilo3" style="height: 15px;">
												Detalle para Pago de la Factura
											</td>
										</tr>
										<tr>
											<td>Forma Pago:</td>
											<td colspan="2">
												<select id="formasPagoFactura" style="width: 100%; font-size: 12px;"></select>
											</td>
										</tr>
										<tr>
											<td>Valor Pago:</td>
											<td colspan="2">
												<input id="valorPagoFactura" name="valorPagoFactura" autocomplete="off" type="text" class="form-control"
													   style="width: 97%; height: 22px; text-align: right;" onChange="formatearCampo(this)"
													   maxlength="10" onkeypress='return filterFloat(event,this);'/>
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<table style="width: 100%;">
													<tr>
														<td style="width: 50%; text-align: center;">
															<button class="btn btn-default btn btn-primary btn-lg" type="button" data-dismiss="modal" 
																	onClick="guardarPagoFactura();">Guardar </button>
														</td>
														<td style="width: 50%; text-align: center;">
															<button class="btn btn-default btn btn-danger btn-lg" type="button" data-dismiss="modal" 
																	onclick="cerrarVentanaPago();">Cancelar </button>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							<tr>
						</table>
					</td>
				<tr>
			</table>	
		</div>
	</div>
	
	<div id="myPopupNC" name="myPopupNC" class="modal">
	  <div class="divPopUpNC">
			<table style="border-style: none; width: 410px; margin-left: 10px; overflow: hidden;">
				<tr>
					<td style="text-align:left; height: 25px; vertical-align: middle; text-align: right; padding: 0px;">
						<input class="bCerrarVentana" type="submit" name="bCerrarVentana" value="" onClick="cerrarVentanaNC();">
					</td>
				<tr>
				<tr>
					<td style="text-align:left; padding-top: 10px; margin: 0px;  vertical-align: bottom;">
						<table style="padding-left: 5px; border-style: none; width: 390px; overflow: hidden; font-size: 12px;">
							<tr>
								<td style="text-align:left; vertical-align: bottom; padding: 0px; height: 15px;">
									<table style="width: 380px;">
										<tr >
											<td colspan="3" style="padding-left: 20px;">N° N/C: <span id="nroNCIndividual" name="nroNCIndividual"></span></td>
											<td>Emisión:</td>
											<td><span id="fechaNCIndividual" name="fechaPagoIndividual"></span></td>
										</tr>
										<tr >
											<td class="estilo3" style="width: 60px; height: 15px;">Factura</td>
											<td class="estilo3" style="width: 80px; height: 15px;">Emisión</td>
											<td class="estilo3" style="width: 55px; height: 15px;">Total</td>
											<td class="estilo3" style="width: 70px; height: 15px;">Regulación</td>
											<td class="estilo3" style="width: 90px; height: 15px;">Fecha</td>
										</tr>	
										<tr>
											<td colspan="5" style="padding: 0px; border-spacing: 0px;">
												<div style="height: 115px; width: 380px; overflow-y : scroll;">
													<table id="tableAfectacionFacturaNC" style="padding: 0px; border-spacing: 0px;">
														<tbody></tbody>
													</table>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2" class="estiloTD" style="align: right; height: 18px; padding-right: 20px;">TOTAL</td>
											<td class="estiloTD" style="align: right; padding-right: 15px;"><span id="tfacemisionNC">0.00</span></td>
											<td class="estiloTD" style="align: right; padding-right: 20px;"><span id="tafecFacturaNC">0.00</span></td>
											<td class="estiloTD"></td>
										</tr>
									</table>
								</td>
							<tr>
						</table>
					</td>
				<tr>
			</table>	
		</div>
	</div>
	
	<div id="myContactoCliente" class="modal">
	  <div class="divContactoCliente" id="divContactoCliente">
			<table style="border-style: none; width: 98%; margin-left: 10px; overflow: hidden;">
				<tr>
					<td style="text-align:left; height: 25px; vertical-align: middle; text-align: right; padding: 0px;">
						<input class="bCerrarVentana" type="submit" name="bCerrarVentana" value="" onClick="cerrarVentanaContacto();">
					</td>
				<tr>
				<tr>
					<td style="text-align:left; padding-top: 0px; margin: 0px;  vertical-align: top;">
						<table style="padding-left: 5px; border-style: none; overflow: hidden; width: 100%;">
							<tr>
								<td style="font-weight: 600; font-size: 10px;">Email Principal:</td>
								<td>
									<input id="emailPrincipal" style="text-transform: lowercase; font-size: 10px; width: 90%; height: 12px;"></input>
								</td>
							</tr>
							<tr>
								<td style="font-size: 10px;">Email Secunadario:</td>
								<td>
									<input id="emailAlternativo" style="text-transform: lowercase; font-size: 10px; width: 90%; height: 12px;"></input>
								</td>
							</tr>
							<tr>
								<td style="font-weight: 600; font-size: 10px;">Telefóno Principal:</td>
								<td>
									<input id="telefonoPrincipal" style="font-size: 10px; width: 90%; height: 12px;"></input>
								</td>
							</tr>
							<tr>
								<td style="font-size: 10px;">Telefóno Secunadario:</td>
								<td>
									<input id="telefonoAlternativo" style="font-size: 10px; width: 90%; height: 12px;"></input>
								</td>
							</tr>
							<tr>
								<td style="font-weight: 600; font-size: 10px;">Referencia del Predio:</td>
								<td>
									<textarea id="referenciaPredio" style="font-size: 12px; width: 90%; height: 28px;"></textarea>
								</td>
							</tr>
							<tr>
								<td style="text-align: center; font-size: 10px;">
									<button type="button" style="border-radius: 5px; padding: 5px; background-color: #B0C4DE;" onClick="actualizaContactosClientes();"></button>
								</td>
								<td style="text-align: center; font-size: 10px;">
									<button type="button" style="border-radius: 5px; padding: 5px; background-color: #FFA07A;" onClick="cerrarVentanaContacto();"></button>
								</td>
							</tr>
						</table>
					</td>
				<tr>
			</table>	
		</div>
	</div>
</body>
</html>