<?php
session_start();
include "../koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil id_user dari user yang login
$id_user = $_SESSION['id_user'];

// Proses simpan data kegiatan jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $id_divisi = $_POST['id_divisi']; // Ambil id_divisi dari form, bukan dari session
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $id_jenis = $_POST['id_jenis'];
    $kegiatan = $_POST['kegiatan'];
    $lokasi = $_POST['lokasi'];
    $budget = !empty($_POST['budget']) ? $_POST['budget'] : 0;
    $pengeluaran = !empty($_POST['pengeluaran']) ? $_POST['pengeluaran'] : 0;
    $sisa = $budget - $pengeluaran; // Hitung sisa dari pengeluaran
    $catatan = $_POST['catatan'];
    $lampiran = $_FILES['lampiran']['name'];


    // Proses upload file lampiran
    $lampiran = null; // Default null jika tidak ada file yang diupload
    $error_message = ""; // Variabel untuk pesan error ukuran file  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validasi ukuran file (maksimum 2MB)
        if (isset($_FILES['lampiran']) && $_FILES['lampiran']['error'] === UPLOAD_ERR_OK) {
            $file_size = $_FILES['lampiran']['size']; // Ukuran file dalam byte
            $max_size = 2 * 1024 * 1024; // Maksimum ukuran file 2MB dalam byte
    
            if ($file_size > $max_size) {
                $error_message = "Ukuran file melebihi 2MB!";
            } else {
                $target_dir = "../images/lampiran/";
                $file_name = basename($_FILES['lampiran']['name']);
                $target_file = $target_dir . $file_name;
                $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
                // Validasi tipe file (hanya izinkan file tertentu)
                $allowed_types = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
                if (in_array($file_type, $allowed_types)) {
                    // Pindahkan file ke folder tujuan
                    if (move_uploaded_file($_FILES['lampiran']['tmp_name'], $target_file)) {
                        $lampiran = $file_name; // Simpan nama file ke database
                    } else {
                        echo "Error: Gagal mengupload file.";
                        exit();
                    }
                } else {
                    echo "Error: Tipe file tidak diizinkan.";
                    exit();
                }
            }
        }
    }

    // Query untuk menyimpan data kegiatan
    if (empty($error_message)) {
    $sql = "INSERT INTO kegiatan (tanggal, id_jenis, id_user, id_divisi, kegiatan, lokasi, waktu_mulai, waktu_selesai, budget, pengeluaran, sisa, lampiran, catatan) 
            VALUES ('$tanggal', '$id_jenis', '$id_user', '$id_divisi', '$kegiatan', '$lokasi', '$waktu_mulai', '$waktu_selesai', '$budget', '$pengeluaran', '$sisa', '$lampiran', '$catatan')";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, redirect ke halaman kegiatan.php
        header("Location: kegiatan.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }
    }
}

// Query untuk mendapatkan data jenis kegiatan
$jenis_query = "SELECT * FROM jenis";
$jenis_result = mysqli_query($conn, $jenis_query);

// Query untuk mendapatkan daftar divisi
$divisi_query = "SELECT * FROM divisi";
$divisi_result = mysqli_query($conn, $divisi_query);
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

    <!-- Link Pack Icon-->
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <!-- Tambahkan DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <?php include 'header.php'; ?>

    <div class="main-content">
        <div class="section__content section__content--p30">
            <h2 class="title-1">Tambah Kegiatan</h2>
            <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group mb-4">
                    <label for="tanggal">Tanggal Kegiatan</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control shadow-sm" required>
                </div>

                <div class="form-group mb-4">
                    <label for="id_divisi">Divisi</label>
                    <select id="id_divisi" name="id_divisi" class="form-control shadow-sm" required>
                        <option value="">Pilih Divisi</option>
                        <?php while ($row_divisi = mysqli_fetch_assoc($divisi_result)) { ?>
                            <option value="<?php echo $row_divisi['id_divisi']; ?>">
                                <?php echo $row_divisi['nm_divisi']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="id_jenis">Jenis Kegiatan</label>
                    <select id="id_jenis" name="id_jenis" class="form-control shadow-sm" required>
                        <option value="">Pilih Jenis Kegiatan</option>
                        <?php while ($row_jenis = mysqli_fetch_assoc($jenis_result)) { ?>
                            <option value="<?php echo $row_jenis['id_jenis']; ?>">
                                <?php echo $row_jenis['jenis']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="kegiatan">Kegiatan</label>
                    <textarea id="kegiatan" name="kegiatan" class="form-control shadow-sm" rows="4" required></textarea>
                </div>

                <div class="form-group mb-4">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi" class="form-control shadow-sm" required>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <label for="waktu_mulai">Waktu Mulai</label>
                        <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" class="form-control shadow-sm" required>
                    </div>
                    <div class="col">
                        <label for="waktu_selesai">Waktu Selesai</label>
                        <input type="datetime-local" id="waktu_selesai" name="waktu_selesai" class="form-control shadow-sm" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <label for="budget">Budget</label>
                        <input type="number" id="budget" name="budget" class="form-control shadow-sm" placeholder="Opsional">
                    </div>
                    <div class="col">
                        <label for="pengeluaran">Pengeluaran</label>
                        <input type="number" id="pengeluaran" name="pengeluaran" class="form-control shadow-sm" placeholder="Opsional">
                    </div>

                <div class="form-group mb-4">
                    <label for="lampiran">Lampiran</label>
                    <input type="file" id="lampiran" name="lampiran" accept=".pdf,.png,.jpg,.jpeg" class="form-control shadow-sm">
                    <small class="form-text text-muted">File yang diizinkan: JPG, JPEG, PNG, PDF. Maksimal 2MB</small>
                    <?php if (!empty($error_message)) { ?>
                        <div class="text-danger mt-2"> <?php echo $error_message; ?> </div>
                    <?php } ?>
                </div>  

                <div class="form-group mb-4">
                    <label for="catatan">Catatan</label>
                    <textarea id="catatan" name="catatan" class="form-control shadow-sm" rows="4"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm px-4">Simpan</button>
                    <a href="kegiatan.php" class="btn btn-secondary btn-lg shadow-sm px-4">Kembali</a>
                </div>
            </form>
        </div>
    </div>


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
    <!-- Tambahkan jQuery (wajib) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Agar Teks tidak berubah jadi link -->
    <style>
        a {
            text-decoration: none;
        }
    </style>
</body>
</html>
