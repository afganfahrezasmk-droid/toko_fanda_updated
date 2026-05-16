<?php
// ============================================================
//  Toko Kue Fanda — Homepage Pelanggan
//  Aesthetic: French Patisserie × Editorial Luxury
// ============================================================
$store_name   = "Toko Kue Fanda";
$current_year = date('Y');

$nav_links = [
    ['label' => 'Beranda',     'href' => '#'],
    ['label' => 'Menu',        'href' => '#menu'],
    ['label' => 'Kontak',      'href' => '#footer'],
    ['label' => 'Tentang Kami','href' => '#tentang'],
];

// Kategori sesuai tabel `kategori` di database
$categories = [
    ['name' => 'Semua',           'count' => '7+', 'photo' => '../gambar/nastar.jpeg'],
    ['name' => 'Kue Kering',      'count' => '3',  'photo' => '../gambar/kastangel.jpeg'],
    ['name' => 'Kue Basah',       'count' => '4',  'photo' => '../gambar/brownis.jpeg'],
    ['name' => 'Cookies',         'count' => '3',  'photo' => '../gambar/chocolate_butter.jpeg'],
    ['name' => 'Cake & Brownies', 'count' => '1',  'photo' => '../gambar/brownis.jpeg'],
    ['name' => 'Snack Manis',     'count' => '2',  'photo' => '../gambar/strawberry_thumb.jpeg'],
];

// Produk sesuai tabel `produk` di database
$products = [
    [
        'cat'   => 'KUE KERING',
        'name'  => 'Nastar Klasik',
        'desc'  => 'Kue nastar lembut dengan isian selai nanas premium',
        'price' => '85.000',
        'stok'  => 47,
        'photo' => '../gambar/nastar.jpeg',
    ],
    [
        'cat'   => 'KUE KERING',
        'name'  => 'Kastengel Keju',
        'desc'  => 'Kue kastengel gurih dengan keju edam dan cheddar',
        'price' => '60.000',
        'stok'  => 38,
        'photo' => '../gambar/kastangel.jpeg',
    ],
    [
        'cat'   => 'KUE KERING',
        'name'  => 'Putri Salju',
        'desc'  => 'Kue lembut dengan taburan gula halus seperti salju',
        'price' => '80.000',
        'stok'  => 40,
        'photo' => '../gambar/putri_salju.jpeg',
    ],
    [
        'cat'   => 'KUE BASAH',
        'name'  => 'Chocolate Butter Cookies',
        'desc'  => 'Cookies butter lembut dengan rasa coklat yang rich dan aroma khas mentega',
        'price' => '70.000',
        'stok'  => 53,
        'photo' => '../gambar/chocolate_butter.jpeg',
    ],
    [
        'cat'   => 'KUE BASAH',
        'name'  => 'Brownies Panggang',
        'desc'  => 'Brownies lembut dengan rasa coklat pekat',
        'price' => '95.000',
        'stok'  => 29,
        'photo' => '../gambar/brownis.jpeg',
    ],
    [
        'cat'   => 'KUE BASAH',
        'name'  => 'Palm Cheese Cookies',
        'desc'  => 'Cookies lembut dengan perpaduan rasa manis gula palm dan gurih keju',
        'price' => '75.000',
        'stok'  => 49,
        'photo' => '../gambar/palm_cheese.jpeg',
    ],
    [
        'cat'   => 'KUE BASAH',
        'name'  => 'Strawberry Thumb',
        'desc'  => 'Cookies dengan isian selai stroberi di tengah, rasa manis dan sedikit asam segar',
        'price' => '72.000',
        'stok'  => 52,
        'photo' => '../gambar/strawberry_thumb.jpeg',
    ],
];

$testimonials = [
    ['text'=>'Nastar Klasiknya lembut banget, isian nanasnya pas dan tidak terlalu manis. Udah langganan tiap minggu, gak pernah kecewa!',   'name'=>'Niny',    'role'=>'Pelanggan Setia',   'stars'=>5],
    ['text'=>'Brownies Panggangnya juara! Teksturnya fudgy dan coklatnya pekat banget. Cocok buat oleh-oleh atau hadiah ulang tahun.',        'name'=>'Agan',    'role'=>'Food Enthusiast',   'stars'=>5],
    ['text'=>'Kastengel Kejunya enak parah, gurih dan renyah. Packaging cantik, pengiriman cepat dan aman. My go-to untuk kue premium!',      'name'=>'Ayuna',   'role'=>'Pelanggan Setia',   'stars'=>5],
];

