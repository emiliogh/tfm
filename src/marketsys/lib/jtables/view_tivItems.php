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
			<td style="height: 20px; width: 80px;">
				Producto:  
			</td>	
			<td>
				<select name="cmbProducto" id="cmbProducto" style="width: 100%">
				  <option value="0" SELECTED>Seleccione un Producto.</option>
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
			cmb.setChangeFunction(dataProductos)
			
			var cmb2=new componente.cmb
			cmb2.ini('cmbProducto')
						
			function dataProductos(){
				cmb2.clear()
				cmb2.loadFromUrl('../../lib/cmb/cmbTivProductos.php',{id:cmb.getSelectedValue()})
				cmb2.setChangeFunction(busquedaInformacion)
			}
			
			
			
			function busquedaInformacion(){
				document.cookie = "id_categoria="+document.getElementById('cmbCategoria').value;
				document.cookie = "id_producto="+document.getElementById('cmbProducto').value;
				$('#tableContainer').jtable('load');
			}
			
		    //Prepare jTable
			$('#tableContainer').jtable({
				title: 'Listado de Ítems',
				actions: {
					listAction: 'crud_tivItems.php?action=list',
					createAction: 'crud_tivItems.php?action=create',
					updateAction: 'crud_tivItems.php?action=update',
					deleteAction: 'crud_tivItems.php?action=delete'
				},
				fields: {
					id_clasificacion: {
						title: 'Categoría',
						width: '20%',
						type: 'list',
						create: false,
						list: false,
						edit: false,
						options: 'listasJTables.php?action=listTIVCategorias',
					},
					id_producto: {
						title: 'Producto',
						width: '20%',
						type: 'list',
						list: false,
						create: false,
						edit: false,
						display: function (data) {
                        return( data.record.id_producto);
                    	},
	                    dependsOn: 'id_categoria', 
	                    options: function (data) {
							if (data.source == 'list') {
								return 'listasJTables.php?action=listTIVProductos&idCategoria=0';
							}
							return 'listasJTables.php?action=listTIVProductos&idCategoria=' + data.dependedValues.id_categoria;
						}
					},
					id_item: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					descripcion: {
						title: 'Descripcion',
						width: '15%'
					},
					observacion: {
						title: 'Detalle',
						width: '30%'
					},
					codigo_barra: {
						title: 'Código_Barra',
						width: '15%'
					},
					id_fabricante: {
						title: 'Fabricante',
						width: '15%',
						list: false,
						options: 'listasJTables.php?action=listTIVFabricantes',
					},
					id_presentacion: {
						title: 'Presentación',
						width: '15%',
						list: false,
						options: 'listasJTables.php?action=listTIVPresentaciones',
					},
					id_graba_iva: {
						title: 'IVA',
						width: '5%',
						options: {
							1 : "SI",
							0 : "NO"
						}
					},
					id_venta_sin_stock: {
						title: 'Vta_sin_stock',
						width: '5%',
						options: {
							1 : "SI",
							0 : "NO"
						}
					},
					precio_costo: {
						title: 'Precio',
						width: '5%'
					},
					porcentaje_gan_min: {
						title: '%Ganancia',
						width: '5%'
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
