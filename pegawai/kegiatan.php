<?php
session_start();
include "../koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil id_user dari session
$id_user = $_SESSION['id_user'];

// Ambil id_divisi dari tabel user berdasarkan id_user
$result_user = mysqli_query($conn, "SELECT id_divisi FROM user WHERE id_user = '$id_user'");
$user_data = mysqli_fetch_assoc($result_user);
$id_divisi_user = $user_data['id_divisi'];

// Ambil nama divisi berdasarkan id_divisi
$result_divisi = mysqli_query($conn, "SELECT nm_divisi FROM divisi WHERE id_divisi = '$id_divisi_user'");
$divisi_data = mysqli_fetch_assoc($result_divisi);
$nm_divisi = $divisi_data ? $divisi_data['nm_divisi'] : 'Divisi Tidak Ditemukan';

// Filter tanggal dan user
$tanggal_awal = isset($_POST['tanggal_awal']) ? $_POST['tanggal_awal'] : '';
$tanggal_akhir = isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : '';
$id_user_filter = isset($_POST['id_user']) ? $_POST['id_user'] : '';

// Query untuk mendapatkan kegiatan yang sesuai dengan id_divisi user dan tanggal filter
$sql_kegiatan = "
    SELECT k.*, j.jenis, u.nm_user
    FROM kegiatan k
    JOIN jenis j ON j.id_jenis = k.id_jenis
    JOIN user u ON u.id_user = k.id_user
    WHERE k.id_divisi = '$id_divisi_user'";

if ($tanggal_awal && $tanggal_akhir) {
    $sql_kegiatan .= " AND k.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
} elseif ($tanggal_awal) {
    $sql_kegiatan .= " AND k.tanggal >= '$tanggal_awal'";
} elseif ($tanggal_akhir) {
    $sql_kegiatan .= " AND k.tanggal <= '$tanggal_akhir'";
}

if ($id_user_filter) {
    $sql_kegiatan .= " AND k.id_user = '$id_user_filter'";
}


$result_kegiatan = mysqli_query($conn, $sql_kegiatan);
$jml_logbook = mysqli_num_rows($result_kegiatan);

// Ambil daftar user untuk dropdown (dengan filter id_divisi)
$result_user_filter = mysqli_query($conn, "SELECT id_user, nm_user FROM user WHERE id_divisi = '$id_divisi_user'");
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
    <title>Logbook</title>

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

    <!-- Link Pack Icon-->
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <!-- Link ke CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="page-top">
    <div class="page-wrapper">

        <!-- MENU SIDEBAR-->
        <?php include 'sidebar.php'; ?>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <?php include 'header.php'; ?>

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                <h2 class="title-1">Logbook - <?php echo $nm_divisi; ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Filter User dan Tanggal -->
                        <form method="POST" class="mb-3">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <select name="id_user" class="form-control">
                                        <option value="">Pilih User</option>
                                        <?php while ($user = mysqli_fetch_assoc($result_user_filter)) { ?>
                                            <option value="<?php echo $user['id_user']; ?>" <?php echo ($id_user_filter == $user['id_user']) ? 'selected' : ''; ?>><?php echo $user['nm_user']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="date" name="tanggal_awal" class="form-control" value="<?php echo $tanggal_awal; ?>" placeholder="Tanggal Awal">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="date" name="tanggal_akhir" class="form-control" value="<?php echo $tanggal_akhir; ?>" placeholder="Tanggal Akhir">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <button type="submit" class="btn btn-success w-100">Filter</button>
                                </div>
                            </div>
                        </form>


                        <!-- Tabel untuk menampilkan data kegiatan -->
                        <div class="card">
                            <div class="card-body">
                            <!-- Menambahkan tombol "Tambah Kegiatan" di atas kanan tabel -->
                            <div class="row mb-3">
                                <div class="col-lg-12 text-end">
                                    <a href="tambah_kegiatan.php" class="btn btn-primary"><i class="bx bx-plus"></i> Tambah Kegiatan</a>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped table-earning">
                                    <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Kegiatan</th> <!-- Kolom Tanggal Kegiatan -->
                                                <th>Oleh</th>
                                                <th>Jenis Kegiatan</th> <!-- Kolom Jenis Kegiatan -->
                                                <th>Kegiatan</th>
                                                <th>Lokasi</th>
                                                <th>Waktu Mulai</th>
                                                <th>Waktu Selesai</th>
                                                <th>Budget</th>
                                                <th>Pengeluaran</th>
                                                <th>Sisa</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 1; // Mulai nomor urut dari 1
                                                while($row_kegiatan = mysqli_fetch_assoc($result_kegiatan)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut otomatis -->
                                                <td style="white-space: nowrap;"><?php echo date('d-m-Y', strtotime($row_kegiatan['tanggal'])); ?></td> <!-- Menampilkan tanggal kegiatan -->
                                                <td><?php echo $row_kegiatan['nm_user']; ?></td> <!-- Menampilkan nama penginput otomatis -->
                                                <td><?php echo $row_kegiatan['jenis']; ?></td> <!-- Menampilkan jenis kegiatan -->
                                                <td><?php echo $row_kegiatan["kegiatan"]; ?></td>
                                                <td><?php echo $row_kegiatan["lokasi"]; ?></td>
                                                <td><?php echo $row_kegiatan["waktu_mulai"]; ?></td>
                                                <td><?php echo $row_kegiatan["waktu_selesai"]; ?></td>
                                                <td style="white-space: nowrap;">Rp <?php echo number_format($row_kegiatan["budget"], 0, ',', '.'); ?></td>
                                                <td style="white-space: nowrap;">Rp <?php echo number_format($row_kegiatan["pengeluaran"], 0, ',', '.'); ?></td>
                                                <td style="white-space: nowrap;">Rp <?php echo number_format($row_kegiatan["sisa"], 0, ',', '.'); ?></td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="surat_masuk_edit.php?id=<?php echo $row_kegiatan["id_kegiatan"]?>" class="btn btn-sm btn-success"><i class="bx bx-pencil"></i> Edit</a>
                                                    <a href="surat_masuk_hapus.php?id=<?php echo $row_kegiatan["id_kegiatan"]?>" class="btn btn-sm btn-danger" onClick="return confirm('Apakah anda yakin ingin menghapus data ini...?')"><i class="bx bx-trash"></i> Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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

    <!-- Jquery JS-->
    <script src="../vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="../vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="../vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS-->
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

    <!-- Main JS-->
    <script src="../js/main.js"></script>
    <!-- Agar Teks tidak berubah jadi link -->
    <style>
        a {
            text-decoration: none;
        }
    </style>
</body>
</html>
