<?php
require('../vendor/fpdf/fpdf.php');
include "../koneksi.php";

// Query untuk mengambil semua data pengguna
$sql_user = "SELECT user.*, divisi.nm_divisi FROM user LEFT JOIN divisi ON user.id_divisi = divisi.id_divisi";
$result_user = mysqli_query($conn, $sql_user);

// Inisialisasi FPDF
$pdf = new FPDF('L', 'mm', 'A4'); // 'L' untuk landscape
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Judul laporan
$pdf->Cell(0, 10, 'Laporan Data Pengguna', 0, 1, 'C');
$pdf->Ln(10);

// Header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(50, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(50, 10, 'Divisi', 1, 0, 'C');
$pdf->Cell(40, 10, 'Username', 1, 0, 'C');
$pdf->Cell(40, 10, 'password', 1, 0, 'C');
$pdf->Cell(40, 10, 'Role', 1, 1, 'C');

// Data tabel
$pdf->SetFont('Arial', '', 12);
$no = 1;
while ($row_user = mysqli_fetch_assoc($result_user)) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
    $pdf->Cell(50, 10, $row_user['nm_user'], 1, 0, 'L');
    $pdf->Cell(50, 10, $row_user['nm_divisi'], 1, 0, 'L');
    $pdf->Cell(40, 10, $row_user['username'], 1, 0, 'L');
    $pdf->Cell(40, 10, $row_user['password'], 1, 0, 'L');
    $pdf->Cell(40, 10, ucfirst($row_user['role']), 1, 1, 'C');
}

// Output PDF
$pdf->Output();
?>
