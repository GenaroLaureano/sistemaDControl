<?php 
session_start();
if(isset($_SESSION) && (isset($_SESSION['logueado'])) == FALSE){
  header("Location: ../index.php");
}
$sucursal= $_SESSION['sucursal'];
include '../header/index.php';
include '../navbar/index.php';
include '../sidebar/index.php'; 
if(!isset($_SESSION["busqueda"])) $_SESSION["busqueda"] = [];
?>
  <div class="content-wrapper">
  	<div class="content">
		<div class="col-xs-12">
		<!-- CABECERA -->
		<h1><i class="fas fa-tasks"></i> Consultar</h1>
		<!-- SECCION DE ALERTAS -->
		<?php
			if(isset($_GET["status"])){
				if($_GET["status"] === "1"){
					?>
						<div class="alert alert-info">
							<strong>Error:</strong> El producto que buscas no existe
							<a href="index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
						</div>
					<?php
				}else{
					?>
					<div class="alert alert-danger">
							<strong>Error:</strong> Algo salió mal mientras se realizaba la consulta
						</div>
					<?php
				}
			}
		?>
		<!-- INPUT DE BUSQUEDA -->
		<br>
		<form method="post" action="agregarABusqueda.php">
			<label for="codigo">Código:</label>
			<input autocomplete="off" autofocus class="form-control" name="codigo" type="number" id="codigo" placeholder="Escriba el código del producto">
			<br>
			<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
		</form>
		<br>



		<?php
		if(isset($_GET["busqueda"])){
			if($_GET['busqueda'] === "1"){
				$producto = $_SESSION['busqueda'];

		?>
			<table class="table table-bordered">
			<thead>
				<tr>
					<th>Código</th>
					<th>Descripción</th>
					<th>Precio</th>
					<th>Existencia</th>
					<th>código de barras</th>
				</tr>
			</thead>
			<tbody>
			
				<tr>
					<td><?php echo $producto['codigo'] ?></td>
					<td><?php echo $producto['descripcion'] ?></td>
					<td><?php echo $producto['precioVenta'] ?></td>
					<td><?php echo $producto['existencia'] ?></td>
					<td><svg id="barcode"></svg></td>
					<script>
						JsBarcode("#barcode", <?php echo $producto['codigo'] ?>);
					</script>
				</tr>
			
			</tbody>
		</table>

		<?php
		}
		}else{
			// 	$producto = $_SESSION['busqueda'];
			include '../database/conexion.php';
			$sqlSelect = "SELECT productos.codigo, productos.descripcion ,sucursal.precioVenta, sucursal.existencia
			FROM sucursal INNER JOIN productos ON sucursal.producto = productos.id  WHERE sucursal.sucursal=$sucursal;";
			$resultSet = $conn->query($sqlSelect);
			
			if($resultSet->num_rows >0 ){
		?>	
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Código</th>
					<th>Descripción</th>
					<th>Precio</th>
					<th>Existencia</th>
					<th>código de barras</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			while($producto = $resultSet->fetch_assoc()){
				$codigo = $producto['codigo'];
			?>
				<tr>
					<td><?php echo $producto['codigo'] ?></td>
					<td><?php echo $producto['descripcion'] ?></td>
					<td><?php echo $producto['precioVenta'] ?></td>
					<td><?php echo $producto['existencia'] ?></td>
					
					<td><img src="../img/codigo<?php echo $codigo ?>.png" alt="codigo"></td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>

		<?php
			
		}}

			?>
	</div>
  </div>
  </div>
<?php include '../footer/index.php'?>