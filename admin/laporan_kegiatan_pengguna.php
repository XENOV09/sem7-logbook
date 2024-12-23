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

// Ambil nama pengguna berdasarkan id_user
$result_user = mysqli_query($conn, "SELECT nm_user FROM user WHERE id_user = '$id_user'");
$user_data = mysqli_fetch_assoc($result_user);
$nm_user = $user_data ? $user_data['nm_user'] : 'Pengguna Tidak Ditemukan';

// Filter tanggal
$tanggal_awal = isset($_POST['tanggal_awal']) ? $_POST['tanggal_awal'] : '';
$tanggal_akhir = isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : '';

// Filter user
$id_user_filter = isset($_POST['id_user']) ? $_POST['id_user'] : ''; // Menangkap nilai user filter dari form

// Query dasar
$sql_kegiatan = "
    SELECT k.*, j.jenis, u.nm_user, d.nm_divisi
    FROM kegiatan k
    JOIN jenis j ON j.id_jenis = k.id_jenis
    JOIN user u ON u.id_user = k.id_user
    JOIN divisi d ON d.id_divisi = k.id_divisi";

// Ambil daftar pengguna untuk dropdown (filter user)
$result_user_filter = mysqli_query($conn, "SELECT id_user, nm_user FROM user");

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
    <title>Laporan Kegiatan Pengguna</title>

    <!-- Fontfaces CSS-->
    <link href="../css/font-face.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="../vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="../vendor/bootstrap-5.1.3/css/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="../vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="../vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="../vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="../vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="../vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="../vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link href="../vendor/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-- Main CSS-->
    <link href="../css/theme.css" rel="stylesheet" media="all">
    <!-- Pack Icon-->
    <link href="../css/boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" media="all">
    <!-- Tambahkan DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
                                <h2 class="title-1">Laporan - Kegiatan Pengguna</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Tanggal dan User -->
                    <form method="POST" class="mb-3">
                        <div class="row">
                            <!-- Filter User -->
                            <div class="col-md-3 mb-2">
                                <label for="id_user">Pilih Pengguna</label>
                                <select name="id_user" class="form-control" id="id_user">
                                    <option value="">Semua</option>
                                    <?php 
                                    while ($user = mysqli_fetch_assoc($result_user_filter)) {
                                        ?>
                                        <option value="<?php echo $user['id_user']; ?>" <?php echo ($id_user_filter == $user['id_user']) ? 'selected' : ''; ?>>
                                            <?php echo $user['nm_user']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Filter Tanggal Awal -->
                            <div class="col-md-2 mb-2">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input type="date" name="tanggal_awal" class="form-control" value="<?php echo $tanggal_awal; ?>" placeholder="Tanggal Awal" id="tanggal_awal">
                            </div>

                            <!-- Filter Tanggal Akhir -->
                            <div class="col-md-2 mb-2">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" class="form-control" value="<?php echo $tanggal_akhir; ?>" placeholder="Tanggal Akhir" id="tanggal_akhir">
                            </div>

                            <!-- Tombol Filter -->
                            <div class="col-md-2 mb-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabel untuk menampilkan data kegiatan -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Tombol "Print Laporan" -->
                            <div class="row mb-3">
                                <div class="col-lg-12 text-end">
                                    <a href="laporan_kegiatan_pengguna_pdf.php?tanggal_awal=<?php echo $tanggal_awal; ?>&tanggal_akhir=<?php echo $tanggal_akhir; ?>&id_user=<?php echo $id_user_filter; ?>" class="btn btn-success"><i class="bx bx-printer"></i> Print Laporan</a>
                                </div>
                            </div>

                            <!-- Tabel Data Kegiatan -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive table--no-card m-b-30">
                                        <table id="kegiatanTable" class="table table-borderless table-earning">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal Kegiatan</th>
                                                    <th>Divisi</th>
                                                    <th>Oleh</th>
                                                    <th>Jenis Kegiatan</th>
                                                    <th>Kegiatan</th>
                                                    <th>Lokasi</th>
                                                    <th>Waktu Mulai</th>
                                                    <th>Waktu Selesai</th>
                                                    <th>Budget</th>
                                                    <th>Pengeluaran</th>
                                                    <th>Sisa</th>
                                                    <th>Catatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Menambahkan filter berdasarkan POST
                                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                                    if ($tanggal_awal && $tanggal_akhir) {
                                                        $sql_kegiatan .= " WHERE k.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
                                                    } elseif ($tanggal_awal) {
                                                        $sql_kegiatan .= " WHERE k.tanggal >= '$tanggal_awal'";
                                                    } elseif ($tanggal_akhir) {
                                                        $sql_kegiatan .= " WHERE k.tanggal <= '$tanggal_akhir'";
                                                    }
                                                    if ($id_user_filter) {
                                                        $sql_kegiatan .= (strpos($sql_kegiatan, 'WHERE') !== false ? " AND" : " WHERE") . " k.id_user = '$id_user_filter'";
                                                    }

                                                    $result_kegiatan = mysqli_query($conn, $sql_kegiatan);
                                                    $no = 1;
                                                    while ($row_kegiatan = mysqli_fetch_assoc($result_kegiatan)) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row_kegiatan['tanggal'])); ?></td>
                                                            <td><?php echo $row_kegiatan['nm_divisi']; ?></td>
                                                            <td><?php echo $row_kegiatan['nm_user']; ?></td>
                                                            <td><?php echo $row_kegiatan['jenis']; ?></td>
                                                            <td><?php echo $row_kegiatan['kegiatan']; ?></td>
                                                            <td><?php echo $row_kegiatan['lokasi']; ?></td>
                                                            <td><?php echo date('d-m-Y H:i', strtotime($row_kegiatan['waktu_mulai'])); ?></td>
                                                            <td><?php echo date('d-m-Y H:i', strtotime($row_kegiatan['waktu_selesai'])); ?></td>
                                                            <td><?php echo number_format($row_kegiatan['budget'], 2, ',', '.'); ?></td>
                                                            <td><?php echo number_format($row_kegiatan['pengeluaran'], 2, ',', '.'); ?></td>
                                                            <td><?php echo number_format($row_kegiatan['sisa'], 2, ',', '.'); ?></td>
                                                            <td><?php echo $row_kegiatan['catatan']; ?></td>
                                                        </tr>
                                                <?php }} ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
    </div></body>
</html>


    <!-- Jquery JS-->
    <script src="../vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
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

    <!-- Main JS-->
    <script src="../js/main.js"></script>

    <!-- Script untuk fixed header -->
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
    <!-- Tambahkan jQuery (wajib) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tambahkan DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="../vendor/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatable/js/dataTables.bootstrap5.min.js"></script>

    <!-- Agar Teks tidak berubah jadi link -->
    <style>
        a {
            text-decoration: none;
        }
    </style>

<script>
    $(document).ready(function() {
        $('#kegiatanTable').DataTable({
            "scrollX": false,          // Aktifkan pengguliran horizontal
            "paging": false,           // Aktifkan pagination
            "searching": false,       // Aktifkan pencarian
            "ordering": true,         // Aktifkan pengurutan
            "info": false,             // Tampilkan info jumlah data
            "lengthChange": false,     // Pilihan jumlah data per halaman
            "pageLength": 10,         // Banyaknya data per halaman
            "fixedColumns": {
                leftColumns: 0,       // Buat kolom pertama tetap statis
                rightColumns: 0       // Buat kolom terakhir tetap statis
            }
        });
    });
</script>


</body>
</html>
