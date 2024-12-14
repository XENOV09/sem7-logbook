<?php
include "../koneksi.php";

// Pastikan parameter id_user ada dalam URL
if (isset($_GET['id_divisi'])) {
    $id_divisi = $_GET['id_divisi'];

    // Hapus data user berdasarkan id_user
    $query_delete = "DELETE FROM divisi WHERE id_divisi = '$id_divisi'";
    if (mysqli_query($conn, $query_delete)) {
        // Jika berhasil, redirect ke halaman user.php
        header("Location: divisi.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "ID user tidak ditemukan.";
}
?>
