<?php

// Optionally define the filesystem path to your system fonts
// otherwise tFPDF will use [path to tFPDF]/font/unifont/ directory
// define("_SYSTEM_TTFONTS", "C:/Windows/Fonts/");

require('tfpdf.php');

$pdf = new tFPDF();
$pdf->AddPage();

$str = 'https://maps.googleapis.com/maps/api/staticmap?cneter=Murom&size=400x300&zoom=13&maptype=roadmap
&markers=color:red%7Clabel:C%7C55.57722084215371,42.051084181510646&key=AIzaSyDLzWXCDzG8Ui_APDFhNmq9YRJMbUbBj3Y';
$local='tmp.png';
file_put_contents($local, file_get_contents($str));











$pdf->Image($str,10,8,33);

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',14);

// Load a UTF-8 string from a file and print it
$txt = file_get_contents('HelloWorld.txt');
$pdf->Write(8,$txt);

// Select a standard font (uses windows-1252)
$pdf->SetFont('Arial','',14);
$pdf->Ln(10);
$pdf->Write(5,'The file size of this PDF is only 13 KB.');

$pdf->Output();
?>
