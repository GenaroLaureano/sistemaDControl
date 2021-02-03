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

if(!isset($_SESSION["add"])) $_SESSION["add"] = []; //si no existe la variable Baja la crea como un arreglo vacio
// if(!isset($_SESSION["caja"])) $_SESSION["caja"] = 0;
$granTotal = 0;

?>
  <div class="content-wrapper">
  <div class="content">
	<div class="col-xs-12">
		<h1><i class="fas fa-user-plus"></i> Agregar Usuario</h1>

  
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
				}else{
					?>
					<div class="alert alert-danger">
							<strong>Error:</strong> Algo salió mal mientras se registraba el usuario
							<a href="index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
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
                <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre del usuario" required>
            <!-- </div> -->
			<!-- <div class="form-group"> -->
                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control" name="apellidos" placeholder="Ingrese los apellidos del usuario " required>
            <!-- </div> -->
            <!-- <div class="form-group"> -->
                <label for="nick">Usuario</label>
                <input type="text" class="form-control" name="nick" placeholder="Ingrese el nickname del usuario (con este ingresara el sistema)" required>
            <!-- </div> -->

            <!-- <div class="form-group"> -->
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name ="password"  placeholder="Ingrese la nueva contraseña del usuario" required>
            <!-- </div> -->

            <!-- <div class="form-group"> -->
              <label for="rol">Seleccione el rol de usuario</label>
			  <select class="form-select" name='rol' required>
				<option selected value=''>Seleccione el rol</option>	
				<option value='administrador' >Administrador</option>
				<option value='usario' >Usuario</option>
				</select>
               <!-- <br> -->

			<?php
			include '../database/conexion.php';
			?>

			<label for="sucursal">Seleccione la sucursal de trabajo del usuario</label>
			
			<select class="form-select" name='sucursal' required>
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
              <button type="submit" name="add_user" class="btn btn-primary">Agregar</button>
            <!-- </div> -->
        </form>
        </div>





	</div>
  </div>
  </div>
  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>