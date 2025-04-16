<?php
require_once __DIR__ . '/../vendor/autoload.php'; // TCPDF via Composer

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/data.php';

$id = $_GET['id'];
$villaDetail = $villa->getVilla($id);
$villaImage = $villa->getPrimaryImage($id);
$villaEigenschappen = $options->getEigenschappenByVilla($id);
$villaOpties = $liggingsopties->getLiggingsoptiesByVilla($id);

if (!$villaDetail) {
    die("Villa niet gevonden.");
}

// Convert villaDetail to array if it is an object
if (is_object($villaDetail)) {
    $villaDetail = (array) $villaDetail;
}

// Banner pad
$bannerPath = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/villa/' . $villaImage;

// Maak nieuwe PDF aan
$pdf = new \TCPDF();
$pdf->AddPage();

// Logo & Titel
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(0, 10, 'VAKANTIE 🏝 VILLA', 0, 1, 'C');

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, $villaDetail['name'] ?? '', 0, 1, 'C');

// Banner
if ($bannerPath && file_exists($bannerPath)) {
    $pdf->Image($bannerPath, 30, $pdf->GetY(), 150, 75, '', '', '', true);
    $pdf->Ln(80);
} else {
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Rect(30, $pdf->GetY(), 150, 75, 'F');
    $pdf->SetY($pdf->GetY() + 35);
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'banner', 0, 1, 'C');
    $pdf->Ln(10);
}

// Prijs
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, '€ ' . number_format($villaDetail['price'] ?? 0, 0, ',', '.'), 0, 1, 'R');

$pdf->SetFont('helvetica', '', 11);
$pdf->MultiCell(0, 6, $villaDetail['desc'] ?? '', 0, 'L');

// Adres
$pdf->Ln(5);
$pdf->Write(6, "📍 " . (($villaDetail['street'] ?? '') . ' ' . ($villaDetail['number'] ?? '')));
$pdf->Ln(5);
$pdf->Write(6, "🏡 Te koop: " . (!empty($villaDetail['forsale']) ? 'Ja' : 'Nee'));

// Eigenschappen
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Write(6, 'Eigenschappen:');
$pdf->Ln(6);
$pdf->SetFont('helvetica', '', 11);
foreach ($villaEigenschappen as $eigenschap) {
    $name = is_object($eigenschap) ? $eigenschap->name : ($eigenschap['name'] ?? '');
    $pdf->Write(6, "- " . $name);
    $pdf->Ln(5);
}

// Opties
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Write(6, 'Opties:');
$pdf->Ln(6);
$pdf->SetFont('helvetica', '', 11);
foreach ($villaOpties as $optie) {
    $name = is_object($optie) ? $optie->name : ($optie['name'] ?? '');
    $pdf->Write(6, "- " . $name);
    $pdf->Ln(5);
}

// Output
$pdf->Output('villa_' . ($villaDetail['id'] ?? 'unknown') . '.pdf', 'I'); // I = direct tonen in browser
?>
