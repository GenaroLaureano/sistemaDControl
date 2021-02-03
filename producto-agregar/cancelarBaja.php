<?php
session_start();
unset($_SESSION["add"]);
unset($_SESSION["seleccionarSucursal"]);

$_SESSION["add"] = [];
header("Location: index.php?status=2");
?>