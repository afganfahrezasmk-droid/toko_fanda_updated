<?php
session_start();
include 'koneksi.php';
/** @var mysqli $koneksi */

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $login    = trim($_POST['login'] ?? '');
    $password = md5($_POST['password'] ?? '');

    // Prepared statement
    $stmt = $koneksi->prepare(
        "SELECT * FROM user
         WHERE (username = ? OR email = ?)
         AND password = ?"
    );

    $stmt->bind_param('sss', $login, $login, $password);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {

        $u = $result->fetch_assoc();

        $_SESSION['user_id']  = $u['user_id'];
        $_SESSION['nama']     = $u['nama'];
        $_SESSION['username'] = $u['username'];
        $_SESSION['role']     = $u['role'];

        switch ($u['role']) {

            case 'admin':
                header("Location: admin/index.php");
                break;

            case 'kasir':
                header("Location: kasir/index.php");
                break;

            case 'pelanggan':
            default:
                header("Location: pelanggan/index.php");
                break;
        }

        exit;

    } else {

        $pesan = 'Username / email atau password salah.';
    }
}

$flash = $_GET['pesan'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Toko Kue Fanda — Masuk</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
<style>
:root {
    --esp:   #1C0A00;
    --esp-2: #2D1507;
    --brown: #4A2510;
    --car:   #C07B3A;
    --gold:  #E8B46D;
    --cream: #F8F2E5;
    --blush: #F5CECC;
    --blush2:#EDB8B4;
    --white: #FFFCF7;
    --muted: #9B7A5A;
    --pill:  100px;
    --ease:  cubic-bezier(.22,.68,0,1.2);
    --es:    cubic-bezier(.25,.46,.45,.94);
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html { height:100%; }
body {
    font-family: 'DM Sans', sans-serif;
    background: var(--esp-2);
    color: var(--white);
    min-height: 100vh;
    overflow: hidden;
    cursor: none;
    position: relative;
}

/* ── CURSOR ── */
#cur  { position:fixed; width:11px; height:11px; background:var(--car); border-radius:50%; pointer-events:none; z-index:9999; transform:translate(-50%,-50%); mix-blend-mode:multiply; transition:width .2s,height .2s; }
#cur-r{ position:fixed; width:42px; height:42px; border:2px solid var(--car); border-radius:50%; pointer-events:none; z-index:9998; transform:translate(-50%,-50%); opacity:.4; transition:width .3s var(--es),height .3s var(--es); }
body.h #cur  { width:18px; height:18px; }
body.h #cur-r{ width:60px; height:60px; opacity:.18; }

/* ── NOISE OVERLAY ── */
body::before {
    content:''; position:fixed; inset:0; z-index:1; pointer-events:none; opacity:.045;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)'/%3E%3C/svg%3E");
    background-size:200px 200px;
}

/* ── FLOATING FOOD IMAGES ── */
/* Gambar tidak dibuat bulat — cocok untuk foto yang sudah di-remove background */
.food-wrap { position:fixed; pointer-events:none; z-index:2; }
.food-img  {
    object-fit: contain;   /* tampilkan penuh, tidak dipotong */
    display: block;
    filter: drop-shadow(0 20px 40px rgba(0,0,0,.55));
    /* HAPUS border-radius agar gambar remove-bg tampil alami */
}

/* Posisi & ukuran */
.food-wrap.f1 { top:-2%; left:-2%; }
.food-wrap.f2 { top:-1%; right:-1%; }
.food-wrap.f3 { bottom:-2%; left:0%; }
.food-wrap.f4 { bottom:-1%; right:0%; }
.food-wrap.f5 { top:36%; left:-1%; transform:translateY(-50%); }
.food-wrap.f6 { top:36%; right:-1%; transform:translateY(-50%); }

.food-wrap.f1 .food-img { width:clamp(140px,14vw,210px); height:clamp(140px,14vw,210px); }
.food-wrap.f2 .food-img { width:clamp(160px,16vw,240px); height:clamp(160px,16vw,240px); }
.food-wrap.f3 .food-img { width:clamp(130px,13vw,190px); height:clamp(130px,13vw,190px); }
.food-wrap.f4 .food-img { width:clamp(150px,15vw,220px); height:clamp(150px,15vw,220px); }
.food-wrap.f5 .food-img { width:clamp(95px,9vw,135px);   height:clamp(95px,9vw,135px); }
.food-wrap.f6 .food-img { width:clamp(100px,10vw,145px); height:clamp(100px,10vw,145px); }

/* Fly-in */
.food-wrap.f1 { animation: flyTL 1.1s .05s cubic-bezier(.22,.68,0,1) forwards; }
.food-wrap.f2 { animation: flyTR 1.2s .00s cubic-bezier(.22,.68,0,1) forwards; }
.food-wrap.f3 { animation: flyBL 1.1s .20s cubic-bezier(.22,.68,0,1) forwards; }
.food-wrap.f4 { animation: flyBR 1.2s .10s cubic-bezier(.22,.68,0,1) forwards; }
.food-wrap.f5 { animation: flyML 1.0s .28s cubic-bezier(.22,.68,0,1) forwards; }
.food-wrap.f6 { animation: flyMR 1.0s .22s cubic-bezier(.22,.68,0,1) forwards; }

@keyframes flyTL { from{opacity:0;transform:translate(-130%,-110%) rotate(-20deg)} to{opacity:1;transform:translate(0,0) rotate(-9deg)} }
@keyframes flyTR { from{opacity:0;transform:translate(130%,-100%) rotate(18deg)}  to{opacity:1;transform:translate(0,0) rotate(7deg)} }
@keyframes flyBL { from{opacity:0;transform:translate(-120%,110%) rotate(14deg)}  to{opacity:1;transform:translate(0,0) rotate(10deg)} }
@keyframes flyBR { from{opacity:0;transform:translate(120%,100%) rotate(-16deg)}  to{opacity:1;transform:translate(0,0) rotate(-8deg)} }
@keyframes flyML { from{opacity:0;transform:translateY(-50%) translateX(-120%)}   to{opacity:1;transform:translateY(-50%) translateX(0)} }
@keyframes flyMR { from{opacity:0;transform:translateY(-50%) translateX(120%)}    to{opacity:1;transform:translateY(-50%) translateX(0)} }

/* Float setelah fly-in */
.food-wrap.f1 .food-img { animation: flt1 7s 1.15s ease-in-out infinite; }
.food-wrap.f2 .food-img { animation: flt2 8s 1.20s ease-in-out infinite; }
.food-wrap.f3 .food-img { animation: flt3 6.5s 1.30s ease-in-out infinite; }
.food-wrap.f4 .food-img { animation: flt4 7.5s 1.30s ease-in-out infinite; }
.food-wrap.f5 .food-img { animation: flt5 9s 1.28s ease-in-out infinite; }
.food-wrap.f6 .food-img { animation: flt6 8.5s 1.22s ease-in-out infinite; }

@keyframes flt1 { 0%,100%{transform:translateY(0) rotate(-9deg)}  50%{transform:translateY(-16px) rotate(-5deg)} }
@keyframes flt2 { 0%,100%{transform:translateY(0) rotate(7deg)}   50%{transform:translateY(-20px) rotate(11deg)} }
@keyframes flt3 { 0%,100%{transform:translateY(0) rotate(10deg)}  50%{transform:translateY(-13px) rotate(5deg)} }
@keyframes flt4 { 0%,100%{transform:translateY(0) rotate(-8deg)}  50%{transform:translateY(-18px) rotate(-13deg)} }
@keyframes flt5 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
@keyframes flt6 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-15px)} }

