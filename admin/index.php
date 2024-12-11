<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: logout.php");
    exit();
}


// Query untuk menghitung jumlah entri di setiap tabel
$user_query = "SELECT COUNT(*) AS count FROM user";
$divisi_query = "SELECT COUNT(*) AS count FROM divisi";
$kegiatan_query = "SELECT COUNT(*) AS count FROM kegiatan";
$jenis_query = "SELECT COUNT(*) AS count FROM jenis";

// Eksekusi query
$user_result = mysqli_query($conn, $user_query);
$divisi_result = mysqli_query($conn, $divisi_query);
$kegiatan_result = mysqli_query($conn, $kegiatan_query);
$jenis_result = mysqli_query($conn, $jenis_query);

// Ambil hasil hitungan
$user_count = mysqli_fetch_assoc($user_result)['count'];
$divisi_count = mysqli_fetch_assoc($divisi_result)['count'];
$kegiatan_count = mysqli_fetch_assoc($kegiatan_result)['count'];
$jenis_count = mysqli_fetch_assoc($jenis_result)['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Novriyan">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="../css/font-face.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="../vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="../vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="../vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="../vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="../vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="../vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="../vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="../vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="../css/theme.css" rel="stylesheet" media="all">

</head>


<!-- Agar tidak bisa discroll-->
<style>
    body, html {
        overflow: hidden;
        height: 100%;
    }
</style>

<body class="page-top">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->

        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <?php include 'sidebar.php'; ?>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->

            <!-- HEADER DESKTOP-->
            <?php include 'header.php'; ?>

            <!-- MAIN CONTENT-->
             
        <!-- User Card -->
        <style>
                /* Make the overview item taller */
                .overview-item {
                    height: 200px; /* Adjust this value as needed */
                }

                /* Ensure the inner content adjusts accordingly */
                .overview__inner {
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between; /* This ensures the icon and text are spaced evenly */
                }
            </style>
        </head>
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="overview-wrap">
                                <h2 class="title-1">Dashboard</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-25">
                        <!-- User Count -->
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview-item overview-item--c1">
                                <div class="overview__inner">
                                    <div class="overview-box clearfix">
                                        <div class="icon">
                                            <i class="zmdi zmdi-account-o"></i>
                                        </div>
                                        <div class="text">
                                            <h2><?= $user_count ?></h2> <!-- Insert the user count here -->
                                            <span>Pengguna</span> <!-- You can customize this label -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divisi Count -->
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview-item overview-item--c2">
                                <div class="overview__inner">
                                    <div class="overview-box clearfix">
                                        <div class="icon">
                                            <i class="zmdi zmdi-account-box"></i>
                                        </div>
                                        <div class="text">
                                            <h2><?= $divisi_count ?></h2> <!-- Insert the divisi count here -->
                                            <span>Divisi</span> <!-- You can customize this label -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kegiatan Count -->
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview-item overview-item--c3">
                                <div class="overview__inner">
                                    <div class="overview-box clearfix">
                                        <div class="icon">
                                            <i class="zmdi zmdi-calendar-note"></i>
                                        </div>
                                        <div class="text">
                                            <h2><?= $kegiatan_count ?></h2> <!-- Insert the kegiatan count here -->
                                            <span>Kegiatan</span> <!-- You can customize this label -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Count -->
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview-item overview-item--c4">
                                <div class="overview__inner">
                                    <div class="overview-box clearfix">
                                        <div class="icon">
                                            <i class="zmdi zmdi-check-square"></i>
                                        </div>
                                        <div class="text">
                                            <h2><?= $jenis_count ?></h2> <!-- Insert the tanggal count here -->
                                            <span>Jenis Kegiatan</span> <!-- You can customize this label -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="../vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="../vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="../vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="../vendor/slick/slick.min.js">
    </script>
    <script src="../vendor/wow/wow.min.js"></script>
    <script src="../vendor/animsition/animsition.min.js"></script>
    <script src="../vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="../vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="../vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="../vendor/circle-progress/circle-progress.min.js"></script>
    <script src="../vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="../vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="../js/main.js"></script>


</body>

</html>
<!-- end document-->
