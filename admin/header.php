<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Kue Fanda — Admin</title>

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

session_name('ADMIN_SESSION');
session_start();

if (!isset($_SESSION['role'])) {
    header("location:../index.php?pesan=belum_login");
    exit;
}

if ($_SESSION['role'] != "admin") {
    header("location:../index.php?pesan=bukan_admin");
    exit;
}

session_write_close();

$current = basename($_SERVER['PHP_SELF']);
?>

<!-- TOP BAR -->
<nav class="navbar">
    <div class="d-flex align-items-center">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-cake-candles"></i>
            Toko Kue <span style="color:var(--accent-gold);">Fanda</span>
        </a>
        <span class="role-badge">Admin</span>
    </div>
    <div class="nav-user">
        <div class="nav-username">
            <i class="fas fa-user"></i>
            <?php echo htmlspecialchars($_SESSION['username']); ?>
        </div>
        <a href="logout.php" class="btn-logout">
            <i class="fas fa-right-from-bracket me-1"></i>Keluar
        </a>
    </div>
</nav>

<!-- LAYOUT WRAPPER -->
<div class="layout-wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <p class="sidebar-section-label">Menu Utama</p>
        <ul class="sidebar-nav">
            <li>
                <a href="index.php" class="<?= ($current=='index.php')?'active':'' ?>">
                    <i class="fas fa-house"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="produk.php" class="<?= (strpos($current,'produk')!==false)?'active':'' ?>">
                    <i class="fas fa-box-open"></i> Kelola Produk
                </a>
            </li>
            <li>
                <a href="kategori.php" class="<?= (strpos($current,'kategori')!==false)?'active':'' ?>">
                    <i class="fas fa-tags"></i> Kategori
                </a>
            </li>
            <li>
                <a href="order.php" class="<?= (strpos($current,'order')!==false)?'active':'' ?>">
                    <i class="fas fa-cart-shopping"></i> Manajemen Order
                </a>
            </li>
            <li>
                <a href="user.php" class="<?= (strpos($current,'user')!==false && strpos($current,'password')===false)?'active':'' ?>">
                    <i class="fas fa-users"></i> Data User
                </a>
            </li>
            <li>
                <a href="laporan.php" class="<?= (strpos($current,'laporan')!==false)?'active':'' ?>">
                    <i class="fas fa-chart-bar"></i> Laporan
                </a>
            </li>
            <li style="margin-top:20px;border-top:1px solid var(--cream-border);padding-top:16px;">
                <a href="password.php" class="<?= (strpos($current,'password')!==false)?'active':'' ?>">
                    <i class="fas fa-lock"></i> Ganti Password
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
