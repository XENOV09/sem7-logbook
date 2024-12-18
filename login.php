<?php
session_start();
include "koneksi.php";

if (isset($_POST["submit"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $login = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
    $jml_login = mysqli_num_rows($login);

    if ($jml_login == 1) {
        $row = mysqli_fetch_assoc($login);
        $_SESSION["id_user"] = $row["id_user"];
        $_SESSION["id_divisi"] = $row["id_divisi"];
        $_SESSION["nm_user"] = $row["nm_user"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["password"] = $row["password"];  
        $_SESSION["role"] = $row["role"];

        if ($row["role"] == 'pegawai') {
            header("Location: pegawai/index.php"); // Masuk ke direktori pegawai
        } else if ($row["role"] == 'admin') {
            header("Location: admin/index.php"); // Masuk ke direktori admin
        }
        exit;
    } else {
        $error = 'Username atau Password salah!';
    }
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
    <title>Selamat Datang!</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="images/icon/icon_mobile.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
    <form action="" method="post">
        <div class="form-group">
            <label>Username</label>
            <input class="au-input au-input--full" type="text" id="username" name="username" placeholder="Username" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <div class="password-wrapper" style="position: relative;">
                <input class="au-input au-input--full" type="password" id="password" name="password" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePassword()" 
                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                    <i class="fa fa-eye" id="toggle-icon"></i>
                </span>
            </div>
        </div>
        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="submit">Masuk</button>
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $error; ?>
            </div>
        <?php endif; ?>
    </form>
</div>
                    </div>
                </div>
            </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>
    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggle-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>

</body>

</html>
<!-- end document-->