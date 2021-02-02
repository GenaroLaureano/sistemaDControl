<?php
#Salir si alguno de los datos no está presente
if(!isset($_POST["sucursal"]) || !isset($_POST["codigo"]) || !isset($_POST["precioVenta"]) || !isset($_POST["precioCompra"]) || !isset($_POST["existencia"])) exit();

#Si todo va bien, se ejecuta esta parte del código...

include '../database/conexion.php';
$sucursal = $_POST["sucursal"];
$codigo = $_POST["codigo"];
$precioVenta = abs($_POST["precioVenta"]);
$precioCompra = abs($_POST["precioCompra"]);
$existencia = abs($_POST["existencia"]);

$sqlInsert ="INSERT INTO sucursal VALUES (null,$codigo,$precioCompra,$precioVenta,$existencia,$sucursal);";
$conn->query($sqlInsert);

// var_dump($sqlInsert);
// exit;

$valor = mysqli_affected_rows($conn);
if($valor === -1){
	header("Location: index.php?status=6");
	exit;
}

header("Location: index.php?status=1");

?>
