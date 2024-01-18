<?php session_start(); ?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/really-simple-jquery-dialog.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
	<script type="text/javascript" src="../jquery/jquery.js"></script>
	
	<script>
		$(document).ready(function() { 
			$('button#cambioClave').click(function() {  
					cambiarContrasena ();
			 });
			 
			 $('button#cancelarCambio').click(function() {  
					cancelarCambio ();
			 });
		});	 
	</script>

</head>
<body onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
  <div class="col-lg-12" style="margin-left: 0px; margin-top: 20px;">
	<div class="card">
		<div class="card-body card-block" style="margin-bottom: -30px;">
			<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
			    <div class="row form-group">
					<div class="col col-md-3"><label for="txtContrasenaActual" class=" form-control-label">Contraseña actual</label></div>
					<div class="col-12 col-md-9"><input type="password" id="txtContrasenaActual" name="txtContrasenaActual"  class="form-control"></div>
				</div>
				
				<div class="row form-group">
					<div class="col col-md-3"><label for="txtNuevaContrasena" class=" form-control-label">Nueva contraseña</label></div>
					<div class="col-12 col-md-9"><input type="password" id="txtNuevaContrasena" name="txtNuevaContrasena" class="form-control"></div>
				</div>
				
				<div class="row form-group">
					<div class="col col-md-3"><label for="txtContrasenaConfirmar" class=" form-control-label">Confirmar nueva contraseña</label></div>
					<div class="col-12 col-md-9"><input type="password" id="txtContrasenaConfirmar" name="txtContrasenaConfirmar" class="form-control"></div>
				</div>
				
				<div class="row form-group" style="padding: 1.5rem 1.5rem; background-color: rgba(0,0,0,.03); border-bottom: 1px solid rgba(0,0,0,.125);">
					<div class="col col-md-2"></div>
					<div class="col col-md-3" style="text-align: center;">
						<button type="button" class="btn btn-primary btn-sm" id="cambioClave" style="width: 220px;">
							<i class="fa fa-dot-circle-o"></i> Guardar Cambio Contraseña
						</button>
					</div>
					<div class="col col-md-2"></div>
					<div class="col col-md-3" style="text-align: center;">
						<button type="reset" class="btn btn-danger btn-sm" id="cancelarCambio" style="width: 220px;">
							<i class="fa fa-ban"></i> Cancelar
						</button>
					</div>
					<div class="col col-md-2"></div>	
				</div>
			</form>
		</div>

	</div>

	</div>

<!-- Scripts -->
	<div id="testAlert"></div>
	<script type="text/javascript" src="../js/really-simple-jquery-dialog.js"></script>
	<script type="text/javascript" src="../../lib/js/funciones.generales.js"></script>

</body>
</html>
