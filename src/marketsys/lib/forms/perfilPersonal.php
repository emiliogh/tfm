<?php session_start(); ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Ficha Usuario</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/perfil.css" rel="stylesheet">
    <script type="text/javascript" src="../jquery/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/really-simple-jquery-dialog.css">

</head>

<body onLoad="cargaInformacionPerfil();">
    <div id="wrapper">
        <!-- Navigation -->
        
        
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" height="100%" alt="user" src="../images/avatar/fondoPerfil.png">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)"><img src="../images/avatar/<?php echo $_SESSION["avatar"];?>" class="thumb-lg img-circle" alt="img"></a>
                                        <h4 class="text-white"><span id="cmp_0"></h4>
                                        <h5 class="text-white"><span id="cmp_4"></h5> </div>
                                </div>
                            </div>
                            <div class="user-btm-box">
                                <div class="col-md-12 col-sm-12 text-left">
                                    <p class="text-blue">Perfil Asignado</p>
                                    <h5><span id="cmp_1"> </span></h5> </div>
                                <div class="col-md-12 col-sm-12 text-left">
                                    <p class="text-danger">Acceso Desde</p>
                                    <h5><span id="cmp_2"> </span></h5> </div>
                                <div class="col-md-12 col-sm-12 text-left">
                                    <p class="text-danger">Acceso Hasta</p>
                                    <h5><span id="cmp_3"> </span></h5> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material">
                                <div class="form-group">
                                    <label class="col-md-12">Identificación</label>
                                    <div class="col-md-12">
                                        <span id="cmp1"> </span>
									</div>
                                </div>
								<div class="form-group">
                                    <label class="col-md-12">Apellidos/Nombre</label>
                                    <div class="col-md-12">
										<span id="cmp2"> </span>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-md-12">Género</label>
                                    <div class="col-md-12">
                                    	<span id="cmp3"> </span>
									</div>
                                </div>
								<div class="form-group">
                                    <label class="col-md-12">Estado Civil</label>
                                    <div class="col-md-12">
                                    	<span id="cmp4"> </span>
									</div>
                                </div>
								<div class="form-group">
                                    <label class="col-md-12">Cargo institucional</label>
                                    <div class="col-md-12">
                                    	<span id="cmp5"> </span>
									</div>
                                </div>
								<div class="form-group">
                                    <label class="col-md-12">Departamento</label>
                                    <div class="col-md-12">
                                    	<span id="cmp6"> </span>
									</div>
                                </div>
								<div class="form-group">
                                    <label class="col-md-12">Tipo de Contrato</label>
                                    <div class="col-md-12">
                                    	<span id="cmp7"> </span>
									</div>
                                </div>
								<div class="form-group">
                                    <label class="col-md-12">Correo Personal</label>
                                    <div class="col-md-12">
                                    	<span id="cmp8"> </span>
									</div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Correo Institucional</label>
                                    <div class="col-md-12">
                                    	<span id="cmp9"> </span>
									</div>
								</div>	
								<div class="form-group">
                                    <label class="col-md-12">Teléfono Móvil</label>
                                    <div class="col-md-12">
                                    	<span id="cmp10"> </span>
									</div>
                                </div>	
								<div class="form-group">
                                    <label class="col-md-12">Telefóno Convencional</label>
                                    <div class="col-md-12">
                                    	<span id="cmp11"> </span>
									</div>
                                </div>	
                                <div class="form-group">
                                    <label class="col-md-12">Dirección</label>
                                    <div class="col-md-12">
                                    	<span id="cmp12"> </span>
									</div>
                                </div>
                                <!--
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success">Update Profile</button>
                                    </div>
                                </div>-->
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            
        </div>
        <!-- /#page-wrapper -->
    </div>
	<script type="text/javascript" src="../js/really-simple-jquery-dialog.js"></script>
	<script>
	function cargaInformacionPerfil(){
		  url = '../php/retornaInformacionPerfil.php';
		  $.ajax({
			  type:'POST',
			  url:url,
			  success:function(data){
				  datos = eval(data);
				  datos = datos[0];
				  document.getElementById("cmp1").innerHTML = datos[0];
				  document.getElementById("cmp2").innerHTML = datos[1];
				  document.getElementById("cmp3").innerHTML = datos[2];
				  document.getElementById("cmp4").innerHTML = datos[3];
				  document.getElementById("cmp5").innerHTML = datos[4];
				  document.getElementById("cmp6").innerHTML = datos[5];
				  document.getElementById("cmp7").innerHTML = datos[6];
				  document.getElementById("cmp8").innerHTML = datos[7];
				  document.getElementById("cmp9").innerHTML = datos[8];
				  document.getElementById("cmp10").innerHTML = datos[9];
				  document.getElementById("cmp11").innerHTML = datos[10];
				  document.getElementById("cmp12").innerHTML = datos[11];
				  
				  document.getElementById("cmp_0").innerHTML = datos[12];
				  document.getElementById("cmp_1").innerHTML = datos[16];
				  document.getElementById("cmp_2").innerHTML = datos[14];
				  document.getElementById("cmp_3").innerHTML = datos[15];
				  document.getElementById("cmp_4").innerHTML = datos[7];
				  
				  parent.document.getElementById('divLoadding').style.display = 'none';
			  }
		  });
	
	  }
    </script>
</body>

</html>
