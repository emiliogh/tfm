<?php include "./lib/php/sesionSecurity.php"; ?>
<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<meta charset="UTF-8">
	<title>MarketSys</title>
	<meta name="keywords" content="MarketSys" />
	<meta name="description" content="MarketSys">
	<meta name="author" content="Marabú Consulting&Services">
	<link rel="icon" type="image/png" href="lib/images/icons/marabu.png"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
  <link rel="stylesheet" href="lib/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="lib/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="lib/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="lib/css/font.css" type="text/css" />
  <link rel="stylesheet" href="lib/css/app.css" type="text/css" />
  <link rel="stylesheet" href="lib/css/rmodal-no-bootstrap.css"/>
  <link rel="stylesheet" href="lib/css/jquery.loadingModal.css"> 	
</head>
<body onLoad="cargarOpcion('MN0000');">
  <section class="vbox">
    <header class="bg-dark dk header navbar navbar-fixed-top-xs">
      <div class="navbar-header aside-md">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
          <i class="fa fa-bars"></i>
        </a>
        <a href="principal.php"><img src="lib/images/logoMarketSys.png" style="height:40px; margin-bottom: -30px;"></a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
          <i class="fa fa-cog"></i>
        </a>
      </div>
            
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
        <li class="hidden-xs">
          
        </li>
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left">
              <img src="lib/images/avatar/<?php echo $_SESSION["avatar"];?>">
            </span>
            <?php echo strtoupper(utf8_encode($_SESSION["nombre"]));?><b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">
            <span class="arrow top"></span>
            <li onclick="cargarOpcion('Perfil');">
              <a href="javascript:void(0);" >Mi perfil</a>
            </li>  
            <li onclick="cargarOpcion('CambioClave');">
              <a href="javascript:void(0);">Cambiar Contraseña</a>
            </li>
			<li class="divider"></li>
			<li onclick="cargarOpcion('CambioPerfil');">
              <a href="javascript:void(0);">Cambiar imagen perfil</a>
            </li>
			<li class="divider"></li>
            <li>
              <a href="lib/php/endsession.php">Salir del Sistema</a>
            </li>
          </ul>
        </li>
      </ul>      
    </header>
    <section>
      <section class="hbox stretch">
        <!-- .aside -->
        <aside class="bg-dark lter aside-md hidden-print" id="nav">          
          <section class="vbox">
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                  <ul class="nav">
                    
					<li  class="active">
                      <a href="principal.php"   class="active">
                        <i class="fa fa-dashboard icon">
                          <b class="bg-success"></b>
                        </i>
                        <span>Inicio</span>
                      </a>
                    </li>
					<?php
					    include_once("lib/php/menuAcceso.php");
					?> 
                  </ul>
                </nav>
              </div>
            </section>
            
            <footer class="footer lt hidden-xs b-t b-dark">
         
              <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon">
                <i class="fa fa-angle-left text"></i>
                <i class="fa fa-angle-right text-active"></i>
              </a>
              
            </footer>
          </section>
        </aside>
		<section id="principal">
		  <!--<section class="vbox">
            <section id="myTab" class="scrollable padder" style="margin-top: 0px;">
			  <div class="m-b-md" >
				<table style="width: 100%">
					<tr style="text-align: center;">
						<td rowspan="2">
							<img src="lib/images/logoEmpresaBody.png" style="height: 180px;">
						</td>
					</tr>
				</table>
			  </div>
			</section> 
		  </section>-->
		</section>	
		
        <aside class="bg-light lter b-l aside-md hide" id="notes">
          <div class="wrapper">Notification</div>
        </aside>
      </section>
    </section>
  </section>
  <script src="lib/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="lib/js/bootstrap.js"></script>
  <!-- App -->
  <script src="lib/js/app.js"></script>
  <script src="lib/js/app.plugin.js"></script>
  <script src="lib/js/funciones.generales.js?v=21.09.09"></script>
  <script src="lib/jquery/jquery.slimscroll.min.js"></script>
  <script src="lib/js/rmodal.js"></script>
  <script src="lib/js/jquery.loadingModal.js"></script>	
  <div id="divLoadding" class="divLoad" style="top: 0px; padding-top: 100px;">
	  <img src="lib/images/load/loadingMarketSys.gif" style="height: 450px; width: 550px;"/>
	</div>
  <footer class="site-footer">
	  <div class="footer-inner bg-white">
		  <div class="row">
			  <div class="col-sm-6">
				  Copyright &copy; 2020 Marabú Consulting&Services
			  </div>
		  </div>
	  </div>
	</footer>	
	<div id="modal" class="modal">
			<div class="modal-dialog animated">
				<div class="modal-content">
					<form class="form-horizontal" method="get">
						<div class="modal-header">
							<strong><span id="titleModal"></span></strong>
						</div>

						<div class="modal-body">
							<div id="bodyModal" class="form-group" style="padding-left: 30px; white-space: pre-wrap;">
								
							</div>
						</div>

						<div class="modal-footer">
							<button id="btn1-modal" class="btn btn-default" 
									type="button" onclick="removeTabF();">Aceptar</button>
							<button id="btn2-modal" class="btn btn-default" 
									type="button" onclick="$('#modal').css('display','none');">Aceptar</button>
							<button id="btn3-modal" class="btn btn-default" 
									type="button" onclick="$('#modal').css('display','none');">Aceptar</button>
							<button id="btnf-modal" class="btn btn-default" 
									type="button" onclick="$('#modal').css('display','none');">Aceptar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
</body>
</html>