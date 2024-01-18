<?php include "../php/sesionSecurityForms.php"; ?>
<html>
  <head>
    <link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="scripts/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" />	
	<script src="scripts/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="scripts/jtable/jquery.jtable.js" type="text/javascript"></script>	
    <script type="text/javascript" src="scripts/jquery.validationEngine.js"></script>
	<script type="text/javascript" src="scripts/jquery.validationEngine-es.js"></script>
	<link href="scripts/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../js/componentes.js"></script> 
  </head>
  <body onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<table width="100%" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
		<tr>
			<td style="height: 20px; width: 80px; font-family: Vegur, 'PT Sans', Verdana, sans-serif;">
				Establecimiento:  
			</td>	
			<td>
				<select name="idEstablecimiento" id="idEstablecimiento" style="width: 100%">
				</select> 
			</td>
		</tr>
		<tr>
			<td colspan="2" style="height: 400px; vertical-align: top;">
				<div id="tableContainer" style="width: 100%;"></div>
			</td>
		</tr>
	</table>
	<script type="text/javascript">		
		$(document).ready(function () {
			var cmb=new componente.cmb
			cmb.ini('idEstablecimiento')
			
			cmb.loadFromUrl('../../lib/cmb/cmbEstablecimientos.php')
			cmb.setChangeFunction(busquedaInformacion)
			
			function busquedaInformacion(){
				//window.top.document.getElementById('load').style.display = 'block';
				document.cookie = "idEstablecimiento="+document.getElementById('idEstablecimiento').value;
				$('#tableContainer').jtable('load');
				//window.top.document.getElementById('load').style.display = 'none';
			}
			
			$('#tableContainer').jtable({
				title: 'Puntos de Emisión',
				actions: {
					listAction: 'crud_tscPuntosEmision.php?action=list',
					createAction: 'crud_tscPuntosEmision.php?action=create',
					updateAction: 'crud_tscPuntosEmision.php?action=update',
					deleteAction: 'crud_tscPuntosEmision.php?action=delete',
				},
				fields: {
					id_punto_emision: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					codigo_punto: {
						title: 'Código',
						width: '10%'
					},
					definicion: {
						title: 'Descripción',
						width: '40%'
					},
					observacion: {
						title: 'Observación',
						width: '40%'
					},
					estado: {
						title: 'Estado',
						width: '10%',
						list:  true,
						create: false,
						edit: false,
						options: {
							"N" : "Selecciona una opción",
							"A" : "ACTIVO",
							"F" : "FINALIZADO",
							"I" : "INACTIVO"
						}
					}
				}
			  });
			//$('#tableContainer').jtable('load');
		});
		

	</script>
  </body>
</html>
