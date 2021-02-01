<?php
session_start();
unset($_SESSION["devoluciones"]);
$_SESSION["devoluciones"] = [];
header("Location: index.php?status=2");
?>