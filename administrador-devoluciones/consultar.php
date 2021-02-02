<?php
session_start();
if(!isset($_POST["fechaInicio"]) || !isset($_POST["fechaFin"]) || !isset($_POST["sucursal"])) exit();

include '../database/conexion.php';
date_default_timezone_set('America/Mexico_City');
$hoy= date('Y-m-d',time());
$fechaInicio = $_POST["fechaInicio"];
$fechaFin = $_POST["fechaFin"];
$sucursal = $_POST["sucursal"];

if($fechaInicio>$fechaFin){
	header("Location: index.php?status=1");
	exit;
}

if($fechaFin>$hoy){
	header("Location: index.php?status=2");
	exit;
}
$fechaInicio .= ' 00:00:00';
$fechaFin .= ' 23:59:59';


$sqlSelect ="SELECT devoluciones.fecha,devoluciones.total,devoluciones.venta,devoluciones.usuario
FROM devoluciones INNER JOIN ventas ON devoluciones.venta = ventas.id
WHERE devoluciones.fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND ventas.sucursal=$sucursal;";
$resultSet = $conn->query($sqlSelect);

if($resultSet->num_rows >0){
    $i = 0;
    while($row = $resultSet->fetch_assoc()){
    $_SESSION['adminDev'][$i] = $row;
        $i++;
    }
}else{
	$_SESSION['adminDev'] = [];
}

if($_SESSION['adminDev']===[]){
	header("Location: index.php?status=3");
	exit;
}

header("Location: index.php?consulta=1");
?>

