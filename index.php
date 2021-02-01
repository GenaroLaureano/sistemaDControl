<?php
// ob_start();
    session_start();
    require_once 'header/index.php';
    //validacion de sesión activa
    if(isset($_SESSION) && (isset($_SESSION['logueado'])) == TRUE){
        $rol = $_SESSION['rol'];
        header("Location: $rol-principal/index.php");
    }
    //envio formulario
    if(isset($_POST['btnLogin'])){
        require_once 'database/conexion.php';
        $usuario_nick = $_POST['usuario_nick'];
        $usuario_password = $_POST['usuario_password'];
        $sqlSelect = "SELECT usuario_id,usuario_nombre,usuario_nick,usuario_apellidos,usuario_password,usuario_role,usuario_sucursal
        FROM usuarios WHERE usuario_nick = '$usuario_nick' and usuario_password = '$usuario_password' ";
        $resultSet = $conn->query($sqlSelect); 
        if ($resultSet->num_rows > 0){
            $row = $resultSet -> fetch_assoc();
                $_SESSION['usuario_id'] = $row['usuario_id'];
                $_SESSION['usuario_nick'] = $row['usuario_nick'];
                $_SESSION['userName'] = $row['usuario_apellidos'].' '.$row['usuario_nombre'];
                $_SESSION['logueado'] = TRUE;
                $_SESSION['rol'] = $row['usuario_role'];
                $_SESSION['sucursal'] = $row['usuario_sucursal'];
                if($_SESSION['rol'] == 'administrador'){
                    header("Location: administrador-principal/index.php");
                }else{
                   header("Location: usuario-principal/index.php");
                }
        }else{
            $errmensaje = "CREDENCIALES NO VALIDAS";
        }
    }
    require_once 'formulario-login.php';
    require_once 'footer/index.php';
?>