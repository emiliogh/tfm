<?php

$mensaje = $_POST['mensaje'];

echo $_POST['ruta'].$_POST['nombre'];
$file = fopen('../'.$_POST['ruta'].$_POST['nombre'], "w");

fwrite($file, $mensaje . PHP_EOL);

fclose($file);