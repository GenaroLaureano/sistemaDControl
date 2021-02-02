<?php 
session_start();//inicia la sesion
if(isset($_SESSION) && (isset($_SESSION['logueado'])) == FALSE){
  // $rol = $_SESSION['rol'];
  header("Location: ../index.php");
}
include '../header/index.php';
include '../navbar/index.php';
include '../sidebar/index.php'; 

if(!isset($_SESSION["add"])) $_SESSION["add"] = []; //si no existe la variable Baja la crea como un arreglo vacio
// if(!isset($_SESSION["caja"])) $_SESSION["caja"] = 0;
$granTotal = 0;

?>
  <div class="content-wrapper">
  <div class="content">
	<div class="col-xs-12">
		<h1><i class="fas fa-cart-plus"></i> Surtir</h1>

  
      <!-- <br><br> -->
		<?php
			if(isset($_GET["status"])){
				if($_GET["status"] === "1"){
					?>
						<div class="alert alert-success">
							<strong>¡Correcto!</strong> Venta realizada correctamente
						</div>
					<?php
				}else if($_GET["status"] === "2"){
					?>
					<div class="alert alert-info">
							<strong>Venta cancelada</strong>
						</div>
					<?php
				}else if($_GET["status"] === "3"){
					?>
					<div class="alert alert-info">
							<strong>Ok</strong> Producto quitado de la lista
						</div>
					<?php
				}else if($_GET["status"] === "4"){
					?>
					<div class="alert alert-warning">
							<strong>Error:</strong> El producto que buscas no existe
						</div>
					<?php
				}else if($_GET["status"] === "5"){
					?>
					<div class="alert alert-danger">
							<strong>Error: </strong>El producto está agotado
						</div>
					<?php
				}else{
					?>
					<div class="alert alert-danger">
							<strong>Error:</strong> Algo salió mal mientras se realizaba la venta
						</div>
					<?php
				}
			}
		?>
		<br>
		<form method="post" action="agregarBaja.php">
			<label for="codigo">Código:</label>
			<input autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escriba el código del producto">
			<br>
			<button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Añadir</button>
		</form>
		<br><br>

		<?php
			if($_SESSION['add']!=[]){ 
		?>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Código</th>
					<th>Descripción</th>
					<th>Precio de venta</th>
					<th>Cantidad</th>
					<!-- <th>Total</th> -->
					<!-- <th>Quitar</th> -->
				</tr>
			</thead>
			<tbody>
				<?php foreach($_SESSION["add"] as $indice => $producto){ 
						$granTotal += $producto['total'];
					?>
				<tr>
					<td><?php echo $producto['id'] ?></td>
					<td><?php echo $producto['codigo'] ?></td>
					<td><?php echo $producto['descripcion'] ?></td>
					<td><?php echo $producto['precioVenta'] ?></td>
					<td><?php echo $producto['cantidad'] ?></td>
					<!-- <td><?php echo $producto['total'] ?></td> -->
					<!-- <td><a class="btn btn-danger" href="<?php echo "quitarDelCarrito.php?indice=" . $indice?>"><i class="fa fa-trash"></i></a></td> -->
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<!-- <h3>Total: <?php echo $granTotal; ?></h3> -->
		<form action="terminarBaja.php" method="POST">
			<!-- <input name="total" type="hidden" value="<?php echo $granTotal;?>"> -->
			<button type="submit" class="btn btn-success">Agregar a Tienda</button>
			<a href="cancelarBaja.php" class="btn btn-danger">Cancelar</a>
		</form>
		<?php } ?>			

	</div>
  </div>
  </div>
  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>