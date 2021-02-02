<?php 
session_start();
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

if(!isset($_SESSION["adminDev"])) $_SESSION["adminDev"] = []; //si no existe la variable Baja la crea como un arreglo vacio
// if(!isset($_SESSION["caja"])) $_SESSION["caja"] = 0;
$granTotal = 0;

?>
  <div class="content-wrapper">
  <div class="content">
	<div class="col-xs-12">
		<h1><i class="fas fa-redo"></i> Devoluciones</h1>

  
      <!-- <br><br> -->
		<?php
			if(isset($_GET["status"])){
				if($_GET["status"] === "1"){
					?>
						<div class="alert alert-warning">
							<strong>Error: </strong>La fecha de inicio no puede ser mayor a la de final
							<a href="index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
						</div>
					<?php
				}else if($_GET["status"] === "2"){
					?>
					<div class="alert alert-danger">
						<strong>Error: </strong>No puede seleccionar un día mayor al de hoy
						<a href="index.php">
						<i class="fas fa-times-circle text-danger float-right"></i>
						</a>
						</div>
					<?php
				}else if($_GET["status"] === "3"){
					?>
					<div class="alert alert-info">
							<strong>No se encontraron devoluciones</strong>
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
		<br>

		

		<div class="col-md-6">
          <form method="post" action="consultar.php">
          
		  <!-- <div class="form-group"> -->
              <label class="form-label">Rango de fechas</label>
			  <br>
                <!-- <div class="input-group"> -->
                  <!-- <input type="text" class="datepicker form-control" name="start-date" placeholder="From"> -->
				  <!-- <div class="campo "> -->
                    <label for="fechaInicio">Desde: </label>
                    <input type="date" name="fechaInicio" class="form-control" required>
                <!-- </div> -->
                  <!-- <span class="input-group-addon"><i class="fas fa-chevron-right"></i></span> -->
				  
				  <!-- <div class="campo"> --> 
                    <label for="fechaFin">Hasta: </label>
                    <input type="date" name="fechaFin" class="form-control" required>
                <!-- </div> -->
                  <!-- <input type="text" class="datepicker form-control" name="end-date" placeholder="To"> -->
                <!-- </div> -->
			

            <!-- </div> -->


               <br>

			<?php
			include '../database/conexion.php';
			?>

			<label for="sucursal">Sucursal</label>
			
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
              <button type="submit" name="add_user" class="btn btn-primary">Guardar</button>
			  <!-- <br> -->
            <!-- </div> -->
        </form>
        </div>
		<br>




		<?php
			if(isset($_GET["consulta"])){
			if($_GET['consulta'] === "1"){
			$devoluciones = $_SESSION['adminDev'];
				
			$devolucionesTable = '';
		
			foreach($devoluciones as $devolucion){ 
				$fechaDev = $devolucion['fecha'];
				$totalDev = $devolucion['total'];
				$ventaDev = $devolucion['venta'];
				$usuarioDev = $devolucion['usuario'];

				$devolucionesTable .= "<tr >";
				$devolucionesTable .= "<td >$fechaDev</td>";
				$devolucionesTable .= "<td >$totalDev</td>";
				$devolucionesTable .= "<td >$ventaDev</td>";
				$devolucionesTable .= "<td >$usuarioDev</td>";
				$devolucionesTable .= "</tr>";
			}
				
		?>
			<table class="table">
			<thead>
				<tr>
					<th>fecha</th>
					<th>total</th>
					<th>venta</th>
					<th>usuario</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			echo $devolucionesTable;
			?>
			</tbody>
		</table>

		

			<?php	
		}}
		?>



	</div>
  </div>
  </div>
  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>