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
			<td style="height: 20px; width: 120px;">Tipos de clientes:</td>	
			<td><select name="idTipoCliente" id="idTipoCliente" style="width: 100%;"><option value="0" SELECTED></option></select> </td>
		</tr>
		<tr>
			<td colspan="2" style="vertical-align: top;">
				<div id="tableContainer" style="width: 100%;"></div>
			</td>
		</tr>
	</table>  
	
	<script type="text/javascript">		
		$(document).ready(function () {
			var cmbCatalogoN1 = new componente.cmb; 
				cmbCatalogoN1.ini('idTipoCliente');
			
			cmbCatalogoN1.loadFromUrl('../cmb/cmbTiposClientes.php');
			cmbCatalogoN1.setChangeFunction(busquedaInformacionNivel1);
			
			function busquedaInformacionNivel1(){		
				if (cmbCatalogoN1.getSelectedValue() != 0)
				   {document.cookie = "idTipoCliente="+cmbCatalogoN1.getSelectedValue();}
				else {document.cookie = "idTipoCliente=NULL";}
				$('#tableContainer').jtable('load');  
			}
						
			$('#tableContainer').jtable({
				title: 'Configuración de retenciones',
				actions: {
					listAction: 'crud_tfnConfiguracionRetenciones.php?action=list',
					createAction: 'crud_tfnConfiguracionRetenciones.php?action=create',
					updateAction: 'crud_tfnConfiguracionRetenciones.php?action=update',
					deleteAction: 'crud_tfnConfiguracionRetenciones.php?action=delete',
				},
				fields: {
					id_configuracion: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					id_clasificacion_producto: {
						title: 'Clasificación producto',
						width: '20%',
						options : 'listasJTables.php?action=listTIVClasificacionProductos'
					},
					fecha_desde: {
						title: 'Fecha desde',
						width: '10%',
						type: 'date'
					},
					fecha_hasta: {
						title: 'Fecha hasta',
						width: '10%',
						type: 'date'
					},
					porcentaje_retencion_renta: {
						title: '% Fuente',
						width: '7%',
						
					},
					id_cuenta_contable_renta: {
						title: 'Cuenta',
						width: '15%',
						options : 'listasJTables.php?action=listTFNCatalogoContable'
						
					},
					porcentaje_retencion_iva: {
						title: '% IVA',
						width: '7%'
					},
					id_cuenta_contable_iva: {
						title: 'Cuenta',
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
