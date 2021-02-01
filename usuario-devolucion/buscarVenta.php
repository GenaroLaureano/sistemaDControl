<?php
if(!isset($_POST['folio'])){
    exit;
}
session_start();

include '../database/conexion.php';

$sucursal= $_SESSION['sucursal'];

$folio = $_POST["folio"]; 

$sqlSelect = "SELECT ventas.total, ventas.fecha, ventas.id, ventas.estado , GROUP_CONCAT(productos.codigo,'..', productos.descripcion,'..', productosVendidos.cantidad, '..', productosVendidos.precioVenta SEPARATOR '__') AS productos
FROM productosVendidos INNER JOIN ventas ON productosVendidos.venta = ventas.id
INNER JOIN productos ON productosVendidos.producto = productos.id WHERE productosVendidos.venta=$folio AND ventas.sucursal=$sucursal;";
$resultSet = $conn->query($sqlSelect);

$ventas = $resultSet -> fetch_assoc();

if($ventas['total'] ===NULL){
    unset($_SESSION["devolucion"]);
    header("Location: index.php?status=4");
    exit;
}

if($ventas['estado'] === 'DEVOLUCION'){
    unset($_SESSION["devolucion"]);
    header("Location: index.php?status=5");
    exit;
}

$_SESSION['devolucion'] = $ventas;
header("Location: index.php");

?>