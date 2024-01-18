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
				title: 'Proveedores',
				actions: {
					listAction:   'crud_tsProveedores.php?action=list',
					createAction: 'crud_tsProveedores.php?action=create',
					updateAction: 'crud_tsProveedores.php?action=update',
					deleteAction: 'crud_tsProveedores.php?action=delete',
				},
				fields: {
					id_proveedor: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					id_tipo_proveedor: {
						title: 'Tipo Proveedor',
						width: '10%',
						options : 'listasJTables.php?action=listTCUTiposProveedores',
					},
					id_tipo_identificacion: {
						title: 'Tipo_identif.',
						width: '10%',
						options : 'listasJTables.php?action=tiposIdentificacion',
					},
					numero_identificacion: {
						title: 'Identificación',
						width: '20%'
					},
					nombre_proveedor: {
						title: 'Razón social',
						width: '20%'
					},
					nombre_comercial: {
						title: 'Nombre comercial',
						width: '20%',
						options : 'listasJTables.php?action=listTBEstadosCiviles',
						list: false
					},
					direccion: {
						title: 'Dirección',
						width: '20%'
					},
					correo_electronico: {
						title: 'Email',
						width: '20%'
					},
					telefono: {
						title: 'Teléfono',
						width: '20%'
					},
					id_categoria_proveedor: {
						title: 'Categoría',
						width: '20%',
						options : 'listasJTables.php?action=listTCUCategoriasProveedores',
						list: false
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
