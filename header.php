<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Kue Fanda</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="pelanggan/style.css">
</head>

<body>

<?php
session_start();
$current = basename($_SERVER['PHP_SELF']);
?>

    <!-- TOP BAR -->
    <nav class="navbar">
        <div class="d-flex align-items-center">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-cake-candles"></i>
                Toko Kue <span style="color:var(--accent-gold);">Fanda</span>
            </a>
            <span class="role-badge">Pengguna</span>
        </div>
        <div class="nav-user">
            <div class="nav-username">
                <i class="fas fa-user"></i>
            </div>
            <a href="index.php" class="btn-logout">
                <i class="fas fa-right-from-bracket me-1"></i>Keluar
            </a>
        </div>
    </nav>

    <!-- LAYOUT WRAPPER -->
    <div class="layout-wrapper no-sidebar">

        <!-- MAIN CONTENT -->
        <main class="main-content centered-content">