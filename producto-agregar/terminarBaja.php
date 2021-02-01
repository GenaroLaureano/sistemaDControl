<?php
// if(!isset($_POST["total"])) exit;

session_start();
// $total = $_POST["total"];
include_once "../database/conexion.php";
date_default_timezone_set('America/Mexico_City');
$ahora = date("Y-m-d H:i:s",time());
// print_r($ahora);
// printf($ahora);
// var_dump($ahora);
// $sqlInsert = "INSERT INTO adds(fecha, total) VALUES ('$ahora', $total);";
// $conn->query($sqlInsert);


// $sqlSelect = "SELECT id FROM ventas ORDER BY id DESC LIMIT 1;";
// $resultSet  = $conn->query($sqlSelect);
// $resultado = $resultSet->fetch_assoc();

// $idVenta = $resultado === false ? 1 : $resultado['id'];

foreach ($_SESSION["add"] as $producto) {
    // $total += $producto['total'];
    $id = $producto['id'];
    $cantidad = $producto['cantidad'];
	// $sqlInsert ="INSERT INTO productos_add(id_producto, cantidad) VALUES ($id,$cantidad);";
    // $conn->query($sqlInsert);
    // $sqlUpdate = "UPDATE productos SET existencia = existencia - $cantidad WHERE id = $id;";
    // $conn->query($sqlUpdate);
    $sqlUpdate = "UPDATE sucursal SET existencia = existencia + $cantidad WHERE producto = $id;";
    $conn->query($sqlUpdate);
}

// $base_de_datos->commit();
unset($_SESSION["add"]);
$_SESSION["add"] = [];
header("Location: index.php?status=1");
?>