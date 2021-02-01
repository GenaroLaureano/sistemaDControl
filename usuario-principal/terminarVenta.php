<?php
if(!isset($_POST["total"])) exit;

session_start();
$total = $_POST["total"];
$sucursal= $_SESSION['sucursal'];
$usuario_id= $_SESSION['usuario_id'];

include_once "../database/conexion.php";
date_default_timezone_set('America/Mexico_City');
$ahora = date("Y-m-d H:i:s",time());
$sqlInsert = "INSERT INTO ventas VALUES (null,'$ahora',$total,'VENTA',0,$sucursal,$usuario_id);";
$conn->query($sqlInsert);

if(!$conn){
    header("Location: index.php?status=6");
    exit;
}

$sqlSelect = "SELECT id FROM ventas ORDER BY id DESC LIMIT 1;";

$resultSet  = $conn->query($sqlSelect);

$resultado = $resultSet->fetch_assoc();

$idVenta = $resultado === false ? 1 : $resultado['id'];

// var_dump($_SESSION['carrito']);

// exit;


foreach ($_SESSION["carrito"] as $producto){
    $total += $producto['total'];
    $id = $producto['id'];
    $cantidad = $producto['cantidad'];
    $precioVenta = $producto['precioVenta'];
	$sqlInsert ="INSERT INTO productosVendidos VALUES (null,$cantidad,$precioVenta,$id,$idVenta);";
    $conn->query($sqlInsert);
    if(!$conn){
        header("Location: index.php?status=6");
        exit;
    }
    $sqlUpdate = "UPDATE sucursal SET existencia = existencia - $cantidad WHERE id = $id AND sucursal=$sucursal;";
    $conn->query($sqlUpdate);
    if(!$conn){
        header("Location: index.php?status=6");
        exit;
    }
}

unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];
header("Location: index.php?status=1");
?>