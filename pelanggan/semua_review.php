<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */

$reviews = mysqli_query($koneksi, "
    SELECT 
        review.*,
        produk.nama_produk
    FROM review
    LEFT JOIN produk ON review.produk_id = produk.produk_id
    ORDER BY review.id_review DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Semua Ulasan — Toko Kue Fanda</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
<style>
:root{
  --esp:#1C0A00;--esp-2:#2D1507;--brown:#4A2510;--car:#C07B3A;
  --gold:#E8B46D;--cream:#F8F2E5;--cream2:#EFE3CE;--blush:#F5CECC;
  --white:#FFFCF7;--muted:#9B7A5A;--pill:100px;
  --es:cubic-bezier(.25,.46,.45,.94);
}
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--esp);overflow-x:hidden}
a{text-decoration:none}

/* PAGE HEADER — kecil, tidak full hero */
.page-header{
  background:var(--esp-2);
  padding:100px 64px 40px;
  display:flex;
  align-items:center;
  gap:24px;
}
.back-btn{
  display:inline-flex;align-items:center;gap:6px;
  padding:9px 20px;border-radius:var(--pill);
  background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);
  color:rgba(255,252,247,.7);font-size:.78rem;font-weight:500;
  transition:all .3s var(--es);white-space:nowrap;flex-shrink:0;
}
.back-btn:hover{background:var(--gold);color:var(--esp);border-color:var(--gold)}
.back-btn svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2.5}

.page-header-text{}
.page-header-text .stag{
  display:block;font-size:.62rem;font-weight:500;
  letter-spacing:.2em;text-transform:uppercase;
  color:var(--gold);margin-bottom:4px;
}
.page-header-text h1{
  font-family:'Kaushan Script',cursive;
  font-size:clamp(28px,4vw,42px);
  color:var(--blush);line-height:1;
}

/* REVIEW SECTION */
.review-section{padding:60px 64px 100px}

.review-grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:24px;
}

.r-card{
  background:var(--white);
  border-radius:20px;
  padding:28px;
  box-shadow:0 4px 20px rgba(74,37,16,.07);
  transition:transform .4s var(--es),box-shadow .4s;
  display:flex;flex-direction:column;gap:14px;
}
.r-card:hover{
  transform:translateY(-5px);
  box-shadow:0 16px 40px rgba(74,37,16,.13);
}

.r-stars{display:flex;gap:2px}
.r-stars span{color:var(--gold);font-size:.9rem}

.r-quote{
  font-family:'Playfair Display',serif;
  font-size:1rem;font-style:italic;
  line-height:1.75;color:var(--esp);flex:1;
}
.r-quote::before{content:'"';font-size:2rem;color:var(--gold);line-height:0;vertical-align:-.4em;margin-right:2px}
.r-quote::after{content:'"';font-size:2rem;color:var(--gold);line-height:0;vertical-align:-.4em;margin-left:2px}

.r-meta{
  display:flex;align-items:center;justify-content:space-between;
  padding-top:14px;border-top:1px solid var(--cream2);
}
.r-name{font-size:.85rem;font-weight:600;color:var(--esp)}
.r-produk{font-size:.72rem;color:var(--muted);margin-top:2px}

.empty{text-align:center;padding:80px 20px;grid-column:1/-1}
.empty p{font-family:'Playfair Display',serif;font-size:1.3rem;font-style:italic;color:var(--muted)}

.add-review-wrap{text-align:center;margin-top:60px}
.add-review-btn{
  display:inline-flex;align-items:center;gap:10px;
  padding:15px 34px;border-radius:var(--pill);
  background:var(--esp);color:var(--white);
  font-size:.88rem;font-weight:500;transition:all .35s var(--es);
}
.add-review-btn:hover{background:var(--car);transform:translateY(-3px)}

@media(max-width:960px){
  .page-header{padding:90px 22px 32px;gap:16px}
  .review-section{padding:40px 22px 80px}
  .review-grid{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:600px){
  .review-grid{grid-template-columns:1fr}
}
</style>
</head>
<body>

<!-- HEADER KECIL dengan tombol kembali di kiri -->
<div class="page-header">
  <a href="javascript:history.back()" class="back-btn">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali
  </a>
  <div class="page-header-text">
    <span class="stag">Dari Pelanggan Kami</span>
    <h1>Semua Ulasan</h1>
  </div>
</div>

<section class="review-section">
  <div class="review-grid">

    <?php if(mysqli_num_rows($reviews) === 0): ?>
    <div class="empty">
      <p>Belum ada ulasan yang ditampilkan.</p>
    </div>
    <?php else: ?>

    <?php while($r = mysqli_fetch_assoc($reviews)): ?>
    <div class="r-card">
      <div class="r-stars">
        <?php for($i=1;$i<=5;$i++): ?>
          <span><?= $i <= $r['rating'] ? '★' : '☆' ?></span>
        <?php endfor; ?>
      </div>
      <p class="r-quote"><?= htmlspecialchars($r['review']) ?></p>
      <div class="r-meta">
        <div>
          <div class="r-name"><?= htmlspecialchars($r['nama_pelanggan']) ?></div>
          <div class="r-produk"><?= htmlspecialchars($r['nama_produk']) ?></div>
        </div>
      </div>
    </div>
    <?php endwhile; ?>

    <?php endif; ?>

  </div>

  <div class="add-review-wrap">
    <a href="review_tambah.php" class="add-review-btn">
      + Bagikan Pengalaman Anda
    </a>
  </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>