<?php 
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Testimoni</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>

:root{
    --esp:#1C0A00;
    --brown:#4A2510;
    --gold:#E8B46D;
    --cream:#F8F2E5;
    --white:#FFFCF7;
    --muted:#9B7A5A;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    min-height:100vh;

    background:
    radial-gradient(circle at top right, rgba(232,180,109,.08), transparent 30%),
    radial-gradient(circle at bottom left, rgba(245,206,204,.08), transparent 30%),
    var(--esp);

    font-family:'DM Sans',sans-serif;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:40px;

}

/* DECOR */
.blob{
    position:absolute;
    border-radius:50%;
    filter:blur(80px);
    opacity:.12;
}

.blob1{
    width:300px;
    height:300px;
    background:#E8B46D;
    top:-80px;
    left:-80px;
}

.blob2{
    width:260px;
    height:260px;
    background:#F5CECC;
    bottom:-100px;
    right:-80px;
}

/* CARD */
.box{
    width:100%;
    max-width:560px;

    background:rgba(255,252,247,.06);

    border:1px solid rgba(255,255,255,.08);

    backdrop-filter:blur(16px);

    border-radius:32px;

    padding:42px;

    box-shadow:0 30px 80px rgba(0,0,0,.35);

    position:relative;
    z-index:2;
}

.top-label{
    font-family:'Kaushan Script',cursive;
    color:rgba(255,255,255,.35);
    font-size:1.4rem;
    margin-bottom:10px;
}

h2{
    font-family:'Playfair Display',serif;
    font-size:2.6rem;
    line-height:1.1;
    color:var(--white);

    margin-bottom:14px;
}

.desc{
    color:rgba(255,255,255,.5);
    line-height:1.8;
    font-size:.92rem;

    margin-bottom:32px;
}

/* FORM */
.form-group{
    margin-bottom:18px;
}

.input{
    width:100%;

    padding:16px 18px;

    border-radius:18px;

    border:1px solid rgba(255,255,255,.08);

    background:rgba(255,255,255,.05);

    color:var(--white);

    font-size:.95rem;

    outline:none;

    transition:.3s;

    box-shadow:inset 0 0 0 1px rgba(255,255,255,.02);
}

.input::placeholder{
    color:rgba(255,255,255,.35);
}

.input:focus{
    border-color:var(--gold);
    background:rgba(255,255,255,.08);
}

textarea{
    min-height:130px;
    resize:none;
}

select.input{
    appearance:none;
    -webkit-appearance:none;
    -moz-appearance:none;

    padding-right:55px;

    background:
    rgba(255,255,255,.05)
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='none' stroke='%23E8B46D' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 8 12 14 18 8'/%3E%3C/svg%3E")
    no-repeat right 18px center;

    cursor:pointer;
}

/* WARNA OPTION DROPDOWN */
select.input option{
    background:#2A1208;
    color:#F8F2E5;
}

option{
    background:#2A140B;
    color:#F8F2E5;
}

/* BUTTON */

.back-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;

    margin-bottom:30px;

    text-decoration:none;

    color:rgba(255,255,255,.72);

    font-size:.9rem;
    font-weight:500;

    transition:.3s;
}

.back-btn:hover{
    transform:translateX(-4px);

    color:var(--gold);
}

.btn{
    width:100%;

    border:none;

    padding:18px;

    border-radius:999px;

    background:var(--gold);

    color:var(--esp);

    font-weight:700;

    font-size:.92rem;

    letter-spacing:.08em;
    text-transform:uppercase;

    cursor:pointer;

    transition:.35s;
}

.btn:hover{
    transform:translateY(-4px);

    box-shadow:0 16px 40px rgba(232,180,109,.28);
}

/* SMALL */
.small{
    margin-top:16px;

    text-align:center;

    color:rgba(255,255,255,.35);

    font-size:.8rem;
}

@media(max-width:700px){

    .box{
        padding:28px;
        border-radius:24px;
    }

    h2{
        font-size:2rem;
    }

}

</style>
</head>
<body>

<div class="blob blob1"></div>
<div class="blob blob2"></div>

<div class="box">

    <a href="index.php#tentang" class="back-btn">
        ← Kembali
    </a>
    
    <div class="top-label">
        Toko Kue Fanda
    </div>

    <h2>Bagikan Pengalaman Manismu</h2>

    <p class="desc">
        Ceritakan pengalamanmu menikmati kue favorit dari dapur kami ✨
    </p>

    <form action="review_aksi.php" method="POST">

        <div class="form-group">
            <input 
                type="text"
                name="nama_pelanggan"
                class="input"
                placeholder="Nama Anda"
                required
            >
        </div>

        <div class="form-group">
            <select name="id_produk" class="input" required>

                <option value="">
                    Pilih Produk Favorit
                </option>

                <?php
                $produk = mysqli_query($koneksi, "SELECT * FROM produk");

                while($p = mysqli_fetch_assoc($produk)){
                ?>

                <option value="<?= $p['produk_id']; ?>">
                    <?= $p['nama_produk']; ?>
                </option>

                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <textarea
                name="review"
                class="input"
                placeholder="Tulis pengalaman manismu di sini..."
                required
            ></textarea>
        </div>

        <div class="form-group">
            <select name="rating" class="input" required>
                <option value="">Pilih Rating</option>
                <option value="5">★★★★★ — Sangat Puas</option>
                <option value="4">★★★★☆ — Puas</option>
                <option value="3">★★★☆☆ — Lumayan</option>
                <option value="2">★★☆☆☆ — Kurang</option>
                <option value="1">★☆☆☆☆ — Buruk</option>
            </select>
        </div>

        <button type="submit" class="btn">
            Kirim Testimoni
        </button>

    </form>

    <div class="small">
        Testimoni akan tampil setelah disimpan ✨
    </div>

</div>

</body>
</html>