/* ── MAIN LAYOUT ── */
.page {
    position: relative; z-index: 3;
    min-height: 100vh;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 40px 20px;
}

/* ── LOGO ── */
.logo-wrap {
    text-align: center; margin-bottom: 28px;
    opacity: 0; animation: fadeUp .7s .4s var(--es) forwards;
}
.logo-title {
    font-family: 'Kaushan Script', cursive;
    font-size: clamp(2.2rem, 5vw, 3.2rem);
    color: var(--blush);
    line-height: 1;
    text-shadow: 0 4px 30px rgba(0,0,0,.5);
}
.logo-tagline {
    font-family: 'Playfair Display', serif;
    font-style: italic;
    font-size: .85rem;
    color: rgba(255,252,247,.4);
    letter-spacing: .08em;
    margin-top: 6px;
}

/* ── CARD LOGIN ── */
.card-login {
    width: 100%; max-width: 420px;
    background: rgba(255, 252, 247, 0.06);
    border: 1px solid rgba(255, 252, 247, 0.12);
    border-radius: 24px;
    padding: 40px 36px 36px;
    backdrop-filter: blur(20px);
    box-shadow: 0 40px 100px rgba(0,0,0,.55), inset 0 1px 0 rgba(255,252,247,.08);
    opacity: 0; animation: fadeUp .7s .6s var(--es) forwards;
    position: relative; overflow: hidden;
}
.card-login::before {
    content: '';
    position: absolute; top: -60px; left: 50%; transform: translateX(-50%);
    width: 200px; height: 200px; border-radius: 50%;
    background: radial-gradient(circle, rgba(192,123,58,.25) 0%, transparent 70%);
    pointer-events: none;
}

