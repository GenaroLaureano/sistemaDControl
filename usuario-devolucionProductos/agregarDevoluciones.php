<?php
if (!isset($_GET["id"])) { 
    return;
}
session_start();
$sucursal= $_SESSION['sucursal'];
$id = $_GET["id"]; 
include_once "../database/conexion.php"; 

// $sqlSelect = "SELECT venta.existencia, productos.id, productos.codigo, productos.descripcion, sucursal.precioVenta FROM sucursal INNER JOIN productos ON sucursal.id=productos.id WHERE productos.codigo='$codigo' AND sucursal.sucursal=$sucursal;";
$resultSet = $conn->query($sqlSelect);

//SI NO SE OBTUVO NINGUN REGISTRO
if(!$resultSet->num_rows > 0){
    header("Location: index.php?status=4");
    exit;
}
//SE OBTIENE EL OBJETO
$producto = $resultSet->fetch_assoc();
if ($producto['existencia'] < 1) {
    header("Location: index.php?status=5");
    exit;
}

# Buscar producto dentro del cartito
$indice = false; 
for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
    if ($_SESSION["carrito"][$i]['codigo'] === $codigo) {
        $indice = $i;
        break;
    }
}

# Si no existe, lo agregamos como nuevo
if ($indice === false) {
    $producto['cantidad'] = 1;
    $producto['total'] = $producto['precioVenta'];
    array_push($_SESSION["carrito"], $producto);
} else {
    # Si ya existe, se agrega la cantidad
    # Pero espera, tal vez ya no haya
    $cantidadExistente = $_SESSION["carrito"][$indice]['cantidad'];
    # si al sumarle uno supera lo que existe, no se agrega
    if ($cantidadExistente + 1 > $producto['existencia']) {
        header("Location: index.php?status=5");
        exit;
    }
    $_SESSION["carrito"][$indice]['cantidad']++;
    $_SESSION["carrito"][$indice]['total'] = $_SESSION["carrito"][$indice]['cantidad'] * $_SESSION["carrito"][$indice]['precioVenta'];
}
header("Location: index.php");
