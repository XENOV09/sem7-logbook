<?php
include "../koneksi.php";

// Pastikan parameter id_kegiatan ada dalam URL
if (isset($_GET['id_kegiatan'])) {
    $id_kegiatan = $_GET['id_kegiatan'];

    // Hapus data kegiatan berdasarkan id_kegiatan
    $query_delete = "DELETE FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'";
    if (mysqli_query($conn, $query_delete)) {
        // Jika berhasil, redirect ke halaman kegiatan
        header("Location: kegiatan.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "ID kegiatan tidak ditemukan.";
}
?>
