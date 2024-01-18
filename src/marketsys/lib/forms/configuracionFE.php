<?php include "../php/sesionSecurityForms.php"; ?>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Empresa</title>
	<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css"/>
	<link rel="stylesheet" type="text/css" href="../css/stylesEmpresa.css"/>
	<script src="../js/fiddle.js"></script>
	<script src="../js/forge.min.js"></script>
	<script src="../js/moment.min.js"></script>
	<script src="../js/buffer.js"></script>
</head>
<body bgcolor="#eee" style="left: 0px;" onLoad="retornaInformacionTributaria();">	
  <div id="configuracion" name="configuracion" class="contentblock hidden">
	 <table style="width: 100%;">
		<tr>
			<td colspan="8" class="estilo3">Parámetros Documentos Electrónicos</td>
			<input id="idEmpresa" type="text" style="width: 100%; height: 18px;display: none;"/>
		</tr>
		<tr>
			<td>Ambiente</td>
			<td>
				<select id="ambiente" style="width: 80px; height: 18px;">
				 	<option value="1">PRUEBAS</option>
					<option value="2">PRODUCCIÓN</option>
				</select>
			</td>
			<td style="text-align: right;">Tipo Emisión</td>
			<td>
				<select id="tipoEmision" style="width: 100%; height: 18px;">
					<option value="1">NORMAL</option>
				</select>
			</td>
			<td style="text-align: right;">N° Contribuyente Especial</td>
			<td style="width: 80px;"> 
				<input id="contribuyenteEspecial" type="text" style="width: 80px; height: 18px;"/>
			</td>
			<td style="text-align: right;">Obligado Llevar Contabilidad</td>
			<td>
				<select id="llevarContabilidad" style="width: 100%; height: 18px;">
					<option value="S">SI</option>
					<option value="N">NO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Moneda</td>
			<td colspan="3">
				<select id="moneda" style="width: 100%; height: 18px;">
					<option value="1">DÓLAR AMERICANO</option>
				</select>
			</td>
			<td style="text-align: right;">Código Númerico</td>
			<td style="width: 80px;">
				<input id="codigoNumerico" type="text" style="width: 80px; height: 18px;"/>
			</td>
		</tr>
		<tr>
			<td colspan="8" class="estilo3">Configuración Firma Electrónica</td>
		</tr>
		<tr>
			<td>Firma Electrónica</td>
			<td colspan="8">
				<div width="720px" height="60px" style="margin: 0px;">
					<object id="objFirmaElectronica" type="text/html" 
							data="../upload/viewFirmaElectronica.php" 
							style="width: 720px; height: 60px; border:0px">
					</object>
				</div>
				<input id="archivoFirma" type="text" style="width: 100%; height: 18px;display: none;"/>
				<input id="validezFirma" type="text" style="width: 100%; height: 18px;display: none;"/>
			</td>
		</tr>
		<tr> 
			<td>Nombre Firma</td>
			<td colspan="3">
				<input id="nombreFirma" style="width: 100%; height: 18px;"/>
			</td>
			<td style="text-align: right;">Fecha de Vigencia</td>
			<td style="width: 80px;">
				<input id="fechaVigencia" disabled style="width: 80px; height: 18px;"/>
			</td>
			<td style="text-align: right;">Clave Firma Electrónica</td>
			<td>
				<input id="claveFirma" type="password" style="width: 100%; height: 18px;"/>
			</td>
		</tr>
		<tr>
			<td colspan="8" class="estilo3">Configuración Rutas XML</td>
		</tr>
		<tr>
			<td>
				Ruta XML Generados
			</td>
			<td colspan="7">
				<input id="xmlGenerados" type="text" style="width: 100%; height: 18px;"/>
			</td>
		</tr>
		<tr>
			<td>
				Ruta XML Firmados
			</td>
			<td colspan="7">
				<input id="xmlFirmados" type="text" style="width: 100%; height: 18px;"/>
			</td>
		</tr>
		<tr>
			<td>
				Ruta XML Enviados
			</td>
			<td colspan="7">
				<input id="xmlEnviados" type="text" style="width: 100%; height: 18px;"/>
			</td>
		</tr>
		<tr>
			<td>
				Ruta XML Rechazados
			</td>
			<td colspan="7">
				<input id="xmlRechazados" type="text" style="width: 100%; height: 18px;"/>
			</td>
		</tr>
		<tr>
			<td>
				Ruta XML Autorizados
			</td>
			<td colspan="7">
				<input id="xmlAutorizados" type="text" style="width: 100%; height: 18px;"/>
			</td>
		</tr>
		<tr>
			<td>
				Ruta XML No Autorizados
			</td>
			<td colspan="7">
				<input id="xmlNoAutorizados" type="text" style="width: 100%; height: 18px;"/>
			</td>
		</tr>
		<tr>
			<td colspan="8" class="estilo3">
				Configuración WebServices SRI
			</td>
		</tr>
		<tr>
			<td>
				URL SRI Recepción
			</td>
			<td colspan="7">
				<input id="urlRecepcion" type="text" style="width: 100%; height: 18px;"/>
			</td>
		</tr>
		<tr>
			<td>
				URL SRI Autorización
			</td>
			<td colspan="7">
				<input id="urlAutorizacion" type="text" style="width: 100%; height: 18px;"/>
			</td>
		</tr>
		<tr>
			<td colspan="8" style="text-align: right; height: 45px; vertical-align: middle;">
				<button id="btn_guardar" onClick="guardaInformacionTributaria();"
						style="width: 120px; height: 30px; background-color: #7FB3D5; color: #1A5276;">
					<img src="../images/icons/guardarICON.png" alt=""/><b>Guardar</b>
				</button>
			</td>	
		</tr>	
	</table>
  </div>
