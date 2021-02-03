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
		<h1><i class="fas fa-users-cog"></i> General</h1>

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

<?php
include_once "../database/conexion.php";
date_default_timezone_set('America/Mexico_City');
$ventas = 0;
$fechaInicio= date('Y-m-d 00:00:00',time());
$sqlSelect = "SELECT count(id) AS ventas from ventas where fecha > '$fechaInicio' AND sucursal=1";
$resultSet = $conn->query($sqlSelect);
// var_dump($resultSet);	
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$ventas = $row['ventas'];
}else{
	$ventas = 0;
}

// ventas en el centro
$ventasCentro = 0;
// $fechaInicio= date('Y-m-d 00:00:00',time());
$sqlSelect = "SELECT count(id) AS ventas from ventas where fecha > '$fechaInicio' AND sucursal=2";
$resultSet = $conn->query($sqlSelect);
// var_dump($resultSet);	
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$ventasCentro = $row['ventas'];
}else{
	$ventasCentro = 0;
}

// caja en el mercado
$totalMercado = 0;
$sqlSelect = "SELECT SUM(total) AS total FROM ventas WHERE fecha > '$fechaInicio' and sucursal=1 and corte=0;";
$resultSet = $conn->query($sqlSelect);
// var_dump($resultSet);	
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$totalMercado = $row['total'];
}else{
	$totalMercado = 0;
}


$sqlSelect = "SELECT SUM(total) AS total FROM entradas WHERE fecha > '$fechaInicio' AND estado='SINCORTE';";
$resultSet = $conn->query($sqlSelect);		
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$totalMercado += $row['total'];
}


$sqlSelect = "SELECT SUM(devoluciones.total) AS total FROM devoluciones INNER JOIN  ventas ON devoluciones.venta=ventas.id  WHERE devoluciones.fecha > '$fechaInicio' AND ventas.sucursal=$sucursal AND ventas.corte=0;
";
$resultSet = $conn->query($sqlSelect);	
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$totalMercado -= $row['total'];
}

// caja en el centro
$totalCentro = 0;
$sqlSelect = "SELECT SUM(total) AS total FROM ventas WHERE fecha > '$fechaInicio' and sucursal=2 and corte=0;";
$resultSet = $conn->query($sqlSelect);
// var_dump($resultSet);	
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$totalCentro = $row['total'];
	if($totalCentro === null){
		$totalCentro = 0;
	}
}else{
	$totalCentro = 0;
}

$gananciaMercado = 0;
$sqlSelect = "SELECT SUM(total) AS total FROM ventas WHERE sucursal=1";
$resultSet = $conn->query($sqlSelect);
// var_dump($resultSet);	
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$gananciaMercado = $row['total'];
	if($gananciaMercado === null){
		$gananciaMercado = 0;
	}
}else{
	$gananciaMercado = 0;
}

$gananciaMercadoNeta = 0;
$sqlSelect = "SELECT SUM((productosVendidos.cantidad * productosVendidos.precioVenta ) - (productosVendidos.cantidad *  sucursal.precioCompra)) AS total FROM productosVendidos INNER JOIN sucursal ON productosVendidos.producto = sucursal.producto AND sucursal=1;";
$resultSet = $conn->query($sqlSelect);
// var_dump($resultSet);	
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$gananciaMercadoNeta = $row['total'];
	if($gananciaMercadoNeta === null){
		$gananciaMercadoNeta = 0;
	}
}else{
	$gananciaMercadoNeta = 0;
}

$gananciaCentro = 0;
$sqlSelect = "SELECT SUM(total) AS total FROM ventas WHERE sucursal=2";
$resultSet = $conn->query($sqlSelect);
// var_dump($resultSet);	
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$gananciaCentro = $row['total'];
	if($gananciaCentro === null){
		$gananciaCentro = 0;
	}
}else{
	$gananciaCentro = 0;
}

$gananciaCentroNeta = 0;
$sqlSelect = "SELECT SUM((productosVendidos.cantidad * productosVendidos.precioVenta ) - (productosVendidos.cantidad *  sucursal.precioCompra)) AS total FROM productosVendidos INNER JOIN sucursal ON productosVendidos.producto = sucursal.producto AND sucursal=2;";
$resultSet = $conn->query($sqlSelect);
// var_dump($resultSet);	
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$gananciaCentroNeta = $row['total'];
	if($gananciaCentroNeta === null){
		$gananciaCentroNeta = 0;
	}
}else{
	$gananciaCentroNeta = 0;
}

$inventario = 0;
$sqlSelect = "SELECT (existencia * precioVenta) AS inventario FROM sucursal;";
$resultSet = $conn->query($sqlSelect);
// var_dump($resultSet);	
if($resultSet->num_rows > 0){
	$row = $resultSet->fetch_assoc();
	$inventario = $row['inventario'];
	if($inventario === null){
		$inventario = 0;
	}
}else{
	$inventario = 0;
}


?>


<div class="container-fluid">

<div class="row">

		<div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $ventas?></h3>
                <p>Ventas en el Mercado</p>
              </div>
              <div class="icon">
			<i class="fas fa-dollar-sign"></i>
              </div>
              <a href="../ventas/index.php?sucursal=1" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
		  </div>
		  
		  <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $ventasCentro?></h3>
                <p>Ventas en el Centro</p>
              </div>
              <div class="icon">
			<i class="fas fa-dollar-sign"></i>
              </div>
              <a href="../ventas/index.php?sucursal=2" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
		  </div>
		  

		  <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $totalMercado?></h3>
                <p>Caja en el Mercado</p>
              </div>
              <div class="icon">
			<i class="fas fa-cash-register"></i>
              </div>
              <a href="../corte/agregarACorte.php?sucursal=1" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
		  </div>
		  
		  <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?php echo $totalCentro?></h3>
                <p>Caja en el Centro</p>
              </div>
              <div class="icon">
			<i class="fas fa-cash-register"></i>
              </div>
              <a href="../corte/agregarACorte.php?sucursal=2" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>



