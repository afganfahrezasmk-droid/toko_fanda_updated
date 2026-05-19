<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Toko Kue Fanda — Sign Up</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600&family=Kaushan+Script&display=swap" rel="stylesheet">

<style>
:root {
  --esp:       #1C0A00;
  --brown:     #3B2314;
  --brown-mid: #5C3D2E;
  --car:       #C9883C;
  --gold:      #E8B46D;
  --cream:     #F5EFE6;
  --cream2:    #EFE8DC;
  --cream3:    #E8DFCF;
  --border:    #DDD3C2;
  --muted:     #9A7B6A;
  --text:      #1A1008;
  --text-mid:  #4A3728;
}

*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--cream);
  min-height: 100vh;
  overflow-x: hidden;
}

/* ── NAVBAR ── */
.top-nav {
  position: fixed;
  top: 0; left: 0; right: 0;
  height: 66px;
  background: rgba(245,239,230,.92);
  backdrop-filter: blur(14px);
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 52px;
  z-index: 200;
}

.nav-logo {
  font-family: 'Kaushan Script', cursive;
  font-size: 1.5rem;
  color: var(--text);
  text-decoration: none;
}
.nav-logo span { color: var(--car); }

.nav-links {
  display: flex;
  list-style: none;
  gap: 36px;
}
.nav-links a {
  text-decoration: none;
  color: var(--text-mid);
  font-size: .88rem;
  font-weight: 500;
  transition: color .25s;
}
.nav-links a:hover { color: var(--car); }

.nav-right { display: flex; align-items: center; gap: 14px; }
.nav-right a { color: var(--text-mid); text-decoration: none; font-size: 1.1rem; transition: color .25s; }
.nav-right a:hover { color: var(--car); }

.btn-kembali {
  background: var(--brown);
  color: #fff;
  padding: 9px 22px;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 600;
  font-size: .88rem;
  transition: .25s;
}
.btn-kembali:hover { background: var(--brown-mid); transform: translateY(-1px); }

/* ── MAIN LAYOUT ── */
.signup-page {
  min-height: 100vh;
  padding-top: 66px;
  display: grid;
  grid-template-columns: 1fr 1fr;
}

/* ══════════════════════════════
   LEFT — Logo + orbiting balls
══════════════════════════════ */
.signup-visual {
  background: var(--cream);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 60px 40px;
  position: relative;
  overflow: hidden;
}

/* Subtle background pattern */
.signup-visual::before {
  content: '';
  position: absolute;
  width: 600px; height: 600px;
  border-radius: 50%;
  border: 1px solid rgba(201,136,60,.08);
  top: 50%; left: 50%;
  transform: translate(-50%,-50%);
  pointer-events: none;
}
.signup-visual::after {
  content: '';
  position: absolute;
  width: 420px; height: 420px;
  border-radius: 50%;
  border: 1px solid rgba(201,136,60,.07);
  top: 50%; left: 50%;
  transform: translate(-50%,-50%);
  pointer-events: none;
}

/* orbit ring */
.orbit-ring {
  position: absolute;
  border-radius: 50%;
  border: 1.5px dashed rgba(201,136,60,.18);
  top: 50%; left: 50%;
  transform: translate(-50%,-50%);
  pointer-events: none;
}
.ring-1 { width: 340px; height: 340px; }
.ring-2 { width: 460px; height: 460px; animation: ring-pulse 6s ease-in-out infinite; }
.ring-3 { width: 560px; height: 560px; border-color: rgba(201,136,60,.08); }

@keyframes ring-pulse {
  0%,100% { opacity: .5; transform: translate(-50%,-50%) scale(1); }
  50%      { opacity: 1;  transform: translate(-50%,-50%) scale(1.02); }
}

/* Orbiting dots container — rotates, inner dot counter-rotates to stay upright */
.orbit {
  position: absolute;
  top: 50%; left: 50%;
  border-radius: 50%;
  pointer-events: none;
}

.o1 { width: 340px; height: 340px; margin: -170px 0 0 -170px; animation: spin 18s linear infinite; }
.o2 { width: 460px; height: 460px; margin: -230px 0 0 -230px; animation: spin 26s linear infinite reverse; }
.o3 { width: 560px; height: 560px; margin: -280px 0 0 -280px; animation: spin 34s linear infinite; }

@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