$ticker_raw = ['Fresh Baked Daily','Premium Quality','Pengiriman ke Seluruh Wilayah','Rating 4.9 Bintang','Dipanggang Dengan Cinta'];
$ticker_items = array_merge($ticker_raw,$ticker_raw,$ticker_raw,$ticker_raw);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($store_name) ?> — Freshly Baked, Made With Love</title>
    <meta name="description" content="Nikmati aneka kue premium buatan tangan yang dibuat segar setiap hari di Semarang.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

    <style>
    :root {
        --cream:      #F8F1E5;
        --cream-2:    #EFE3CE;
        --cream-3:    #E4D2B8;
        --espresso:   #1C0A00;
        --espresso-2: #2D1507;
        --caramel:    #C07D3A;
        --caramel-lt: #D4993F;
        --gold:       #E8B86D;
        --brown:      #6B3E26;
        --muted:      #9B8A7A;
        --muted-2:    #C4B5A5;
        --white:      #FFFCF7;
        --r-lg:       24px;
        --r-sm:       12px;
        --r-pill:     100px;
        --shadow:     0 20px 60px rgba(28,10,0,.12);
        --shadow-xl:  0 30px 80px rgba(28,10,0,.20);
        --ease:       cubic-bezier(.25,.46,.45,.94);
        --dur:        .4s;
    }

    *,*::before,*::after { margin:0;padding:0;box-sizing:border-box; }
    html { scroll-behavior:smooth;font-size:16px; }
    body { font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--espresso);overflow-x:hidden;cursor:none; }
    img  { display:block;max-width:100%;height:auto; }
    a    { text-decoration:none; }
    ul   { list-style:none; }
    button { font-family:inherit;cursor:none;border:none; }

    body::before {
        content:'';
        position:fixed;inset:0;
        z-index:9998;
        pointer-events:none;
        opacity:.04;
        background-image:
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)'/%3E%3C/svg%3E");
        background-size:220px 220px;
    }

    #cur-dot {
        position:fixed;width:10px;height:10px;
        background:var(--caramel);border-radius:50%;
        pointer-events:none;z-index:10000;
        transform:translate(-50%,-50%);
        transition:width .25s var(--ease),height .25s var(--ease);
        mix-blend-mode:multiply;
    }
    #cur-ring {
        position:fixed;width:38px;height:38px;
        border:1.5px solid var(--caramel);border-radius:50%;
        pointer-events:none;z-index:9999;
        transform:translate(-50%,-50%);
        opacity:.55;
        transition:width .3s var(--ease),height .3s var(--ease),opacity .3s;
    }
    body.c-hover #cur-dot  { width:16px;height:16px; }
    body.c-hover #cur-ring { width:58px;height:58px;opacity:.25; }

    ::-webkit-scrollbar           { width:5px; }
    ::-webkit-scrollbar-track     { background:var(--cream); }
    ::-webkit-scrollbar-thumb     { background:var(--caramel);border-radius:3px; }

    /* NAVBAR */
    .nav {
        position:fixed;top:0;left:0;right:0;z-index:900;
        padding:22px 64px;
        display:flex;align-items:center;justify-content:space-between;
        transition:padding var(--dur) var(--ease), background var(--dur) var(--ease), box-shadow var(--dur) var(--ease);
    }
    .nav.stuck {
        padding:13px 64px;
        background:rgba(248,241,229,.92);
        backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
        box-shadow:0 1px 0 rgba(28,10,0,.07);
    }
    .nav-logo {
        font-family:'Cormorant Garamond',serif;
        font-size:1.5rem;font-weight:700;letter-spacing:-.02em;
        color:var(--espresso);
    }
    .nav-logo em { color:var(--caramel);font-style:italic; }

    .nav-center { display:flex;gap:36px; }
    .nav-center a {
        font-size:.85rem;font-weight:400;letter-spacing:.025em;
        color:var(--espresso);opacity:.6;
        position:relative;transition:opacity var(--dur);
    }
    .nav-center a::after {
        content:'';position:absolute;bottom:-2px;left:0;
        width:0;height:1px;background:var(--caramel);
        transition:width var(--dur) var(--ease);
    }
    .nav-center a:hover { opacity:1; }
    .nav-center a:hover::after { width:100%; }

    .nav-right { display:flex;align-items:center;gap:10px; }
    .nav-icon-btn {
        width:40px;height:40px;border-radius:50%;
        border:1.5px solid rgba(28,10,0,.14);
        background:transparent;
        display:flex;align-items:center;justify-content:center;
        transition:background var(--dur),border-color var(--dur);
        position:relative;
    }
    .nav-icon-btn:hover { background:var(--espresso);border-color:var(--espresso); }
    .nav-icon-btn:hover svg { stroke:var(--white); }
    .nav-icon-btn svg { width:18px;height:18px;stroke:var(--espresso);fill:none;stroke-width:1.6;transition:stroke var(--dur); }
    .cart-badge {
        position:absolute;top:-4px;right:-4px;
        width:17px;height:17px;border-radius:50%;
        background:var(--caramel);color:#fff;
        font-size:.6rem;font-weight:600;
        display:flex;align-items:center;justify-content:center;
    }
    .btn-keluar {
        padding:11px 26px;border-radius:var(--r-pill);
        background:var(--espresso);color:var(--white);
        font-size:.85rem;font-weight:500;letter-spacing:.02em;
        border:2px solid var(--espresso);
        transition:background var(--dur),color var(--dur),transform .2s;
    }
    .btn-keluar:hover { background:var(--caramel);border-color:var(--caramel);transform:translateY(-1px); }

    /* HERO */
    .hero {
        min-height:100vh;
        display:grid;grid-template-columns:55% 45%;
        align-items:center;
        padding:130px 64px 80px;
        position:relative;overflow:hidden;gap:0;
    }
    .hero::before,.hero::after {
        content:'';position:absolute;border-radius:50%;pointer-events:none;
    }
    .hero::before {
        width:700px;height:700px;
        top:-200px;right:-150px;
        background:radial-gradient(circle,rgba(193,125,58,.13) 0%,transparent 65%);
    }
    .hero::after {
        width:400px;height:400px;
        bottom:-60px;left:120px;
        background:radial-gradient(circle,rgba(193,125,58,.08) 0%,transparent 65%);
    }
    .hero-ghost {
        position:absolute;
        bottom:20px;right:-20px;
        font-family:'Cormorant Garamond',serif;
        font-size:clamp(100px,18vw,240px);
        font-weight:700;letter-spacing:-.05em;line-height:1;
        color:transparent;
        -webkit-text-stroke:1.5px rgba(28,10,0,.055);
        pointer-events:none;user-select:none;
        animation:ghostDrift 12s ease-in-out infinite alternate;
    }
    @keyframes ghostDrift { from{transform:translateY(0)} to{transform:translateY(-14px)} }

    .hero-left { position:relative;z-index:2; }
    .hero-badge {
        display:inline-flex;align-items:center;gap:9px;
        background:var(--espresso);color:var(--gold);
        font-size:.68rem;font-weight:500;letter-spacing:.16em;text-transform:uppercase;
        padding:8px 18px;border-radius:var(--r-pill);
        margin-bottom:30px;
        opacity:0;animation:fadeUp .7s .2s ease forwards;
    }
    .hero-badge i {
        width:6px;height:6px;background:var(--gold);border-radius:50%;
        animation:blink 2s infinite;
    }
    @keyframes blink { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(1.5)} }

    .hero-h1 {
        font-family:'Cormorant Garamond',serif;
        font-size:clamp(46px,5.5vw,88px);
        font-weight:600;line-height:1.04;letter-spacing:-.03em;
        color:var(--espresso);margin-bottom:22px;
    }
    .hero-h1 em { font-style:italic;color:var(--caramel);display:block; }
    .word-wrap { overflow:hidden;display:inline-block; }
    .word {
        display:inline-block;
        opacity:0;transform:translateY(105%);
        animation:wordReveal .75s var(--ease) forwards;
    }
    .w0{animation-delay:.35s}.w1{animation-delay:.45s}
    .w2{animation-delay:.52s}.w3{animation-delay:.60s}.w4{animation-delay:.68s}
    @keyframes wordReveal { to{opacity:1;transform:translateY(0)} }

    .hero-desc {
        font-size:.97rem;line-height:1.75;color:var(--muted);
        max-width:420px;margin-bottom:38px;
        opacity:0;animation:fadeUp .7s .95s ease forwards;
    }
    .hero-cta {
        display:flex;gap:14px;align-items:center;
        opacity:0;animation:fadeUp .7s 1.05s ease forwards;
    }
    .btn-fill {
        display:inline-flex;align-items:center;gap:10px;
        padding:15px 36px;border-radius:var(--r-pill);
        background:var(--espresso);color:var(--white);
        font-size:.9rem;font-weight:500;letter-spacing:.02em;
        border:2px solid var(--espresso);
        position:relative;overflow:hidden;transition:color var(--dur);
    }
    .btn-fill::before {
        content:'';position:absolute;inset:0;
        background:var(--caramel);
        transform:translateX(-100%);
        transition:transform .4s var(--ease);
    }
    .btn-fill:hover::before { transform:translateX(0); }
    .btn-fill span,.btn-fill svg { position:relative;z-index:1; }
    .btn-fill svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;transition:transform .3s; }
    .btn-fill:hover svg { transform:translateX(4px); }

    .btn-outline {
        display:inline-flex;align-items:center;gap:8px;
        padding:15px 28px;border-radius:var(--r-pill);
        background:transparent;color:var(--espresso);
        font-size:.9rem;font-weight:500;letter-spacing:.02em;
        border:2px solid rgba(28,10,0,.18);
        transition:border-color var(--dur),background var(--dur);
    }
    .btn-outline:hover { border-color:var(--espresso);background:rgba(28,10,0,.04); }

    .hero-stats {
        display:flex;gap:40px;
        margin-top:56px;padding-top:38px;
        border-top:1px solid rgba(28,10,0,.1);
        opacity:0;animation:fadeUp .7s 1.15s ease forwards;
    }
    .stat { display:flex;flex-direction:column; }
    .stat-n {
        font-family:'Cormorant Garamond',serif;
        font-size:2.25rem;font-weight:700;line-height:1;
        letter-spacing:-.03em;color:var(--espresso);
    }
    .stat-n sup { color:var(--caramel);font-size:1.4rem; }
    .stat-l { font-size:.72rem;color:var(--muted);margin-top:5px;font-weight:400; }

    .hero-right {
        position:relative;z-index:2;
        display:flex;justify-content:center;align-items:center;
    }
    .img-frame {
        position:relative;
        width:clamp(300px,38vw,460px);height:clamp(300px,38vw,460px);
        opacity:0;animation:popIn 1s .55s var(--ease) forwards;
    }
    @keyframes popIn { from{opacity:0;transform:scale(.88)} to{opacity:1;transform:scale(1)} }

    .ring-a,.ring-b { position:absolute;border-radius:50%;pointer-events:none; }
    .ring-a {
        inset:-22px;
        border:1.5px dashed rgba(193,125,58,.45);
        animation:spin 32s linear infinite;
    }
    .ring-b {
        inset:-42px;
        border:1px solid rgba(193,125,58,.15);
        animation:spin 22s linear infinite reverse;
    }
    @keyframes spin { to{transform:rotate(360deg)} }
    .ring-a::before,.ring-a::after {
        content:'';position:absolute;
        width:9px;height:9px;background:var(--caramel);border-radius:50%;
    }
    .ring-a::before { top:-4.5px;left:calc(50% - 4.5px); }
    .ring-a::after  { bottom:-4.5px;left:calc(50% - 4.5px); }
    .img-frame img { width:100%;height:100%;object-fit:cover;border-radius:50%; }

    .float-card {
        position:absolute;
        background:var(--white);border-radius:var(--r-lg);
        padding:14px 18px;box-shadow:var(--shadow);
        display:flex;align-items:center;gap:12px;
        animation:floatY 5s ease-in-out infinite;
    }
    .float-card.fc-1 { bottom:30px;left:-44px;animation-delay:0s; }
    .float-card.fc-2 { top:50px;right:-48px;animation-delay:2.5s; }
    @keyframes floatY { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
    .fc-icon { font-size:1.6rem;line-height:1; }
    .fc-body { display:flex;flex-direction:column; }
    .fc-val {
        font-family:'Cormorant Garamond',serif;
        font-size:1.15rem;font-weight:700;
        color:var(--espresso);line-height:1;
    }
    .fc-lbl { font-size:.68rem;color:var(--muted);margin-top:3px; }

    @keyframes fadeUp { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }

    /* TICKER */
    .ticker {
        background:var(--espresso-2);
        padding:13px 0;overflow:hidden;display:flex;
        border-top:1px solid rgba(255,252,247,.06);
    }
    .ticker-track {
        display:flex;gap:0;width:max-content;
        animation:marquee 28s linear infinite;
    }
    .ticker-track:hover { animation-play-state:paused; }
    @keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }
    .ticker-item {
        display:flex;align-items:center;gap:20px;
        white-space:nowrap;padding:0 20px;
        color:var(--gold);
        font-size:.72rem;font-weight:400;letter-spacing:.1em;text-transform:uppercase;
    }
    .ticker-gem { width:4px;height:4px;background:var(--caramel);border-radius:50%;flex-shrink:0; }

    /* SECTION SHARED */
    .section-tag {
        display:block;
        font-size:.68rem;font-weight:500;letter-spacing:.22em;text-transform:uppercase;
        color:var(--caramel);margin-bottom:10px;
    }
    .section-title {
        font-family:'Cormorant Garamond',serif;
        font-size:clamp(34px,4.5vw,58px);
        font-weight:600;letter-spacing:-.025em;line-height:1.08;
        color:var(--espresso);
    }

    /* CATEGORIES */
    .cat-section { padding:80px 0 60px; }
    .cat-head { padding:0 64px 36px; }
    .cat-track {
        display:flex;gap:16px;
        padding:4px 64px 24px;
        overflow-x:auto;scroll-snap-type:x mandatory;
        -ms-overflow-style:none;scrollbar-width:none;
    }
    .cat-track::-webkit-scrollbar { display:none; }
    .cat-card {
        flex-shrink:0;width:155px;height:205px;
        border-radius:var(--r-lg);overflow:hidden;
        position:relative;scroll-snap-align:start;
        cursor:none;transition:transform .35s var(--ease),box-shadow .35s var(--ease);
        border:2px solid transparent;
    }
    .cat-card.is-active {
        border-color:var(--caramel);
        box-shadow:0 0 0 4px rgba(193,125,58,.15);
    }
    .cat-card:hover { transform:translateY(-5px);box-shadow:var(--shadow); }
    .cat-card img {
        width:100%;height:100%;object-fit:cover;
        transition:transform .55s var(--ease);
    }
    .cat-card:hover img { transform:scale(1.1); }
    .cat-card::after {
        content:'';position:absolute;inset:0;
        background:linear-gradient(to top,rgba(28,10,0,.78) 0%,rgba(28,10,0,.08) 55%,transparent 100%);
    }
    .cat-label {
        position:absolute;bottom:0;left:0;right:0;z-index:1;
        padding:18px 14px 16px;color:#fff;
    }
    .cat-lname {
        font-family:'Cormorant Garamond',serif;
        font-size:1.18rem;font-weight:600;display:block;line-height:1.2;
    }
    .is-active .cat-lname { color:var(--gold); }
    .cat-lcount { font-size:.68rem;opacity:.65;margin-top:2px;display:block; }

    /* STOK BADGE */
    .stok-badge {
        position:absolute;top:14px;right:14px;z-index:2;
        font-size:.6rem;font-weight:500;letter-spacing:.1em;text-transform:uppercase;
        padding:4px 11px;border-radius:var(--r-pill);
    }
    .stok-aman  { background:rgba(255,252,247,.9);color:var(--espresso); }
    .stok-tipis { background:rgba(255,190,100,.9);color:var(--espresso-2); }
    .stok-habis { background:rgba(200,60,60,.9);color:#fff; }

    /* MENU / PRODUCTS */
    .menu-section { padding:80px 64px 100px;background:var(--white); }
    .menu-head {
        display:flex;align-items:flex-end;justify-content:space-between;
        margin-bottom:46px;
    }
    .see-all {
        display:flex;align-items:center;gap:7px;
        color:var(--caramel);font-size:.85rem;font-weight:500;letter-spacing:.02em;
        transition:gap .3s;
    }
    .see-all:hover { gap:12px; }
    .see-all svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2; }

    .products-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:22px; }

    .p-card {
        border-radius:var(--r-lg);overflow:hidden;
        background:var(--white);
        border:1px solid rgba(28,10,0,.07);
        transition:box-shadow .4s var(--ease),transform .4s var(--ease);
        cursor:none;
        opacity:0;transform:translateY(34px);
    }
    .p-card.show { animation:cardIn .65s var(--ease) forwards; }
    .p-card:nth-child(2).show { animation-delay:.1s; }
    .p-card:nth-child(3).show { animation-delay:.2s; }
    .p-card:nth-child(4).show { animation-delay:.05s; }
    .p-card:nth-child(5).show { animation-delay:.15s; }
    .p-card:nth-child(6).show { animation-delay:.25s; }
    .p-card:nth-child(7).show { animation-delay:.3s; }
    @keyframes cardIn { to{opacity:1;transform:translateY(0)} }
    .p-card:hover { box-shadow:var(--shadow-xl);transform:translateY(-6px); }

    .p-img-wrap { position:relative;aspect-ratio:4/3;overflow:hidden; }
    .p-img-wrap img {
        width:100%;height:100%;object-fit:cover;
        transition:transform .6s var(--ease);
    }
    .p-card:hover .p-img-wrap img { transform:scale(1.09); }

    .p-badge {
        position:absolute;top:14px;left:14px;z-index:1;
        background:var(--espresso);color:var(--gold);
        font-size:.58rem;font-weight:500;letter-spacing:.16em;text-transform:uppercase;
        padding:5px 13px;border-radius:var(--r-pill);
    }

    .p-overlay {
        position:absolute;inset:0;z-index:2;
        background:rgba(28,10,0,.35);
        display:flex;align-items:center;justify-content:center;
        opacity:0;transition:opacity .35s;
        backdrop-filter:blur(2px);
    }
    .p-card:hover .p-overlay { opacity:1; }
    .p-overlay-btn {
        display:inline-flex;align-items:center;gap:8px;
        padding:12px 24px;border-radius:var(--r-pill);
        background:var(--white);color:var(--espresso);
        font-size:.82rem;font-weight:500;
        border:none;cursor:none;
        transform:translateY(10px);transition:transform .35s var(--ease) .05s;
    }
    .p-card:hover .p-overlay-btn { transform:translateY(0); }
    .p-overlay-btn svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2; }

    .p-body { padding:22px 22px 20px; }
    .p-name {
        font-family:'Cormorant Garamond',serif;
        font-size:1.3rem;font-weight:600;letter-spacing:-.01em;line-height:1.2;
        color:var(--espresso);margin-bottom:7px;
    }
    .p-desc { font-size:.8rem;line-height:1.65;color:var(--muted);margin-bottom:18px; }
    .p-foot { display:flex;align-items:center;justify-content:space-between; }
    .p-price { display:flex;align-items:center;gap:7px; }
    .price-dot {
        width:20px;height:20px;border-radius:50%;
        background:var(--caramel);
        display:flex;align-items:center;justify-content:center;flex-shrink:0;
    }
    .price-dot svg { width:10px;height:10px;stroke:#fff;fill:none;stroke-width:2; }
    .p-price-val {
        font-family:'Cormorant Garamond',serif;
        font-size:1.1rem;font-weight:700;color:var(--espresso);
    }
    .btn-add {
        width:36px;height:36px;border-radius:50%;
        background:var(--espresso);
        display:flex;align-items:center;justify-content:center;
        transition:background .3s,transform .4s var(--ease);
    }
    .btn-add:hover { background:var(--caramel);transform:rotate(90deg) scale(1.1); }
    .btn-add svg { width:15px;height:15px;stroke:#fff;fill:none;stroke-width:2.5; }

    /* PROMO */
    .promo-wrap { padding:0 64px; }
    .promo {
        border-radius:var(--r-lg);
        background:var(--espresso-2);overflow:hidden;
        display:grid;grid-template-columns:1fr 1fr;
        min-height:460px;position:relative;
    }
    .promo::before {
        content:'';position:absolute;
        width:500px;height:500px;border-radius:50%;
        top:-160px;left:-120px;
        background:radial-gradient(circle,rgba(193,125,58,.18) 0%,transparent 65%);
        pointer-events:none;
    }
    .promo-left {
        padding:64px 56px;
        display:flex;flex-direction:column;justify-content:center;
        position:relative;z-index:2;
    }
    .promo-tag-line {
        display:flex;align-items:center;gap:10px;
        font-size:.68rem;font-weight:500;letter-spacing:.2em;text-transform:uppercase;
        color:var(--caramel);margin-bottom:16px;
    }
    .promo-tag-line::before { content:'';display:block;width:22px;height:1px;background:var(--caramel); }
    .promo-h {
        font-family:'Cormorant Garamond',serif;
        font-size:clamp(38px,4.5vw,68px);font-weight:700;line-height:1.05;
        letter-spacing:-.03em;color:var(--white);margin-bottom:14px;
    }
    .promo-h em { color:var(--gold);font-style:italic; }
    .promo-body {
        font-size:.875rem;line-height:1.75;
        color:rgba(255,252,247,.48);max-width:360px;margin-bottom:38px;
    }
    .btn-promo {
        display:inline-flex;align-items:center;gap:12px;
        padding:15px 36px;border-radius:var(--r-pill);
        background:var(--white);color:var(--espresso);
        font-size:.875rem;font-weight:500;width:fit-content;
        border:2px solid var(--white);cursor:none;
        transition:background .3s,color .3s;
    }
    .btn-promo:hover { background:transparent;color:var(--white); }
    .btn-promo svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;transition:transform .3s; }
    .btn-promo:hover svg { transform:translateX(5px); }
    .promo-right { position:relative;overflow:hidden; }
    .promo-imgs { position:absolute;inset:0;display:grid;grid-template-rows:1fr 1fr;gap:3px; }
    .promo-imgs img { width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease); }
    .promo:hover .promo-imgs img { transform:scale(1.06); }

    /* TESTIMONIALS */
    .testi-section { padding:100px 64px; }
    .testi-head {
        display:flex;align-items:flex-end;justify-content:space-between;
        margin-bottom:48px;
    }
    .testi-meta { text-align:right; }
    .testi-stars { display:flex;gap:3px;justify-content:flex-end;margin-bottom:4px; }
    .testi-stars span { color:var(--gold);font-size:1.1rem; }
    .testi-num {
        font-family:'Cormorant Garamond',serif;
        font-size:2.1rem;font-weight:700;line-height:1;color:var(--espresso);
    }
    .testi-total { font-size:.75rem;color:var(--muted); }
    .testi-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:18px; }
    .t-card {
        background:var(--white);border-radius:var(--r-lg);
        padding:34px 30px;
        border:1px solid transparent;
        transition:border-color .35s,box-shadow .35s,transform .35s;
        cursor:none;
        opacity:0;transform:translateY(24px);
    }
    .t-card.show { animation:cardIn .6s var(--ease) forwards; }
    .t-card:nth-child(2).show { animation-delay:.1s; }
    .t-card:nth-child(3).show { animation-delay:.2s; }
    .t-card:hover { border-color:var(--cream-3);box-shadow:0 20px 50px rgba(28,10,0,.08);transform:translateY(-4px); }
    .t-quote {
        font-family:'Cormorant Garamond',serif;
        font-size:4.5rem;line-height:.7;
        color:var(--caramel);opacity:.28;margin-bottom:10px;
    }
    .t-text {
        font-size:.865rem;line-height:1.8;
        color:var(--espresso);opacity:.78;margin-bottom:22px;
    }
    .t-author { display:flex;align-items:center;gap:11px; }
    .t-avatar {
        width:44px;height:44px;border-radius:50%;
        background:var(--cream-3);flex-shrink:0;
        display:flex;align-items:center;justify-content:center;
        font-family:'Cormorant Garamond',serif;
        font-size:1.1rem;font-weight:700;color:var(--brown);
    }
    .t-name { font-size:.85rem;font-weight:500;color:var(--espresso); }
    .t-role { font-size:.72rem;color:var(--muted);margin-top:2px; }
    .t-stars { margin-left:auto;display:flex;gap:2px; }
    .t-stars span { font-size:.65rem;color:var(--gold); }

    /* FOOTER */
    footer {
        background:var(--espresso-2);
        padding:76px 64px 38px;
        border-top:1px solid rgba(255,252,247,.05);
    }
    .footer-grid {
        display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;
        gap:56px;margin-bottom:56px;padding-bottom:52px;
        border-bottom:1px solid rgba(255,252,247,.09);
    }
    .f-logo {
        font-family:'Cormorant Garamond',serif;
        font-size:1.6rem;font-weight:700;letter-spacing:-.02em;
        color:var(--white);display:block;margin-bottom:14px;
    }
    .f-logo em { color:var(--caramel);font-style:italic; }
    .f-desc {
        font-size:.845rem;line-height:1.75;
        color:rgba(255,252,247,.4);max-width:230px;margin-bottom:22px;
    }
    .f-social { display:flex;gap:10px; }
    .f-soc-btn {
        width:36px;height:36px;border-radius:50%;
        border:1.5px solid rgba(255,252,247,.14);
        display:flex;align-items:center;justify-content:center;
        transition:background .3s,border-color .3s;cursor:none;
    }
    .f-soc-btn:hover { background:var(--caramel);border-color:var(--caramel); }
    .f-soc-btn svg { width:15px;height:15px;stroke:rgba(255,252,247,.65);fill:none;stroke-width:1.6;transition:stroke .3s; }
    .f-soc-btn:hover svg { stroke:#fff; }
    .f-col-title { font-size:.85rem;font-weight:500;color:var(--white);margin-bottom:18px; }
    .f-links { display:flex;flex-direction:column;gap:9px; }
    .f-links a {
        font-size:.8rem;color:rgba(255,252,247,.4);
        transition:color .3s,padding-left .3s;cursor:none;
    }
    .f-links a:hover { color:var(--gold);padding-left:4px; }
    .footer-bottom { display:flex;align-items:center;justify-content:space-between; }
    .f-copy { font-size:.78rem;color:rgba(255,252,247,.28); }
    .f-copy strong { color:var(--caramel);font-weight:500; }

    .reveal-ready { opacity:0;transform:translateY(28px);transition:opacity .6s var(--ease),transform .6s var(--ease); }
    .reveal-ready.revealed { opacity:1;transform:translateY(0); }

    @media(max-width:960px){
        .hero        { grid-template-columns:1fr;padding:110px 28px 70px;gap:50px;text-align:center; }
        .hero-right  { order:-1;justify-content:center; }
        .img-frame   { width:280px;height:280px; }
        .float-card  { display:none; }
        .hero-cta    { justify-content:center; }
        .hero-stats  { justify-content:center; }
        .hero-desc   { margin:0 auto 38px; }
        .nav         { padding:14px 22px; }
        .nav-center  { display:none; }
        .nav.stuck   { padding:12px 22px; }
        .cat-head, .menu-head { padding-left:22px;padding-right:22px; }
        .cat-track  { padding-left:22px;padding-right:22px; }
        .menu-section { padding:60px 22px 80px; }
        .products-grid { grid-template-columns:1fr; }
        .testi-section { padding:70px 22px; }
        .testi-grid { grid-template-columns:1fr; }
        .promo-wrap { padding:0 22px; }
        .promo      { grid-template-columns:1fr; }
        .promo-right { height:220px; }
        .promo-left { padding:44px 30px; }
        footer      { padding:56px 22px 30px; }
        .footer-grid { grid-template-columns:1fr 1fr;gap:36px; }
        .footer-bottom { flex-direction:column;gap:8px;text-align:center; }
    }
    </style>
</head>
<body>

<div id="cur-dot"></div>
<div id="cur-ring"></div>

<!-- NAVBAR -->
<nav class="nav" id="mainNav">
    <a href="#" class="nav-logo">Toko Kue <em>Fanda</em></a>
    <ul class="nav-center">
        <?php foreach ($nav_links as $nl): ?>
        <li><a href="<?= htmlspecialchars($nl['href']) ?>"><?= htmlspecialchars($nl['label']) ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="nav-right">
        <button class="nav-icon-btn" title="Keranjang">
            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            <span class="cart-badge">0</span>
        </button>
        <button class="nav-icon-btn" title="Akun">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </button>
        <form method="post" action="../index.php">
        <button class="btn-keluar">Keluar</button>
        </form>
    </div>
</nav>

<!-- HERO -->
<section class="hero" id="beranda">
    <div class="hero-ghost" aria-hidden="true">FANDA</div>
    <div class="hero-left">
        <div class="hero-badge"><i></i> Fresh Baked Daily</div>
        <h1 class="hero-h1">
            <span class="word-wrap"><span class="word w0">Freshly&nbsp;</span></span><span class="word-wrap"><span class="word w1">Baked,</span></span>
            <br>
            <em>
                <span class="word-wrap"><span class="word w2">Made&nbsp;</span></span><span class="word-wrap"><span class="word w3">With&nbsp;</span></span><span class="word-wrap"><span class="word w4">Love</span></span>
            </em>
        </h1>
        <p class="hero-desc">Nikmati aneka kue premium buatan tangan yang dibuat segar setiap hari. Dari Nastar Klasik hingga Brownies Panggang yang bikin nagih.</p>
        <div class="hero-cta">
            <a href="#menu" class="btn-fill">
                <span>Pesan Sekarang</span>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            <a href="#menu" class="btn-outline">Lihat Menu</a>
        </div>
        <div class="hero-stats">
            <div class="stat">
                <span class="stat-n"><span class="ctr" data-to="7">0</span><sup>+</sup></span>
                <span class="stat-l">Menu Pilihan</span>
            </div>
            <div class="stat">
                <span class="stat-n">4.9<sup>★</sup></span>
                <span class="stat-l">Rating Pelanggan</span>
            </div>
            <div class="stat">
                <!-- Total qty dari order_items = 13 item, 4 orders -->
                <span class="stat-n"><span class="ctr" data-to="4">0</span><sup>+</sup></span>
                <span class="stat-l">Pesanan Masuk</span>
            </div>
        </div>
    </div>
    <div class="hero-right">
        <div class="img-frame">
            <div class="ring-a"></div>
            <div class="ring-b"></div>
            <img
                src="../gambar/logo.jpeg"
                alt="Aneka Kue Premium Fanda"
                loading="eager"
            />
            <div class="float-card fc-1">
                <div class="fc-icon">🍪</div>
                <div class="fc-body">
                    <span class="fc-val">Rp 72rb</span>
                    <span class="fc-lbl">Mulai dari</span>
                </div>
            </div>
            <div class="float-card fc-2">
                <div class="fc-icon">🛍️</div>
                <div class="fc-body">
                    <span class="fc-val">Promo</span>
                    <span class="fc-lbl">Min. 3 item</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TICKER -->
<div class="ticker" aria-hidden="true">
    <div class="ticker-track">
        <?php foreach ($ticker_items as $ti): ?>
        <div class="ticker-item">
            <?= htmlspecialchars($ti) ?>
            <span class="ticker-gem"></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- CATEGORIES -->
<section class="cat-section">
    <div class="cat-head">
        <span class="section-tag">Kategori</span>
        <h2 class="section-title">Pilih Favoritmu</h2>
    </div>
    <div class="cat-track" id="catTrack">
        <?php foreach ($categories as $i => $c): ?>
        <div class="cat-card<?= $i === 0 ? ' is-active' : '' ?>" onclick="setActive(this)">
            <img
                src="<?= htmlspecialchars($c['photo']) ?>"
                alt="<?= htmlspecialchars($c['name']) ?>"
                loading="lazy"
            />
            <div class="cat-label">
                <span class="cat-lname"><?= htmlspecialchars($c['name']) ?></span>
                <span class="cat-lcount"><?= $c['count'] ?> produk</span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- MENU / PRODUCTS -->
<section class="menu-section" id="menu">
    <div class="menu-head">
        <div>
            <span class="section-tag">Menu Kami</span>
            <h2 class="section-title">Semua Menu</h2>
        </div>
        <a href="#" class="see-all">
            Lihat Semua
            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>

    <div class="products-grid" id="productsGrid">
        <?php foreach ($products as $p):
            // Tentukan badge stok
            if ($p['stok'] <= 0) {
                $stok_class = 'stok-habis'; $stok_label = 'Habis';
            } elseif ($p['stok'] <= 10) {
                $stok_class = 'stok-tipis'; $stok_label = 'Stok Tipis';
            } else {
                $stok_class = 'stok-aman'; $stok_label = 'Stok ' . $p['stok'];
            }
        ?>
        <div class="p-card">
            <div class="p-img-wrap">
                <span class="p-badge"><?= htmlspecialchars($p['cat']) ?></span>
                <span class="stok-badge <?= $stok_class ?>"><?= $stok_label ?></span>
                <img
                    src="<?= htmlspecialchars($p['photo']) ?>"
                    alt="<?= htmlspecialchars($p['name']) ?>"
                    loading="lazy"
                />
                <div class="p-overlay">
                    <button class="p-overlay-btn">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>
            <div class="p-body">
                <h3 class="p-name"><?= htmlspecialchars($p['name']) ?></h3>
                <p class="p-desc"><?= htmlspecialchars($p['desc']) ?></p>
                <div class="p-foot">
                    <div class="p-price">
                        <div class="price-dot">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        </div>
                        <span class="p-price-val">Rp <?= htmlspecialchars($p['price']) ?></span>
                    </div>
                    <button class="btn-add" title="Tambah">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- PROMO BANNER -->
<div class="promo-wrap" style="padding-bottom:100px;">
    <div class="promo reveal-ready" id="promoBanner">
        <div class="promo-left">
            <span class="promo-tag-line">Promo Spesial</span>
            <h2 class="promo-h">Beli 3 Item,<br><em>Gratis Ongkir</em></h2>
            <p class="promo-body">Dapatkan gratis ongkos kirim untuk setiap pembelian minimal 3 item. Berlaku setiap hari ke seluruh wilayah Semarang dan sekitarnya.</p>
            <a href="#menu" class="btn-promo">
                Pesan Sekarang
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
        <div class="promo-right">
            <div class="promo-imgs">
                <img src="../gambar/kastangel.jpeg" alt="Nastar Klasik" loading="lazy">
                <img src="../gambar/brownis.jpeg" alt="Brownies Panggang" loading="lazy">
            </div>
        </div>
    </div>
</div>

<!-- TESTIMONIALS -->
<section class="testi-section" id="tentang">
    <div class="testi-head">
        <div>
            <span class="section-tag">Ulasan</span>
            <h2 class="section-title">Kata Mereka</h2>
        </div>
        <div class="testi-meta">
            <div class="testi-stars">
                <?php for ($i=0;$i<5;$i++): ?><span>★</span><?php endfor; ?>
            </div>
            <div class="testi-num">4.9</div>
            <div class="testi-total">dari pelanggan kami</div>
        </div>
    </div>
    <div class="testi-grid">
        <?php foreach ($testimonials as $t): ?>
        <div class="t-card">
            <div class="t-quote">"</div>
            <p class="t-text"><?= htmlspecialchars($t['text']) ?></p>
            <div class="t-author">
                <div class="t-avatar"><?= mb_substr($t['name'], 0, 1) ?></div>
                <div>
                    <div class="t-name"><?= htmlspecialchars($t['name']) ?></div>
                    <div class="t-role"><?= htmlspecialchars($t['role']) ?></div>
                </div>
                <div class="t-stars">
                    <?php for ($i=0;$i<$t['stars'];$i++): ?><span>★</span><?php endfor; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- FOOTER -->
<footer id="footer">
    <div class="footer-grid">
        <div>
            <span class="f-logo">Toko Kue <em>Fanda</em></span>
            <p class="f-desc">Kue premium buatan tangan, dipanggang segar setiap hari dengan bahan-bahan pilihan terbaik. Dikirim langsung ke pintumu.</p>
            <div class="f-social">
                <a href="#" class="f-soc-btn" title="Facebook">
                    <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                </a>
                <a href="#" class="f-soc-btn" title="Instagram">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                </a>
                <a href="#" class="f-soc-btn" title="WhatsApp">
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                </a>
            </div>
        </div>
        <div>
            <h4 class="f-col-title">Menu</h4>
            <ul class="f-links">
                <li><a href="#">Kue Kering</a></li>
                <li><a href="#">Kue Basah</a></li>
                <li><a href="#">Cookies</a></li>
                <li><a href="#">Cake &amp; Brownies</a></li>
                <li><a href="#">Snack Manis</a></li>
            </ul>
        </div>
        <div>
            <h4 class="f-col-title">Info</h4>
            <ul class="f-links">
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Cara Order</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>
        <div>
            <h4 class="f-col-title">Kontak</h4>
            <ul class="f-links">
                <li><a href="#">📍 Semarang, Jawa Tengah</a></li>
                <li><a href="#">📞 +62 812-3456-7890</a></li>
                <li><a href="#">✉️ hello@tokokuefanda.id</a></li>
                <li><a href="#">⏰ Buka Setiap Hari</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <span class="f-copy">© <?= $current_year ?> <strong>Toko Kue Fanda</strong>. All rights reserved.</span>
        <span class="f-copy">Made with ❤️ in Semarang</span>
    </div>
</footer>

<script>
/* Custom Cursor */
const dot  = document.getElementById('cur-dot');
const ring = document.getElementById('cur-ring');
let mx=0,my=0,rx=0,ry=0;

document.addEventListener('mousemove', e => {
    mx = e.clientX; my = e.clientY;
    dot.style.left = mx + 'px';
    dot.style.top  = my + 'px';
});
(function loop(){
    rx += (mx - rx) * .11;
    ry += (my - ry) * .11;
    ring.style.left = rx + 'px';
    ring.style.top  = ry + 'px';
    requestAnimationFrame(loop);
})();

const hoverEls = document.querySelectorAll('a,button,.cat-card,.p-card,.t-card');
hoverEls.forEach(el => {
    el.addEventListener('mouseenter', () => document.body.classList.add('c-hover'));
    el.addEventListener('mouseleave', () => document.body.classList.remove('c-hover'));
});

/* Navbar */
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => {
    nav.classList.toggle('stuck', window.scrollY > 55);
}, {passive:true});

