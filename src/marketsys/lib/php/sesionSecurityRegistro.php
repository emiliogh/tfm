<?php
  session_start();
  if(!$_SESSION['identificacion']){
    header("Location: index.php");
  }
?>