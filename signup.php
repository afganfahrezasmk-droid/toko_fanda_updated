<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Kue Fanda — Sign Up</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

        :root {
            --brown-dark:  #3B2314;
            --brown-mid:   #5C3D2E;
            --accent-gold: #C9883C;
            --accent-rose: #C97B8C;
            --cream-bg:    #F5EFE6;
            --cream-card:  #F0E8DD;
            --cream-border:#E0D5C8;
            --text-dark:   #1A1008;
            --text-mid:    #4A3728;
            --text-muted:  #9A7B6A;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'DM Sans',sans-serif;
            background:var(--cream-bg);
            min-height:100vh;
            overflow-x:hidden;
        }

        /* NAVBAR */
        .top-nav{
            position:fixed;
            top:0;
            left:0;
            right:0;
            height:68px;
            background:rgba(255,255,255,.95);
            backdrop-filter:blur(10px);
            border-bottom:1px solid var(--cream-border);
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 48px;
            z-index:100;
        }

        .nav-logo{
            font-family:'Playfair Display',serif;
            font-size:1.4rem;
            font-weight:700;
            color:var(--text-dark);
            text-decoration:none;
        }

        .nav-logo span{
            color:var(--accent-gold);
        }

        .nav-links{
            display:flex;
            list-style:none;
            gap:36px;
        }

        .nav-links a{
            text-decoration:none;
            color:var(--text-mid);
            font-size:.9rem;
            font-weight:500;
        }

        .nav-right{
            display:flex;
            align-items:center;
            gap:16px;
        }

        .nav-right a{
            color:var(--text-mid);
            text-decoration:none;
            font-size:1.1rem;
        }

        .btn-masuk{
            background:var(--brown-dark);
            color:#fff !important;
            padding:9px 22px;
            border-radius:10px;
            text-decoration:none;
            font-weight:600;
            transition:.25s;
        }

        .btn-masuk:hover{
            background:var(--brown-mid);
        }

        /* MAIN */
        .signup-page{
            min-height:100vh;
            padding-top:68px;
            display:grid;
            grid-template-columns:1fr 1fr;
        }

        /* LEFT SIDE */
        .signup-hero{
            background:var(--brown-dark);
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            padding:60px;
            position:relative;
            overflow:hidden;
        }

        .signup-hero::before{
            content:'';
            position:absolute;
            width:400px;
            height:400px;
            border-radius:50%;
            background:rgba(255,255,255,.04);
            top:-120px;
            right:-120px;
        }

        .signup-hero::after{
            content:'';
            position:absolute;
            width:300px;
            height:300px;
            border-radius:50%;
            background:rgba(201,136,60,.1);
            bottom:-80px;
            left:-80px;
        }

        .hero-img{
            width:280px;
            height:280px;
            border-radius:50%;
            object-fit:cover;
            border:6px solid rgba(255,255,255,.15);
            margin-bottom:35px;
            box-shadow:0 20px 60px rgba(0,0,0,.3);
        }

        .hero-subtitle{
            color:var(--accent-rose);
            text-transform:uppercase;
            letter-spacing:1px;
            margin-bottom:8px;
        }

        .hero-title{
            font-family:'Playfair Display',serif;
            color:#fff;
            font-size:2.7rem;
            font-weight:900;
            line-height:1.1;
        }

        .hero-italic{
            font-family:'Playfair Display',serif;
            font-style:italic;
            color:var(--accent-rose);
            font-size:2.1rem;
            margin-bottom:20px;
        }

        .hero-desc{
            color:rgba(255,255,255,.7);
            text-align:center;
            max-width:350px;
            line-height:1.7;
            font-size:.9rem;
        }

        /* RIGHT SIDE */
        .signup-form-side{
            display:flex;
            justify-content:center;
            align-items:center;
            padding:50px 70px;
            background:var(--cream-bg);
        }

        .form-card{
            width:100%;
            max-width:450px;
            background:var(--cream-card);
            padding:40px;
            border-radius:22px;
            box-shadow:0 8px 40px rgba(59,35,20,.12);
        }

        .form-card-title{
            font-family:'Playfair Display',serif;
            font-size:2rem;
            color:var(--text-dark);
            margin-bottom:4px;
            font-weight:700;
        }

        .form-card-sub{
            color:var(--text-muted);
            margin-bottom:28px;
            font-size:.9rem;
        }

        .form-label{
            font-size:.85rem;
            font-weight:600;
            color:var(--text-mid);
            margin-bottom:6px;
            display:block;
        }

        .form-control,
        .form-select{
            width:100%;
            border:1.5px solid var(--cream-border);
            border-radius:10px;
            padding:12px 15px;
            font-size:.9rem;
            margin-bottom:18px;
            background:#fff;
            transition:.2s;
        }

        .form-control:focus,
        .form-select:focus{
            outline:none;
            border-color:var(--brown-mid);
            box-shadow:0 0 0 3px rgba(92,61,46,.12);
        }

        .btn-submit{
            width:100%;
            border:none;
            background:var(--brown-dark);
            color:#fff;
            padding:14px;
            border-radius:10px;
            font-size:1rem;
            font-weight:600;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            transition:.25s;
            margin-top:8px;
        }

        .btn-submit:hover{
            background:var(--brown-mid);
            transform:translateY(-2px);
        }

        .bottom-link{
            text-align:center;
            margin-top:18px;
            font-size:.9rem;
            color:var(--text-mid);
        }

        .bottom-link a{
            color:var(--brown-dark);
            text-decoration:none;
            font-weight:600;
        }

        @media(max-width:768px){

            .signup-page{
                grid-template-columns:1fr;
            }

            .signup-hero{
                display:none;
            }

            .top-nav{
                padding:0 20px;
            }

            .nav-links{
                display:none;
            }

            .signup-form-side{
                padding:40px 20px;
            }

            .form-card{
                padding:30px 24px;
            }

        }

    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="top-nav">

    <a href="#" class="nav-logo">
        Toko Kue <span>Fanda</span>
    </a>

    <ul class="nav-links">
        <li><a href="#">Beranda</a></li>
        <li><a href="">Menu</a></li>
        <li><a href="#">Kontak</a></li>
        <li><a href="#">Tentang Kami</a></li>
    </ul>

    <div class="nav-right">
        <a href="#"><i class="fas fa-cart-shopping"></i></a>
        <a href="#"><i class="fas fa-user"></i></a>
        <a href="index.php" class="btn-masuk">Kembali</a>
    </div>

