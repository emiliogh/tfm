<?php
session_start();
require_once('../src/nusoap.php');
require_once('../generarPDF.php');
include_once("../../conexion/class.conexion.php");
require_once('../enviarMailFactura.php');

$sendMail = multi_attach_mail('cesarroblesq@hotmail.com', 'César', '01001003000003856','Marabú');

echo $sendMail;

?>