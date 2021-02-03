<?php 
session_start();//inicia la sesion
if($_SESSION['nivel']!=1){
	header("Location: ../index.php");
	exit;
}
if(isset($_SESSION) && (isset($_SESSION['logueado'])) == FALSE){
  // $rol = $_SESSION['rol'];
  header("Location: ../index.php");
}
include '../header/index.php';
include '../navbar/index.php';
include '../sidebar/index.php'; 

if(!isset($_SESSION["add"])) $_SESSION["add"] = [];
if(!isset($_SESSION["seleccionarSucursal"])) $_SESSION["seleccionarSucursal"] = '';

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
							<strong>¡Correcto!</strong> Surtido realizada correctamente
							<a href="index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
						</div>
					<?php
				}else if($_GET["status"] === "2"){
					?>
					<div class="alert alert-info">
							<strong>Surtido de productos cancelado</strong>
							<a href="index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
						</div>
					<?php
				}else if($_GET["status"] === "4"){
					?>
					<div class="alert alert-warning">
							<strong>Error:</strong> El producto que buscas no existe en tienda
							<a href="index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
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



		<?php
			include '../database/conexion.php';
		?>
		<?php
		if($_SESSION['seleccionarSucursal']===''){
		?>
		<form method="post" action="seleccionarSucursal.php" >
		<select class="form-select" name='sucursal' id='sucursal'>
		<option selected value=''>Seleccione la sucursal</option>		
		<?php
			$sqlSelect = "SELECT id, nombre FROM sucursales";
			$resultSet = $conn->query($sqlSelect);
			$resultSet = $conn->query($sqlSelect); 
			if($resultSet->num_rows > 0){
				while($row = $resultSet->fetch_assoc()){
					$id = $row['id'];
					$nombre = $row['nombre'];
					echo "<option value=$id >$nombre</option>";
				}
			}
		?>
		</select>
		<br>
		<!-- <input type="submit"class="btn btn-primary" value="Consultar" >  -->

		<button type="submit" class="btn btn-primary"><i class="fas fa-hand-pointer"></i> Seleccionar</button>
		</form>
		<br>
		<?php
		}
		?>
		
		<?php
			if($_SESSION['seleccionarSucursal']!=''){
				$sucusalID = $_SESSION['seleccionarSucursal'];
				$sqlSelect = "SELECT nombre FROM sucursales WHERE id=$sucusalID";
				$resultSet = $conn->query($sqlSelect);
				$row = $resultSet->fetch_assoc();
				$nombreSucursal = $row['nombre'];
		?>

			<h4><?php echo $nombreSucursal?></h4>

		<?php		
			} 
		?>




		<form method="post" action="agregarBaja.php">
			<label for="codigo">Código:</label>
			<?php
			if($_SESSION['seleccionarSucursal']!=''){
			?>
			<input autocomplete="off" autofocus class="form-control" name="codigo" required type="number" id="codigo" placeholder="Escriba el código del producto">
			<br>
			<button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Añadir</button>
			<?php
			}else{
			?>
			<input autocomplete="off" autofocus class="form-control" name="codigo" required type="number" id="codigo" placeholder="Escriba el código del producto" disabled>
			
			<?php
			}
			?>

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
		<?php } ?>

		<form action="terminarBaja.php" method="POST">
			<button type="submit" class="btn btn-success">Agregar a Tienda</button>
			<a href="cancelarBaja.php" class="btn btn-danger">Cancelar</a>
		</form>
			

	</div>
  </div>
  </div>
  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>