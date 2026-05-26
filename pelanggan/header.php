<!DOCTYPE html>
<html lang="id">
<head>
    <title>Toko Kue Fanda —Pelanggan</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="stylesheet" href="style.css">

</head>

<body>

<?php

session_name('PELANGGAN_SESSION');
session_start();

if (!isset($_SESSION['role'])) {
    header("location:../index.php?pesan=belum_login");
    exit;
}

if ($_SESSION['role'] != "pelanggan") {
    header("location:../index.php?pesan=bukan_pelanggan");
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
        <span class="role-badge">pelanggan</span>
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
<div class="layout-wrapper no-sidebar">

<!-- MAIN CONTENT -->
<main class="main-content centered-content">
