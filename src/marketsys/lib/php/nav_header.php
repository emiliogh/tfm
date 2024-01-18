    <a href="principal.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
		  <img src="./images/logoEmpresa.png" class="logo-mini" style="height: 50px;">
          <!-- logo for regular state and mobile devices -->
		  <img src="./images/logoEmpresa.png" class="logo-lg" style="height: 50px;">
    </a>
<!-- Header Navbar -->
  <?php
   error_reporting(0);
   $fp = fopen("contador.txt","r"); // Abrimos el fichero donde guardaremos y leeremos las visitas
   $visitas = intval(fgets($fp)); // Leemos las visitas y usamos intval para asegurarnos de que devuelve un entero
   ?>
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <!--<a href="#" class="sidebar-toggle" style="color: #AAAAAA" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>-->
          <a href="#" class="dropdown-toggle" onClick="actualizarMenu(0);">
            <i class="fa fa-money" ></i>
            <span class="label"> Ventas</span>
          </a>
          <a href="#" onClick="actualizarMenu(1);">
            <i class="fa fa-shopping-cart"></i>
            <span class="label"> Compras</span>
          </a>
          <a href="#" onClick="actualizarMenu(2);">
            <i class="fa fa-th-list"></i>
            <span class="label"> Inventario</span>
          </a>
          <a href="#" onClick="actualizarMenu(3);">
             <i class="fa fa-building"></i>
             <span class="label"> Contabilidad</span>
          </a>
          <a href="#" onClick="actualizarMenu(4);">
             <i class="fa fa-cubes"></i>
             <span class="label"> Utilidades</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success"><?php echo $visitas; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Numero de accesos a la aplicacion.</li>
                  <li>
                    <!-- inner menu: contains the messages -->
                    <ul class="menu">
                      <li><!-- start message -->
                        <a href="">
                          <div class="pull-left">
                            <!-- User Image -->
                            <img src="./images/information_image.png" class="img-circle" alt="User Image">
                          </div>
                          <!-- Message title and timestamp -->
                          <h4>
                            Se ha accesado a la aplicacion:
                          </h4>
                          <!-- The message -->
                          <p><?php echo $visitas; ?> veces.</p>
                        </a>
                      </li><!-- end message -->
                    </ul><!-- /.menu -->
                  </li>
                </ul>
              </li><!-- /.messages-menu -->

              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-danger num_noti">0</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Productos Para Caducar...</li>

                  <li>

                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu arti_caducos">

                    </ul>
                  </li>
                  <!--<li class="footer"><a href="#">View all</a></li>-->
                </ul>
              </li>
              <!-- Tasks Menu -->
              <li class="dropdown tasks-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-warning">0</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">0 tareas pendientes.</li>
                  <!--
                  <li>
                    <!-- Inner menu: contains the tasks
                    <ul class="menu">
                      <li><!-- Task item
                        <a href="#">
                          <!-- Task title and progress text
                          <!--<h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                          </h3>
                          <!-- The progress bar
                          <div class="progress xs">
                            <!-- Change the css width attribute to simulate progress
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">20% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li><!-- end task item
                    </ul>
                  </li>

                  <li class="footer">
                    <a href="#">View all tasks</a>
                  </li>-->
                </ul>
              </li>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="./images/avatars/avatar.png" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $_SESSION['nombre_de_usuario']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="./images/avatars/avatar.png" class="img-circle" alt="User Image">
                    <p>
                      Usuario: <?php echo $_SESSION['nombre_de_usuario']; ?>
                      <!--<small>Member since Nov. 2012</small>-->
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!--<li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li>-->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <a href="#!" class="btn btn-info btn-block"><i class='fa fa-user'></i> Perfil</a>
                    <a href="./lib/php/endsession.php" class="btn btn-danger btn-block btn-exit-system"><i class='fa fa-power-off'></i> Salir</a>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <!--<li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
          </div>
        </nav>
