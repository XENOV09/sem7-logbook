<?php
require('../vendor/fpdf/fpdf.php');
include "../koneksi.php";

// Query untuk mengambil semua data jenis kegiatan
$sql_divisi = "SELECT * FROM divisi";
$result_divisi = mysqli_query($conn, $sql_divisi);

// Inisialisasi FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Judul laporan
$pdf->Cell(0, 10, 'Laporan Divisi', 0, 1, 'C');
$pdf->Ln(10);

// Header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'No', 1, 0, 'C');
$pdf->Cell(50, 10, 'ID Divisi', 1, 0, 'C');
$pdf->Cell(120, 10, 'Nama Divisi', 1, 1, 'C');

// Data tabel
$pdf->SetFont('Arial', '', 12);
$no = 1;
while ($row_divisi = mysqli_fetch_assoc($result_divisi)) {
    $pdf->Cell(20, 10, $no++, 1, 0, 'C');
    $pdf->Cell(50, 10, $row_divisi['id_divisi'], 1, 0, 'C');
    $pdf->Cell(120, 10, $row_divisi['nm_divisi'], 1, 1, 'L');
}

// Output PDF
$pdf->Output();
?>
