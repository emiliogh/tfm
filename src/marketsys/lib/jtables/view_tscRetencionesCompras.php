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
  <body>
	<table width="100%" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
		<tr id="nivel1">
			<td style="height: 20px; width: 120px;">Tipos de Retención:</td>	
			<td><select name="idRetencion" id="idRetencion" style="width: 100%;" onChange="busquedaInformacionNivel1();">
					<option value="0" SELECTED>Seleccione una opción</option>
				    <option value="1">Retención en IR</option>
				    <option value="2">Retención en IVA</option>
				</select> </td>
		</tr>
		<tr>
			<td colspan="2" style="vertical-align: top;">
				<div id="tableContainer" style="width: 100%;"></div>
			</td>
		</tr>
	</table>  
	
	<script type="text/javascript">
		function busquedaInformacionNivel1(){
				var cmbTipoRetencion = document.getElementById("idRetencion").value;
					if (cmbTipoRetencion != 0)
					   {document.cookie = "idRetencion="+cmbTipoRetencion;}
					else {document.cookie = "idRetencion=NULL";}
					$('#tableContainer').jtable('load');  
			}
		
		$(document).ready(function () {
			$('#tableContainer').jtable({
				title: 'Configuración de retenciones en Compras',
				actions: {
					listAction: 'crud_tscRetencionesCompras.php?action=list',
					createAction: 'crud_tscRetencionesCompras.php?action=create',
					updateAction: 'crud_tscRetencionesCompras.php?action=update',
					deleteAction: 'crud_tscRetencionesCompras.php?action=delete',
				},
				fields: {
					id_retencion: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					id_tipo_retenciones: {
						create: false,
						edit: false,
						list: false
					},
					descripcion: {
						title: 'Descripción',
						width: '20%'
					},
					valor: {
						title: 'valor',
						width: '10%'
					},
					codigo_ats: {
						title: 'Código ATS',
						width: '10%'
					},
					id_cuenta_contable: {
						title: 'Cuenta Contable',
						width: '15%',
						options : 'listasJTables.php?action=listTFNCatalogoContable'
						
					},
					estado: {
						title: 'Estado',
						width: '5%',
						list:  true,
						create: false,
						edit: false,
						options: {
							"N" : "Selecciona una opción",
							"A" : "ACTIVO",
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
