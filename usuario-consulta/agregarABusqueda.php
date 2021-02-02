<?php
if (!isset($_POST["codigo"])) { 
    return;
}

session_start();
$sucursal= $_SESSION['sucursal'];
$codigo = $_POST["codigo"]; 

if($codigo===''){
    header("Location: index.php");
    exit;
}

include_once "../database/conexion.php"; 

$sqlSelect = "SELECT productos.id, productos.codigo, productos.descripcion, sucursal.precioVenta,sucursal.existencia
FROM sucursal INNER JOIN productos on productos.id = sucursal.producto WHERE productos.codigo = '$codigo' AND sucursal.sucursal=$sucursal;";
$resultSet = $conn->query($sqlSelect);

if(!$resultSet->num_rows > 0){
    header("Location: index.php?status=1");
    unset($_SESSION["busqueda"]);
    exit;
}

$producto = $resultSet->fetch_assoc();
$_SESSION['busqueda'] = $producto;

header("Location: index.php?busqueda=1");
