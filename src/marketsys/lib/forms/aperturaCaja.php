<?php include "../php/sesionSecurityForms.php"; ?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Apertura del Día</title>
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/styleCajas.css">
	
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
		
		function mostrarInformacionCajero(e){
			var informacionCajero = e;
			var existeInf = 0;
			for(var i in informacionCajero)
				{
					document.getElementById('idEstablecimiento').value = informacionCajero[i].id_establecimiento;
					document.getElementById('definicionEstablecimiento').value = informacionCajero[i].establecimiento;
					document.getElementById('codigoEstablecimiento').value = informacionCajero[i].codigo_establecimiento;
					document.getElementById('idPuntoEmision').value = informacionCajero[i].id_punto_emision;
					document.getElementById('definicionPuntoEmision').value = informacionCajero[i].punto_emision;
					document.getElementById('codigoPuntoEmision').value = informacionCajero[i].codigo_punto;
					document.getElementById('ciCajero').value = informacionCajero[i].numero_identificacion;
					document.getElementById('nombresCajero').value = informacionCajero[i].nombre;
					document.getElementById('idCajero').value = informacionCajero[i].id_personal;
					existeInf = 1;
				}
				if (existeInf == 0){
					parent. modalAlertPrincipal(2, 'MarketSys', 'Usted no cuenta con permisos para Manejo de Cajas. Comuniquese con su Administrador.', 0, 'Aceptar', '')
					parent.cargarOpcion('MN0000');
				}
			}
		
		
		function loadInformacionCajero(e){
			enviarAjax("GET","../../lib/php/loadInformacionCajero.php", {idZona:e}, mostrarInformacionCajero);
				parent.document.getElementById('divLoadding').style.display = 'none';	
			}
			
		function calcularApertura(fila)
			{
				valAnterior = document.getElementById('txtTDenominacion'+fila).innerHTML;
				valNuevo = document.getElementById('txtDenominacion'+fila).value * document.getElementById('txtVDenominacion'+fila).innerHTML;
				document.getElementById('txtTDenominacion'+fila).innerHTML = valNuevo.toFixed(2);
				nuevoTotal  = parseFloat(document.getElementById('txtVTApertura').innerHTML) - parseFloat(valAnterior);
				document.getElementById('txtVTApertura').innerHTML = nuevoTotal.toFixed(2);
				TotalApertura = parseFloat(document.getElementById('txtTDenominacion'+fila).innerHTML) + parseFloat(document.getElementById('txtVTApertura').innerHTML);
				document.getElementById('txtVTApertura').innerHTML = parseFloat(TotalApertura).toFixed(2);
			}
		
		function aperturarCaja(e){
				if (document.getElementById('ciCajero').value == '')
					{parent.errorAlert('Usted no tiene permisos para ejecutar esta opción. Por favor comuniquese con su administrador.');}
				else{enviarAjax("POST","../../lib/php/aperturarCaja.php", {idEstablecimiento: document.getElementById('idEstablecimiento').value, 
				                                                           idPuntoEmision: document.getElementById('idPuntoEmision').value,
																		   idPersonal: document.getElementById('idCajero').value,
																		   apertura: document.getElementById('txtVTApertura').innerHTML}, 
																		   mensajeTransaccion);}
				
			}
		
		function mensajeTransaccion(e){
			var resp=eval(e)
			var x = 0;
			cadenaR = resp[0];
				var res = cadenaR.replace("&&", "\n");
				var res = res.replace("&&", "\n");
				var res = res.replace("&&", "\n");
				var res = res.replace("&&", "\n");
				var res = res.replace("&&", "\n");
				var res = res.replace("&&", "\n");
				
			if (resp[1] == 0)
			   {var table = document.getElementById("tableDenominacion").rows.length;
				x = 1;
				for (var i = 1, row; i < table-1; i++) {
				   enviarAjax("POST","../../lib/php/aperturarDenominacionCaja.php", 
				             {idEstablecimiento: document.getElementById('idEstablecimiento').value, 
							  idPuntoEmision: document.getElementById('idPuntoEmision').value,
							  idPersonal: document.getElementById('idCajero').value,
							  idApertura: resp[2], 
							  idDenominacion: i, 
							  cantidad: document.getElementById('txtDenominacion'+i).value, 
							  total: document.getElementById('txtTDenominacion'+i).innerHTML,
							  tipo: 1},
					cerrrarVentana(i,res, resp[2], resp[1]));		  
				}
			}
			if (x==0){
				if (resp[1] == 0){
					parent. modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', resp[0], 0, 'Aceptar', '');
					
					}
				    else {parent. modalAlertPrincipal(1, 'MarketSys [MRER-0010]', resp[0], 0, 'Aceptar', '')}
			}
		}
		
		function cerrrarVentana(id,resp, ape, sus){
			if (id==13){
				  enviarAjax("POST","../../lib/php/aperturarDenominacionCaja.php", 
				            {idEstablecimiento: document.getElementById('idEstablecimiento').value, 
							 idPuntoEmision: document.getElementById('idPuntoEmision').value,
							 idPersonal: document.getElementById('idCajero').value,
							 idApertura: ape, 
							 idDenominacion: 13, 
							 cantidad: document.getElementById('txtDenominacion13').value, 
							 total: document.getElementById('txtTDenominacion13').innerHTML,
							 tipo: 1});
				if (sus == 0){
					parent.modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', resp, 0, 'Aceptar', '');
					
					window.setTimeout(function(){
							//parent.removeTabNombre('AperturaCaja');
							parent.cargarOpcion('MN0000');
						}, 2000);
						
						
					}
				    else {parent.modalAlertPrincipal(1, 'MarketSys [MRER-0010]', resp, 0, 'Aceptar', '')}
				
			}
		}
	</script>
