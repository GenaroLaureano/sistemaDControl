<?php
if(!isset($_POST["total"])) exit;

session_start();
$total = $_POST["total"];
$sucursal= $_SESSION['sucursal'];
$usuario_id= $_SESSION['usuario_id'];

include_once "../database/conexion.php";
date_default_timezone_set('America/Mexico_City');
$ahora = date("Y-m-d H:i:s",time());
$sqlInsert = "INSERT INTO cortes VALUES (null,'$ahora',$total,$sucursal,$usuario_id);";
$conn->query($sqlInsert);
if(!$conn){
    header("Location: index.php?status=6");
    exit;
}
$entradas = $_SESSION['entrada'];
$ventas = $_SESSION['ventas'];

foreach($entradas as $entrada){
    $id = $entrada['folio'];
    $sqlUpdate = "UPDATE entradas SET estado = 'CORTE' WHERE id = $id";
    $conn->query($sqlUpdate);
    if(!$conn){
        header("Location: index.php?status=6");
        exit;
    }
}

foreach($ventas as $venta){
    $id = $venta['folio'];
    $sqlUpdate = "UPDATE ventas SET corte = 1 WHERE id = $id";
    $conn->query($sqlUpdate);
    if(!$conn){
        header("Location: index.php?status=6");
        exit;
    }
}


unset($_SESSION['entrada']);
unset($_SESSION['ventas']);
unset($_SESSION['dev']);
header("Location: index.php?status=1");
?>