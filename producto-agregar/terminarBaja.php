<?php
// if(!isset($_GET["sucursal"])) exit;

session_start();
include_once "../database/conexion.php";
date_default_timezone_set('America/Mexico_City');
$ahora = date("Y-m-d H:i:s",time());
$sucursal = $_SESSION["seleccionarSucursal"];


foreach ($_SESSION["add"] as $producto) {
    $id = $producto['id'];
    $cantidad = $producto['cantidad'];
    $sqlUpdate = "UPDATE sucursal SET existencia = existencia + $cantidad WHERE producto = $id AND sucursal=$sucursal;";
    // var_dump($sqlUpdate);
    // exit;
    $conn->query($sqlUpdate);
    if(!$conn){
        header("Location: index.php?status=6");
    }
}

unset($_SESSION["add"]);
unset($_SESSION["seleccionarSucursal"]);
$_SESSION["add"] = [];
header("Location: index.php?status=1");
?>