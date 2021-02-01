<?php
session_start();
unset($_SESSION["Baja"]);
$_SESSION["Baja"] = [];
header("Location: index.php?status=2");
?>