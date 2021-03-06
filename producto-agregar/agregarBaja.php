<?php
if (!isset($_POST["codigo"])) { //si no lo desencadeno un  codigo termina la ejecuion
    return;
}

session_start();
$sucursal= $_SESSION["seleccionarSucursal"];

$codigo = $_POST["codigo"]; //obten el codigo del producto
include_once "../database/conexion.php"; //llamada a la bd
$sqlSelect = "SELECT productos.id, productos.codigo, productos.descripcion, sucursal.precioVenta,sucursal.existencia
FROM sucursal INNER JOIN productos on productos.id = sucursal.producto WHERE productos.codigo = '$codigo' AND sucursal.sucursal=$sucursal;";
$resultSet = $conn->query($sqlSelect);

if(!$resultSet->num_rows > 0){
    header("Location: index.php?status=4");
    exit;
}

$producto = $resultSet->fetch_assoc();
// $producto = $row;
// $producto = $datos['']
// print_r($producto);
// printf($producto);
// $resultSet->num_rows > 0
// $sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE codigo = ? LIMIT 1;"); //manda a llamar el producto con el codigo
// $sentencia->execute([$codigo]); 
// $producto = $sentencia->fetch(PDO::FETCH_OBJ);
# Si no existe, salimos y lo indicamos
// if (!$producto) {
//     header("Location: index.php?status=4");
//     exit;
// }
# Si no hay existencia...
// if ($producto['existencia'] < 1) {
//     header("Location: index.php?status=5");
//     exit;
// }

session_start(); 
# Buscar producto dentro del cartito
$indice = false; 
for ($i = 0; $i < count($_SESSION["add"]); $i++) {
    if ($_SESSION["add"][$i]['codigo'] === $codigo) {
        $indice = $i;
        break;
    }
}
# Si no existe, lo agregamos como nuevo
if ($indice === false) {
    $producto['cantidad'] = 1;
    $producto['total'] = $producto['precioVenta'];
    array_push($_SESSION["add"], $producto);
} else {
    # Si ya existe, se agrega la cantidad
    # Pero espera, tal vez ya no haya
    $cantidadExistente = $_SESSION["add"][$indice]['cantidad'];
    # si al sumarle uno supera lo que existe, no se agrega
    // if ($cantidadExistente + 1 > $producto['existencia']) {
    //     header("Location: index.php?status=5");
    //     exit;
    // }
    $_SESSION["add"][$indice]['cantidad']++;
    $_SESSION["add"][$indice]['total'] = $_SESSION["add"][$indice]['cantidad'] * $_SESSION["add"][$indice]['precioVenta'];
}
header("Location: index.php");
