<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Kue Fanda — Masuk</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --brown-dark:  #3B2314;
            --brown-mid:   #5C3D2E;
            --brown-bg:    #4A2C1A;
            --accent-gold: #C9883C;
            --accent-rose: #C97B8C;
            --cream-bg:    #F5EFE6;
            --cream-card:  #F0E8DD;
            --cream-border:#E0D5C8;
            --text-dark:   #1A1008;
            --text-mid:    #4A3728;
            --text-muted:  #9A7B6A;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background: var(--cream-bg);
            overflow: hidden;
        }

        /* NAVBAR */
        .top-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 68px;
            background: rgba(255,255,255,.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--cream-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            z-index: 100;
            animation: slideDown .5s ease both;
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to   { transform: translateY(0); opacity: 1; }
        }

        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            text-decoration: none;
        }

        .nav-logo span { color: var(--accent-gold); }

        .nav-links {
            display: flex;
            gap: 36px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-mid);
            font-size: .9rem;
            font-weight: 500;
            transition: color .2s;
        }

        .nav-links a:hover { color: var(--brown-dark); }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .nav-right a {
            color: var(--text-mid);
            font-size: 1.1rem;
            text-decoration: none;
            transition: color .2s;
        }

        .nav-right a:hover { color: var(--brown-dark); }

        .btn-masuk {
            background: var(--brown-dark);
            color: #fff !important;
            padding: 9px 22px;
            border-radius: 9px;
            font-size: .88rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .25s;
        }

        .btn-masuk:hover {
            background: var(--brown-mid);
            transform: translateY(-1px);
        }

        /* MAIN LAYOUT */
        .login-page {
            min-height: 100vh;
            padding-top: 68px;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* LEFT: brown hero */
        .login-hero {
            background: var(--brown-dark);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 56px;
            position: relative;
            overflow: hidden;
            animation: fadeSlideLeft .6s .2s ease both;
        }

        @keyframes fadeSlideLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* Decorative circle */
        .login-hero::before {
            content: '';
            position: absolute;
            top: -120px; right: -120px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }

        .login-hero::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(201,136,60,.1);
        }

        .hero-img {
            width: 280px; height: 280px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid rgba(255,255,255,.15);
            margin-bottom: 36px;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
            animation: floatImg 4s ease-in-out infinite;
        }

        @keyframes floatImg {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
        }

        .hero-subtitle {
            font-size: .95rem;
            color: var(--accent-rose);
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem;
            font-weight: 900;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 8px;
        }

        .hero-italic {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 2.2rem;
            color: var(--accent-rose);
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-desc {
            color: rgba(255,255,255,.6);
            font-size: .88rem;
            line-height: 1.6;
            max-width: 340px;
            text-align: center;
        }

        /* RIGHT: login form */
        .login-form-side {
            background: var(--cream-bg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 80px;
            animation: fadeSlideRight .6s .3s ease both;
        }

        @keyframes fadeSlideRight {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .form-card {
            background: var(--cream-card);
            border-radius: 20px;
            padding: 44px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 40px rgba(59,35,20,.12);
        }

        .form-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .form-card-sub {
            color: var(--text-muted);
            font-size: .88rem;
            margin-bottom: 28px;
        }

        .form-label {
            font-size: .85rem;
            font-weight: 600;
            color: var(--text-mid);
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--cream-border);
            border-radius: 10px;
            font-size: .9rem;
            font-family: 'DM Sans', sans-serif;
            background: #fff;
            color: var(--text-dark);
            transition: border-color .2s, box-shadow .2s;
            margin-bottom: 20px;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--brown-mid);
            box-shadow: 0 0 0 3px rgba(92,61,46,.12);
        }

        .btn-submit {
            width: 100%;
            background: var(--brown-dark);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all .25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
        }

        .btn-submit:hover {
            background: var(--brown-mid);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59,35,20,.25);
        }

        .btn-submit:active { transform: translateY(0); }

        /* Alert messages */
        .alert-msg {
            background: rgba(192,57,43,.1);
            color: #c0392b;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .alert-msg.success {
            background: rgba(34,139,34,.1);
            color: #1a6b1a;
        }

        @media (max-width: 768px) {
            .login-page { grid-template-columns: 1fr; }
            .login-hero { display: none; }
            .top-nav .nav-links { display: none; }
            .top-nav { padding: 0 20px; }
            .login-form-side { padding: 40px 20px; }
            .form-card { padding: 32px 24px; }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="top-nav">
    <a href="#" class="nav-logo">Toko Kue <span>Fanda</span></a>

    <ul class="nav-links">
        <li><a href="#">Beranda</a></li>
        <li><a href="#">Menu</a></li>
        <li><a href="#">Kontak</a></li>
        <li><a href="#">Tentang Kami</a></li>
    </ul>

    <div class="nav-right">
        <a href="#"><i class="fas fa-cart-shopping"></i></a>
        <a href="#"><i class="fas fa-user"></i></a>
        <a href="pelanggan/index.php" class="btn-masuk">Masuk</a>
    </div>
</nav>

<!-- LOGIN PAGE -->
<div class="login-page">

    <!-- LEFT: Hero -->
    <div class="login-hero">
        <img src="gambar/logo.jpeg" alt="Kue Fanda" class="hero-img">
        <p class="hero-subtitle">Toko Kue Fanda</p>
        <h1 class="hero-title">Sistem Informasi</h1>
        <p class="hero-italic">Toko kue Fanda</p>
        <p class="hero-desc">Platform terintegrasi untuk mengelola pesanan, produk, dan transaksi toko kue secara efisien.</p>
    </div>

    <!-- RIGHT: Form -->
    <div class="login-form-side">
        <?php
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan'] == 'gagal') {
                    echo "<div class='alert-msg'>Login gagal! Username atau password salah.</div>";
                } elseif ($_GET['pesan'] == 'logout') {
                    echo "<div class='alert-msg success'>Anda telah berhasil logout.</div>";
                } elseif ($_GET['pesan'] == 'belum_login') {
                    echo "<div class='alert-msg'>Anda harus login untuk mengakses halaman tersebut.</div>";
                } elseif ($_GET['pesan'] == 'bukan_admin') {
                    echo "<div class='alert-msg'>Akses ditolak. Halaman khusus admin.</div>";
                }
            }
            ?>
        <div class="form-card">

            <h2 class="form-card-title">Log In 🔑</h2>
            <form method="post" action="login.php">
            <button type="submit" class="btn-submit">Login<i class="fas fa"></i></button>
            </form>
            <br>
            <h2 class="form-card-title">📝 Sign Up</h2>
            <form method="post" action="signup.php">
            <button type="submit" class="btn-submit">Sign Up<i class="fas fa"></i></button>
            </form>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
