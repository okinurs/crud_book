<?php
session_start();
require 'functions.php';
$book = query("SELECT * FROM tb_book");


require_once("tcpdf/tcpdf.php");

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information


$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Naura Store');
$pdf->setTitle('Data Buku Naura Store');
$pdf->setSubject('Data Buku Naura Store ');
$pdf->setKeywords('Data Buku Naura Store');

$pdf->setFont('dejavusans', '', 11, '', true);
$pdf->AddPage();

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
 
    <title>Data Buku Naura Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<table class="table table-bordered"> 
    
        <tr>
            <td>No</td>
            <td>Judul Buku</td>
            <td>Penulis</td>
            <td>Penerbit</td>
            <td>Cover</td>
            
        </tr>';
        $i = 1;
        foreach($book as $item){
            $html .= '<tr>
            <td>'. $i++.'</td>
            <td>'. $item["judul_buku"] .'</td> 
            <td>'. $item["penulis"] .'</td> 
            <td>'. $item["penerbit"] .'</td> 
            <td><img src="img/'.$item["cover"].'" width="45"></td> 
            </tr>';
        }
  
 $html .= '</table>
</body>
</html>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Output('DataBuku.pdf', 'I');