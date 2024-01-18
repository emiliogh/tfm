<?php
   SESSION_START();
		include("../conexion/class.conexion.php");
		$db = new MySQL();
		$consulta = $db->consulta("update tas_usuarios set avatar = '".$_GET['nb']."' where id_usuario = '".$_SESSION['idUsuario']."';");
		$_SESSION["avatar"] = $_GET['nb'];

?>