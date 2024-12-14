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

// Ambil data pengguna dari tabel user
$sql_user = "SELECT user.*, divisi.nm_divisi FROM user LEFT JOIN divisi ON user.id_divisi = divisi.id_divisi";
$result_user = mysqli_query($conn, $sql_user);
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
                                <h2 class="title-1">Manajemen - Pengguna</h2>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel untuk menampilkan data kegiatan -->
                        <div class="card">
                            <div class="card-body">
                                <!-- Menambahkan tombol "Tambah Kegiatan" di atas kanan tabel -->
                                <div class="row mb-3">
                                    <div class="col-lg-12 text-end">
                                        <a href="user_tambah.php" class="btn btn-primary"><i class="bx bx-plus"></i> Tambah User</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive table--no-card m-b-30">
                                            <!-- Ganti ID tabel agar sesuai dengan DataTables -->
                                            <table id="kegiatanTable" class="table table-borderless table-earning">
                                                <thead>
                                                <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Divisi</th>
                                                        <th>Username</th>
                                                        <th>Password</th>
                                                        <th>Role</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    while ($row_user = mysqli_fetch_assoc($result_user)) { 
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row_user['nm_user']; ?></td>
                                                            <td><?php echo $row_user['nm_divisi']; ?></td>
                                                            <td><?php echo $row_user['username']; ?></td>
                                                            <td><?php echo $row_user['password']; ?></td>
                                                            <td><?php echo $row_user['role']; ?></td>
                                                            <td>
                                                                <a href="user_edit.php?id_user=<?php echo $row_user['id_user']; ?>" class="btn btn-sm btn-success">Edit</a>
                                                                <a href="user_hapus.php?id_user=<?php echo $row_user['id_user']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">Hapus</a>
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
            dom: 'Bfrtip',  // Menambahkan area untuk tombol
            buttons: [
                
                //'copy',  // Menyalin data tabel
                //'csv',   // Mengekspor ke CSV
                //'excel', // Mengekspor ke Excel
                {
                    extend: 'pdf',  // Tombol untuk mengekspor ke PDF
                    text: 'PDF',
                    orientation: 'landscape',  // Orientasi halaman, bisa 'portrait' atau 'landscape'
                    pageSize: 'A4',            // Ukuran halaman, bisa 'A4', 'letter', dll.
                    customize: function(doc) {
                        // Menyesuaikan tampilan PDF
                        doc.styles = {
                            // Menyesuaikan font pada seluruh dokumen
                            body: {
                                fontSize: 10,    // Ukuran font untuk isi dokumen
                                font: 'TimesNewRoman',    // Jenis font
                                color: 'black'    // Warna teks
                            },
                            // Menyesuaikan font untuk header tabel
                            tableHeader: {
                                bold: true,      // Menebalkan font header
                                fontSize: 12,    // Ukuran font header
                                color: 'white',   // Warna teks header
                                fillColor: '#4CAF50' // Warna latar belakang header
                            },
                            // Menyesuaikan font untuk data tabel
                            tableCell: {
                                fontSize: 10,    // Ukuran font sel tabel
                                color: 'black'   // Warna teks dalam tabel
                            }
                        };

                        // Menghapus kolom Action pada PDF
                        var rowCount = doc.content[1].table.body.length;
                        for (var i = 0; i < rowCount; i++) {
                            // Hapus kolom terakhir (kolom Action)
                            doc.content[1].table.body[i].splice(6, 1); // Indeks kolom Action dimulai dari 0
                        }

                        // Menambahkan header khusus ke dalam PDF
                        doc['header'] = function() {
                            return {
                                text: 'Laporan Kegiatan',
                                alignment: 'center',
                                fontSize: 14,
                                bold: true,
                                margin: [0, 10]
                            };
                        };

                        // Menambahkan footer ke dalam PDF
                        doc['footer'] = function(currentPage, pageCount) {
                            return {
                                text: currentPage + ' of ' + pageCount,
                                alignment: 'center',
                                fontSize: 8,
                                margin: [0, 0, 0, 10]
                            };
                        };
                    }
                },
                {
                    extend: 'print',  // Tombol untuk mencetak tabel
                    text: 'Print',
                    customize: function(win) {
                        // Menyembunyikan kolom Action di Print
                        $(win.document.body).find('th:nth-child(7), td:nth-child(7)').css('display', 'none');
                    }
                }
            ],
            "scrollX": false,          // Aktifkan pengguliran horizontal
            "paging": false,           // Aktifkan pagination
            "searching": true,       // Aktifkan pencarian
            "ordering": true,         // Aktifkan pengurutan
            "info": true,             // Tampilkan info jumlah data
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
