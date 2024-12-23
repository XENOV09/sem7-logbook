<?php
require('../vendor/fpdf/fpdf.php');
include "../koneksi.php";

// Query untuk mengambil semua data jenis kegiatan
$sql_jenis = "SELECT * FROM jenis";
$result_jenis = mysqli_query($conn, $sql_jenis);

// Inisialisasi FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Judul laporan
$pdf->Cell(0, 10, 'Laporan Jenis Kegiatan', 0, 1, 'C');
$pdf->Ln(10);

// Header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'No', 1, 0, 'C');
$pdf->Cell(50, 10, 'ID Jenis', 1, 0, 'C');
$pdf->Cell(120, 10, 'Jenis Kegiatan', 1, 1, 'C');

// Data tabel
$pdf->SetFont('Arial', '', 12);
$no = 1;
while ($row_jenis = mysqli_fetch_assoc($result_jenis)) {
    $pdf->Cell(20, 10, $no++, 1, 0, 'C');
    $pdf->Cell(50, 10, $row_jenis['id_jenis'], 1, 0, 'C');
    $pdf->Cell(120, 10, $row_jenis['jenis'], 1, 1, 'L');
}

// Output PDF
$pdf->Output();
?>
