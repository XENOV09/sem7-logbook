<?php
include "../koneksi.php";

// Pastikan parameter id_user ada dalam URL
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Hapus data user berdasarkan id_user
    $query_delete = "DELETE FROM user WHERE id_user = '$id_user'";
    if (mysqli_query($conn, $query_delete)) {
        // Jika berhasil, redirect ke halaman user.php
        header("Location: user.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "ID user tidak ditemukan.";
}
?>
