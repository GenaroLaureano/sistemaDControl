<?php
session_start();
if(!isset($_GET["sucursal"])) exit();
$sucursal = $_GET['sucursal'];
include_once "../database/conexion.php"; 
$_SESSION['entrada'] =[];
$_SESSION['ventas'] = [];
$_SESSION['dev'] = [];

date_default_timezone_set('America/Mexico_City');
$fechaInicio= date('Y-m-d 00:00:00',time());

$sqlSelect = "SELECT id AS folio, fecha,total AS cantidad, estado AS tipo FROM entradas WHERE fecha > '$fechaInicio' AND estado='SINCORTE' AND sucursal=$sucursal;";
$resultSet = $conn->query($sqlSelect);		
if($resultSet->num_rows > 0){
    $i = 0;
    while($row = $resultSet->fetch_assoc()){
    $_SESSION['entrada'][$i] = $row;
        $i++;
    }
}

$sqlSelect = "SELECT id AS folio, fecha ,total AS cantidad, estado AS tipo FROM ventas WHERE fecha > '$fechaInicio' AND sucursal=$sucursal AND corte = 0;";
$resultSet = $conn->query($sqlSelect);	

if($resultSet->num_rows >0){
    $i = 0;
    while($row = $resultSet->fetch_assoc()){
    $_SESSION['ventas'][$i] = $row;
        $i++;
    }
}

$sqlSelect = "SELECT devoluciones.id AS folio, devoluciones.fecha ,devoluciones.total AS cantidad, ventas.sucursal FROM devoluciones INNER JOIN ventas ON devoluciones.venta=ventas.id  WHERE devoluciones.fecha > '$fechaInicio' AND ventas.sucursal=$sucursal AND ventas.corte=0;
";
$resultSet = $conn->query($sqlSelect);	

if($resultSet->num_rows >0){
    $i = 0;
    while($row = $resultSet->fetch_assoc()){
    $_SESSION['dev'][$i] = $row;
        $i++;
    }
}

if(count($_SESSION['entrada']) === 0 && count($_SESSION['ventas']) === 0 && count($_SESSION['dev']) ===0)
{
    header("Location: index.php?status=2");
    exit;
}


header("Location: index.php?corte=1");
?>