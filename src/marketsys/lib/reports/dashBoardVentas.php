<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DashBoard Ventas</title>
  <link rel="stylesheet" type="text/css" href="../css/fuenteGoogle.css"/>
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>	
  <link rel="stylesheet" type="text/css" href="../css/material-dashboard.css"/>
  <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.css"/>
  <style>
		.button {
		  background-color: #4CAF50;
		  border: none;
		  color: white;
		  padding: 5px 32px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  font-size: 12px;
		  margin: 4px 2px;
		  cursor: pointer;
	      width: 100%;
		}
	</style>
  <script src="../rGraph/RGraph.common.core.js"></script>
  <script src="../rGraph/RGraph.bar.js"></script>
</head>

<body class="" style="background: #ccc;">
  <div class="wrapper ">
    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon" 
					 onClick="graficaInfoPrincipal('Gráfico de Peronas Naturales clasificadas por Ámbito de la Actividad Principal', 1);">
                  <div class="card-icon">
                    <i class="fa fa-bar-chart-o" aria-hidden="true"></i>
                  </div>
                  <p class="card-category" 
					 style="color: #B7950B; font-weight: 501; line-height: 100%;">
					  <span id="idParam01"></span>
				  </p>
                </div>
                <div class="card-footer" style="margin-top: 0px;">
                  <div class="stats">
                    Evolución por Fechas
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon" 
					 onClick="graficaInfoPrincipal('Gráfico de Personas Jurídicas clasificadas por Ámbito Cultural Principal', 2);">
                  <div class="card-icon">
                    <i class="fa fa-sitemap" aria-hidden="true"></i>
                  </div>
                  <p class="card-category" style="color: #196F3D; font-weight: 501; line-height: 100%;">
					  <span id="idParam02"></span>
				  </p>
                </div>
				<div class="card-footer" style="margin-top: 0px;">
                  <div class="stats">
                    Categorías de Productos
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon" 
					 onClick="graficaInfoPrincipal('Gráfico de Personas Naturales clasificados por País registrado para su actividad', 3);">
                  <div class="card-icon">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                  </div>
                  <p class="card-category" style="color: #922B21; font-weight: 501; line-height: 100%;">
					  <span id="idParam03"></span>
				  </p>
                </div>
                <div class="card-footer" style="margin-top: 0px;">
                  <div class="stats">
                    Productos
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon" 
					 onClick="graficaInfoPrincipal('Gráfico de Personas Jurídicas clasificadas por Provincia registrada para su actividad', 4);">
                  <div class="card-icon">
                    <i class="fa fa-money" aria-hidden="true"></i>
                  </div>
                  <p class="card-category" style="color: #247980; font-weight: 501; line-height: 100%;">
					  <span id="idParam04"></span>
					</p>
                </div>
                <div class="card-footer" style="margin-top: 0px;">
                  <div class="stats">
                    Formas de pago
                  </div>
                </div>
              </div>
            </div>
          </div>
		  <div class="row">
            <div class="col-md-12">
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  Parámetros de búsqueda
                </div>
				<div class="card-footer">
                  <div class="stats" style="width: 100%;">
                      <table style="width: 100%; margin: 5px;">
						  <tr>
							<td class="clsEtiquetasTable" style="width:15%;text-align:right;padding-right:10px;">
								<b>Fecha desde:</b>
							</td>
							<td class="clsObjetosTable" style="width: 20%;">
								<input id="fechaDesde" onFocus="this.blur()" style="height: 20px; width: 100%; text-align: center;" 
									   value="<?php echo date("01/m/Y")?>" placeholder="Fecha desde">
							</td>
							<td class="clsEtiquetasTable" style="width:15%;text-align:right;padding-right:10px;">
								<b>Fecha hasta:</b>
							</td>
							<td class="clsObjetosTable" style="width: 20%;">
								<input id="fechaHasta" onFocus="this.blur()" style="height: 20px; width: 100%; text-align: center;" 
									   value="<?php echo date("d/m/Y")?>" placeholder="Fecha hasta">
							</td>
							<td class="clsEtiquetasTable" style="width: 20%;">
								<button class="button">
									<i class="fa fa-refresh" aria-hidden="true"></i>  Actualizar Información
								</button>
								
							</td>  
						</tr>
					</table>
                  </div>
                </div>
              </div>
            </div>
          </div>	
          <div class="row">
            <div class="col-md-12">
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  Detalle de la Información
				  <span style="float:right; right: 10px;"> 
				    <!--<table>
						<tr>
							<td style="width: 30px; font-size: 1.6em; color: #196F3D;" onClick="exportarXLSInformacion();">
								<i class="fa fa-file-excel-o" aria-hidden="true"></i>
							</td>
							<td style="width: 30px; font-size: 1.6em; color: #B7950B;" onClick="exportarIESS();">
								<i class="fa fa-file-text" aria-hidden="true"></i>
							</td>
							<td style="width: 30px; font-size: 1.6em; color: #2471A3;">
								<i class="fa fa-envelope-o" aria-hidden="true" onClick="exportarXLSCorreos();"></i>
							</td>
						</tr>
					</table>-->
				  </span>
                </div>
                <div class="card-body" id="contenedorGrafico">
                    <div style="padding-left: 35px" id="contenedorGraficoCVS" height="100%">
						<canvas id="cvs" width="750" height="250">[No canvas support]</canvas>
					</div>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="fa fa-clock-o" aria-hidden="true"></i> Generación:&nbsp;<span id="infoGeneracionRep"> </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script type="text/javascript" src="../jquery/jquery.min.js"></script>
  <script type="text/javascript" src="../js/jquery.datetimepicker.full.js"></script>	
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <script type="text/javascript" src="../js/funciones.generales.js"></script>
  <script type="text/javascript" src="../js/componentes.js"></script>
  <script type="text/javascript" src="../js/bootstrap-material-design.min.js"></script>
  <script type="text/javascript" src="../js/material-dashboard.js?v=2.1.1"></script>
  <script type="text/javascript" src="../js/pnotify.custom.js"></script>  
  <script>
	$(document).ready(function () {
		$.datetimepicker.setLocale('es');
		$('#fechaDesde').datetimepicker({
			dayOfWeekStart : 1,
			timepicker:false,
			format:'d/m/Y',
			formatDate:'Y/m/d'
		});
		$('#fechaHasta').datetimepicker({
			dayOfWeekStart : 1,
			timepicker:false,
			format:'d/m/Y',
			formatDate:'Y/m/d'
		});
		
		cargaInformacionVentas(0);
		
	});
	  
	function cargaInformacionVentas(i){
		url = '../php/reporteVentasInicial.php';
		fechaDesde = document.getElementById("fechaDesde").value;
		fechaHasta = document.getElementById("fechaHasta").value;
		$.ajax({
			url: url,
			type: 'POST',
			data: 'id='+i+'&fechaDesde='+fechaDesde+'&fechaHasta='+fechaHasta,
			dataType:'json',
			success:function(data){
				data = eval(data);
				var datos = data[4];
				var etiquetas = data[1];
				/*for (var i=0; i<data.length; ++i) {
					a = data[i];
					datos[i] = a[0];
					etiquetas[i] = a[1];
					//console.log(a[0]);

				}*/
				RGraph.reset(document.getElementById('cvs'));
				document.getElementById('cvs').width  = parseInt(window.innerWidth)-100;
				//document.getElementById("").style.height = '560px';
				
				
				new RGraph.Bar({
					id: 'cvs',
					data: datos,
					options: {
						labelsAbove: true,
						labelsAboveColor: 'black',
						labelsAboveSize: 9,
						//marginInner: 20,
						colors: ['#003399', '#009933', '#00FF00', '#00FFCC', '#663333', '#666699', '#993399', 
								 '#996600', '#99CC99', '#CC6600', '#CC9966', '#CCCCCC', '#FF0000', '#FF3366', 
								 '#FFCC00', '#FFFF00', '#FFFF99','#003399', '#009933', '#00FF00', '#00FFCC', 
								 '#663333', '#666699', '#993399', '#996600', '#99CC99', '#CC6600', '#CC9966', 
								 '#CCCCCC', '#FF0000', '#FF3366', '#FFCC00', '#FFFF00', '#FFFF99'],
						colorsSequential: true,
						xaxisLabels: etiquetas,
						textSize: 10,
						textColor: 'gray',
						backgroundGridVlines: true,
						backgroundGridBorder: true,
						axes: false,
						title: 'Recaudación por días',
						labelsDecimals: 2,
						scaleDecimals: 2,
						labelsInnerDecimals: 2,
						labelsAbove: true,
            			labelsAboveDecimals: 2,
						titleSize: 14,
						titleX: 0,
						titleY: 5,
						titleHalign: 'left',
						titleColor: '#003366',
						yaxisLabelsOffsetx: -10,
						xaxisLabelsAngle: 25
					}
				}).grow({frames: 60});
				
				document.getElementById("idParam01").innerHTML = data[6]+' USD';
				document.getElementById("idParam02").innerHTML = data[7]+' Categorías';
				document.getElementById("idParam03").innerHTML = data[8]+' Ítems';
				document.getElementById("idParam04").innerHTML = data[9]+' Formas pago';
				document.getElementById("infoGeneracionRep").innerHTML = data[10];
				parent.document.getElementById("divLoadding").style.display = 'none';
			}
		});
	}  
	
	function graficaInfoPrincipal(titulo, idconsulta){
			if (parent.document.getElementById("divLoadding").style.display != 'block'){
				parent.document.getElementById("divLoadding").style.display = 'block';
				}
			var ancho = window.innerWidth;
			ancho = ancho - 100;
			document.getElementById("cvs").style.width = ancho+'px';
			
			url = '../../lib/php/infoDashBoardInitRGraph.php';
			idPais = document.getElementById("txtPaisActividad").value;
			idProvincia = document.getElementById("txtProvinciaActividad").value;
			idPais_ = document.getElementById("txtPaisActividad_").value;
			idProvincia_ = document.getElementById("txtProvinciaActividad_").value;
			idActividadP = document.getElementById("txtActividadPersonas").value;
			idActividadE = document.getElementById("txtActividadEmpresas").value;
			document.getElementById("idconsulta").innerHTML = idconsulta;
			
			//document.getElementById("divLoadding").style.display = 'block';
			if (idconsulta == 1 || idconsulta == 2){
				document.getElementById("txtActividadPersonas").value = 0;
				document.getElementById("txtActividadEmpresas").value = 0;
			}
			if (idconsulta == 1 || idconsulta == 2 || idconsulta == 3 || idconsulta == 4){
				document.getElementById("txtPaisActividad").value = 0;
				document.getElementById("txtProvinciaActividad").value = 0;
				document.getElementById("txtPaisActividad_").value = 0;
				document.getElementById("txtProvinciaActividad_").value = 0;
			} else if (idconsulta == 5){
						document.getElementById("txtProvinciaActividad").value = 0;
						document.getElementById("txtPaisActividad_").value = 0;
						document.getElementById("txtProvinciaActividad_").value = 0;
					}else if (idconsulta == 6){
								document.getElementById("txtPaisActividad_").value = 0;
								document.getElementById("txtProvinciaActividad_").value = 0;
							}else if (idconsulta == 7){
										document.getElementById("txtPaisActividad").value = 0;
										document.getElementById("txtProvinciaActividad").value = 0;
										document.getElementById("txtProvinciaActividad_").value = 0;
									}else if (idconsulta == 8){
												document.getElementById("txtPaisActividad").value = 0;
												document.getElementById("txtProvinciaActividad").value = 0;
											}
			
			RGraph.reset(document.getElementById('cvs'));
			
			$.ajax({
				type:'POST',
				data: 'id='+idconsulta+'&idPais='+idPais+'&idProvincia='+idProvincia+'&idPais_='+idPais_+'&idProvincia_='+idProvincia_+'&idActividadP='+idActividadP+'&idActividadE='+idActividadE,
				url: url,
				success:function(data){
					  data = eval(data);
					    genr = data[1];
					    data = data[0];
					    var datos = [];
						var etiquetas = [];
						for (var i=0; i<data.length; ++i) {
							 a = data[i];
							 datos[i] = a[0];
							 etiquetas[i] = a[1];
							 //console.log(a[0]);
							
						}
						
						new RGraph.Bar({
							id: 'cvs',
							data: datos,
							options: {
								labelsAbove: true,
								labelsAboveColor: 'black',
								labelsAboveSize: 9,
								//marginInner: 20,
								colors: ['#003399', '#009933', '#00FF00', '#00FFCC', '#663333', '#666699', '#993399', '#996600', '#99CC99', '#CC6600', '#CC9966', '#CCCCCC', '#FF0000', '#FF3366', '#FFCC00', '#FFFF00', '#FFFF99','#003399', '#009933', '#00FF00', '#00FFCC', '#663333', '#666699', '#993399', '#996600', '#99CC99', '#CC6600', '#CC9966', '#CCCCCC', '#FF0000', '#FF3366', '#FFCC00', '#FFFF00', '#FFFF99'],
								colorsSequential: true,
								xaxisLabels: etiquetas,
								textSize: 10,
								textColor: 'gray',
								backgroundGridVlines: true,
								backgroundGridBorder: true,
								axes: false,
								title: titulo,
								titleSize: 14,
								titleX: 0,
								titleY: 5,
								titleHalign: 'left',
								titleColor: '#003366',
								yaxisLabelsOffsetx: -10,
								xaxisLabelsAngle: 25
							}
						}).grow({frames: 60});
					
						document.getElementById("infoGeneracionRep").innerHTML = genr;
						document.getElementById("contenedorGrafico").style.height = '560px';
					    parent.document.getElementById("divLoadding").style.display = 'none';
					  
					}
				});
		
		}
		
		function exportarXLSCorreos(){
			parent.document.getElementById("divLoadding").style.display = 'block';
			idPais = document.getElementById("txtPaisActividad").value;
			idProvincia = document.getElementById("txtProvinciaActividad").value;
			idPais_ = document.getElementById("txtPaisActividad_").value;
			idProvincia_ = document.getElementById("txtProvinciaActividad_").value;
			idconsulta = document.getElementById("idconsulta").innerHTML;
			idActividadP = document.getElementById("txtActividadPersonas").value;
			idActividadE = document.getElementById("txtActividadEmpresas").value;
			
			var page='../reports/excelCorreosDashBoard.php';
			//window.open(page+'?id='+idconsulta+'&idPais='+idPais+'&idProvincia='+idProvincia+'&idPais_='+idPais_+'&idProvincia_='+idProvincia_+'&idActividadP='+idActividadP+'&idActividadE='+idActividadE);
			$.ajax({
				url: page,
				type: 'GET',
				data: 'id='+idconsulta+'&idPais='+idPais+'&idProvincia='+idProvincia+'&idPais_='+idPais_+'&idProvincia_='+idProvincia_+'&idActividadP='+idActividadP+'&idActividadE='+idActividadE,
				dataType:'json'
				}).done(function(data){
					if (data.op == 'ok'){
						var $a = $("<a>");
						$a.attr("href",data.file);
						$("body").append($a);
						$a.attr("download","listaCorreos.xlsx");
						$a[0].click();
						$a.remove();
						parent.document.getElementById("divLoadding").style.display = 'none';
					}
				});
				
		}
		
		function exportarXLSInformacion(){
			parent.document.getElementById("divLoadding").style.display = 'block';
			
			idPais = document.getElementById("txtPaisActividad").value;
			idProvincia = document.getElementById("txtProvinciaActividad").value;
			idPais_ = document.getElementById("txtPaisActividad_").value;
			idProvincia_ = document.getElementById("txtProvinciaActividad_").value;
			idconsulta = document.getElementById("idconsulta").innerHTML;
			idActividadP = document.getElementById("txtActividadPersonas").value;
			idActividadE = document.getElementById("txtActividadEmpresas").value;
			
			var page='../reports/excelInformacionDashBoard.php';
			//window.open(page+'?id='+idconsulta+'&idPais='+idPais+'&idProvincia='+idProvincia+'&idPais_='+idPais_+'&idProvincia_='+idProvincia_+'&idActividadP='+idActividadP+'&idActividadE='+idActividadE);
			$.ajax({
				url: page,
				type: 'GET',
				data: 'id='+idconsulta+'&idPais='+idPais+'&idProvincia='+idProvincia+'&idPais_='+idPais_+'&idProvincia_='+idProvincia_+'&idActividadP='+idActividadP+'&idActividadE='+idActividadE,
				dataType:'json'
				}).done(function(data){
					if (data.op == 'ok'){
						var $a = $("<a>");
						$a.attr("href",data.file);
						$("body").append($a);
						$a.attr("download","informacionRUAC.xlsx");
						$a[0].click();
						$a.remove();
						parent.document.getElementById("divLoadding").style.display = 'none';
					}
				});	
		}
		
		function exportarIESS(){
			idPais = document.getElementById("txtPaisActividad").value;
			idProvincia = document.getElementById("txtProvinciaActividad").value;
			idPais_ = document.getElementById("txtPaisActividad_").value;
			idProvincia_ = document.getElementById("txtProvinciaActividad_").value;
			idProvincia_ = document.getElementById("txtProvinciaActividad_").value;
			idProvincia_ = document.getElementById("txtProvinciaActividad_").value;
			idconsulta = document.getElementById("idconsulta").innerHTML;
			if (idconsulta == 2 || idconsulta == 4 || idconsulta == 7 || idconsulta == 8)
			   {var stack_bar_bottom = {"dir1": "up", "dir2": "right", "spacing1": 0, "spacing2": 0};
				//document.getElementById("divLoadding").style.display = 'none';
				var notice = new PNotify({
					 title:'Error Generación',
					 text: 'La información del IESS, esta relacionada exclusivamente a las personas naturales, verifique la opción utilizada. <br>Si el problema persiste comuniquese con el administrador.',
					 type: 'error',
					 addclass: 'stack-bar-bottom',
					 stack: stack_bar_bottom,
					 width: "50%"
					});}else{
							var page='../reports/excelInformacionIESS.php';
							window.open(page+'?id='+idconsulta+'&idPais='+idPais+'&idProvincia='+idProvincia+'&idPais_='+idPais_+'&idProvincia_='+idProvincia_);
							}
		}
		
		
  </script>
</body>

</html>

  