.card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem; font-weight: 700;
    color: var(--white);
    margin-bottom: 4px;
}
.card-sub {
    font-size: .82rem; color: rgba(255,252,247,.42);
    margin-bottom: 30px;
}

/* ── FLASH ALERT ── */
.alert {
    padding: 12px 16px; border-radius: 12px; font-size: .83rem;
    margin-bottom: 18px; display: flex; align-items: center; gap: 8px;
}
.alert-error { background: rgba(220,60,60,.18); border:1px solid rgba(220,60,60,.3); color:#ffaaaa; }
.alert-info  { background: rgba(232,180,109,.15); border:1px solid rgba(232,180,109,.25); color:var(--gold); }

/* ── FORM ── */
.field { margin-bottom: 18px; }
.field label {
    display: block; font-size: .78rem; font-weight: 500;
    letter-spacing: .06em; text-transform: uppercase;
    color: rgba(255,252,247,.5); margin-bottom: 8px;
}
.input-wrap { position: relative; }
.input-wrap svg {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    width: 16px; height: 16px; stroke: rgba(255,252,247,.3);
    fill: none; stroke-width: 1.8; pointer-events: none;
    transition: stroke .3s;
}
.input-wrap input {
    width: 100%; padding: 13px 14px 13px 42px;
    background: rgba(255,252,247,.07);
    border: 1.5px solid rgba(255,252,247,.12);
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: .92rem; color: var(--white);
    outline: none; transition: border-color .3s, background .3s;
    cursor: none;
}
.input-wrap input::placeholder { color: rgba(255,252,247,.25); }
.input-wrap input:focus {
    border-color: var(--car);
    background: rgba(192,123,58,.08);
}
.input-wrap input:focus + svg,
.input-wrap:focus-within svg { stroke: var(--car); }

/* show/hide password */
.eye-btn {
    position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: none; padding: 4px;
    display: flex; align-items: center;
}
.eye-btn svg { width:16px; height:16px; stroke:rgba(255,252,247,.3); fill:none; stroke-width:1.8; transition:stroke .3s; }
.eye-btn:hover svg { stroke: var(--car); }

/* ── SUBMIT BUTTON ── */
.btn-masuk {
    width: 100%; padding: 14px;
    border-radius: 12px;
    background: var(--car);
    color: var(--white);
    font-family: 'DM Sans', sans-serif;
    font-size: .95rem; font-weight: 600;
    letter-spacing: .03em;
    border: none; cursor: none;
    position: relative; overflow: hidden;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 8px 30px rgba(192,123,58,.4);
    margin-top: 6px;
}
.btn-masuk::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.15) 0%, transparent 60%);
    pointer-events: none;
}
.btn-masuk:hover  { transform: translateY(-2px); box-shadow: 0 14px 40px rgba(192,123,58,.55); }
.btn-masuk:active { transform: translateY(0); box-shadow: 0 4px 16px rgba(192,123,58,.3); }

/* ── SIGN UP LINK ── */
/* Menggantikan bagian role badges yang dihapus */
.signup-link {
    margin-top: 22px;
    text-align: center;
    font-size: .84rem;
    color: rgba(255,252,247,.38);
}
.signup-link a {
    color: var(--gold);
    text-decoration: none;
    font-weight: 600;
    transition: color .2s, opacity .2s;
    cursor: none;
}
.signup-link a:hover {
    color: var(--blush);
    opacity: .9;
}

/* ── FOOTER NOTE ── */
.bottom-note {
    margin-top: 24px; text-align: center;
    font-size: .75rem; color: rgba(255,252,247,.22);
    opacity: 0; animation: fadeUp .6s 1s var(--es) forwards;
}
.bottom-note strong { color: rgba(255,252,247,.4); font-weight: 500; }

/* ── SCROLLBAR ── */
::-webkit-scrollbar { width:4px; }
::-webkit-scrollbar-thumb { background:var(--car); border-radius:2px; }

/* ── ANIMATIONS ── */
@keyframes fadeUp { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }

/* ── RESPONSIVE ── */
@media (max-width: 500px) {
    .card-login { padding: 30px 22px 28px; }
    .food-wrap.f5, .food-wrap.f6 { display:none; }
}
</style>
</head>
<body>

<!-- CURSOR -->
<div id="cur"></div>
<div id="cur-r"></div>

