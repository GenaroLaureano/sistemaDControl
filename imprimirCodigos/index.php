<?php
require('../reportes/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    // $this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10, utf8_decode('Códigos de barra'),0,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
include '../database/conexion.php';
$codigos = [];
$sqlSelect = "SELECT codigo, descripcion FROM productos;";
$resultSet = $conn->query($sqlSelect);

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$i=0;
while($row = $resultSet->fetch_assoc()){
    $id = $row['codigo'];
	$descripcion = $row['descripcion'];
	// $pdf->Cell(0,10,$descripcion,0,1);
	$pdf->Cell(0,15,$id,0,1);
	$pdf->Image("../img/codigo$id.png",30,33+(15*$i),0,0);
	$i++;
}


$pdf->Output();
?>