<?php include "../php/sesionSecurityForms.php"; ?>
<html>
  <head>
    <link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="scripts/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" />	
	<script src="scripts/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="scripts/jtable/jquery.jtable.js" type="text/javascript"></script>	
    <script type="text/javascript" src="Scripts/jquery.validationEngine.js"></script>
	<script type="text/javascript" src="Scripts/jquery.validationEngine-es.js"></script>
	<link href="scripts/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
	<div id="tableContainer" style="width: 100%;"></div>
	<script type="text/javascript">		
		$(document).ready(function () {
			$('#tableContainer').jtable({
				title: 'Bodegas',
				actions: {
					listAction: 'crud_tivBodegas.php?action=list',
					createAction: 'crud_tivBodegas.php?action=create',
					updateAction: 'crud_tivBodegas.php?action=update',
					deleteAction: 'crud_tivBodegas.php?action=delete',
				},
				fields: {
					id_bodega: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					descripcion: {
						title: 'Descripción',
						width: '15%'
					},
					ubicacion: {
						title: 'Ubicación',
						width: '40%'
					},
					permite_despacho: {
						title: 'Despachable',
						width: '40%',
						options: {
							"V" : "Selecciona una opción",
							"S" : "PERMITE DESPACHO",
							"N" : "NO PERMITE DESPACHO"
						}
					},
					estado: {
						title: 'Estado',
						width: '20%',
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
