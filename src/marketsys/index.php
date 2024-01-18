<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>marketSys</title>
	<meta name="keywords" content="marketSys" />
	<meta name="description" content="marketSys">
	<meta name="author" content="Marabú Consulting&Services">
	<link rel="icon" type="image/png" href="lib/images/icons/favicon.ico"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="lib/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="lib/css/select2.css">
	<link rel="stylesheet" type="text/css" href="lib/css/pnotify.custom.css">
	<link rel="stylesheet" type="text/css" href="lib/css/util.css">
	<link rel="stylesheet" type="text/css" href="lib/css/main.css">
	<link rel="stylesheet" type="text/css" href="lib/css/theme.css" />
</head>
<body style="overflow: hidden;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="lib/images/logoEmpresa.png" style="height: 240px; margin-top: 10px; margin-left: 20px;" alt="IMG">
				</div>
	
				<form action="javascript: void(0);" class="login100-form validate-form">
					<img src="lib/images/logoMarketSys.png" style="height: 50px; margin-left: 160px; margin-bottom: 5px;" alt="IMG">
					<div class="wrap-input100 validate-input" data-validate = "Usuario es obligatoria">
						<input class="input100" type="text" autocomplete="off" id="usuario" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password es obligatoria">
						<input class="input100" type="password" id="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button onClick="verificaConexionUsuario();" class="login100-form-btn">
							Ingresar
						</button>
					</div>
					<br>
				</form>
				
				<div id="divCopyRight">
					&copy; 2023 <b>Marabú Consulting&Services</b> Sistema de Facturación e Inventario [Versión 1.9.0]
					<br>Chrome 36.0.1; Firefox 31.0; Opera 32.0; Safari 10.0; 
					<br>Resolucion óptima: 1280x768
				</div>
				
			</div>
		</div>
	</div>
	<script type="text/javascript" src="lib/jquery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="lib/js/tilt.jquery.min.js"></script>
	<script type="text/javascript" src="lib/js/funciones.generales.js"></script>
	<script type="text/javascript" src="lib/js/pnotify.custom.js"></script>
	<script src="lib/js/main_login.js"></script>
		<script >
			$('.js-tilt').tilt({
				//scale: 1.1
			})
		</script>
</body>
</html>