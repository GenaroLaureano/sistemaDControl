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
		<h1><i class="fas fa-minus"></i> Surtir</h1>

  
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

		<div class="col-md-6">
          <form method="post" action="agregarUsuario.php">
            <!-- <div class="form-group"> -->
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
            <!-- </div> -->
			<!-- <div class="form-group"> -->
                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control" name="apellidos" placeholder="apellidos " required>
            <!-- </div> -->
            <!-- <div class="form-group"> -->
                <label for="nick">Usuario</label>
                <input type="text" class="form-control" name="nick" placeholder="Nombre de usuario">
            <!-- </div> -->

            <!-- <div class="form-group"> -->
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name ="password"  placeholder="Contraseña">
            <!-- </div> -->

            <!-- <div class="form-group"> -->
              <label for="rol">Rol de usuario</label>
			  <select class="form-select" name='rol'>
				<option selected value=''>Seleccione la sucursal</option>	
				<option value='administrador' >Administrador</option>
				<option value='usario' >Usuario</option>
				</select>
               <br>

			<?php
			include '../database/conexion.php';
			?>

			<label for="sucursal">Sucursals</label>
			
			<select class="form-select" name='sucursal'>
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

            <!-- </div> -->
            <!-- <div class="form-group"> -->
              <button type="submit" name="add_user" class="btn btn-primary">Guardar</button>
            <!-- </div> -->
        </form>
        </div>





	</div>
  </div>
  </div>
  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>