.orb-dot {
  position: absolute;
  border-radius: 50%;
  background: var(--car);
  top: 0; left: 50%;
  transform: translate(-50%, -50%);
  box-shadow: 0 4px 16px rgba(201,136,60,.4);
}
.orb-dot.sm { width: 10px; height: 10px; }
.orb-dot.md { width: 14px; height: 14px; background: var(--gold); box-shadow: 0 4px 20px rgba(232,180,109,.5); }
.orb-dot.lg { width: 18px; height: 18px; background: var(--brown-mid); box-shadow: 0 4px 22px rgba(59,35,20,.4); }

/* extra dots at different angles */
.orb-dot-b { bottom: 0; top: auto; left: 50%; transform: translate(-50%, 50%); }
.orb-dot-l { top: 50%; left: 0; transform: translate(-50%, -50%); }
.orb-dot-r { top: 50%; left: auto; right: 0; transform: translate(50%, -50%); }

/* Floating badge cards (like in pelanggan/index) */
.badge-float {
  position: absolute;
  background: #fff;
  border-radius: 14px;
  padding: 10px 16px;
  box-shadow: 0 8px 32px rgba(59,35,20,.12);
  display: flex;
  align-items: center;
  gap: 10px;
  pointer-events: none;
  z-index: 2;
}
.badge-float.b1 {
  top: 22%;
  right: 10%;
  animation: floatY 5s ease-in-out infinite;
}
.badge-float.b2 {
  bottom: 24%;
  left: 8%;
  animation: floatY 6s 1s ease-in-out infinite;
}
@keyframes floatY {
  0%,100% { transform: translateY(0); }
  50%      { transform: translateY(-10px); }
}

.badge-icon {
  width: 36px; height: 36px;
  border-radius: 50%;
  background: var(--cream2);
  display: flex; align-items: center; justify-content: center;
  font-size: 1rem; flex-shrink: 0;
}
.badge-text { display: flex; flex-direction: column; }
.badge-title { font-size: .8rem; font-weight: 700; color: var(--text); }
.badge-sub   { font-size: .68rem; color: var(--muted); }

/* Logo center */
.visual-logo-wrap {
  position: relative;
  z-index: 3;
  text-align: center;
}
.visual-logo {
  width: clamp(220px, 22vw, 290px);
  height: clamp(220px, 22vw, 290px);
  border-radius: 50%;
  object-fit: cover;
  border: 5px solid rgba(201,136,60,.2);
  box-shadow: 0 20px 60px rgba(59,35,20,.2);
  display: block;
  margin: 0 auto 28px;
  animation: logoFloat 8s ease-in-out infinite;
}
@keyframes logoFloat {
  0%,100% { transform: translateY(0) scale(1); }
  50%      { transform: translateY(-10px) scale(1.015); }
}

.visual-brand {
  font-family: 'Kaushan Script', cursive;
  font-size: 2rem;
  color: var(--brown);
  display: block;
  margin-bottom: 6px;
}
.visual-tagline {
  font-family: 'Playfair Display', serif;
  font-style: italic;
  font-size: .95rem;
  color: var(--muted);
}

/* ══════════════════════════════
   RIGHT — Form
══════════════════════════════ */
.signup-form-side {
  background: var(--cream2);
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 50px 70px;
  border-left: 1px solid var(--border);
}

.form-card {
  width: 100%;
  max-width: 440px;
}

.form-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  background: rgba(201,136,60,.12);
  border: 1px solid rgba(201,136,60,.2);
  color: var(--car);
  font-size: .68rem;
  font-weight: 600;
  letter-spacing: .14em;
  text-transform: uppercase;
  padding: 6px 16px;
  border-radius: 100px;
  margin-bottom: 18px;
}
.eyebrow-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--car);
  animation: blink 2s ease-in-out infinite;
}
@keyframes blink {
  0%,100% { opacity: 1; transform: scale(1); }
  50%      { opacity: .3; transform: scale(1.6); }
}

.form-title {
  font-family: 'Playfair Display', serif;
  font-size: 2.2rem;
  color: var(--text);
  font-weight: 900;
  line-height: 1.1;
  margin-bottom: 6px;
}
.form-title em { font-style: italic; color: var(--car); }
.form-sub {
  color: var(--muted);
  font-size: .88rem;
  margin-bottom: 32px;
  line-height: 1.6;
}

