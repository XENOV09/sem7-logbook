<?php
include "../koneksi.php";

// Pastikan parameter id_user ada dalam URL
if (isset($_GET['id_jenis'])) {
    $id_jenis = $_GET['id_jenis'];

    // Hapus data user berdasarkan id_user
    $query_delete = "DELETE FROM jenis WHERE id_jenis = '$id_jenis'";
    if (mysqli_query($conn, $query_delete)) {
        // Jika berhasil, redirect ke halaman user.php
        header("Location: jenis.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "ID jenis tidak ditemukan.";
}
?>
