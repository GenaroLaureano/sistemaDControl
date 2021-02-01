<?php
$dbhost = 'bqtleac8ctwnn8ij3ly1-mysql.services.clever-cloud.com';
$dbuser = 'ua2gga6vun9cg8fi';
$dbpass = '1GnNQztAHZkk1xnUGRtV';#Cambiar dependiendo de si su bd tiene password
$dbdata = 'bqtleac8ctwnn8ij3ly1'; #nombre de base datos
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbdata);
$conn->set_charset("utf8");
if ($conn->connect_error){
    die('Error de conexion: proceso cancelado');
} else{
    #echo "Conexion exitosa";
}