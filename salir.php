<?php
    session_start();#Inicia la persistencia
    session_destroy();#Cancela la sesion
    header("Location: index.php");
?>