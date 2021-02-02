<?php
session_start();
unset($_SESSION["devolucion"]);
unset($_SESSION['devoluciones']);
header("Location: index.php");
?>