</head>	
<body bgcolor="#fff" style="left: 0px; overflow: hidden;" onLoad="loadInformacionCajero();">
<form id="frm_clientes" method="post" enctype="multipart/form-data"> 
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="4" class="estilo3">
							APERTURA DE CAJA
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable">
							Establecimiento
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="codigoEstablecimiento" name="codigoEstablecimiento" class="required" type="text" style="width: 120px; height: 14px;"/>
							<input onFocus="this.blur()" id="definicionEstablecimiento" name="definicionEstablecimiento" class="required" type="text" style="width: calc(100% - 145px); height: 14px;"/>
							<input onFocus="this.blur()" id="idEstablecimiento" name="idEstablecimiento" type="text" style="display: none;"/>
						<td rowspan="3" class="clsEtiquetasTable">
							<button type="button" id="btn_guardar" onClick="aperturarCaja();"><img src="../images/icons/cajaIcono.png" width="35px" alt=""/><br>Apertura de Caja</button>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Punto de Emisión
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="codigoPuntoEmision" name="codigoPuntoEmision" class="required" type="text" style="width: 120px; height: 14px;"/>
							<input onFocus="this.blur()" id="definicionPuntoEmision" name="definicionPuntoEmision" class="required" type="text" style="width: calc(100% - 145px); height: 14px;"/>
							<input onFocus="this.blur()" id="idPuntoEmision" name="idPuntoEmision" type="text" style="display: none;"/>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Cajero
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="ciCajero" name="ciCajero" class="required" type="text" style="width: 120px; height: 14px;"/>
							<input onFocus="this.blur()" id="nombresCajero" name="nombresCajero" class="required" type="text" style="width: calc(100% - 145px); height: 14px;"/>
							<input onFocus="this.blur()" id="idCajero" name="idCajero" type="text" style="display: none;"/>
					    </td>
					</tr>	
					<tr>
						<td colspan="4" class="estilo2">
							<table id="tableDenominacion" id="tableDenominacion" style="width: 100%;">
								<thead>
									<tr class="tablaAperturaHead">
										<td style="width: 5%;">
											N°	
										</td>
										<td style="width: 50%;">
											Denominación	
										</td>
										<td style="width: 15%;">
											Valor Moneda	
										</td>
										<td style="width: 15%;">
											Cantidad	
										</td>
										<td style="width: 15%;">
											Total	
										</td>
									</tr>
								</thead>
								<tbody bgcolor="#fff">	
									<?php
										include_once("../php/aperturaFunctionPHP.php");
										cargaDenominacion();
									?>
								</tbody>		
								<tfoot>	
									<tr>
										<td colspan="4">	
										</td>
										<td class="tablaAperturaFood">
											<span id="txtVTApertura" name="txtVTApertura" style="width: 100px;">0.00</span>		
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
</form>
	<!--<div id="modal" class="modal">
		<div class="modal-dialog animated">
			<div class="modal-content">
				<form class="form-horizontal" method="get">
					<div class="modal-header">
						<strong><span id="titleModal"></span></strong>
					</div>

					<div class="modal-body">
						<div id="bodyModal" class="form-group" style="padding-left: 30px; white-space: pre-wrap;">

						</div>
					</div>

					<div class="modal-footer">
						<button id="btn1-modal" class="btn btn-default" type="button" onclick="removeTabF();">Aceptar</button>
						<button id="btn2-modal" class="btn btn-default" type="button" onclick="modal.close();">Aceptar</button>
						<button id="btn3-modal" class="btn btn-default" type="button" onclick="modal.close();">Aceptar</button>
						<button id="btnf-modal" class="btn btn-default" type="button" onclick="modal.close();">Aceptar</button>
					</div>
				</form>
			</div>
		</div>
	</div>-->
</body>
</html>