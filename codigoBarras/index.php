
<?php
include '../database/conexion.php';
$codigos = [];
$sqlSelect = "SELECT codigo, descripcion FROM productos;";
$resultSet = $conn->query($sqlSelect);
while($row = $resultSet->fetch_assoc()){
    $id = $row['codigo'];
    $descripcion = $row['descripcion'];
    array_push($codigos, $id);
}
?>

<?php foreach ($codigos as $codigo) {?>
<h4>Con código <?php echo $codigo; ?>: </h4>
<img src="creador.php?texto=<?php echo $codigo; ?>">
<?php }?>


