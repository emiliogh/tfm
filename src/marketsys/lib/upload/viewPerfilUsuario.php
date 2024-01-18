<?php session_start(); ?>
<html>
<head>
<title>UpLoadProfile</title>
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
			var file_data = $("#imageFoto").prop("files")[0]; 
			var form_data = new FormData();
			var nombreArchivo = '';
			form_data.append("file", file_data);
				$.ajax({
					url: "subirArchivoPerfilUsuario.php?nb="+nombreArchivo,
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
						document.getElementById('imagenReclamo').src = '../images/avatar/'+res;
					}
				});
				//$('#files').html('Enviado com sucesso!');
			}
		
		function guardarInformacionPerfil(){
			nombreArchivo = document.getElementById('tituloImage').innerHTML;
			$.ajax({
					url: "guardarInformacionPerfil.php?nb="+nombreArchivo,
					type: "POST",
					success: function(data)
					{
						parent.location.reload(false);
					}
				});
			}
		
		function eliminarArchivo(){
			document.getElementById('imagenReclamo').src = "../images/avatar/0.png";
			document.getElementById('tituloImage').innerHTML='No Disponible';
			document.getElementById('tamanoImagen').innerHTML='(0.00 bytes)';
			document.getElementById('tipoArchivo').innerHTML='';
			document.getElementById('imageFoto').value='';
		}
		
		function previsualizarArchivo() {
			if (document.getElementById('tituloImage').innerHTML!='No Disponible'){
				parent.mostrarPrevisualizar('../fileLoad/predios/fotografias/'+document.getElementById('tituloImage').innerHTML);
			}else{alert('No se puede realizar la descarga, por favor seleccione una imagen.')}
		}
		
		function descargaArchivo() {
		    if (document.getElementById('tituloImage').innerHTML!='No Disponible'){
				location.href = "descargarArchivoPerfil.php?file=../images/avatar/"+document.getElementById('tituloImage').innerHTML;
			}else{alert('No se puede realizar la descarga, por favor seleccione una imagen.')}
		}
	</script>
</head>
<body onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<table>
		<tr>
			<td style="width: 250px; text-align: center;">
				<div id="targetLayer">
					<img id="imagenReclamo" src="../images/avatar/<?php echo $_SESSION["avatar"];?>" width="230px" height="230px" />
				</div>
			</td>
		</tr>
		<tr>
			<td style="width: 250px; height: 10px; text-align: center;">
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
				<table style="width: 100%; text-align: center;">
					<tr>
						<td style="width: 50%;">
							<input type="button" id="loadFileXml" class="bBusquedaImage" onclick="document.getElementById('imageFoto').click();" />
							<input type="file" id="imageFoto" name="imageFoto" accept="image/*" class="upload" data-change="fileChange" style="display:none;">
						</td>
						<td style="width: 50%;">
							<input type="button" id="loadFileXml" class="bGuardarImagen" onclick="guardarInformacionPerfil();" />
						</td>
					</tr>	
				</table>	
			</td>
		</tr>
	</table>
 </body>
</html>