.field-group { margin-bottom: 20px; }
.field-label {
  display: block;
  font-size: .8rem;
  font-weight: 600;
  color: var(--text-mid);
  margin-bottom: 7px;
  letter-spacing: .02em;
}

.field-wrap {
  position: relative;
}
.field-wrap .f-icon {
  position: absolute;
  left: 14px; top: 50%;
  transform: translateY(-50%);
  color: var(--muted);
  font-size: .95rem;
  pointer-events: none;
  transition: color .25s;
}
.field-wrap input {
  width: 100%;
  background: #fff;
  border: 1.5px solid var(--border);
  border-radius: 12px;
  padding: 13px 15px 13px 42px;
  font-size: .9rem;
  font-family: 'DM Sans', sans-serif;
  color: var(--text);
  transition: border-color .25s, box-shadow .25s;
  outline: none;
}
.field-wrap input::placeholder { color: #C4B4A4; }
.field-wrap input:focus {
  border-color: var(--car);
  box-shadow: 0 0 0 4px rgba(201,136,60,.1);
}
.field-wrap input:focus + .f-icon,
.field-wrap:focus-within .f-icon { color: var(--car); }

/* show-password toggle */
.toggle-pw {
  position: absolute;
  right: 14px; top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  color: var(--muted);
  padding: 0;
  font-size: .9rem;
  transition: color .25s;
}
.toggle-pw:hover { color: var(--car); }

.btn-submit {
  width: 100%;
  border: none;
  background: var(--brown);
  color: #fff;
  padding: 15px;
  border-radius: 12px;
  font-size: .95rem;
  font-weight: 700;
  font-family: 'DM Sans', sans-serif;
  letter-spacing: .02em;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  margin-top: 6px;
  cursor: pointer;
  transition: background .25s, transform .35s, box-shadow .35s;
  box-shadow: 0 6px 24px rgba(59,35,20,.2);
}
.btn-submit:hover {
  background: var(--brown-mid);
  transform: translateY(-3px);
  box-shadow: 0 12px 36px rgba(59,35,20,.28);
}
.btn-submit:active { transform: translateY(0); }

.divider {
  display: flex;
  align-items: center;
  gap: 14px;
  margin: 22px 0;
  color: var(--muted);
  font-size: .78rem;
}
.divider::before, .divider::after {
  content: '';
  flex: 1;
  height: 1px;
  background: var(--border);
}

.bottom-link {
  text-align: center;
  font-size: .88rem;
  color: var(--text-mid);
}
.bottom-link a {
  color: var(--brown);
  font-weight: 700;
  text-decoration: none;
  transition: color .25s;
}
.bottom-link a:hover { color: var(--car); }

/* Alert (error/success) */
.alert-msg {
  padding: 12px 16px;
  border-radius: 10px;
  font-size: .85rem;
  margin-bottom: 20px;
  display: none;
  align-items: center;
  gap: 10px;
}
.alert-msg.error  { background: #FDE8E8; color: #8B1A1A; border: 1px solid #F5B8B8; display: flex; }
.alert-msg.success{ background: #E8F5EA; color: #1A5C2A; border: 1px solid #B8DFC0; display: flex; }

/* ── RESPONSIVE ── */
@media (max-width: 860px) {
  .signup-page { grid-template-columns: 1fr; }
  .signup-visual { display: none; }
  .top-nav { padding: 0 20px; }
  .nav-links { display: none; }
  .signup-form-side { padding: 40px 22px; border-left: none; }
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="top-nav">
  <a href="#" class="nav-logo">Toko Kue <span>Fanda</span></a>
  <ul class="nav-links">
    <li><a href="pelanggan.php">Beranda</a></li>
    <li><a href="pelanggan.php#menu">Menu</a></li>
    <li><a href="pelanggan.php#footer">Kontak</a></li>
    <li><a href="pelanggan.php#tentang">Tentang Kami</a></li>
  </ul>
  <div class="nav-right">

  <!-- KERANJANG -->
  <a href="index.php"
     title="Silakan login terlebih dahulu"
     onclick="alert('Anda belum memiliki akun / belum login!')">

     🛒

  </a>

  <!-- AKUN -->
  <a href="index.php"
     title="Silakan login terlebih dahulu"
     onclick="alert('Silakan login terlebih dahulu!')">

     👤

  </a>

  <!-- BUTTON KEMBALI -->
  <a href="index.php" class="btn-kembali">
    Kembali
  </a>

</div>
</nav>

<!-- MAIN -->
<div class="signup-page">

  <!-- ════ LEFT — Visual ════ -->
  <div class="signup-visual">

    <!-- Orbit rings -->
    <div class="orbit-ring ring-2"></div>

    <!-- Orbit 1 — ring kecil, satu titik atas dan bawah -->
    <div class="orbit o1">
      <div class="orb-dot md orb-dot-b"></div>
    </div>

    <!-- Orbit 2 — ring sedang, tiga titik -->
    <div class="orbit o2">
      <div class="orb-dot sm orb-dot-r"></div>
    </div>

    <!-- Floating badges -->
    <div class="badge-float b1">
      <div class="badge-icon">🎁</div>
      <div class="badge-text">
        <span class="badge-title">Promo</span>
        <span class="badge-sub">Min. 3 item</span>
      </div>
    </div>

    <div class="badge-float b2">
      <div class="badge-icon">🍪</div>
      <div class="badge-text">
        <span class="badge-title">Mulai dari</span>
        <span class="badge-sub">Rp 60.000</span>
      </div>
    </div>

    <!-- Center logo -->
    <div class="visual-logo-wrap">
      <img src="gambar/logo.jpeg" alt="Logo Fanda" class="visual-logo">
      <span class="visual-brand">Toko Kue Fanda</span>
      <span class="visual-tagline">Freshly Baked, Made With Love</span>
    </div>

  </div>

  <!-- ════ RIGHT — Form ════ -->
  <div class="signup-form-side">
    <div class="form-card">

      <div class="form-eyebrow">
        <span class="eyebrow-dot"></span>
        Daftar Akun Baru
      </div>

      <h1 class="form-title">Sign Up <em>Yuk!</em> ✨</h1>
      <p class="form-sub">Lengkapi data di bawah untuk membuat akun baru dan mulai pesan kue favorit kamu.</p>

      <!-- Alert placeholder (bisa diisi PHP) -->
      <?php if(isset($_GET['error'])): ?>
      <div class="alert-msg error" style="display:flex">
        ⚠️ <?= htmlspecialchars($_GET['error']) ?>
      </div>
      <?php endif; ?>

      <form method="POST" action="signup_aksi.php">

        <!-- USERNAME -->
        <div class="field-group">
          <label class="field-label" for="username">Username</label>
          <div class="field-wrap">
            <input type="text" id="username" name="username"
                   placeholder="Masukkan username" required autocomplete="username">
            <span class="f-icon">👤</span>
          </div>
        </div>

        <!-- PASSWORD -->
        <div class="field-group">
          <label class="field-label" for="password">Password</label>
          <div class="field-wrap">
            <input type="password" id="password" name="password"
                   placeholder="Masukkan password" required autocomplete="new-password">
            <span class="f-icon">🔒</span>
            <button type="button" class="toggle-pw" onclick="togglePw()" title="Tampilkan/Sembunyikan">
              <span id="pwEye">👁️</span>
            </button>
          </div>
        </div>

        <!-- NAMA LENGKAP -->
        <div class="field-group">
          <label class="field-label" for="nama">Nama Lengkap</label>
          <div class="field-wrap">
            <input type="text" id="nama" name="nama"
                   placeholder="Masukkan nama lengkap" required autocomplete="name">
            <span class="f-icon">✏️</span>
          </div>
        </div>

        <!-- EMAIL -->
        <div class="field-group">
          <label class="field-label" for="email">Email</label>
          <div class="field-wrap">
            <input type="email" id="email" name="email"
                   placeholder="Masukkan email" required autocomplete="email">
            <span class="f-icon">✉️</span>
          </div>
        </div>

        <button type="submit" class="btn-submit">
          Buat Akun
          <span>→</span>
        </button>

      </form>

      <div class="divider">atau</div>

      <div class="bottom-link">
        Sudah punya akun? <a href="index.php">Masuk di sini</a>
      </div>

    </div>
  </div>

</div>

<script>
function togglePw(){
  const inp=document.getElementById('password');
  const eye=document.getElementById('pwEye');
  if(inp.type==='password'){inp.type='text';eye.textContent='🙈'}
  else{inp.type='password';eye.textContent='👁️'}
}
</script>

</body>
</html>
