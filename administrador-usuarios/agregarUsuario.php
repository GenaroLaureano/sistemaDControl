<?php
#Salir si alguno de los datos no está presente
if(!isset($_POST["nombre"]) || !isset($_POST["nick"]) || !isset($_POST["apellidos"]) || !isset($_POST["password"]) || !isset($_POST["rol"]) || !isset($_POST["sucursal"])     ) exit();

#Si todo va bien, se ejecuta esta parte del código...

include '../database/conexion.php';
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$nick = $_POST["nick"];
$password = $_POST["password"];
$rol = $_POST["rol"];
$sucursal = $_POST["sucursal"];


$sqlInsert ="INSERT INTO usuarios VALUES (null,'$nick','$nombre','$apellidos','$password','$rol',$sucursal);";
$conn->query($sqlInsert);


$valor = mysqli_affected_rows($conn);

if($valor === -1){
	header("Location: index.php?status=6");
	exit;
}

	header("Location: ../administrador-todosUsuarios/index.php?status=1");

?>
