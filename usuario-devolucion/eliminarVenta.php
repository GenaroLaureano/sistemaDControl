<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
include_once "../database/conexion.php";

	// $sqlDelete = "DELETE FROM ventas WHERE id = $id";
	$sqlUpdate = "UPDATE ventas SET venta_status = 'DEVOLUCION' WHERE venta_id = $id;";
    // $conn->query($sqlUpdate);
	if($conn->query($sqlUpdate)){
		header("Location: index.php?status=3");
		exit;
	}else{
		echo "Algo salió mal";
	}
?>