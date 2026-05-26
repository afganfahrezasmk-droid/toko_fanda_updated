<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('KASIR_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

?>

<style>

body{
    background:#f6f7fb;
}

/* HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;
    margin-bottom:35px;
}

.page-title{
    font-size:2rem;
    font-weight:700;
    color:#2d1b10;
    margin-bottom:6px;
}

.page-subtitle{
    color:#777;
    font-size:.95rem;
}

/* BUTTON */
.btn-modern{
    background:#c58a3a;
    color:#fff;
    border:none;
    padding:12px 22px;
    border-radius:14px;
    font-weight:600;
    transition:.25s;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:10px;
}

.btn-modern:hover{
    transform:translateY(-2px);
    opacity:.92;
    color:#fff;
}

/* PRODUK */
.section-title{
    font-size:1.5rem;
    font-weight:700;
    color:#2d1b10;
    margin-bottom:25px;
}

.produk-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(290px,1fr));
    gap:25px;
}

.produk-card{
    background:#fff;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
    border:1px solid #f1f1f1;
    transition:.25s;
}

.produk-card:hover{
    transform:translateY(-6px);
    box-shadow:0 18px 35px rgba(0,0,0,.12);
}

.produk-img{
    width:100%;
    height:230px;
    object-fit:cover;
    background:#fafafa;
}

.produk-body{
    padding:22px;
}

.badge-kategori{
    display:inline-block;
    background:#f8efe1;
    color:#c58a3a;
    padding:7px 14px;
    border-radius:999px;
    font-size:.8rem;
    font-weight:600;
    margin-bottom:14px;
}

.produk-nama{
    font-size:1.15rem;
    font-weight:700;
    color:#2d1b10;
    margin-bottom:10px;
}

.produk-desc{
    color:#777;
    font-size:.92rem;
    line-height:1.6;
    height:48px;
    overflow:hidden;
}

.produk-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:22px;
}

.harga{
    font-size:1.1rem;
    font-weight:700;
    color:#c58a3a;
}

.stok{
    background:#f5f5f5;
    padding:7px 14px;
    border-radius:999px;
    font-size:.82rem;
    color:#666;
}

.created{
    margin-top:16px;
    font-size:.8rem;
    color:#999;
}

</style>

<div class="container py-5">

    <!-- HEADER -->
    <div class="page-header">

        <div>

            <h2 class="page-title">
                🍰 Dashboard Produk
            </h2>

            <div class="page-subtitle">
                Kelola produk toko kue 
            </div>

        </div>

        <a href="order_tambah.php" class="btn-modern">

            <i class="fa fa-cart-shopping"></i>
            Order Produk

        </a>

    </div>

    

    <!-- PRODUK -->
    <div class="section-title">
        🧁 Data Produk
    </div>

    <div class="produk-grid">

        <?php
        $produk = mysqli_query($koneksi,
            "SELECT * FROM produk
             JOIN kategori
             ON produk.kategori_id = kategori.kategori_id
             ORDER BY produk.produk_id DESC");

        while($p = mysqli_fetch_array($produk)){
        ?>

        <div class="produk-card">

            <!-- GAMBAR -->
            <img src="../gambar/<?= $p['gambar']; ?>"
                 class="produk-img"
                 onerror="this.src='../gambar/default.jpeg'">

            <div class="produk-body">

                <!-- KATEGORI -->
                <div class="badge-kategori">

                    <?= $p['nama_kategori']; ?>

                </div>

                <!-- NAMA -->
                <div class="produk-nama">

                    <?= $p['nama_produk']; ?>

                </div>

                <!-- DESKRIPSI -->
                <div class="produk-desc">

                    <?= $p['deskripsi']; ?>

                </div>

                <!-- INFO -->
                <div class="produk-footer">

                    <div class="harga">

                        Rp <?= number_format($p['harga']); ?>

                    </div>

                    <div class="stok">

                        Stok <?= $p['stok']; ?>

                    </div>

                </div>

                <!-- CREATED -->
                <div class="created">

                    Dibuat :
                    <?= $p['created_at']; ?>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

<?php include 'footer.php'; ?>