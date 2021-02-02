<?php
if (!isset($_POST["codigo"])) { //si no lo desencadeno un  codigo termina la ejecuion
    return;
}

session_start();
$sucursal= $_SESSION['sucursal'];
$codigo = $_POST["codigo"]; //obten el codigo del producto
include_once "../database/conexion.php"; //llamada a la bd
$sqlSelect = "SELECT productos.id, productos.codigo, productos.descripcion, sucursal.precioVenta,sucursal.existencia
FROM sucursal INNER JOIN productos on productos.id = sucursal.producto WHERE productos.codigo = '$codigo' AND sucursal.sucursal=$sucursal;";
$resultSet = $conn->query($sqlSelect);

if(!$resultSet->num_rows > 0){
    header("Location: index.php?status=5");
    exit;
}

$producto = $resultSet->fetch_assoc();

if ($producto['existencia'] < 1) {
    header("Location: index.php?status=2");
    exit;
}

session_start(); 
# Buscar producto dentro del cartito
$indice = false; 
for ($i = 0; $i < count($_SESSION["Baja"]); $i++) {
    if ($_SESSION["Baja"][$i]['codigo'] === $codigo) {
        $indice = $i;
        break;
    }
}
# Si no existe, lo agregamos como nuevo
if ($indice === false) {
    $producto['cantidad'] = 1;
    $producto['total'] = $producto['precioVenta'];
    array_push($_SESSION["Baja"], $producto);
} else {
    # Si ya existe, se agrega la cantidad
    # Pero espera, tal vez ya no haya
    $cantidadExistente = $_SESSION["Baja"][$indice]['cantidad'];
    # si al sumarle uno supera lo que existe, no se agrega
    if ($cantidadExistente + 1 > $producto['existencia']) {
        header("Location: index.php?status=3");
        exit;
    }
    $_SESSION["Baja"][$indice]['cantidad']++;
    $_SESSION["Baja"][$indice]['total'] = $_SESSION["Baja"][$indice]['cantidad'] * $_SESSION["Baja"][$indice]['precioVenta'];
}
header("Location: index.php");
