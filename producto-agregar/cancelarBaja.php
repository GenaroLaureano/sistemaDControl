<?php
session_start();
unset($_SESSION["add"]);
$_SESSION["add"] = [];
header("Location: index.php?status=2");
?>