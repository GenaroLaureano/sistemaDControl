<?php
if(!isset($_GET["indice"])) return;
$indice = $_GET["indice"];
session_start();
array_splice($_SESSION["devoluciones"], $indice, 1);
header("Location: index.php?status=3");
?>