<!-- FOTO KUE MELAYANG (gambar remove-bg, tanpa border radius) -->
<div class="food-wrap f1"><img class="food-img" src="gambar/strawberry_thumbprint.png" alt=""></div>
<div class="food-wrap f2"><img class="food-img" src="gambar/sagu_keju.png" alt=""></div>
<div class="food-wrap f3"><img class="food-img" src="gambar/nastar.png" alt=""></div>
<div class="food-wrap f4"><img class="food-img" src="gambar/lidah_kucing.png" alt=""></div>
<div class="food-wrap f5"><img class="food-img" src="gambar/kue_kacang.png" alt=""></div>
<div class="food-wrap f6"><img class="food-img" src="gambar/kastengel.png" alt=""></div>

<!-- KONTEN UTAMA -->
<div class="page">

    <!-- LOGO -->
    <div class="logo-wrap">
        <div class="logo-title">Toko Kue Fanda</div>
        <div class="logo-tagline">Artisanal Bakery &amp; Kue Buatan Tangan · Semarang</div>
    </div>

    <!-- CARD LOGIN -->
    <div class="card-login">
        <div class="card-title">Selamat Datang 👋</div>
        <div class="card-sub">Masuk untuk mulai memesan kue favoritmu</div>

        <?php if ($pesan): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($pesan) ?></div>
        <?php endif; ?>

        <?php if ($flash == 'belum_login'): ?>
        <div class="alert alert-info">🔒 Silakan masuk terlebih dahulu.</div>
        <?php elseif ($flash == 'bukan_pelanggan'): ?>
        <div class="alert alert-info">⚠️ Akses hanya untuk pelanggan.</div>
        <?php endif; ?>

        <form method="POST" action="">

            <!-- USERNAME / EMAIL -->
            <div class="field">
                <label for="login">Username atau Email</label>
                <div class="input-wrap">
                    <input type="text" id="login" name="login"
                           placeholder="Masukkan username atau email"
                           autocomplete="username" required
                           value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
            </div>

            <!-- PASSWORD -->
            <div class="field">
                <label for="passInput">Password</label>
                <div class="input-wrap">
                    <input type="password" id="passInput"
                           name="password" placeholder="Masukkan password"
                           autocomplete="current-password" required>
                    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    <button type="button" class="eye-btn" id="eyeBtn" title="Tampilkan password">
                        <svg id="eyeIcon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-masuk">Masuk Sekarang →</button>

        </form>

        <!-- SIGN UP LINK (menggantikan role badges) -->
        <div class="signup-link">
            Belum punya akun? <a href="signup.php">Daftar di sini</a>
        </div>

    </div>

    <!-- BOTTOM NOTE -->
    <div class="bottom-note">
        © <?= date('Y') ?> <strong>Toko Kue Fanda</strong> · Fresh Baked Daily, Made With Love ❤️
    </div>

</div>

<script>
/* ── CURSOR ── */
const cur=document.getElementById('cur'),curR=document.getElementById('cur-r');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY;cur.style.left=mx+'px';cur.style.top=my+'px';});
(function loop(){rx+=(mx-rx)*.1;ry+=(my-ry)*.1;curR.style.left=rx+'px';curR.style.top=ry+'px';requestAnimationFrame(loop);})();
document.querySelectorAll('a,button,input').forEach(el=>{
    el.addEventListener('mouseenter',()=>document.body.classList.add('h'));
    el.addEventListener('mouseleave',()=>document.body.classList.remove('h'));
});

/* ── SHOW/HIDE PASSWORD ── */
const passInput = document.getElementById('passInput');
const eyeBtn    = document.getElementById('eyeBtn');
const eyeIcon   = document.getElementById('eyeIcon');
let showPass = false;
eyeBtn.addEventListener('click', () => {
    showPass = !showPass;
    passInput.type = showPass ? 'text' : 'password';
    eyeIcon.innerHTML = showPass
        ? '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
});

/* ── RIPPLE EFFECT TOMBOL ── */
document.querySelector('.btn-masuk').addEventListener('click', function(e){
    const r = document.createElement('span');
    const rect = this.getBoundingClientRect();
    r.style.cssText = `position:absolute;border-radius:50%;background:rgba(255,255,255,.25);width:10px;height:10px;left:${e.clientX-rect.left-5}px;top:${e.clientY-rect.top-5}px;transform:scale(0);animation:ripple .5s ease-out forwards;pointer-events:none`;
    this.appendChild(r);
    setTimeout(()=>r.remove(),500);
});
const style=document.createElement('style');
style.textContent='@keyframes ripple{to{transform:scale(20);opacity:0}}';
document.head.appendChild(style);
</script>
</body>
</html>
