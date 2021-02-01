<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '12345678';#Cambiar dependiendo de si su bd tiene password
$dbdata = 'ventas'; #nombre de base datos
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbdata);
$conn->set_charset("utf8");
if ($conn->connect_error){
    die('Error de conexion: proceso cancelado');
} else{
    #echo "Conexion exitosa";
}