<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link href="../assets/admin/css/style.min.css" rel="stylesheet">
    <script src="../assets/admin/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="layer"></div>

    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">

        <aside class="sidebar">
            <div class="sidebar-start">
                <div class="sidebar-head">
                    <a href="dashboard.php" class="logo-wrapper" title="Home">
                        <span class="sr-only">Home</span>
                        <span class="icon logo" aria-hidden="true"></span>
                        <div class="logo-text">
                            <span class="logo-title">Puput</span>
                            <span class="logo-subtitle">Electronic</span>
                        </div>
                    </a>
                    <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                        <span class="sr-only">Toggle menu</span>
                        <span class="icon menu-toggle" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="sidebar-body">
                    <ul class="sidebar-body-menu">
                        <?php
                        $current_page = basename($_SERVER['REQUEST_URI']);
                        ?>
                        <li>
                            <a class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>"
                                href="dashboard.php"><span class="icon home" aria-hidden="true"></span>Dashboard</a>
                        </li>
                        <li>
                            <a class="<?php echo ($current_page == 'products.php') ? 'active' : ''; ?>"
                                href="products.php">
                                <span class="icon document" aria-hidden="true"></span>Products
                            </a>
                            <ul class="cat-sub-menu">
                            </ul>
                        </li>
                        <li>
                            <a class="<?php echo ($current_page == 'users.php') ? 'active' : ''; ?>"
                                href="users.php"><span class="icon folder" aria-hidden="true"></span>User</a>
                        </li>
                        <li>
                            <a class="<?php echo ($current_page == 'pesanan.php') ? 'active' : ''; ?>"
                                href="pesanan.php">
                                <span class="icon image" aria-hidden="true"></span>Pesanan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sidebar-footer">
                <a href="##" class="sidebar-user">
                    <span class="sidebar-user-img">
                        <picture>
                            <source srcset="../assets/admin/img/avatar/avatar-illustrated-01.webp" type="image/webp">
                            <img src="../assets/admin/img/avatar/avatar-illustrated-01.png" alt="User name">
                        </picture>
                    </span>
                    <div class="sidebar-user-info">
                        <span
                            class="sidebar-user__title"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User'; ?></span>
                        <span class="sidebar-user__subtitle">Admin Manager</span>
                    </div>
                </a>
            </div>
        </aside>

        <div class="main-wrapper">
            <!-- ! Main nav -->
            <nav class="main-nav--bg">
                <div class="container main-nav">
                    <div class="main-nav-start">
                        <div class="search-wrapper">
                            <i data-feather="search" aria-hidden="true"></i>
                            <input type="text" placeholder="Enter keywords ..." required>
                        </div>
                    </div>
                    <div class="main-nav-end">
                        <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                            <span class="sr-only">Toggle menu</span>
                            <span class="icon menu-toggle--gray" aria-hidden="true"></span>
                        </button>
                        <button class="theme-switcher gray-circle-btn" type="button" title="Switch theme">
                            <span class="sr-only">Switch theme</span>
                            <i class="sun-icon" data-feather="sun" aria-hidden="true"></i>
                            <i class="moon-icon" data-feather="moon" aria-hidden="true"></i>
                        </button>
                        <div class="nav-user-wrapper">
                            <button href="##" class="nav-user-btn dropdown-btn" title="My profile" type="button">
                                <span class="sr-only">My profile</span>
                                <span class="nav-user-img">
                                    <picture>
                                        <source srcset="../assets/admin/img/avatar/avatar-illustrated-01.webp"
                                            type="image/webp">
                                        <img src="../assets/admin/img/avatar/avatar-illustrated-01.png" alt="User name">
                                    </picture>
                                </span>
                            </button>
                            <ul class="users-item-dropdown nav-user-dropdown dropdown">
                                <li><a href="##">
                                        <i data-feather="user" aria-hidden="true"></i>
                                        <span>Profile</span>
                                    </a></li>
                                <li><a href="##">
                                        <i data-feather="settings" aria-hidden="true"></i>
                                        <span>Account settings</span>
                                    </a></li>
                                <li><a class="danger" href="../logout.php">
                                        <i data-feather="log-out" aria-hidden="true"></i>
                                        <span>Log out</span>
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- ! Main -->
            <main class="main users chart-page" id="skip-target">
                <?php
                if (isset($content)) {
                    echo $content;
                }
                ?>
            </main>
            <!-- ! Footer -->
            <footer class="footer">
                <div class="container footer--flex">
                    <div class="footer-start">
                        <p>2024 © Puput Electronic - <a href="elegant-dashboard.com" target="_blank"
                                rel="noopener noreferrer">izzy.com</a></p>
                    </div>
                    <ul class="footer-end">
                        <li><a href="##">About</a></li>
                        <li><a href="##">Support</a></li>
                        <li><a href="##">Puchase</a></li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    <!-- Chart library -->
    <script src="../assets/admin/plugins/chart.min.js"></script>
    <!-- Icons library -->
    <script src="../assets/admin/plugins/feather.min.js"></script>
    <!-- Custom scripts -->
    <script src="../assets/admin/js/script.js"></script>
</body>

</html>