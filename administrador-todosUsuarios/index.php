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
		<h1><i class="fas fa-user-friends"></i> Usuarios</h1>

      <!-- <br><br> -->
		<?php
			if(isset($_GET["status"])){
				if($_GET["status"] === "1"){
					?>
						<div class="alert alert-success">
						<strong>¡Correcto!</strong> Usuario agregado correctamente
							<a href="index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
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
        <a href="../administrador-usuarios/index.php" class="btn btn-primary">Agregar Usuario</a>

		<br>
		<br>
		<?php
			$sqlSelect = "SELECT usuario_nick,usuario_nombre,usuario_apellidos,usuario_role,usuario_sucursal FROM usuarios";;
			$resultSet = $conn->query($sqlSelect);
			
			if($resultSet->num_rows >0 ){
				
		?>

			<table class="table table-bordered">
			<thead>
				<tr>
					<!-- <th>ID</th> -->
					<th>Usuario</th>
					<th>Nombre</th>
					<th>Apellidos</th>
					<th>Rol</th>
					<th>Sucursal</th>

					<!-- <th>Editar</th> -->
					<!-- <th>Eliminar</th> -->
				</tr>
			</thead>
			<tbody>
			<?php 
			while($producto = $resultSet->fetch_assoc()){
			?>
				<tr>
					<td><?php echo $producto['usuario_nick'];?></td>
					<td><?php echo $producto['usuario_nombre']; ?></td>
					<td><?php echo $producto['usuario_apellidos'] ?></td>
					<td><?php echo $producto['usuario_role'] ?></td>
					<td><?php echo $producto['usuario_sucursal'] ?></td>


				
					</tr>	
				<?php
						}
			}
			?>
			</tbody>
		</table>

	


	</div>
  </div>
  </div>
  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>