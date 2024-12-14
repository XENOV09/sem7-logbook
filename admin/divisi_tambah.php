<?php
session_start();
include "../koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit();
}

// Proses simpan data divisi jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nm_divisi = $_POST['nm_divisi'];

    // Query untuk menyimpan data divisi
    $sql = "INSERT INTO divisi (nm_divisi) VALUES ('$nm_divisi')";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, redirect ke halaman divisi_view.php
        header("Location: divisi.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Divisi</title>

    <!-- Fontfaces CSS -->
    <link href="../css/font-face.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="../vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap-5.1.3/css/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS -->
    <link href="../vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="../vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="../vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="../vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="../vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="../vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS -->
    <link href="../css/theme.css" rel="stylesheet" media="all">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <?php include 'header.php'; ?>

    <div class="main-content">
        <div class="section__content section__content--p30">
            <h2 class="title-1">Tambah Divisi</h2>
            <form method="POST" action="">
                <div class="form-group mb-4">
                    <label for="nm_divisi">Nama Divisi</label>
                    <input type="text" id="nm_divisi" name="nm_divisi" class="form-control shadow-sm" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm px-4">Simpan</button>
                    <a href="divisi.php" class="btn btn-secondary btn-lg shadow-sm px-4">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Jquery JS -->
    <script src="../vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="../vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS -->
    <script src="../vendor/slick/slick.min.js"></script>
    <script src="../vendor/wow/wow.min.js"></script>
    <script src="../vendor/animsition/animsition.min.js"></script>
    <script src="../vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="../vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="../vendor/counter-up/jquery.counterup.min.js"></script>
    <script src="../vendor/circle-progress/circle-progress.min.js"></script>
    <script src="../vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="../vendor/select2/select2.min.js"></script>
    <!-- Main JS -->
    <script src="../js/main.js"></script>
    <style>
        a {
            text-decoration: none;
        }
    </style>

</body>

</html>