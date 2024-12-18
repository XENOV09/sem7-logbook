<?php
session_start();
include "../koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit();
}

// Proses simpan data user jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nm_user = $_POST['nm_user'];
    $id_divisi = $_POST['id_divisi'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Query untuk menyimpan data user
    $sql = "INSERT INTO user (nm_user, id_divisi, username, password, role) 
            VALUES ('$nm_user', '$id_divisi', '$username', '$password', '$role')";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, redirect ke halaman user.php
        header("Location: user.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }
}

// Query untuk mendapatkan daftar divisi
$divisi_query = "SELECT * FROM divisi";
$divisi_result = mysqli_query($conn, $divisi_query);

// Query untuk mendapatkan daftar role unik dari kolom 'role' di tabel 'user'
$role_query = "SELECT DISTINCT role FROM user";
$role_result = mysqli_query($conn, $role_query);
?>

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah User</title>

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
            <h2 class="title-1">Tambah User</h2>
            <form method="POST" action="">
                <div class="form-group mb-4">
                    <label for="nm_user">Nama User</label>
                    <input type="text" id="nm_user" name="nm_user" class="form-control shadow-sm" required>
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
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control shadow-sm" required>
                </div>

                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control shadow-sm" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="form-control shadow-sm" required>
                        <option value="">Pilih Role</option>
                        <?php while ($row_role = mysqli_fetch_assoc($role_result)) { ?>
                            <option value="<?php echo $row_role['role']; ?>">
                                <?php echo ucfirst($row_role['role']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm px-4">Simpan</button>
                    <a href="user.php" class="btn btn-secondary btn-lg shadow-sm px-4">Kembali</a>
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
    <style>
    .input-group .btn {
        height: 100%;  /* Memastikan tombol mengisi tinggi input */
        display: flex; /* Membuat tombol fleksibel */
        align-items: center; /* Menjaga ikon berada di tengah */
        padding: 0 10px; /* Menambahkan padding untuk tombol */
    }
</style>

    <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        // Toggle password visibility
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;

        // Change the eye icon based on the password visibility
        const icon = this.querySelector('i');
        if (type === 'password') {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });
</script>

</body>

</html>