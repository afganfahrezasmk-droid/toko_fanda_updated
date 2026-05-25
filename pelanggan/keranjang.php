<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role'])) {
    header("location:../index.php?pesan=belum_login");
    exit;
}

if ($_SESSION['role'] != 'pelanggan') {
    header("location:../index.php?pesan=bukan_pelanggan");
    exit;
}
?>

<style>

.page-title{
    font-size:2rem;
    font-weight:700;
    color:#2d1b10;
}

.page-subtitle{
    color:#888;
    margin-top:5px;
}

.produk-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:24px;
    margin-top:30px;
}

.produk-card{
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.07);
    transition:.25s;
    border:1px solid #f1f1f1;
}

.produk-card:hover{
    transform:translateY(-6px);
    box-shadow:0 18px 35px rgba(0,0,0,.12);
}

.produk-img{
    width:100%;
    height:220px;
    object-fit:cover;
    background:#fafafa;
}

.produk-body{
    padding:20px;
}

.produk-nama{
    font-size:1.15rem;
    font-weight:700;
    color:#2d1b10;
    margin-bottom:8px;
}

.produk-desc{
    font-size:.92rem;
    color:#777;
    line-height:1.6;
    height:48px;
    overflow:hidden;
}

.produk-info{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:18px;
}

.harga{
    font-size:1.1rem;
    font-weight:700;
    color:#c58a3a;
}

.stok{
    font-size:.85rem;
    color:#666;
    background:#f8f8f8;
    padding:6px 12px;
    border-radius:999px;
}

.qty-box{
    margin-top:18px;
}

.qty-box label{
    font-size:.9rem;
    font-weight:600;
    margin-bottom:8px;
    display:block;
}

.qty-input{
    border-radius:12px;
    border:1px solid #ddd;
    padding:10px;
    width:100%;
}

.top-action{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:15px;
}

.btn-kembali{
    border-radius:999px;
    padding:10px 20px;
}

.checkout-box{
    background:#fff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
    margin-top:40px;
}

.checkout-title{
    font-size:1.2rem;
    font-weight:700;
    margin-bottom:20px;
}

.form-control,
.form-select{
    border-radius:12px;
    padding:12px;
}

.btn-order{
    background:#c58a3a;
    color:#fff;
    border:none;
    padding:14px;
    width:100%;
    border-radius:14px;
    font-weight:700;
    transition:.2s;
}

.btn-order:hover{
    opacity:.9;
}

</style>

<div class="container py-5">

   <!-- HEADER -->
    <div class="top-action">

        <div>
            <br><br>
            <a href="index.php"
            class="btn btn-outline-dark btn-kembali">

                <i class="fa fa-arrow-left me-2"></i>
                Kembali

            </a>

        </div>

        <div class="text-center w-100">

            <h2 class="page-title">
                🛒 Keranjang Belanja
            </h2>

            <div class="page-subtitle">
                Pilih produk favoritmu dan buat pesanan sekarang
            </div>

        </div>

    </div>


    <form method="POST" action="proses_transaksi.php">

        <!-- USER -->
        <div class="checkout-box mb-4">

            <div class="checkout-title">
                Data Pemesanan
            </div>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        User
                    </label>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Invoice
                    </label>

                    <input type="text"
                           name="invoice"
                           class="form-control"
                           value="INV-<?= rand(1000,9999); ?>"
                           readonly>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Metode Pembayaran
                    </label>

                    <select name="metode_pembayaran"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Metode --
                        </option>

                        <option value="Cash">
                            Cash
                        </option>

                        <option value="Transfer">
                            Transfer
                        </option>

                        <option value="QRIS">
                            QRIS
                        </option>

                    </select>

                    <div class="mt-3">

                        <label class="form-label">
                            Jumlah Bayar
                        </label>

                        <input type="number"
                            name="bayar"
                            id="inputBayar"
                            class="form-control"
                            placeholder="Masukkan uang pembayaran"
                            required>

                        <div class="mt-3">

                            <label class="form-label">
                                Kembalian
                            </label>

                            <input type="text"
                                id="viewKembalian"
                                class="form-control"
                                value="Rp 0"
                                readonly>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- PRODUK -->
        <div class="produk-grid">

            <?php
            $produk = mysqli_query($koneksi,
                "SELECT * FROM produk");

            while($p = mysqli_fetch_array($produk)){
            ?>

            <div class="produk-card">

                <!-- GAMBAR -->
                <img src="../gambar/<?= $p['gambar']; ?>"
                     class="produk-img"
                     onerror="this.src='../gambar/default.jpeg'">

                <div class="produk-body">

                    <!-- NAMA -->
                    <div class="produk-nama">

                        <?= $p['nama_produk']; ?>

                    </div>

                    <!-- DESKRIPSI -->
                    <div class="produk-desc">

                        <?= $p['deskripsi']; ?>

                    </div>

                    <!-- INFO -->
                    <div class="produk-info">

                        <div class="harga">

                            Rp <?= number_format($p['harga']); ?>

                        </div>

                        <div class="stok">

                            Stok <?= $p['stok']; ?>

                        </div>

                    </div>

                    <!-- HIDDEN -->
                    <input type="hidden"
                           name="produk_id[]"
                           value="<?= $p['produk_id']; ?>">

                    <!-- QTY -->
                    <div class="qty-box">

                        <label>
                            Jumlah Pesanan
                        </label>

                        <input type="number"
                               name="qty[]"
                               class="qty-input"
                               min="0"
                               max="<?= $p['stok']; ?>"
                               value="0">

                    </div>

                </div>

            </div>

            <?php } ?>

        </div>

        <!-- BUTTON -->
        <div class="mt-5">

            <button type="submit"
                    class="btn-order">

                <i class="fa fa-cart-shopping me-2"></i>
                Simpan Order

            </button>

        </div>

    </form>

</div>

<script>

function formatRupiah(angka){

    return 'Rp ' + angka.toLocaleString('id-ID');

}

document.addEventListener('input', function(e){

    if(e.target.id === 'inputBayar'){

        const bayar = parseInt(e.target.value || 0);

        const total = <?= $total ?? 0 ?>;

        let kembali = bayar - total;

        if(kembali < 0){

            kembali = 0;

        }

        document.getElementById('viewKembalian').value =
            formatRupiah(kembali);
    }

});

</script>

<?php include 'footer.php'; ?>