</body>
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui-forms.js"></script>
  <script>
	function retornaInformacionTributaria(){
		$.ajax({type:'POST',
				url:'../php/retornaParametrosTributarios.php',
				success:function(data){
						data = eval(data);
							data = eval(data[0]);
					 		document.getElementById('idEmpresa').value 				= data[1];
							document.getElementById('ambiente').value 				= data[2];
							document.getElementById('tipoEmision').value 			= data[3];
							document.getElementById('contribuyenteEspecial').value 	= data[4];
							document.getElementById('llevarContabilidad').value 	= data[5];
							document.getElementById('moneda').value 				= data[6];
							document.getElementById('codigoNumerico').value 		= data[7];
							document.getElementById('archivoFirma').value 			= data[8];
							objetoPrincipal =	document.getElementById('objFirmaElectronica');	
							objetoPrincipal.contentWindow.document.getElementById('tituloImage').innerHTML = data[8];
							objetoPrincipal.contentWindow.document.getElementById('tamanoImagen').innerHTML = 'Guardada';
							
							document.getElementById('nombreFirma').value 			= data[9];
							document.getElementById('fechaVigencia').value 			= data[10];
							document.getElementById('claveFirma').value 			= data[11];
							document.getElementById('validezFirma').value 			= data[12];
							document.getElementById('xmlGenerados').value 			= data[13];
							document.getElementById('xmlFirmados').value 			= data[14];
							document.getElementById('xmlEnviados').value 			= data[15];
							document.getElementById('xmlRechazados').value 			= data[16];
							document.getElementById('xmlAutorizados').value 		= data[17];
							document.getElementById('xmlNoAutorizados').value 		= data[18];
							document.getElementById('urlRecepcion').value 			= data[19];
							document.getElementById('urlAutorizacion').value 		= data[20];
							
							parent.document.getElementById('divLoadding').style.display = 'none';
						}
			   });
	}
	  
	function guardaInformacionTributaria(){
		if (document.getElementById('fechaVigencia').value == ''){
			parent.modalAlertPrincipal(1,'MarketSys', 
									  'Para poder continuar deberá verificar la vigencia de la contraseña', 
									   0, 'Aceptar', '');
			return;
			}
		
		if (document.getElementById('validezFirma').value == 'N' || document.getElementById('validezFirma').value == ''){
			parent.modalAlertPrincipal(1,'MarketSys', 
									  'El certificado digital se encuentra caducado.', 
									   0, 'Aceptar', '');
			return;
			}
		
		parent.document.getElementById('divLoadding').style.display = 'block';
		/************ variables *************/
		idEmpresa		=	document.getElementById('idEmpresa').value;
		ambiente		=	document.getElementById('ambiente').value;
		tipoEmision		=	document.getElementById('tipoEmision').value;
		contribuyente	= 	document.getElementById('contribuyenteEspecial').value;
		contabilidad	=	document.getElementById('llevarContabilidad').value;
		moneda			= 	document.getElementById('moneda').value;
		codigoNumerico	= 	document.getElementById('codigoNumerico').value;
		archivoFirma	= 	document.getElementById('archivoFirma').value;
		nombreFirma		= 	document.getElementById('nombreFirma').value;
		fechaVigencia	=	document.getElementById('fechaVigencia').value;
		claveFirma		= 	document.getElementById('claveFirma').value;
		validezFirma	=	document.getElementById('validezFirma').value;
		xmlGenerados	=	document.getElementById('xmlGenerados').value;
		xmlFirmados		=	document.getElementById('xmlFirmados').value;
		xmlEnviados		= 	document.getElementById('xmlEnviados').value;
		xmlRechazados	=	document.getElementById('xmlRechazados').value;
		xmlAutorizados	=	document.getElementById('xmlAutorizados').value;
		xmlNoAutorizados=	document.getElementById('xmlNoAutorizados').value;
		urlRecepcion	=	document.getElementById('urlRecepcion').value;
		urlAutorizacion	=	document.getElementById('urlAutorizacion').value;
		
		$.ajax({type:'POST',
				url:'../php/guardaParametrosTributarios.php',
				data: 'idEmpresa='+idEmpresa+'&ambiente='+ambiente+'&tipoEmision='+tipoEmision+'&contribuyente='+contribuyente+
					  '&contabilidad='+contabilidad+'&moneda='+moneda+'&codigoNumerico='+codigoNumerico+'&validezFirma='+validezFirma+
					  '&archivoFirma='+archivoFirma+'&nombreFirma='+nombreFirma+'&fechaVigencia='+fechaVigencia+
				      '&claveFirma='+claveFirma+'&xmlGenerados='+xmlGenerados+'&xmlFirmados='+xmlFirmados+
					  '&xmlEnviados='+xmlEnviados+'&xmlRechazados='+xmlRechazados+'&xmlAutorizados='+xmlAutorizados+
				      '&xmlNoAutorizados='+xmlNoAutorizados+'&urlRecepcion='+urlRecepcion+'&urlAutorizacion='+urlAutorizacion,
				success:function(data){
						data = eval(data);
							parent.modalAlertPrincipal(3,'MarketSys', 
													  'Se han guardado correctamente la información de configuración eletrónica', 
											   		   0, 'Aceptar', '');
					
							parent.document.getElementById('divLoadding').style.display = 'none';
						}
			   });
	}  
  </script>	
</html>	