<?php include "../php/sesionSecurityForms.php"; ?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Cierre del Día</title>
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
					//parent.removeTabNombre('CierreCaja');
					parent.cargarOpcion('MN0000');
				}
				
				//informacionApertura ();
			}
		
		function llenarInformacionBusqueda(e){	
			var informacionBusqueda = e;
			for(var i in informacionBusqueda)
				{
					var table = document.getElementById("tableDenominacion").getElementsByTagName('tbody')[0];
					var row = table.insertRow(0);
					var cell1 = row.insertCell(0);
					var cell3 = row.insertCell(1);
					var cell3 = row.insertCell(2);
					var cell4 = row.insertCell(3);
					var cell5 = row.insertCell(4);
					var cell6 = row.insertCell(5);
					cell1.className = "clsEtiquetasTableUSD";
					cell2.className = "clsEtiquetasTable";
					cell3.className = "clsEtiquetasTableUSD";
					cell4.className = "clsEtiquetasTableUSD";
					cell5.className = "clsObjetosTable";
					cell6.className = "clsEtiquetasTableUSD";
					cell1.innerHTML = informacionBusqueda[i].c1;
					cell2.innerHTML = informacionBusqueda[i].c2;
					cell3.innerHTML = informacionBusqueda[i].c3;
					cell4.innerHTML = informacionBusqueda[i].c4;
					cell5.innerHTML = informacionBusqueda[i].c5;
					cell6.innerHTML = informacionBusqueda[i].c6;	
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
		
		function cerrarCaja(e){
			if (document.getElementById('idCajero').value == '')
			   {parent.modalAlertPrincipal(1, 'MarketSys [MRER-0010]', 'Usted no cuenta con un Punto de Emisión Asignado, por favor verifique con el Administrador.', 0, 'Aceptar', '');}
				else{
					 if (document.getElementById('reporteCierre').value == 0)
						{parent.modalAlertPrincipal(1, 'MarketSys [Información]', 'Usted no ha generado el reporte de Cierre, no olvide generarlo.', 0, 'Aceptar', '');}
						 else{enviarAjax("POST","../../lib/php/cerrarCaja.php", {idEstablecimiento: document.getElementById('idEstablecimiento').value, idPuntoEmision: document.getElementById('idPuntoEmision').value,idPersonal: document.getElementById('idCajero').value,apertura: document.getElementById('txtVTApertura').innerHTML}, mensajeTransaccion);}
				}
			}
		
		function imprimirCierreDia(e){
				document.getElementById('reporteCierre').value = 1;
				var date = new Date();
				if (document.getElementById('impresionCierre').checked == true)
					{window.open('../reports/cierreCajaIndividual.php?fechadesde='+date.toJSON().slice(0,10).replace(new RegExp("-", 'g'),"/" ).split("/").reverse().join("/")+'&fechahasta='+date.toJSON().slice(0,10).replace(new RegExp("-", 'g'),"/" ).split("/").reverse().join("/"));}
					else{window.open('../reports/cierreCajaIndividual.php?fechadesde='+date.toJSON().slice(0,10).replace(new RegExp("-", 'g'),"/" ).split("/").reverse().join("/")+'&fechahasta='+date.toJSON().slice(0,10).replace(new RegExp("-", 'g'),"/" ).split("/").reverse().join("/"));}
				
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
							  tipo: 2},
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
							 tipo: 2});
				if (sus == 0){
					parent.modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', resp, 0, 'Aceptar', '');
					
					window.setTimeout(function(){
							//parent.removeTabNombre('CierreCaja');
							parent.cargarOpcion('MN0000');
						}, 2000);
						
						
					}
				    else {parent.modalAlertPrincipal(1, 'MarketSys [MRER-0010]', resp, 0, 'Aceptar', '')}
				
			}
		}
		
		/*
		
		
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
			   {x=1;
				var table = document.getElementById("tableDenominacion").rows.length;
				
				for (var i = 1, row; i < table-1; i++) {
					 enviarAjax("POST","../../lib/php/aperturarDenominacionCaja.php", 
						{idEstablecimiento: document.getElementById('idEstablecimiento').value, 
						 idPuntoEmision: document.getElementById('idPuntoEmision').value,
						 idPersonal: document.getElementById('idCajero').value,
						 idApertura: resp[2], 
						 idDenominacion: i, 
						 cantidad: document.getElementById('txtDenominacion'+i).value, 
						 total: document.getElementById('txtTDenominacion'+i).innerHTML,
						 tipo: 2},cerrrarVentana(i,res, resp[2]),resp[1]);
						}
				}
			if (x==0){
				if (resp[1] == 0){
					parent. modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', res, 0, 'Aceptar', '');
					window.setTimeout(function(){
							parent.removeTabNombre('CierreCaja');
						}, 2000);
					}else {parent. modalAlertPrincipal(1, 'MarketSys [MRER-0010]', resp[0], 0, 'Aceptar', '');}
			}
		}
		
		function cerrrarVentana(id,resp, ape,sus){
			if (id==13){
				  enviarAjax("POST","../../lib/php/aperturarDenominacionCaja.php", 
				             {idEstablecimiento: document.getElementById('idEstablecimiento').value, 
							  idPuntoEmision: document.getElementById('idPuntoEmision').value,
							  idPersonal: document.getElementById('idCajero').value,
							  idApertura: ape, 
							  idDenominacion: 13, 
							  cantidad: document.getElementById('txtDenominacion13').value, 
							  total: document.getElementById('txtTDenominacion13').innerHTML,
							  tipo: 2});
					console.log(resp)
				if (sus == 0){
					parent. modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', resp, 0, 'Aceptar', '');
						window.setTimeout(function(){
							parent.removeTabNombre('CierreCaja');
						}, 2000);
					}
				    else {parent.modalAlertPrincipal(1, 'MarketSys [MRER-0010]', resp, 0, 'Aceptar', '');}
			}
		}	*/		
	</script>	
