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
				title: 'Fabricantes',
				actions: {
					listAction: 'crud_tivFabricantes.php?action=list',
					createAction: 'crud_tivFabricantes.php?action=create',
					updateAction: 'crud_tivFabricantes.php?action=update',
					deleteAction: 'crud_tivFabricantes.php?action=delete',
				},
				fields: {
					id_fabricante: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					nombre_comercial: {
						title: 'Nombre Comercial',
						width: '15%'
					},
					ruc: {
						title: 'Identificación',
						width: '10%'
					},
					ubicacion: {
						title: 'Ubicación',
						width: '30%'
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
