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
			<td style="height: 20px; width: 80px;">Nivel 1:</td>	
			<td><select name="idNivel1" id="idNivel1" style="width: 100%;"><option value="0" SELECTED></option></select> </td>
		</tr>
		<tr id="nivel2" style="display: none;"> 
			<td style="height: 20px; width: 80px;">Nivel 2:</td>	
			<td><select name="idNivel2" id="idNivel2" style="width: 100%;"><option value="0" SELECTED></option></select> </td>
		</tr>
		<tr id="nivel3" style="display: none;"> 
			<td style="height: 20px; width: 80px;">Nivel 3: </td>	
			<td><select name="idNivel3" id="idNivel3" style="width: 100%"><option value="0" SELECTED></option></select> </td>
		</tr>
		<tr id="nivel4" style="display: none;"> 
			<td style="height: 20px; width: 80px;">Nivel 4: </td>	
			<td><select name="idNivel4" id="idNivel4" style="width: 100%"><option value="0" SELECTED></option></select> </td>
		</tr>
		<tr id="nivel5" style="display: none;"> 
			<td style="height: 20px; width: 80px;">Nivel 5: </td>	
			<td><select name="idNivel5" id="idNivel5" style="width: 100%"><option value="0" SELECTED></option></select> </td>
		</tr>
		<tr>
			<td colspan="2" style="vertical-align: top;">
				<div id="tableContainer" style="width: 100%;"></div>
			</td>
		</tr>
	</table>  
	
	<script type="text/javascript">		
		$(document).ready(function () {
			var cmbCatalogoN1=new componente.cmb; cmbCatalogoN1.ini('idNivel1');
			var cmbCatalogoN2=new componente.cmb; cmbCatalogoN2.ini('idNivel2');
			var cmbCatalogoN3=new componente.cmb; cmbCatalogoN3.ini('idNivel3');
			var cmbCatalogoN4=new componente.cmb; cmbCatalogoN4.ini('idNivel4');
			var cmbCatalogoN5=new componente.cmb; cmbCatalogoN5.ini('idNivel5');
			document.cookie = 'idPadre=NULL';
			
			cmbCatalogoN1.loadFromUrl('../cmb/cmbCatalogoContable.php',{idpadre:null});
			cmbCatalogoN1.setChangeFunction(busquedaInformacionNivel1);
			function busquedaInformacionNivel1(){		
				if (cmbCatalogoN1.getSelectedValue() != 0)
				   {cmbCatalogoN2.clear();
					document.getElementById('nivel2').style.display = 'table-row';
					cmbCatalogoN2.loadFromUrl('../cmb/cmbCatalogoContable.php',{idpadre:cmbCatalogoN1.getSelectedValue()})
					cmbCatalogoN2.setChangeFunction(busquedaInformacionNivel2);
					document.getElementById('nivel3').style.display = 'none'; 
					document.getElementById('nivel4').style.display = 'none';
					document.getElementById('nivel5').style.display = 'none';
					
					document.cookie = "idPadre="+cmbCatalogoN1.getSelectedValue();
				   }
				else {document.getElementById('nivel2').style.display = 'none'; 
					  document.getElementById('nivel3').style.display = 'none';
					  document.getElementById('nivel4').style.display = 'none'; 
					  document.getElementById('nivel5').style.display = 'none'; 
				      document.cookie = "idPadre=NULL";}
				$('#tableContainer').jtable('load');  
			}
			
			function busquedaInformacionNivel2(){		
				if (cmbCatalogoN2.getSelectedValue() != 0)
				   {cmbCatalogoN3.clear();
					document.getElementById('nivel3').style.display = 'table-row';
					cmbCatalogoN3.loadFromUrl('../cmb/cmbCatalogoContable.php',{idpadre:cmbCatalogoN2.getSelectedValue()})
					cmbCatalogoN3.setChangeFunction(busquedaInformacionNivel3);
					document.getElementById('nivel4').style.display = 'none';
					document.getElementById('nivel5').style.display = 'none';
					
					document.cookie = "idPadre="+cmbCatalogoN2.getSelectedValue();
				   }
				else {document.getElementById('nivel3').style.display = 'none';
					  document.getElementById('nivel4').style.display = 'none';
					  document.getElementById('nivel5').style.display = 'none';
				      document.cookie = "idPadre="+cmbCatalogoN1.getSelectedValue();}
				
				$('#tableContainer').jtable('load');  
			}
			
			function busquedaInformacionNivel3(){	
				if (cmbCatalogoN3.getSelectedValue() != 0)
				   {cmbCatalogoN4.clear();
					document.getElementById('nivel4').style.display = 'table-row';
					cmbCatalogoN4.loadFromUrl('../cmb/cmbCatalogoContable.php',{idpadre:cmbCatalogoN3.getSelectedValue()})
					cmbCatalogoN4.setChangeFunction(busquedaInformacionNivel4);
					
					document.getElementById('nivel5').style.display = 'none';
					document.cookie = "idPadre="+cmbCatalogoN3.getSelectedValue();
				   }
				else {document.getElementById('nivel4').style.display = 'none'; 
					  document.getElementById('nivel5').style.display = 'none'; 
				      document.cookie = "idPadre="+cmbCatalogoN2.getSelectedValue();}
				$('#tableContainer').jtable('load');  
			}
			
			function busquedaInformacionNivel4(){	
				if (cmbCatalogoN4.getSelectedValue() != 0)
				   {cmbCatalogoN5.clear();
					document.getElementById('nivel5').style.display = 'table-row';
					cmbCatalogoN5.loadFromUrl('../cmb/cmbCatalogoContable.php',{idpadre:cmbCatalogoN4.getSelectedValue()})
					cmbCatalogoN5.setChangeFunction(busquedaInformacionNivel5);
					document.cookie = "idPadre="+cmbCatalogoN4.getSelectedValue();
				   }
				else {document.getElementById('nivel5').style.display = 'none'; 
				      document.cookie = "idPadre="+cmbCatalogoN3.getSelectedValue();}
				$('#tableContainer').jtable('load'); 
			}
			
			function busquedaInformacionNivel5(){
				document.cookie = "idPadre="+cmbCatalogoN5.getSelectedValue();
				$('#tableContainer').jtable('load');  
			}
			
			$('#tableContainer').jtable({
				title: 'Catálogo contable',
				actions: {
					listAction: 'crud_tfnCatalogoCuentas.php?action=list',
					createAction: 'crud_tfnCatalogoCuentas.php?action=create',
					updateAction: 'crud_tfnCatalogoCuentas.php?action=update',
					deleteAction: 'crud_tfnCatalogoCuentas.php?action=delete',
				},
				fields: {
					id_cuenta: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					codigo: {
						title: 'Código',
						width: '10%'
					},
					descripcion: {
						title: 'Descripción',
						width: '50%'
					},
					id_tipo_cuenta: {
						title: 'Tipo Cuenta',
						width: '15%',
						options : 'listasJTables.php?action=listTFNTiposCuentas'
					},
					id_nivel: {
						title: 'Nivel',
						width: '15%',
						options : 'listasJTables.php?action=listTFNNiveles'
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
