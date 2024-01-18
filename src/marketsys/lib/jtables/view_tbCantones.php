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
				País:  
			</td>	
			<td>
				<select name="idPais" id="idPais" style="width: 100%">
				  <option value="0" SELECTED>Seleccione un País.</option>
				</select> 
			</td>
		</tr>
		<tr>	
			<td style="height: 20px; width: 80px; font-family: Vegur, 'PT Sans', Verdana, sans-serif;">
				Provincia: 
			</td>	
			<td>	
				<select name="idProvincia" id="idProvincia" style="width: 100%">
				  <option value="0" SELECTED>Seleccione una Provincia.</option>
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
			cmb.ini('idPais')
			
			cmb.loadFromUrl('../../lib/cmb/cmbPaises.php')
			cmb.setChangeFunction(dataProvincias)

			var cmb2=new componente.cmb
			cmb2.ini('idProvincia')
						
			function dataProvincias(){
				cmb2.clear()
				cmb2.loadFromUrl('../../lib/cmb/cmbProvincias.php',{id:cmb.getSelectedValue()})
				cmb2.setChangeFunction(busquedaInformacion)
			}
			
			function busquedaInformacion(){
				//window.top.document.getElementById('load').style.display = 'block';
				document.cookie = "idpais="+document.getElementById('idPais').value;
				document.cookie = "idprovincia="+document.getElementById('idProvincia').value;
				$('#tableContainer').jtable('load');
				//window.top.document.getElementById('load').style.display = 'none';
			}
			
			$('#tableContainer').jtable({
				title: 'Cantones',
				actions: {
					listAction: 'crud_tbCantones.php?action=list',
					createAction: 'crud_tbCantones.php?action=create',
					updateAction: 'crud_tbCantones.php?action=update',
					deleteAction: 'crud_tbCantones.php?action=delete',
				},
				fields: {
					id_canton: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					descripcion: {
						title: 'Descripción',
						width: '50%'
					},
					abreviatura: {
						title: 'Abreviatura',
						width: '20%'
					},
					codigo_parroquia: {
						title: 'Código',
						width: '20%'
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
