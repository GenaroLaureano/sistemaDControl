<?php 
session_start();//inicia la sesion
if(isset($_SESSION) && (isset($_SESSION['logueado'])) == FALSE){
  header("Location: ../index.php");
}
$sucursal= $_SESSION['sucursal'];
$bandera = false;
if(!isset($_SESSION["devoluciones"])) $_SESSION["devoluciones"] = [];
if(!isset($_SESSION["devolucion"])) $_SESSION["devolucion"] = [];

include '../header/index.php';
include '../navbar/index.php';
include '../sidebar/index.php'; 
?>
  <div class="content-wrapper">
  <div class="content">
	<div class="col-xs-12">
		<h1><i class="fas fa-redo"></i> Devolución</h1>

      <!-- <br><br> -->
		<?php
			if(isset($_GET["status"])){
				if($_GET["status"] === "1"){
					?>
						<div class="alert alert-success">
							<strong>¡Correcto!</strong> Devolución realizada correctamente
							<a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
						</div>
					<?php
				}else if($_GET["status"] === "2"){
					?>
					<div class="alert alert-info">
							<strong>Devolución cancelada</strong>
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
							<strong>Error:</strong> No se encontro una venta con el folio indicado
							<a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
						</div>
					<?php
				}else if($_GET["status"] === "5"){
					?>
					<div class="alert alert-danger">
							<strong>Error: </strong>Ya se ha realizado una devolución de esta venta
							<a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
						</div>
					<?php
				}else if($_GET["status"] === "6"){
					?>
					<div class="alert alert-info">
							<strong>Error:</strong> No se encontro el producto en la venta
							<a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
						</div>
					<?php
				}else if($_GET["status"] === "7"){
					?>
					<div class="alert alert-danger">
							<strong>Error:</strong> No se encontraron más productos en la venta
							<a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
						</div>
					<?php
				}else{
					?>
					<div class="alert alert-danger">
							<strong>Error:</strong> Algo salió mal mientras se realizaba la devolución
							<a href="index.php">
                    <i class="fas fa-times-circle text-danger float-right"></i>
                    </a>
						</div>
					<?php
				}
			}
		?>
		<br>
		<?php
				if($_SESSION["devoluciones"] === []){ 
				?>
		<form method="post" action="buscarVenta.php">
			<label for="folio">Folio de la venta:</label>
			<input autocomplete="off" autofocus class="form-control" name="folio" required type="number" id="folio" placeholder="Escribe el código">
			<br>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
		</form>
		<?php
				}
				?>
		<br><br>

		<?php
			if($_SESSION['devolucion'] != []){ 
			$ventas = $_SESSION['devolucion'];
			// if(isset($_GET["busqueda"])){
			// if($_GET['busqueda'] === "1"){ 
			// $ventas = $_SESSION['devolucion'];

		?>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Número</th>
					<th>Fecha</th>
					<th>Productos vendidos</th>
					<th>Total</th>
					<!-- <th>Eliminar</th>} -->
				</tr>
			</thead>
			<tbody>
				
				
				<tr>
					<td><?php echo $ventas['id'] ?></td>
					<td><?php echo $ventas['fecha'] ?></td>
					<td>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Código</th>
									<th>Descripción</th>
									<th>Cantidad</th>
									<th>Precio</th>
									<th>Sub Total</th>

								</tr>
							</thead>
							<tbody>
								<?php foreach(explode("__", $ventas['productos']) as $productosConcatenados){ 
								$producto = explode("..", $productosConcatenados)
								?>
								<tr>
									<td><?php echo $producto[0] ?></td>
									<td><?php echo $producto[1] ?></td>
									<td><?php echo $producto[2] ?></td>
									<td><?php echo $producto[3] ?></td>
									<td><?php echo $producto[2] * $producto[3] ?></td>

								</tr>
								<?php } ?>
							</tbody>
						</table>
					</td>
					<td><?php echo $ventas['total'] ?></td>
				</tr>
			</tbody>
		</table>
		<td>
		<a href="limpiarBusqueda.php" class="btn btn-warning float-right">Limpiar Busqueda</a>
		<?php 
		$bandera = true;
		?>
			<!-- <a class="btn btn-warning" href="<?php echo "index.php?id=" . $ventas['id'];
		
		?>"><i class="fa fa-trash"></i> Seleccionar Venta</a></td> -->

		<?php
			}
		// }else{
		// 	$_SESSION['devolucion'] = [];
		// 	}
			// unset($_SESSION["devolucion"]);
		?>
	</div>

  </div>

  <div class="content">
	<div class="col-xs-12">
		<?php
			if($bandera){
		?>

	 <!-- INPUT CODIGO DE BARRAS  -->
	 <br>
				
            <form method="post" action="agregarDevoluciones.php">
                <label for="codigo">Código:</label>
                <input autocomplete="off" autofocus class="form-control" name="codigo" required type="number" id="codigo"
                    placeholder="Escriba el código del producto">
                    <br>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Añadir</button>
			</form>
			

            <!-- TABLA DE VENTAS -->
            <?php
                if($_SESSION["devoluciones"] != []){
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
                        foreach($_SESSION["devoluciones"] as $indice => $producto){ 
						    $total += $producto['total'];
					?>
                    <tr>
                        <td><?php echo $producto['codigo'] ?></td>
                        <td><?php echo $producto['descripcion'] ?></td>
                        <td><?php echo $producto['precioVenta'] ?></td>
                        <td><?php echo $producto['cantidad'] ?></td>
                        <td><?php echo $producto['total'] ?></td>
                        <td><a class="btn btn-danger" href="<?php echo "quitarDeDevoluciones.php?indice=" . $indice?>"><i
                            class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php 
                        } 
                    ?>
                </tbody>
            </table>
            <!-- TOTAL DE LA VENTA -->
            <div class="float-right">
                <h3>Total Devolución: <?php echo $total; ?></h3>
                <form action="terminarDevolucion.php" method="POST">
                    <input name="total" type="hidden" value="<?php echo $total;?>">
                    <button type="submit" class="btn btn-success">Terminar Devolución</button>
                    <a href="cancelarDevolucion.php" class="btn btn-danger">Cancelar Devolución</a>
                </form>
            </div>
            <?php
                }
            ?>
		<!-- </div> -->
	
<?php
		}
		?>
	</div>	
	</div>	
	<br><br>
	<br><br>

	<br><br>



  </div>


  

  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>