<body bgcolor="#fff" style="left: 0px;" onLoad="loadInformacionCajero();">
<form id="frm_clientes" method="post" enctype="multipart/form-data"> 
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="4" class="estilo3">
							CIERRE DE CAJA	
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable">
							Establecimiento
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="codigoEstablecimiento" name="codigoEstablecimiento" class="required" type="text" style="width: 100px; height: 14px;"/>
							<input onFocus="this.blur()" id="definicionEstablecimiento" name="definicionEstablecimiento" class="required" type="text" style="width: calc(100% - 140px); height: 14px;"/>
							<input onFocus="this.blur()" id="idEstablecimiento" name="idEstablecimiento" type="text" style="display: none;"/>
							<input onFocus="this.blur()" id="reporteCierre" name="reporteCierre" value="0" type="text" style="display: none;"/>
						<td rowspan="3" style="width: 225px;" class="clsEtiquetasTable">
							<table style="width: 100%;">
								<tr>
									<td>
										<button type="button" id="btn_guardar" style="font-size: 12px;" onClick="imprimirCierreDia();"><img src="../images/icons/imprimirIcono.png" height="20px" alt=""/><br>Imprimir Cierre</button>
									</td>
									<td>
										<button type="button" id="btn_guardar" style="font-size: 12px;" onClick="cerrarCaja();"><img src="../images/icons/cierreIcono.png" height="20px" alt=""/><br>Cierre de Caja</button>
									</td>
								</tr>
								<tr>
									<td colspan="2" style="text-align: center;">
										<input type="checkbox" id="impresionCierre" />Impresión del Día
									</td>
								</tr>
							</table>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Punto de Emisión
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="codigoPuntoEmision" name="codigoPuntoEmision" 
								   class="required" type="text" style="width: 100px; height: 14px;"/>
							<input onFocus="this.blur()" id="definicionPuntoEmision" name="definicionPuntoEmision" 
								   class="required" type="text" style="width: calc(100% - 140px); height: 14px;"/>
							<input onFocus="this.blur()" id="idPuntoEmision" name="idPuntoEmision" 
								   type="text" style="display: none;"/>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Cajero
					    </td>
						<td class="clsObjetosTable">
							<input onFocus="this.blur()" id="ciCajero" name="ciCajero" class="required" type="text" 
								   style="width: 100px; height: 14px;"/>
							<input onFocus="this.blur()" id="nombresCajero" name="nombresCajero" class="required" 
								   type="text" style="width: calc(100% - 140px); height: 14px;"/>
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
										<td style="width: 45%;">
											Denominación	
										</td>
										<td style="width: 15%;">
											Valor Moneda	
										</td>
										<td style="width: 10%;">
											Apertura	
										</td>
										<td style="width: 10%;">
											Cantidad	
										</td>
										<td style="width: 15%;">
											Total	
										</td>
									</tr>
								</thead>
								<tbody bgcolor="#fff">	
									<?php
										include_once("../../lib/php/aperturaFunctionPHP.php");
										cargaDenominacionCierre();
									?>
							</table>
						</td>
					</tr>
				</tbody>	
			</table>
        </div>
    </div>
</form>
</body>
</html>