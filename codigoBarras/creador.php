<?php
session_start();
 if(empty($_GET["texto"])) exit("No proporcionaste el texto en la URL");

require_once "../vendor/autoload.php";

# Indicamos que usaremos el namespace de BarcodeGeneratorPNG
use Picqer\Barcode\BarcodeGeneratorPNG;

# Crear generador
$generador = new BarcodeGeneratorPNG();

# Ajustes
$texto = $_GET["texto"];
$tipo = $generador::TYPE_CODE_128;


$imagen = $generador->getBarcode($texto, $tipo);

$nombreArchivo = "../img/codigo$texto.png";

$bytesEscritos = file_put_contents($nombreArchivo, $imagen);

# Comprobar si todo fue bien
if ($bytesEscritos !== false) {
    echo "Correcto. Se escribieron $bytesEscritos bytes en $nombreArchivo";
} else {
    echo "Error guardando código de barras";
}
// header("Content-type: image/png");
// echo   $imagen;
