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
				title: 'Proveedores',
				actions: {
					listAction: 'crud_tivProveedores.php?action=list',
					createAction: 'crud_tivProveedores.php?action=create',
					updateAction: 'crud_tivProveedores.php?action=update',
					deleteAction: 'crud_tivProveedores.php?action=delete',
				},
				fields: {
					id_proveedor: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					identificacion: {
						title: 'Identificación',
						width: '15%'
					},
					razon_social: {
						title: 'Razón Social',
						width: '40%'
					},
					nombre_comercial: {
						title: 'Nombre Comercial',
						width: '40%'
					},
					credito: {
						title: 'Crédito',
						width: '20%',
						list:  true,
						options: {
							"I" : "Selecciona una opción",
							"S" : "SI APLICA",
							"N" : "NO APLICA"
						}
					},
					tiempo_credito: {
						title: 'Tiempo días',
						width: '40%'
					},
					id_categoria: {
						title: 'Categoría',
						width: '40%',
						options: 'acciones.php?action=listTIVCategorias',
					},
					categoria: {
						title: 'Categoría',
						width: '40%',
						list:  false,
						create: false,
						edit: false,
					},
					vendedor: {
						title: 'Vendedor',
						width: '40%'
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