</div>
</div>



			<div class="card">
              <div class="card-header border-0 bg-success">
                <h3 >Productos más vendidos</h3>
                <div class="card-tools">
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Precio</th>
					<th>Ventas</th>
                    <th>Sucursal</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php
					$sqlSelect = "SELECT productos.codigo, productos.descripcion, productosVendidos.precioVenta, COUNT(productosVendidos.cantidad) AS cantidad,ventas.sucursal
					FROM productosVendidos INNER JOIN ventas ON productosVendidos.venta = ventas.id
					INNER JOIN productos ON productosVendidos.producto=productos.id GROUP BY productosVendidos.producto limit 5;";
					$resultSet = $conn->query($sqlSelect);
					
					if($resultSet->num_rows >0 ){
					 
			while($producto = $resultSet->fetch_assoc()){
			?>
                  <tr>	

				<td><?php echo $producto['codigo'];?></td>
				<td><?php echo $producto['descripcion'];?></td>
				<td><?php echo $producto['precioVenta'];?></td>
				<td>
					<small class="text-success mr-1">
						<i class="fas fa-arrow-up"></i>
					</small>
					<?php echo $producto['cantidad'];?></td>
				<td><?php echo $producto['sucursal'];?></td>
				</tr>
	
			<?php
			} }
			?>	
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->



			<div class="card">
              <div class="card-header border-0 bg-warning">
                <h3 class=''>Productos con menos existencia</h3>
                <div class="card-tools">
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Precio</th>
					<th>Existencia</th>
                    <th>Sucursal</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php
					$sqlSelect = "SELECT existencia, productos.codigo,productos.descripcion, sucursal.precioVenta, sucursal.sucursal
					FROM sucursal INNER JOIN productos ON sucursal.producto = productos.id ORDER BY sucursal.existencia ASC LIMIT 5;";
					$resultSet = $conn->query($sqlSelect);
					
					if($resultSet->num_rows >0 ){
					 
			while($producto = $resultSet->fetch_assoc()){
			?>
                  <tr>	

				<td><?php echo $producto['codigo'];?></td>
				<td><?php echo $producto['descripcion'];?></td>
				<td><?php echo $producto['precioVenta'];?></td>
				<td>
					<small class="text-warning mr-1">
						<i class="fas fa-arrow-down"></i>
					</small>
				<?php echo $producto['existencia'];?></td>
				<td><?php echo $producto['sucursal'];?></td>
				</tr>
	
			<?php
			} }
			?>	
                  </tbody>
                </table>
              </div>
            </div>




                <div class="row">
     
                  <div class="col-md-4">
                    <h3 class="text-center">
                      <strong>Ganancias Mercado</strong>
					</h3>

                    <div class="progress-group">
                      Ventas
                      <span class="float-right"><b>$ <?php echo $gananciaMercado;?></b></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: 80%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      Neta 
                      <span class="float-right"><b>$ <?php echo $gananciaMercadoNeta;?> </b></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-info" style="width: 75%"></div>
                      </div>
                    </div>

              

					</div>


					
					<div class="col-md-4">
                    <h3 class="text-center">
                      <strong>Ganancias Centro</strong>
					</h3>

                    <div class="progress-group">
                      Ventas
                      <span class="float-right"><b>$ <?php echo $gananciaCentro;?></b></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 80%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      Neta 
                      <span class="float-right"><b>$ <?php echo $gananciaCentroNeta;?> </b></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 75%"></div>
                      </div>
                    </div>

			  </div>




			<br>


			  <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-primary">
              <span class="info-box-icon"><i class="fas fa-cash-register"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ventas</span>
                <span class="info-box-number"><?php echo $gananciaCentro + $gananciaMercado;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ganancia</span>
                <span class="info-box-number"><?php echo $gananciaCentroNeta + $gananciaMercadoNeta;?></span>
              </div>
              <!-- /.info-box-content -->
			</div>
			
			<div class="info-box mb-3 bg-warning">
			<span class="info-box-icon"><i class="fas fa-tag"></i></span>
              
              <div class="info-box-content">
                <span class="info-box-text">Inventario</span>
                <span class="info-box-number"><?php echo $inventario?></span>
              </div>
              <!-- /.info-box-content -->
            </div>


            <!-- /.info-box -->
            <!-- <div class="info-box mb-3 bg-danger"> -->
              <!-- <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span> -->

              <!-- <div class="info-box-content">
                <span class="info-box-text">Downloads</span>
                <span class="info-box-number">114,381</span>
              </div> -->
              <!-- /.info-box-content -->
            <!-- </div> -->
            <!-- /.info-box -->
            <!-- <div class="info-box mb-3 bg-info"> -->
              <!-- <span class="info-box-icon"><i class="far fa-comment"></i></span> -->

              <!-- <div class="info-box-content">
                <span class="info-box-text">Direct Messages</span>
				<span class="info-box-number">163,921</span>
				
              </div> -->
              <!-- /.info-box-content -->
			</div>
			</div>
            <!-- /.info-box -->
			  




					</div>
					<br><br>







       



	</div>
  </div>
  </div>
  <!-- /.content-wrapper -->
<?php include '../footer/index.php'?>