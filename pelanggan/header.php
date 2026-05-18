<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Kue Fanda — Pelanggan</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("location:../index.php?pesan=belum_login");
    exit;
}

if ($_SESSION['role'] != "pelanggan") {
    header("location:../index.php?pesan=bukan_pelanggan");
    exit;
}

$current = basename($_SERVER['PHP_SELF']);
?>

<!-- TOP NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm py-3"
     style="background:#1f1f1f;">

    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
           href="index.php"
           style="font-size:1.3rem;">

            <i class="fas fa-cake-candles"
               style="color:#d4a25a;"></i>

            Toko Kue
            <span style="color:#d4a25a;">
                Fanda
            </span>

        </a>

        <!-- TOGGLE MOBILE -->
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarPelanggan">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse"
             id="navbarPelanggan">

            <!-- MENU KIRI -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-4">

                <li class="nav-item">

                    <a class="nav-link <?= ($current == 'index.php') ? 'active' : ''; ?>"
                       href="index.php">

                        <i class="fas fa-store me-1"></i>
                        Menu

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link <?= ($current == 'order_tambah.php') ? 'active' : ''; ?>"
                       href="order_tambah.php">

                        <i class="fas fa-cart-shopping me-1"></i>
                        Keranjang

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link <?= ($current == 'akun.php') ? 'active' : ''; ?>"
                       href="akun.php">

                        <i class="fas fa-user me-1"></i>
                        Akun

                    </a>

                </li>

            </ul>

            <!-- USER -->
            <div class="d-flex align-items-center gap-3">

                <span class="text-light small">

                    <i class="fas fa-user-circle me-1"></i>

                    <?= htmlspecialchars($_SESSION['username']); ?>

                </span>

                <a href="../logout.php"
                   class="btn btn-warning btn-sm px-3">

                    <i class="fas fa-right-from-bracket me-1"></i>
                    Keluar

                </a>

            </div>

        </div>

    </div>

</nav>


    <!-- MAIN CONTENT -->
    <main class="main-content">
