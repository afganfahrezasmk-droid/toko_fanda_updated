<?php 
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */
?>

<style>
/* Override layout dari header.php */
.layout-wrapper.no-sidebar {
    background: #1C0A00 !important;
    min-height: 100vh;
}
.main-content.centered-content {
    background:
        radial-gradient(circle at top right, rgba(232,180,109,.08), transparent 30%),
        radial-gradient(circle at bottom left, rgba(245,206,204,.08), transparent 30%),
        #1C0A00 !important;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px !important;
    margin-left: 0 !important;
}

/* DECOR */
.blob{position:absolute;border-radius:50%;filter:blur(80px);opacity:.12;pointer-events:none}
.blob1{width:300px;height:300px;background:#E8B46D;top:80px;left:0}
.blob2{width:260px;height:260px;background:#F5CECC;bottom:80px;right:0}

/* CARD */
.review-box{
    width:100%;max-width:560px;
    background:rgba(255,252,247,.06);
    border:1px solid rgba(255,255,255,.08);
    backdrop-filter:blur(16px);
    border-radius:32px;
    padding:42px;
    box-shadow:0 30px 80px rgba(0,0,0,.35);
    position:relative;z-index:2;
}

.top-label{
    font-family:'Kaushan Script',cursive;
    color:rgba(255,255,255,.35);
    font-size:1.4rem;margin-bottom:10px;
}

.review-box h2{
    font-family:'Playfair Display',serif;
    font-size:2.6rem;line-height:1.1;
    color:#FFFCF7;margin-bottom:14px;
}

.review-desc{
    color:rgba(255,255,255,.5);
    line-height:1.8;font-size:.92rem;margin-bottom:32px;
}

.form-group-rv{margin-bottom:18px}

.input-rv{
    width:100%;padding:16px 18px;
    border-radius:18px;
    border:1px solid rgba(255,255,255,.08);
    background:rgba(255,255,255,.05);
    color:#FFFCF7;font-size:.95rem;
    outline:none;transition:.3s;
    font-family:'DM Sans',sans-serif;
}
.input-rv::placeholder{color:rgba(255,255,255,.35)}
.input-rv:focus{border-color:#E8B46D;background:rgba(255,255,255,.08)}

textarea.input-rv{min-height:130px;resize:none}

select.input-rv{
    appearance:none;-webkit-appearance:none;
    padding-right:55px;
    background:rgba(255,255,255,.05) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='none' stroke='%23E8B46D' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 8 12 14 18 8'/%3E%3C/svg%3E") no-repeat right 18px center;
    cursor:pointer;
}
select.input-rv option{background:#2A1208;color:#F8F2E5}

.back-link{
    display:inline-flex;align-items:center;gap:8px;
    margin-bottom:30px;text-decoration:none;
    color:rgba(255,255,255,.72);font-size:.9rem;font-weight:500;transition:.3s;
}
.back-link:hover{transform:translateX(-4px);color:#E8B46D}

.btn-submit{
    width:100%;border:none;padding:18px;
    border-radius:999px;background:#E8B46D;
    color:#1C0A00;font-weight:700;font-size:.92rem;
    letter-spacing:.08em;text-transform:uppercase;
    cursor:pointer;transition:.35s;font-family:'DM Sans',sans-serif;
}
.btn-submit:hover{transform:translateY(-4px);box-shadow:0 16px 40px rgba(232,180,109,.28)}

.small-note{
    margin-top:16px;text-align:center;
    color:rgba(255,255,255,.35);font-size:.8rem;
}

@media(max-width:700px){
    .review-box{padding:28px;border-radius:24px}
    .review-box h2{font-size:2rem}
}
</style>

<div class="blob blob1"></div>
<div class="blob blob2"></div>

<div class="review-box">

    <a href="javascript:history.back()" class="back-link">← Kembali</a>

    <div class="top-label">Toko Kue Fanda</div>
    <h2>Bagikan Pengalaman Manismu</h2>
    <p class="review-desc">Ceritakan pengalamanmu menikmati kue favorit dari dapur kami ✨</p>

    <form action="review_aksi.php" method="POST">

        <div class="form-group-rv">
            <input type="text" name="nama_pelanggan" class="input-rv"
                placeholder="Nama Anda" required>
        </div>

        <div class="form-group-rv">
            <select name="id_produk" class="input-rv" required>
                <option value="">Pilih Produk Favorit</option>
                <?php
                $produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama_produk ASC");
                while($p = mysqli_fetch_assoc($produk)):
                ?>
                <option value="<?= $p['produk_id'] ?>"><?= htmlspecialchars($p['nama_produk']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group-rv">
            <textarea name="review" class="input-rv"
                placeholder="Tulis pengalaman manismu di sini..." required></textarea>
        </div>

        <div class="form-group-rv">
            <select name="rating" class="input-rv" required>
                <option value="">Pilih Rating</option>
                <option value="5">★★★★★ — Sangat Puas</option>
                <option value="4">★★★★☆ — Puas</option>
                <option value="3">★★★☆☆ — Lumayan</option>
                <option value="2">★★☆☆☆ — Kurang</option>
                <option value="1">★☆☆☆☆ — Buruk</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">Kirim Testimoni</button>

    </form>

</div>

<?php include 'footer.php'; ?>