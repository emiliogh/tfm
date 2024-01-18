<?php
  session_start();
  date_default_timezone_set('America/Guayaquil');
  if(!$_SESSION['autorizadoLogin']){
     echo '<script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>';
	 echo '<script>alert("Su sesión ha caducado, por favor vuelva a ingresar con sus credenciales. ");</script>';  
     echo '<script type="text/javascript">$(document).ready(function () { parent.window.location.href="index.php"; });</script>';
  }
?>