<?php 
session_start();//inicia la sesion
if(isset($_SESSION) && (isset($_SESSION['logueado'])) == FALSE){
  // $rol = $_SESSION['rol'];
  header("Location: ../index.php");
}
// $sucursal= $_SESSION['sucursal'];
include '../header/index.php';
include '../navbar/index.php';
include '../sidebar/index.php'; 
$sucursal= $_SESSION['sucursal'];
if(!isset($_SESSION["carrito"])) $_SESSION["carrito"] = []; //si no existe la variable carrito la crea como un arreglo vacio
// if(!isset($_SESSION["caja"])) $_SESSION["caja"] = 0;
$granTotal = 0;

?>
  <div class="content-wrapper">
  <div class="content">
	<div class="col-xs-12">
		<h1><i class="fas fa-tasks"></i> Consulta</h1>

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



		<!-- <form action="a.php">
 <select name="miselector" id="miselector" onchange="this.form.submit()">
 <option value="">Seleccionar</option>
 <option value="coches">Coches</option>
 <option value="casas">Casas</option>
</form> -->


		<?php
			include '../database/conexion.php';
		?>

		<form method="post" action="index.php" >
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
		<input type="submit"class="btn btn-primary" value="Consultar" > 

		</form>
		<br>
		<?php

		if(isset($_POST['sucursal'])){
			if($_POST['sucursal']===''){
				?>
					<div class="alert alert-danger">
							<strong>Error:</strong> No se pudo realizar la busqueda
							<a href="index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
						</div>
					<?php
					exit;
			}
			$sucursalSelect = (int)$_POST["sucursal"];
			// var_dump($sucursalSelect);
			// exit;
			// $sqlSelect ="SELECT * FROM productos WHERE codigo = $codigo";
			$sqlSelect = "SELECT productos.codigo, productos.descripcion ,sucursal.precioVenta, sucursal.existencia, sucursal.sucursal
			FROM sucursal INNER JOIN productos ON sucursal.producto = productos.id  WHERE sucursal.sucursal=$sucursalSelect;";
			$resultSet = $conn->query($sqlSelect);
			
			if($resultSet->num_rows >0 ){
				
		?>

			<table class="table table-bordered">
			<thead>
				<tr>
					<!-- <th>ID</th> -->
					<th>Código</th>
					<th>Descripción</th>
					<th>Precio de venta</th>
					<th>DISPONIBILIDAD</th>
					<!-- <th>Editar</th> -->
					<!-- <th>Eliminar</th> -->
				</tr>
			</thead>
			<tbody>
			<?php 
			while($producto = $resultSet->fetch_assoc()){
			?>
				<tr>
					<td><?php echo $producto['codigo'];?></td>
					<td><?php echo $producto['descripcion']; ?></td>
					<td><?php echo $producto['precioVenta'] ?></td>
					<?php 
						if($producto['sucursal'] === $sucursal){
					?>

					<td><?php echo $producto['existencia']?></td>
					<?php
						}else{
					?>
						<td><?php echo ($producto['existencia'] > 0) ? 'DISPONIBLE' : 'NO DISPONIBLE';?></td>
					</tr>	
				<?php
						}
			}
			?>
			</tbody>
		</table>

		<?php
				
			}
			}
		?>



	</div>
  </div>
  </div>
  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>