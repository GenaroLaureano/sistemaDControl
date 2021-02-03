<?php
if(!isset($_POST["total"])) exit;

session_start();
$total = $_POST["total"];
$sucursal= $_SESSION['sucursal'];
$usuario_id= $_SESSION['usuario_id'];
$venta= $_SESSION['devolucion']['id'];
include_once "../database/conexion.php";
date_default_timezone_set('America/Mexico_City');
$ahora = date("Y-m-d H:i:s",time());
$sqlInsert = "INSERT INTO devoluciones VALUES (null,'$ahora',$total,$venta,$usuario_id,0);";
$conn->query($sqlInsert);

if(!$conn){
    header("Location: index.php?status=6");
    exit;
}

$sqlSelect = "SELECT id FROM devoluciones ORDER BY id DESC LIMIT 1;";

$resultSet  = $conn->query($sqlSelect);
$resultado = $resultSet->fetch_assoc();
$idDevolucion = $resultado === false ? 1 : $resultado['id'];

// var_dump($_SESSION['devoluciones']);

// exit;

// var_dump($_SESSION['devoluciones']);

foreach ($_SESSION["devoluciones"] as $producto){
    // var_dump($producto);
    $total += $producto['total'];
    $id = $producto['id'];
    $cantidad = $producto['cantidad'];
    // $precioVenta = $producto['precioVenta'];
	$sqlInsert ="INSERT INTO productosDevueltos VALUES (null,$cantidad,$id,$idDevolucion);";
    $conn->query($sqlInsert);

    // exit;

    if(!$conn){
        header("Location: index.php?status=6");
        exit;
    }
    $sqlUpdate = "UPDATE sucursal SET existencia = existencia + $cantidad WHERE id = $id AND sucursal=$sucursal;";

    var_dump($sqlUpdate);
    // exit;
    $conn->query($sqlUpdate);
    if(!$conn){
        header("Location: index.php?status=6");
        exit;
    }
}

$sqlUpdate = "UPDATE ventas SET estado = 'DEVOLUCION' WHERE id = $venta AND sucursal=$sucursal;";
$conn->query($sqlUpdate);
if(!$conn){
    header("Location: index.php?status=6");
    exit;
}

unset($_SESSION["devoluciones"]);
unset($_SESSION["devolucion"]);
header("Location: index.php?status=1");
?>