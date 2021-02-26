<?php
function pdf($transcript,$event)
{
require('fpdf.php');
class PDF extends FPDF
{
// Page header
function Header()
{
	// Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
	$this->Cell(80);
    // Title
    $this->Cell(30,10,'SPEECH TO TEXT ',15,0,'C');
	// Line break
    $this->Ln(30);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
	$pdf->Write(5,$event);
	$pdf->Ln(10);
	$pdf->Write(5,$transcript);
    $pdf->Ln(10);
   
 $pdf->Output();
}
 ?>