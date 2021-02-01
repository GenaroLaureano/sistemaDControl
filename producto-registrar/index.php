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
		<h1><i class="fas fa-plus"></i> Nuevo Producto</h1>

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




		<!-- <div class="col-xs-12"> -->
	<!-- <h1>Nuevo producto</h1> -->
	<form method="post" action="nuevo.php">
		<label for="codigo">Código de barras:</label>
		<input class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">

		<label for="descripcion">Descripción:</label>
		<textarea required id="descripcion" name="descripcion" cols="30" rows="5" class="form-control"></textarea>

		<br><br><input class="btn btn-info" type="submit" value="Guardar">
	</form>
<!-- </div> -->





	</div>
  </div>
  </div>
  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>