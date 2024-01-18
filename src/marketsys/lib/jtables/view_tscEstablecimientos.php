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
  </head>
  <body>
	<div id="tableContainer" style="width: 100%;"></div>
	<script type="text/javascript">		
		$(document).ready(function () {
			$('#tableContainer').jtable({
				title: 'Establecimientos',
				actions: {
					listAction: 'crud_tscEstablecimientos.php?action=list',
					createAction: 'crud_tscEstablecimientos.php?action=create',
					updateAction: 'crud_tscEstablecimientos.php?action=update',
					deleteAction: 'crud_tscEstablecimientos.php?action=delete',
				},
				fields: {
					id_establecimiento: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					codigo_establecimiento: {
						title: 'Código',
						width: '5%'
					},
					id_tipo_establecimiento: {
						title: 'Tipo',
						width: '5%',
						options: {
							"0" : "Selecciona una opción",
							"1" : "FACTURAS",
							"2" : "RETENCIONES"
						}
					},
					definicion: {
						title: 'Descripción',
						width: '20%'
					},
					direccion: {
						title: 'Dirección',
						width: '30%'
					},
					nombre_comercial: {
						title: 'Nombre comercial',
						width: '20%'
					},
					identificador_matriz: {
						title: 'Matriz',
						width: '5%',
						options: {
							"0" : "Selecciona una opción",
							"S" : "SI",
							"N" : "NO"
						}
					},
					id_bodega: {
						title: 'Bodega',
						width: '20%',
						options : 'listasJTables.php?action=listTSCBodegas'
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
							"I" : "INACTIVO"
						}
					}
				}
			  });
			$('#tableContainer').jtable('load');
		});
		

	</script>
  </body>
</html>
