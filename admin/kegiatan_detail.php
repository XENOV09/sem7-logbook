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

// Ambil ID kegiatan dari URL
$id_kegiatan = isset($_GET['id_kegiatan']) ? $_GET['id_kegiatan'] : 0;

// Query untuk mengambil data kegiatan berdasarkan id_kegiatan
// Query dasar
$sql = "
    SELECT 
        k.id_kegiatan, 
        k.tanggal, 
        d.nm_divisi, 
        u.nm_user, 
        j.jenis, 
        k.kegiatan, 
        k.lokasi, 
        k.waktu_mulai, 
        k.waktu_selesai, 
        k.budget, 
        k.pengeluaran, 
        k.sisa, 
        k.lampiran, 
        k.catatan 
    FROM kegiatan k 
    LEFT JOIN user u ON k.id_user = u.id_user 
    LEFT JOIN jenis j ON k.id_jenis = j.id_jenis 
    LEFT JOIN divisi d ON k.id_divisi = d.id_divisi 
    WHERE k.id_kegiatan = '$id_kegiatan'
";

$result = mysqli_query($conn, $sql);
$kegiatan = mysqli_fetch_assoc($result);

if (!$kegiatan) {
    echo "<p>Data tidak ditemukan</p>";
    exit;
}
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
    <title>Detail Kegiatan</title>

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

    <!-- Main CSS-->
    <link href="../css/theme.css" rel="stylesheet" media="all">

    <!-- Pack Icon-->
    <link href="../css/boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" media="all">
    <!-- Link ke CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Untuk fixed header -->

</head>
<body>
    
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Detail Kegiatan</h3>
            </div>
            <div class="card-body">
            <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Tanggal Kegiatan</strong></h5>
                        <p><?php echo date('d-m-Y', strtotime($kegiatan['tanggal'])); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Divisi</strong></h5>
                        <p><?php echo $kegiatan['nm_divisi']; ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Oleh</strong></h5>
                        <p><?php echo $kegiatan['nm_user']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Jenis Kegiatan</strong></h5>
                        <p><?php echo $kegiatan['jenis']; ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Nama Kegiatan</strong></h5>
                        <p><?php echo $kegiatan['kegiatan']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Lokasi</strong></h5>
                        <p><?php echo $kegiatan['lokasi']; ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Waktu Mulai</strong></h5>
                        <p><?php echo date('d-m-Y H:i', strtotime($kegiatan['waktu_mulai'])); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Waktu Selesai</strong></h5>
                        <p><?php echo date('d-m-Y H:i', strtotime($kegiatan['waktu_selesai'])); ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Budget</strong></h5>
                        <p>Rp <?php echo number_format($kegiatan['budget'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Pengeluaran</strong></h5>
                        <p>Rp <?php echo number_format($kegiatan['pengeluaran'], 0, ',', '.'); ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5><strong>Sisa</strong></h5>
                        <p style="color: <?php echo $kegiatan['sisa'] < 0 ? 'red' : 'green'; ?>;">
                            Rp <?php echo number_format($kegiatan['sisa'], 0, ',', '.'); ?>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5><strong>Catatan</strong></h5>
                        <p><?php echo $kegiatan['catatan']; ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5><strong>Lampiran</strong></h5>
                        <?php if ($kegiatan['lampiran']) : ?>
                            <a href="../images/lampiran/<?php echo $kegiatan['lampiran']; ?>" class="btn btn-success" target="_blank">Lihat Lampiran</a>
                        <?php else : ?>
                            <p>Tidak Ada Lampiran</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="kegiatan.php" class="btn btn-danger">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
