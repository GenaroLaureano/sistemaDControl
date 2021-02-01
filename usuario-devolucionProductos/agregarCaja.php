<?php
if (!isset($_POST["cuenta"])) { 
    return;
}
session_start(); 
include_once "../database/conexion.php";
$cuenta = $_POST["cuenta"];
$sucursal= $_SESSION['sucursal'];
date_default_timezone_set('America/Mexico_City');
$ahora = date("Y-m-d H:i:s",time());
$sqlInsert = "INSERT INTO entradas VALUES(null,'$ahora',$cuenta,'SINCORTE',$sucursal);";
if($conn->query($sqlInsert)){
header("Location: index.php");
}
