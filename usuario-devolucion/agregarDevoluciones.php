<?php
if (!isset($_POST["codigo"])) { 
    return;
}

session_start();
$codigo = $_POST["codigo"];
$producto = [];
$cadena = $_SESSION['devolucion']['productos'];
$sucursal= $_SESSION['sucursal'];
$porciones = explode("__", $cadena);
$bandera = false;

foreach ($porciones as $indice => $a){
  $datos = explode("..",$a);
  if($codigo === $datos[0]){
    $producto['codigo'] = $datos[0];
    $producto['descripcion'] = $datos[1];
    $producto['comprados'] = (int)($datos[2]);
    $producto['precioVenta'] = (float)$datos[3];
    $bandera = true;
    break;
  }
}

if(!$bandera){
    header("Location: index.php?status=6");
    exit;
}

$indice = false; 
for ($i = 0; $i < count($_SESSION["devoluciones"]); $i++) {
    if ($_SESSION["devoluciones"][$i]['codigo'] === $codigo) {
        $indice = $i;
        break;
    }
}

if ($indice === false) {
    $producto['cantidad'] = 1;
    $producto['total'] = $producto['precioVenta'];
    include_once "../database/conexion.php"; 
    $sqlSelect = "SELECT productos.id, productos.codigo FROM sucursal INNER JOIN productos ON sucursal.producto=productos.id WHERE productos.codigo='$codigo' AND sucursal.sucursal=$sucursal;";
    $resultSet = $conn->query($sqlSelect);
    if(!$resultSet->num_rows > 0){
        header("Location: index.php?status=10");
        exit;
    }
    $respuesta = $resultSet->fetch_assoc();
    $producto['id'] = $respuesta['id'];
    array_push($_SESSION["devoluciones"], $producto);
} else {
    if($producto['cantidad']<$producto['comprados']){ 
    $cantidadExistente = $_SESSION["devoluciones"][$indice]['cantidad'];
    if ($cantidadExistente + 1 > $producto['comprados']) {
        header("Location: index.php?status=7");
        exit;
    }
    $_SESSION["devoluciones"][$indice]['cantidad']++;
    $_SESSION["devoluciones"][$indice]['total'] = $_SESSION["devoluciones"][$indice]['cantidad'] * $_SESSION["devoluciones"][$indice]['precioVenta'];
    }else{
        header("Location: index.php?status=7");
    }
}


header("Location: index.php");
