<?php 
	session_start();
	if(isset($_SESSION) && (isset($_SESSION['logueado'])) == FALSE){
		header("Location: ../index.php");
	}
	include '../header/index.php';
	include '../navbar/index.php';
    include '../sidebar/index.php'; 
    $sucursal= $_SESSION['sucursal'];
	if(!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];
    $vender = false;
?>
<div class="content-wrapper">
    <div class="content">
        <div class="col-xs-12">
        <!-- Encabezado -->
            <h1><i class="fas fa-cash-register"></i>Caja</h1>
            <!-- INPUT DE INICIO DE TURNO -->
            <?php
                include_once "../database/conexion.php";
                date_default_timezone_set('America/Mexico_City');
                $fechaInicio= date('Y-m-d 00:00:00',time());
                $fechaFin= date('Y-m-d 23:59:59',time());
                $sqlSelect = "SELECT id from entradas WHERE sucursal = $sucursal AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND estado='SINCORTE';";
                $resultSet = $conn->query($sqlSelect);
                if($resultSet->num_rows > 0){
                    $vender = true;  
                }else{
            ?>
                <div class="card bg-primary">
                    <div class="card-body">
                        <form method="post" action="agregarCaja.php">
                            <label for="cuenta">Inicio con:</label>
                            <input autocomplete="off" autofocus class="form-control" name="cuenta" required type="text"
                            id="cuenta" placeholder="Ingresa la cantidad con que inicia el turno">
                        </form>
                    </div>
                </div>
                <?php
                    }
                ?>
                <!-- SECCIÓN DE ALERTAR -->
                <?php
                    if(isset($_GET["status"])){
                        if($_GET["status"] === "1"){
                ?>
                <div class="alert alert-success">
                    <strong>¡Correcto!</strong> Venta realizada correctamente
                    <a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
                </div>
                <?php
                    }else if($_GET["status"] === "2"){
                ?>
                <div class="alert alert-danger">
                    <strong>Venta cancelada</strong>
                    <a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
                </div>
                <?php
                    }else if($_GET["status"] === "3"){
                ?>
                <div class="alert alert-warning">
                    <strong>El producto se elimino de la lista</strong> 
                    <a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
                </div>
                <?php
                    }else if($_GET["status"] === "4"){
                ?>
                <div class="alert alert-info">
                    <strong>Error:</strong> El producto que buscas no existe
                    <a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
                </div>
                <?php
                    }else if($_GET["status"] === "5"){
                ?>
                <div class="alert alert-secondary">
                    <strong>Error: </strong>El producto está agotado
                    <a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
                </div>
                <?php
                    }else{
                ?>
                <div class="alert alert-danger">
                    <strong>Error:</strong> Algo salió mal mientras se realizaba la venta
                    <a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
                </div>
                <?php
                        }
                    }
                ?>
                <!-- INPUT CODIGO DE BARRAS  -->
            <br>
            <form method="post" action="agregarAlCarrito.php">
                <label for="codigo">Código:</label>
                <?php
                    if($vender){
                ?>
                <input autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo"
                    placeholder="Escriba el código del producto">
                    <br>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Añadir</button>

                <?php
                    }else{
                ?>
                    <input autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo"
                    placeholder="Escriba el código del producto" disabled>
                <?php
                    }
                ?>
            </form>

            <!-- TABLA DE VENTAS -->
            <?php
                if($_SESSION["carrito"] != []){
            ?>
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $total = 0;
                        foreach($_SESSION["carrito"] as $indice => $producto){ 
						    $total += $producto['total'];
					?>
                    <tr>
                        <td><?php echo $producto['codigo'] ?></td>
                        <td><?php echo $producto['descripcion'] ?></td>
                        <td><?php echo $producto['precioVenta'] ?></td>
                        <td><?php echo $producto['cantidad'] ?></td>
                        <td><?php echo $producto['total'] ?></td>
                        <td><a class="btn btn-danger" href="<?php echo "quitarDelCarrito.php?indice=" . $indice?>"><i
                            class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php 
                        } 
                    ?>
                </tbody>
            </table>
            <!-- TOTAL DE LA VENTA -->
            <div class="float-right">
                <h3>Total: <?php echo $total; ?></h3>
                <form action="./terminarVenta.php" method="POST">
                    <input name="total" type="hidden" value="<?php echo $total;?>">
                    <button type="submit" class="btn btn-success">Terminar Venta</button>
                    <a href="./cancelarVenta.php" class="btn btn-danger">Cancelar Venta</a>
                </form>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>
<!-- FOOTER -->
<?php include '../footer/index.php'?>