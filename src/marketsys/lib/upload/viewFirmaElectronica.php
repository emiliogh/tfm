<html>
<head>
	<link href="../css/stylesUpLoadImage.css" rel="stylesheet" type="text/css" />
	<meta charset="utf-8">
	<script src="../jquery/jqueryUpload.js"></script>
	<script src="../js/simpleUpload.js"></script>
	<script src="../js/fiddle.js"></script>
	<script src="../js/forge.min.js"></script>
	<script src="../js/moment.min.js"></script>
	<script src="../js/buffer.js"></script>
	<script type="text/javascript">
		$(function(){
			$('.upload').simpleUpload({
				beforeSend: function(){
				}
			});
		});

		function fileChange(files){
			$('#files').empty();
			$.each(files, function(i, file){
				document.getElementById('tituloImage').innerHTML =  file.name;
				var fSExt = new Array('Bytes', 'KB', 'MB', 'GB');
				fSize = file.size; 
				i=0;
				while(fSize>900){fSize/=1024;i++;}
				document.getElementById('tamanoImagen').innerHTML = '('+(Math.round(fSize*100)/100)+' '+fSExt[i]+')';
				document.getElementById('tipoArchivo').innerHTML =  file.type;
				enviaArchivo(file.name, file.size, file.type);
			});
			
		}
		
		function enviaArchivo(name, size, type){
			parent.parent.document.getElementById('divLoadding').style.display = 'block';
			var file_data = $("#imageFoto").prop("files")[0]; 
			var form_data = new FormData();
			form_data.append("file", file_data);
				$.ajax({
					url: "uploadFirmaElectronica.php",
					type: "POST",
					dataType: 'script',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					success: function(data)
					{
						var str = data;
						var res = str.replace(String.fromCharCode(34), '');
						var res = res.replace(String.fromCharCode(34), '');
						document.getElementById('tituloImage').innerHTML=res;
						parent.document.getElementById('archivoFirma').value=res;
						parent.document.getElementById('validezFirma').value = 'N';
						document.getElementById('imagenFormulario').src = '../images/icons/keyICON.png';
						
						parent.parent.document.getElementById('divLoadding').style.display = 'none';
						
					}
				});
				//$('#files').html('Enviado com sucesso!');
			}
		
		function eliminarArchivo(){
			document.getElementById('imagenFormulario').src = "../images/icons/keyNotICON.png";
			document.getElementById('tituloImage').innerHTML='No Disponible';
			document.getElementById('tamanoImagen').innerHTML='(0.00 bytes)';
			document.getElementById('tipoArchivo').innerHTML='';
			document.getElementById('imageFoto').value='';
		}
		
		function verificaClaveFirma(){
			if (document.getElementById('tituloImage').innerHTML == 'No Disponible'){
				parent.parent.modalAlertPrincipal(1, 'MarketSys [Error información]', 
													 'No hay firma seleccionada.', 0, 
													 'Aceptar', '');
				return;
				}
			if (parent.document.getElementById('claveFirma').value == ''){
				parent.parent.modalAlertPrincipal(1, 'MarketSys [Error información]', 
												  	 'No hay clave registrada para realizar la verificación.', 0, 
													 'Aceptar', '');
				return;
				}
			rutaFirma = '../facturaElectronica/firmaElectronica/'+document.getElementById('tituloImage').innerHTML;
			clave = parent.document.getElementById('claveFirma').value;
			validar_pwrd_nw(rutaFirma,clave);
		}
		
		function verificaVigenciaFirma(){
			if (document.getElementById('tituloImage').innerHTML == 'No Disponible'){
				parent.parent.modalAlertPrincipal(1, 'MarketSys [Error información]', 
													 'No hay firma seleccionada.', 0, 
													 'Aceptar', '');
				return;
				}
			if (parent.document.getElementById('claveFirma').value == ''){
				parent.parent.modalAlertPrincipal(1, 'MarketSys [Error información]', 
												  	 'No hay clave registrada para realizar la verificación.', 0, 
													 'Aceptar', '');
				return;
				}
			rutaFirma = '../facturaElectronica/firmaElectronica/'+document.getElementById('tituloImage').innerHTML;
			clave = parent.document.getElementById('claveFirma').value;
			fechas_certificado_nw(rutaFirma,clave,1);
		}
		
		/*function cargaImagenBase(idpredio){
			var url = '../php/funcionArrchivosPredios.php';
			$.ajax({
				type:'POST',
				url:url,
				data:'idPredio='+idpredio+'&tipoArchivo=P',
				success:function(data){
					var array = eval(data);
					if (array!=''){
						if (array[0].des!=null){
						document.getElementById('tamanoImagen').innerHTML = 'Guardado';
						document.getElementById('tituloImage').innerHTML = array[0].des;
						document.getElementById('imagenFormulario').src = '../respaldos_compras/xml/'+array[0].des;
						}
					}	
				}
			});
			return false;
		}*/
	</script>
</head>
<body>
	<table>
		<tr>
			<td style="width: 100%; text-align: center;">
				<div id="targetLayer">
					<img id="imagenFormulario" src="../images/icons/keyNotICON.png" style="margin: 5px; width: 40px; height: 20px" />
				</div>
			</td>
			<td>
				<table style="width: 100px;">
					<tr>
						<td style="width: 100px; height: 10px; text-align: center;">
							<div id="files"></div>
							<span id="tituloImage" class="informacionImage">No Disponible</span>
						</td>
					</tr>
					<tr>
						<td style="height: 10px; text-align: center;">
							<span id="tamanoImagen" class="informacionImage">(0.00 bytes)</span>
							<span id="tipoArchivo" style="display: none;" class="informacionImage"></span>
						</td>
					</tr>	
				</table>	
			</td>	
			<td style="width: 100%; text-align: center;">
				<table width="100%">
					<tr>
						<td style="text-align: center;">
							<input type="button" id="loadFileXml" class="bBusquedaImageH" 
								   onclick="document.getElementById('imageFoto').click();" />
							<input type="file" id="imageFoto" name="imageFoto" accept="application/x-pkcs12" class="upload" 
								   data-change="fileChange" style="display:none;">
						</td>
						
						<td style="text-align: center;">
							<input type="button" id="loadFileXml" class="bVerificaFirmaH" 
								   onclick="verificaClaveFirma();" />	
						</td>
						
						<td style="text-align: center;">
							<input type="button" id="loadFileXml" class="bVerificaVigenciaH" 
								   onclick="verificaVigenciaFirma();" />	
						</td>
						
						<td style="text-align: center;">
							<input type="button" id="loadFileXml" class="bEliminaImageH" 
								   onclick="eliminarArchivo();" />	
						</td>
						
					</tr>
				</table>
			</td>	
		</tr>
	</table>
 </body>
</html>