/* Intersection Observer */
const io = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            if (e.target.classList.contains('reveal-ready')) {
                e.target.classList.add('revealed');
            } else {
                e.target.classList.add('show');
            }
            io.unobserve(e.target);
        }
    });
}, { threshold: 0.14 });

document.querySelectorAll('.p-card, .t-card, .reveal-ready').forEach(el => io.observe(el));

/* Counter Animation */
const cio = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (!e.isIntersecting) return;
        e.target.querySelectorAll('.ctr').forEach(el => {
            const target = +el.dataset.to;
            const dur    = 1600;
            const start  = performance.now();
            const tick = now => {
                const t = Math.min((now - start) / dur, 1);
                const eased = 1 - Math.pow(1 - t, 3);
                el.textContent = Math.floor(eased * target);
                if (t < 1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
        });
        cio.unobserve(e.target);
    });
}, { threshold:.5 });

const statsEl = document.querySelector('.hero-stats');
if (statsEl) cio.observe(statsEl);

/* Category Active */
function setActive(el){
    document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('is-active'));
    el.classList.add('is-active');
}

/* Add-to-cart */
document.querySelectorAll('.btn-add, .p-overlay-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        e.stopPropagation();
        btn.style.transform = 'scale(.88)';
        btn.style.background = 'var(--caramel)';
        setTimeout(() => {
            btn.style.transform = '';
            btn.style.background = '';
        }, 300);
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            badge.textContent = +badge.textContent + 1;
            badge.style.transform = 'scale(1.4)';
            setTimeout(() => badge.style.transform = '', 250);
        }
    });
});

/* Parallax */
window.addEventListener('scroll', () => {
    const img = document.querySelector('.img-frame img');
    if (img) {
        const offset = window.scrollY * 0.12;
        img.style.transform = `translateY(${offset}px)`;
    }
}, {passive:true});
</script>
</body>
</html>