</nav>

<!-- SIGN UP PAGE -->
<div class="signup-page">

    <!-- LEFT -->
    <div class="signup-hero">

        <img src="gambar/logo.jpeg Kacang 250gr.jpg"
             alt="Toko Kue Fanda"
             class="hero-img">

        <p class="hero-subtitle">
            Toko Kue Fanda
        </p>

        <h1 class="hero-title">
            Daftar Akun
        </h1>

        <p class="hero-italic">
            Toko kue Fanda
        </p>

        <p class="hero-desc">
            Buat akun baru untuk mengakses sistem pemesanan,
            pengelolaan produk, dan transaksi toko kue Fanda.
        </p>

    </div>

    <!-- RIGHT -->
    <div class="signup-form-side">

        <div class="form-card">

            <h2 class="form-card-title">
                Sign Up ✨
            </h2>

            <p class="form-card-sub">
                Lengkapi data di bawah untuk membuat akun baru.
            </p>

            <form method="POST" action="signup_aksi.php">

                <!-- USERNAME -->
                <label class="form-label">
                    Username
                </label>

                <input type="text"
                       name="username"
                       class="form-control"
                       placeholder="Masukkan username"
                       required>

                <!-- PASSWORD -->
                <label class="form-label">
                    Password
                </label>

                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Masukkan password"
                       required>

                <!-- NAMA -->
                <label class="form-label">
                    Nama Lengkap
                </label>

                <input type="text"
                       name="nama"
                       class="form-control"
                       placeholder="Masukkan nama lengkap"
                       required>

                <!-- EMAIL -->
                <label class="form-label">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Masukkan email"
                       required>

                <!-- BUTTON -->
                <button type="submit" class="btn-submit">

                    Buat Akun
                    <i class="fas fa-user-plus"></i>

                </button>

                <div class="bottom-link">
                    Sudah punya akun?
                    <a href="login.php">Masuk di sini</a>
                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>