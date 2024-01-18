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
				title: 'Personal',
				actions: {
					listAction: 'crud_tgnPersonal.php?action=list',
					createAction: 'crud_tgnPersonal.php?action=create',
					updateAction: 'crud_tgnPersonal.php?action=update',
					deleteAction: 'crud_tgnPersonal.php?action=delete',
				},
				fields: {
					id_personal: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					tipo_identificacion: {
						title: 'Estado',
						list:  false,
						create: true,
						edit: true,
						options : 'listasJTables.php?action=tiposIdentificacion'
						
					},
					numero_identificacion: {
						title: 'Identificación',
						width: '10%'
					},
					nombre: {
						title: 'Nombres',
						width: '30%'
					},
					id_genero: {
						title: 'Género',
						list:  false,
						create: true,
						edit: true,
						options : 'listasJTables.php?action=generosSexuales'
						
					},
					id_estado_civil: {
						title: 'Estado Civil',
						list:  false,
						create: true,
						edit: true,
						options : 'listasJTables.php?action=estadosCiviles'
						
					},
					id_cargo: {
						title: 'Perfil',
						width: '20%',
						list:  true,
						create: true,
						edit: true,
						options : 'listasJTables.php?action=cargos'
						
					},
					id_departamento: {
						title: 'Unidad',
						width: '20%',
						list:  true,
						create: true,
						edit: true,
						options : 'listasJTables.php?action=departamentos'
						
					},
					fecha_nacimiento: {
						title: 'Fecha nacimiento',
						type: 'date',
						list:  false
					},
					correo_personal: {
						title: 'Email personal',
						width: '10%'
					},
					correo_institucional: {
						title: 'Email_Institucional',
						list:  false
					},
					telefono: {
						title: 'Teléfono',
						width: '7%'
					},
					telefono_convencional: {
						title: 'Convencional',
						width: '7%'
					},
					direccion: {
						title: 'Dirección',
						list:  false
					},
					estado: {
						title: 'Estado',
						width: '7%',
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
