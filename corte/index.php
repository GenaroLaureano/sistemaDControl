<?php 
session_start();
if(isset($_SESSION) && (isset($_SESSION['logueado'])) == FALSE){
  header("Location: ../index.php");
}
if(!isset($_SESSION["entrada"])) $_SESSION["entrada"] = [];
if(!isset($_SESSION["ventas"])) $_SESSION["ventas"] = [];
if(!isset($_SESSION["dev"])) $_SESSION["dev"] = [];
include '../header/index.php';
include '../navbar/index.php';
include '../sidebar/index.php';
?>
  <div class="content-wrapper">
  <div class="content">
	<div class="col-xs-12">
		<h1><i class="fas fa-cash-register"></i> Caja</h1>
		<br>
		<a href="../administrador-principal/index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Regresar</a>
		<br>
		<br>
		<?php
			if(isset($_GET["status"])){
				if($_GET["status"] === "1"){
					?>
						<div class="alert alert-success">
							<strong>¡Correcto!</strong> Corte realizada correctamente
							<a href="index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
						</div>
					<?php
				}else if($_GET["status"] === "2"){
					?>
					<div class="alert alert-warning">
							<strong>No se encontraron registros</strong>
							<a href="../administrador-principal/index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
						</div>
					<?php
				}else{
					?>
					<div class="alert alert-danger">
							<strong>Error:</strong> Algo salió mal mientras se realizaba la corte
							<a href="../administrador-principal/index.php">
							<i class="fas fa-times-circle text-danger float-right"></i>
							</a>
						</div>
					<?php
				}
			}
		?>
		<br>
	

		<?php
			if(isset($_GET["corte"])){
			if($_GET['corte'] === "1"){ 
			$entradas = $_SESSION['entrada'];
			$ventas = $_SESSION['ventas'];
			$devoluciones = $_SESSION['dev'];
			$total = 0;


			$entradasTable = '';
			$ventasTable = '';
			$devolucionesTable = '';
			
			foreach($entradas as $entrada){ 
				$total += $entrada['cantidad'];

				$folioEntrada = $entrada['folio'];
				$fechaEntrada = $entrada['fecha'];
				$cantidadEntrada = $entrada['cantidad'];

				$entradasTable .= "<tr class='table-info'>";
				$entradasTable .= "<td >$folioEntrada</td>";
				$entradasTable .= "<td >$fechaEntrada</td>";
				$entradasTable .= "<td >+ $ $cantidadEntrada</td>";
				$entradasTable .= "<td >ENTRADA</td>";
				$entradasTable .= "</tr>";
			}

			foreach($ventas as $venta){ 
				$total += $venta['cantidad'];

				$folioVenta = $venta['folio'];
				$fechaVenta = $venta['fecha'];
				$cantidadVenta = $venta['cantidad'];

				$ventasTable .= "<tr class='table-success'>";
				$ventasTable .= "<td >$folioVenta</td>";
				$ventasTable .= "<td >$fechaVenta</td>";
				$ventasTable .= "<td >+ $ $cantidadVenta</td>";
				$ventasTable .= "<td >VENTA</td>";
				$ventasTable .= "</tr>";
			}

			foreach($devoluciones as $devolucion){ 
				$total -= $devolucion['cantidad'];
				$folioDev = $devolucion['folio'];
				$fechaDev = $devolucion['fecha'];
				$cantidadDev = $devolucion['cantidad'];

				$devolucionesTable .= "<tr class='table-warning'>";
				$devolucionesTable .= "<td >$folioDev</td>";
				$devolucionesTable .= "<td >$fechaDev</td>";
				$devolucionesTable .= "<td >- $ $cantidadDev</td>";
				$devolucionesTable .= "<td >DEVOLUCIÓN</td>";
				$devolucionesTable .= "</tr>";
			}
				
		?>
			<table class="table">
			<thead>
				<tr>
					<th>Folio</th>
					<th>Fecha</th>
					<th>Cantidad</th>
					<th>Tipo</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			echo $entradasTable;
			echo $ventasTable;
			echo $devolucionesTable;
			?>
			</tbody>
		</table>

		

		<h3>Total: <?php echo $total; ?></h3>
            <form action="terminarCorte.php" method="POST">
                <input name="total" type="hidden" value="<?php echo $total;?>">
            </form>
			<?php
			
		}
		}else{
			$_SESSION['entrada'] =[];
			$_SESSION['ventas'] = [];
			$_SESSION['dev'] = [];

		}
		?>


	</div>
  </div>
  </div>
  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>