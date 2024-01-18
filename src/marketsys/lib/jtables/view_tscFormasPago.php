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
				title: 'Formas de Pago',
				actions: {
					listAction: 'crud_tscFormasPago.php?action=list',
					createAction: 'crud_tscFormasPago.php?action=create',
					updateAction: 'crud_tscFormasPago.php?action=update',
					deleteAction: 'crud_tscFormasPago.php?action=delete',
				},
				fields: {
					id_forma_pago: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					codigo: {
						title: 'CódigoSRI',
						width: '10%'
					},
					descripcion: {
						title: 'Descripción',
						width: '20%'
					},
					id_destino_transaccional: {
						title: 'Ejecución',
						width: '20%',
						options: {
							"0" : "MÚLTIPLE",
							"1" : "EFECTIVO",
							"2" : "BANCOS",
							"3" : "CRÉDITOS",
							"4" : "CHEQUES"
						}
					},
					id_detalle_destino: {
						title: 'Destino Banco',
						width: '20%',
						options : 'listasJTables.php?action=listTSCCuentasBancarias'
					},
					id_cuenta_contable: {
						title: 'Cuenta Contable',
						width: '20%',
						options : 'listasJTables.php?action=listTFNCatalogoContable'
					},
					tiempo_vigencia: {
						title: 'Tiempo',
						width: '10%'
					},
					aplicable_facturas: {
						title: 'Facturas',
						width: '10%',
						options: {
							"" : "Selecciona una opción",
							"N" : "NO",
							"S" : "SI"
						}
					},
					aplicable_compras: {
						title: 'Compras',
						width: '10%',
						options: {
							"" : "Selecciona una opción",
							"N" : "NO",
							"S" : "SI"
						}
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
