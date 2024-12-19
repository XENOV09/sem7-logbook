<?php
require('../vendor/fpdf/fpdf.php');  // Pastikan path FPDF sesuai dengan tempat Anda meletakkan file FPDF

// Ambil parameter yang dikirimkan melalui URL
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';
$id_divisi_filter = isset($_GET['id_divisi']) ? $_GET['id_divisi'] : '';

// Koneksi ke database
include "../koneksi.php";

// Query dasar
$sql_kegiatan = "
    SELECT k.*, j.jenis, u.nm_user, d.nm_divisi
    FROM kegiatan k
    JOIN jenis j ON j.id_jenis = k.id_jenis
    JOIN user u ON u.id_user = k.id_user
    JOIN divisi d ON d.id_divisi = k.id_divisi";

// Filter berdasarkan tanggal dan divisi
if ($tanggal_awal && $tanggal_akhir) {
    $sql_kegiatan .= " AND k.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
} elseif ($tanggal_awal) {
    $sql_kegiatan .= " AND k.tanggal >= '$tanggal_awal'";
} elseif ($tanggal_akhir) {
    $sql_kegiatan .= " AND k.tanggal <= '$tanggal_akhir'";
}
if ($id_divisi_filter) {
    $sql_kegiatan .= " AND k.id_divisi = '$id_divisi_filter'";
}

// Eksekusi query
$result_kegiatan = mysqli_query($conn, $sql_kegiatan);

// Buat objek FPDF
$pdf = new FPDF('L', 'mm', 'legal');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Judul Laporan
$pdf->Cell(0, 10, 'Laporan Kegiatan Divisi', 0, 1, 'C');
$pdf->Cell(0, 10, 'Tanggal: ' . ($tanggal_awal ? $tanggal_awal : 'Semua Tanggal Awal') . ' - ' . ($tanggal_akhir ? $tanggal_akhir : 'Semua Tanggal Akhir'), 0, 1, 'C');
$pdf->Ln(10);

// Header Tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 7, 'No', 1, 0, 'C');
$pdf->Cell(30, 7, 'Tanggal', 1, 0, 'C');
$pdf->Cell(30, 7, 'Divisi', 1, 0, 'C');
$pdf->Cell(40, 7, 'Oleh', 1, 0, 'C');
$pdf->Cell(40, 7, 'Jenis Kegiatan', 1, 0, 'C');
$pdf->Cell(50, 7, 'Kegiatan', 1, 0, 'C');
$pdf->Cell(30, 7, 'Lokasi', 1, 0, 'C');
$pdf->Cell(30, 7, 'Waktu Mulai', 1, 0, 'C');
$pdf->Cell(30, 7, 'Waktu Selesai', 1, 1, 'C');

// Menampilkan data kegiatan dalam tabel
$pdf->SetFont('Arial', '', 10);
$no = 1;
while ($row = mysqli_fetch_assoc($result_kegiatan)) {
    $pdf->Cell(10, 7, $no++, 1, 0, 'C');
    $pdf->Cell(30, 7, date('d-m-Y', strtotime($row['tanggal'])), 1, 0, 'C');
    $pdf->Cell(30, 7, $row['nm_divisi'], 1, 0, 'C');
    $pdf->Cell(40, 7, $row['nm_user'], 1, 0, 'C');
    $pdf->Cell(40, 7, $row['jenis'], 1, 0, 'C');
    $pdf->Cell(50, 7, $row['kegiatan'], 1, 0, 'C');
    $pdf->Cell(30, 7, $row['lokasi'], 1, 0, 'C');
    $pdf->Cell(30, 7, date('d-m-Y H:i', strtotime($row['waktu_mulai'])), 1, 0, 'C');
    $pdf->Cell(30, 7, date('d-m-Y H:i', strtotime($row['waktu_selesai'])), 1, 1, 'C');
}

// Output PDF
$pdf->Output();
?>
