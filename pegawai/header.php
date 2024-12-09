<?php
include "../koneksi.php"; // Koneksi ke database

// Ambil id_user dari session
$id_user = $_SESSION['id_user'];

// Query untuk mendapatkan nama user dari tabel user
$query = "SELECT nm_user FROM user WHERE id_user = '$id_user'";
$result = mysqli_query($conn, $query);

// Ambil data nama pengguna
$user = mysqli_fetch_assoc($result);
$nm_user = $user['nm_user'] ?? 'Guest'; // Jika nama tidak ditemukan, tampilkan "Guest"
?>

<div class="page-container">
    <!-- HEADER DESKTOP-->
    <header class="header-desktop">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="header-wrap">
                    <form class="form-header" action="" method="POST">
                        <button class="au-btn--submit" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
                    <div class="header-button">
                        <div class="noti-wrap">
                        <div class="account-wrap">
                            <div class="account-item clearfix js-item-menu">
                                <div class="image">
                                    <img src="../images/icon/profil.jpg" alt="<?= htmlspecialchars($nm_user) ?>" />
                                </div>
                                <div class="content">
                                    <a class="js-acc-btn" href="#"><?= htmlspecialchars($nm_user) ?></a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="info clearfix">
                                        <div class="image">
                                            <a href="#">
                                                <img src="../images/icon/profil.jpg" alt="<?= htmlspecialchars($nm_user) ?>" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="name">
                                                <a href="#"><?= htmlspecialchars($nm_user) ?></a>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__body">
                                    <div class="account-dropdown__footer">
                                        <a href="logout.php">
                                            <i class="zmdi zmdi-power"></i>Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>