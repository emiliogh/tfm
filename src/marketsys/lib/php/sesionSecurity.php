<?php
  session_start();
  if(!$_SESSION['autorizadoLogin']){
    header("Location: index.php");
  }
?>