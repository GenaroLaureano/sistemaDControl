<?php
#Salir si alguno de los datos no está presente
if(!isset($_POST["codigo"]) || !isset($_POST["descripcion"]) ) exit();

#Si todo va bien, se ejecuta esta parte del código...

include '../database/conexion.php';
$codigo = $_POST["codigo"];
$descripcion = $_POST["descripcion"];




$sqlInsert ="INSERT INTO productos VALUES (null,'$codigo','$descripcion');";
$conn->query($sqlInsert);


$valor = mysqli_affected_rows($conn);
if($valor === -1){
	header("Location: index.php?status=6");
	exit;
}

	header("Location: index.php?status=1");

?>
