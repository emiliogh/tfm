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
  <body onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<table width="100%" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
		<tr>
			<td style="height: 20px; width: 80px;">
				Categoría:  
			</td>	
			<td>
				<select name="cmbCategoria" id="cmbCategoria" style="width: 100%">
				  <option value="0" SELECTED>Seleccione una Categoría.</option>
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
			cmb.ini('cmbCategoria')
			
			cmb.loadFromUrl('../../lib/cmb/cmbTivCategoriasProductos.php')
			cmb.setChangeFunction(busquedaInformacion)
			
			function busquedaInformacion(){
				document.cookie = "idCategoria="+document.getElementById('cmbCategoria').value;
				$('#tableContainer').jtable('load');
			}
			
		    //Prepare jTable
			$('#tableContainer').jtable({
				title: 'Listado de Productos',
				actions: {
					listAction: 'crud_tivProductos.php?action=list',
					createAction: 'crud_tivProductos.php?action=create',
					updateAction: 'crud_tivProductos.php?action=update',
					deleteAction: 'crud_tivProductos.php?action=delete'
				},
				fields: {
					id_categoria: {
						title: 'Categoría',
						width: '20%',
						type: 'list',
						create: false,
						list: false,
						options: 'acciones.php?action=listTIVCategorias',
					},
					id_producto: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					nombre: {
						title: 'Nombre',
						width: '15%'
					},
					descripcion: {
						title: 'Detalle',
						width: '15%'
					},
					perecible: {
						title: 'Perecible',
						width: '30%',
						options: {
							"N" : "Selecciona una opción",
							"S" : "PERECIBLE",
							"N" : "NO PERECIBLE"
						}
					},
					stock_minimo: {
						title: 'Stock Mínimo',
						width: '15%'
					},
					estado: {
						title: 'Estado',
						width: '20%',
						list:  true,
						edit: false,
						create: false,
						options: {
							"N" : "Selecciona una opción",
							"A" : "ACTIVO",
							"I" : "INACTIVO"
						}
					}
				},
			});

			//Load person list from server
			//$('#PeopleTableContainer').jtable('load');
		});

	</script>
 
  </body>
</html>
