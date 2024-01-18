<?php include "./lib/php/sesionSecurity.php"; ?>
<!doctype html>
<html class="fixed">
	<head>
		<meta charset="UTF-8">
		<title>MarketSys</title>
		<meta name="keywords" content="MarketSys" />
		<meta name="description" content="MarketSys">
		<meta name="author" content="Marabú Consulting&Services">
		<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<link rel="stylesheet" href="lib/vendor/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="lib/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="lib/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" type="text/css" href="lib/vendor/pnotify/pnotify.custom.css">
		<link rel="stylesheet" href="lib/css/theme.css" />
		<link rel="stylesheet" href="lib/css/skins/default.css" />
		<link rel="stylesheet" href="lib/css/theme-custom.css">
		<script src="lib/vendor/modernizr/modernizr.js"></script>
		<link rel="stylesheet" type="text/css" href="lib/vendor/magnific-popup/magnific-popup.css">
		<link rel="stylesheet" type="text/css" href="lib/css/util.css">
		<link rel="stylesheet" type="text/css" href="lib/css/main.css">
		<link rel="stylesheet" type="text/css" href="lib/css/theme.css" />
		<link rel="stylesheet" type="text/css" href="lib/css/skins/default.css" />
		
		

	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign body-locked">
			<div class="center-sign">
				<div class="panel panel-sign">
					<div class="panel-body">
						<form action="javascript: void(0);" class="login100-form validate-form" style="width: 100%">
							<div class="current-user text-center">
								<img src="images/avatar/<?php echo $_SESSION["avatar"];?>" alt=alt="<?php echo strtoupper($_SESSION["nombre"]);?>" class="img-circle user-image" />
								<h2 class="user-name text-dark m-none"><?php echo strtoupper($_SESSION["nombre"]);?></h2>
								<p class="user-email m-none"><?php echo $_SESSION["correo"];?></p>
							</div>
							<div class="wrap-input100 validate-input" data-validate = "Password es obligatoria">
								<input class="input100" type="password" id="pass" placeholder="Password">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-lock" aria-hidden="true"></i>
								</span>
							</div>

							<div class="row">
								<div class="col-xs-6" style="width: 50%">
									<p class="mt-xs mb-none">
										<a href="lib/php/endsession.php">No soy <?php echo strtolower($_SESSION["usuarioMS"]);?></a>
									</p>
								</div>
								<div class="col-xs-6 text-right" style="width: 50%">
									<button type="submit" onClick="desbloquearUsuario();" class="btn btn-primary">Desbloquear</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="lib/vendor/jquery/jquery.js"></script>
		<script type="text/javascript" src="lib/vendor/bootstrap/js/popper.js"></script>		<script src="lib/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>		<script src="lib/vendor/bootstrap/js/bootstrap.min.js"></script>		<script src="lib/vendor/nanoscroller/nanoscroller.js"></script>		<script src="lib/vendor/magnific-popup/magnific-popup.js"></script>		<script src="lib/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<script type="text/javascript" src="lib/js/funciones.generales.js"></script>
		<script type="text/javascript" src="lib/vendor/pnotify/pnotify.custom.js"></script>
		<script src="lib/js/theme.js"></script>
		<script src="lib/js/theme.custom.js"></script>
		<script src="lib/js/theme.init.js"></script>

	</body>
</html>