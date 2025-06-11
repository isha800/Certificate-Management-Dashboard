<?php
include('db.php');
include('fpdf\fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetFont('Arial','B',16);
        $pdf->cell(0,10,'course completion certificate',0,1,'C');
        $pdf->SetFont('Arial','',12);
        $pdf->cell(0,10,"Name:mohan",0,1);
        $pdf->cell(0,10,"Course:python",0,1);
        $pdf->cell(0,10,"Expiry Date:XX/XX/XXXX",0,1);
        $pdf->Ln(10);
        $pdf->cell(0,10,'(This is a masked preview)',0,1);
        
$pdf->output();
        
?>