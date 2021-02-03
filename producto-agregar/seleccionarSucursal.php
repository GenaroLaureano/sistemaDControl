<?php
if(!isset($_POST["sucursal"])) exit;
session_start();
$_SESSION["seleccionarSucursal"] = $_POST['sucursal'];

if($_POST['sucursal']===''){
header("Location: index.php?status=6");
exit;
}

header("Location: index.php");
?>