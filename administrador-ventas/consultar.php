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


$sqlSelect ="SELECT id,fecha,total,sucursal,usuario
FROM ventas WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND sucursal=$sucursal;";


$resultSet = $conn->query($sqlSelect);

if($resultSet->num_rows >0){
    $i = 0;
    while($row = $resultSet->fetch_assoc()){
    $_SESSION['adminVentas'][$i] = $row;
        $i++;
    }
}else{
	$_SESSION['adminVentas'] = [];
}

if($_SESSION['adminVentas']===[]){
	header("Location: index.php?status=3");
	exit;
}

header("Location: index.php?consulta=1");
?>

