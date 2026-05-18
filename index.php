<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Kue Fanda — Masuk</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2a1810 0%, #1f0f08 25%, #3d2817 50%, #1a0a04 75%, #2d1810 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animated background particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(212, 165, 116, 0.3);
            border-radius: 50%;
            animation: float 20s infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0) scale(1);
                opacity: 0;
            }
            10% {
                opacity: 0.5;
            }
            90% {
                opacity: 0.5;
            }
            100% {
                transform: translateY(-100vh) translateX(100px) scale(0);
                opacity: 0;
            }
        }

        /* Glow orbs */
        .glow-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }

        .glow-orb-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(212, 165, 116, 0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            animation: orbFloat1 20s ease-in-out infinite;
        }

        .glow-orb-2 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(212, 132, 156, 0.1) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
            animation: orbFloat2 25s ease-in-out infinite;
        }

        @keyframes orbFloat1 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(50px, -50px); }
        }

        @keyframes orbFloat2 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-50px, 50px); }
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            max-width: 1300px;
            width: 90%;
            position: relative;
            z-index: 1;
            align-items: center;
        }

        /* LEFT SECTION */
        .left-section {
            animation: slideInLeft 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .left-section h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.8) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            line-height: 1.05;
            letter-spacing: -1px;
        }

        .left-section > p {
            color: rgba(255, 255, 255, 0.65);
            font-size: 1.05rem;
            margin-bottom: 50px;
            line-height: 1.7;
            font-weight: 300;
            letter-spacing: 0.3px;
        }

        .role-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .role-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 20px 24px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            backdrop-filter: blur(20px);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .role-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .role-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateX(12px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .role-item:hover::before {
            left: 100%;
        }

        .role-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            margin-top: 3px;
            flex-shrink: 0;
            box-shadow: 0 0 12px currentColor;
        }

        .role-dot.admin {
            background: #5B9BFF;
            color: #5B9BFF;
        }

        .role-dot.kasir {
            background: #4ECB71;
            color: #4ECB71;
        }

        .role-dot.pelanggan {
            background: #FFB84D;
            color: #FFB84D;
        }

        .role-content h3 {
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }

        .role-content p {
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.85rem;
            margin: 0;
            line-height: 1.5;
            font-weight: 300;
        }

        /* RIGHT SECTION - LOGIN CARD */
        .right-section {
            display: flex;
            justify-content: center;
            animation: slideInRight 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .login-card {
            background: rgba(60, 40, 30, 0.5);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 28px;
            padding: 56px 48px;
            width: 100%;
            max-width: 420px;
            box-shadow: 
                0 0 60px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(212, 165, 116, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-card::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(212, 132, 156, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 12px;
            text-align: center;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 2;
        }

        .login-card-subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            margin-bottom: 36px;
            font-weight: 300;
            position: relative;
            z-index: 2;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
            z-index: 2;
        }

        .form-group label {
            display: block;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-weight: 400;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }

        .form-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(212, 165, 116, 0.6);
            box-shadow: 
                0 0 0 4px rgba(212, 165, 116, 0.12),
                inset 0 1px 2px rgba(255, 255, 255, 0.1);
        }

        .form-group input:hover {
            border-color: rgba(255, 255, 255, 0.25);
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #FFB84D 0%, #FF9E1B 50%, #FF8C00 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            margin-top: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 12px 32px rgba(255, 184, 77, 0.35);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 48px rgba(255, 184, 77, 0.45);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 32px 0;
            gap: 12px;
            color: rgba(255, 255, 255, 0.25);
            font-size: 0.85rem;
            font-weight: 500;
            position: relative;
            z-index: 2;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0) 100%);
        }

        .demo-section {
            position: relative;
            z-index: 2;
        }

        .demo-section h3 {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 14px;
            text-align: center;
            font-weight: 700;
        }

        .demo-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
        }

        .btn-demo {
            padding: 10px 14px;
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-demo:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .btn-demo:active {
            transform: translateY(0);
        }

        /* Alert messages */
        .alert-msg {
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInAlert 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            z-index: 2;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        .alert-msg.error {
            background: rgba(220, 53, 69, 0.25);
            color: #FF6B6B;
            border: 1px solid rgba(220, 53, 69, 0.4);
        }

        .alert-msg.success {
            background: rgba(40, 167, 69, 0.25);
            color: #51CF66;
            border: 1px solid rgba(40, 167, 69, 0.4);
        }

        @keyframes slideInAlert {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .container {
                gap: 60px;
            }

            .left-section h1 {
                font-size: 3.2rem;
            }

            .login-card {
                padding: 48px 40px;
            }
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .left-section h1 {
                font-size: 2.5rem;
            }

            .left-section > p {
                font-size: 0.95rem;
            }

            .login-card {
                max-width: 100%;
                padding: 40px 32px;
            }

            .login-card h2 {
                font-size: 2rem;
            }

            .demo-buttons {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>

<body>

<!-- Animated background -->
<div class="glow-orb glow-orb-1"></div>
<div class="glow-orb glow-orb-2"></div>
<div class="particles" id="particles"></div>

<div class="container">
    <!-- LEFT SECTION -->
    <div class="left-section">
        <h1>Toko Kue Fanda</h1>
        <p>Platform toko kue modern untuk admin, kasir, dan pelanggan. Kelola bisnis dengan mudah dan efisien.</p>

        <div class="role-list">
            <div class="role-item">
                <div class="role-dot admin"></div>
                <div class="role-content">
                    <h3>Admin</h3>
                    <p>Kelola produk, user, laporan & dashboard</p>
                </div>
            </div>

            <div class="role-item">
                <div class="role-dot kasir"></div>
                <div class="role-content">
                    <h3>Kasir</h3>
                    <p>Input transaksi, POS, cetak struk</p>
                </div>
            </div>

            <div class="role-item">
                <div class="role-dot pelanggan"></div>
                <div class="role-content">
                    <h3>Pelanggan</h3>
                    <p>Browse menu & order online</p>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT SECTION -->
    <div class="right-section">
        <div class="login-card">
            <?php
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan'] == 'gagal') {
                    echo "<div class='alert-msg error'><i class='fas fa-exclamation-circle'></i> Login gagal! Username atau password salah.</div>";
                } elseif ($_GET['pesan'] == 'logout') {
                    echo "<div class='alert-msg success'><i class='fas fa-check-circle'></i> Anda telah berhasil logout.</div>";
                } elseif ($_GET['pesan'] == 'belum_login') {
                    echo "<div class='alert-msg error'><i class='fas fa-lock'></i> Anda harus login untuk mengakses halaman tersebut.</div>";
                } elseif ($_GET['pesan'] == 'bukan_admin') {
                    echo "<div class='alert-msg error'><i class='fas fa-ban'></i> Akses ditolak. Halaman khusus admin.</div>";
                }
            }
            ?>

            <h2>Login</h2>
            <p class="login-card-subtitle">Masuk ke akun Anda sekarang</p>

            <form method="post" action="login_aksi.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <div class="divider">atau</div>

            <div class="demo-section">
                <h3>Demo:</h3>
                <div class="demo-buttons">
                    <button type="button" class="btn-demo" onclick="fillDemo('admin', 'admin123')">Admin</button>
                    <button type="button" class="btn-demo" onclick="fillDemo('kasir', 'kasir123')">Kasir</button>
                    <button type="button" class="btn-demo" onclick="fillDemo('user', 'user123')">User</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Create animated particles
    function createParticles() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 30;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 20 + 's';
            particle.style.animationDuration = (15 + Math.random() * 20) + 's';
            particlesContainer.appendChild(particle);
        }
    }

    // Fill demo credentials
    function fillDemo(username, password) {
        document.getElementById('username').value = username;
        document.getElementById('password').value = password;
        document.getElementById('username').focus();
    }

    // Initialize
    createParticles();
</script>

</body>
</html>
