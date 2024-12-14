<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
        }

        .header-mobile {
            display: block;
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
        }

        .header-mobile__bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .header-mobile-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .logo img.logo-mobile {
            width: 100%;
            max-width: 50px;
            height: auto;
            object-fit: contain;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            transform: translateX(-100%);
            transition: none; /* Hapus transisi */
            z-index: 999;
        }

        .hamburger {
            background: none;
            border: none;
            cursor: pointer;
            transition: none !important;
        }

        .hamburger-box {
            width: 30px;
            height: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Garis sejajar */
            position: relative;
        }

        .hamburger-inner {
            width: 100%;
            height: 4px;
            background-color: #000;
            transition: none !important; /* Hapus animasi */
        }

        .hamburger-inner::before, 
        .hamburger-inner::after {
            content: '';
            width: 100%;
            height: 4px;
            background-color: #000;
            display: block;
            transition: none !important; /* Hapus animasi */
        }

        .hamburger, 
        .hamburger-box, 
        .hamburger-inner, 
        .hamburger-inner::before, 
        .hamburger-inner::after {
            animation: none !important;
            transition: none !important;
            transform: none !important;
        }



        .mobile-menu.open {
            transform: translateX(0);
        }

        .mobile-menu ul {
            list-style: none;
            padding: 20px;
        }

        .mobile-menu ul li {
            margin-bottom: 10px;
        }

        .mobile-menu ul li a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 15px;
        }

        .mobile-menu ul li a i {
            margin-right: 10px;
        }

        .mobile-menu ul .has-sub > a {
            display: flex;
            justify-content: space-between;
        }

        .mobile-menu ul .navbar__sub-list {
            display: none;
            padding-left: 20px;
        }

        .mobile-menu ul .has-sub.open .navbar__sub-list {
            display: block;
        }

        .mobile-menu ul .has-sub a.js-arrow:after {
            content: '\f105';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            margin-left: auto;
        }
    </style>


 <!-- HEADER MOBILE-->
    <!-- Header Mobile -->
    <header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="header-mobile-inner">
            <a class="logo" href="index.html">
                <img src="../images/icon/Kayuh_Baimbai.png" alt="LOGBOOK" class="logo-mobile" />
            </a>

            <!-- Tombol Hamburger -->
            <button class="hamburger" id="hamburger-button" type="button">
                <div class="hamburger-box">
                    <div class="hamburger-inner"></div>
                    <div class="hamburger-inner"></div>
                    <div class="hamburger-inner"></div>
                </div>
            </button>
        </div>
    </div>
</header>


    <!-- Mobile Menu -->
    <aside class="mobile-menu" id="mobile-menu">
        <ul class="list-unstyled navbar__list">
            <!-- Dashboard Menu -->
            <li>
                <a href="index.php">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
            </li>

            <!-- Menu Utama -->
            <li class="has-sub">
                <a class="js-arrow" href="#">
                    <i class="fas fa-book"></i>Menu Utama
                </a>
                <ul class="list-unstyled navbar__sub-list">
                    <li><a href="kegiatan.php">Logbook</a></li>
                </ul>
            </li>

            <!-- Kelola Data -->
            <li class="has-sub">
                <a class="js-arrow" href="#">
                    <i class="fas fa-gear"></i>Kelola Data
                </a>
                <ul class="list-unstyled navbar__sub-list">
                    <li><a href="user.php">Pegawai
                    <li><a href="divisi.php">Divisi</a></li>
                    <li><a href="jenis.php">Jenis Kegiatan</a></li>
                </ul>
            </li>
        </ul>
    </aside>
        <!-- END HEADER MOBILE-->

<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <div class="d-flex align-items-center">
            <img src="../images/icon/Kayuh_Baimbai.png" alt="LOGBOOK" style="width: 80px; height: auto;" />
            <span class="ml-3 text-black">LOGBOOK</span>
        </div>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <!-- Dashboard Menu -->
                <li class="<?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>">
                    <a href="index.php">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </li>

                <!-- Menu Utama -->
                <li class="has-sub <?= (basename($_SERVER['PHP_SELF']) == 'kegiatan.php') ? 'active show' : '' ?>">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-book"></i>Menu Utama
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list" <?= (basename($_SERVER['PHP_SELF']) == 'kegiatan.php') ? 'style="display:block;"' : '' ?>>
                        <li class="<?= (basename($_SERVER['PHP_SELF']) == 'kegiatan.php') ? 'active' : '' ?>">
                            <a href="kegiatan.php">Kegiatan</a>
                        </li>
                    </ul>
                </li>

                <!-- Kelola Data -->
                <li class="has-sub <?= (in_array(basename($_SERVER['PHP_SELF']), ['user.php', 'divisi.php'])) ? 'active show' : '' ?>">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-gear"></i>Kelola Data
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list" <?= (in_array(basename($_SERVER['PHP_SELF']), ['user.php', 'divisi.php'])) ? 'style="display:block;"' : '' ?>>
                        <li class="<?= (basename($_SERVER['PHP_SELF']) == 'user.php') ? 'active' : '' ?>">
                            <a href="user.php">Pegawai</a>
                        </li>
                        <li class="<?= (basename($_SERVER['PHP_SELF']) == 'divisi.php') ? 'active' : '' ?>">
                            <a href="divisi.php">Divisi</a>
                        </li>
                        <li class="<?= (basename($_SERVER['PHP_SELF']) == 'jenis_kegiatan.php') ? 'active' : '' ?>">
                            <a href="jenis.php">Jenis Kegiatan</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>


<script>
        const hamburgerButton = document.getElementById('hamburger-button');
        const mobileMenu = document.getElementById('mobile-menu');

        // Toggle Menu saat hamburger ditekan
        hamburgerButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
        });

        // Dropdown Submenu
        const subMenus = document.querySelectorAll('.has-sub > a.js-arrow');
        subMenus.forEach(menu => {
            menu.addEventListener('click', (e) => {
                e.preventDefault();
                const parent = menu.parentElement;
                parent.classList.toggle('open');
            });
        });
</script>