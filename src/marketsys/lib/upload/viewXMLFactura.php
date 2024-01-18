<html>
<head>
	<link href="../css/stylesUpLoadImage.css" rel="stylesheet" type="text/css" />
	<meta charset="utf-8">
	<script src="../jquery/jqueryUpload.js"></script>
	<script src="../js/simpleUpload.js"></script>
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
					url: "uploadXMLFactura.php",
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
						parent.document.getElementById('fileXML').value=res;
						document.getElementById('imagenReclamo').src = '../respaldos_compras/xml/archivo-subido.png';
						
						parent.parent.document.getElementById('divLoadding').style.display = 'none';
						
					}
				});
				//$('#files').html('Enviado com sucesso!');
			}
		
		function eliminarArchivo(){
			document.getElementById('imagenReclamo').src = "../respaldos_compras/xml/archivo-no-disponible.png";
			document.getElementById('tituloImage').innerHTML='No Disponible';
			document.getElementById('tamanoImagen').innerHTML='(0.00 bytes)';
			document.getElementById('tipoArchivo').innerHTML='';
			document.getElementById('imageFoto').value='';
		}
		
		function previsualizarArchivo() {
			if (document.getElementById('tituloImage').innerHTML!='No Disponible'){
				parent.mostrarPrevisualizar('../respaldos_compras/xml/'+document.getElementById('tituloImage').innerHTML);
			}else{alert('No se puede realizar la descarga, por favor seleccione una imagen.')}
		}
		
		function descargaArchivo() {
		    if (document.getElementById('tituloImage').innerHTML!='No Disponible'){
				location.href = "../respaldos_compras/xml/descargarArchivoPredios.php?file="+
					document.getElementById('tituloImage').innerHTML;
			}else{alert('No se puede realizar la descarga, por favor seleccione una imagen.')}
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
						document.getElementById('imagenReclamo').src = '../respaldos_compras/xml/'+array[0].des;
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
					<img id="imagenReclamo" src="../respaldos_compras/xml/archivo-no-disponible.png" width="100px" height="100px" />
				</div>
			</td>
		</tr>
		<tr>
			<td style="width: 100%; text-align: center;">
				<table width="100%">
					<tr>
						<td style="text-align: center;">
							<a href ="javascript:descargaArchivo()">
							   <img src="../images/icons/descargarICO.png" width="16px" height="16px"/>
							</a>	
						</td>
						<td style="text-align: center;">
							<a href ="javascript:previsualizarArchivo()">
							   <img src="../images/icons/preliminarICON.png" width="16px" height="16px"/>
							</a>	
						</td>
						<td style="text-align: center;">
							<a href ="javascript:eliminarArchivo()">
								<img src="../images/icons/cerrarICO.png" width="16px" height="16px"/>
							</a>	
						</td>
					</tr>
				</table>
			</td>
		</tr>
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
		<tr>
			<td style="text-align: center;">
				<input type="button" id="loadFileXml" class="bBusquedaImage" 
					   onclick="document.getElementById('imageFoto').click();" />
				<input type="file" id="imageFoto" name="imageFoto" accept="application/xml" class="upload" 
					   data-change="fileChange" style="display:none;">
			</td>
		</tr>
	</table>
 </body>
</html>