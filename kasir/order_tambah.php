<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('KASIR_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

?>

<style>

.order-wrap{
    max-width:1100px;
    margin:auto;
    padding:40px 24px 70px;
}

.order-card{
    background:#fff;
    border-radius:20px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
}

.page-title{
    margin-bottom:30px;
}

.page-title h2{
    font-size:1.8rem;
    font-weight:700;
    margin-bottom:8px;
    color:#222;
}

.page-title p{
    color:#888;
    font-size:.95rem;
}

.form-label{
    font-weight:600;
    margin-bottom:8px;
    color:#333;
}

.form-control,
.form-select{
    border-radius:12px;
    padding:12px 14px;
    border:1px solid #ddd;
    box-shadow:none !important;
}

.form-control:focus,
.form-select:focus{
    border-color:#c59d5f;
}

.table{
    margin-top:20px;
}

.table thead th{
    background:#f8f8f8;
    border:none;
    padding:14px;
    font-size:.9rem;
    color:#555;
}

.table tbody td{
    vertical-align:middle;
    padding:14px;
}

.produk-img{
    width:55px;
    height:55px;
    border-radius:12px;
    object-fit:cover;
    margin-right:12px;
}

.produk-box{
    display:flex;
    align-items:center;
}

.produk-nama{
    font-weight:600;
    color:#222;
}

.produk-harga{
    font-size:.85rem;
    color:#888;
}

.qty-input{
    width:90px;
    border-radius:10px;
    text-align:center;
}

.btn-simpan{
    border:none;
    background:#c59d5f;
    color:#fff;
    padding:13px 28px;
    border-radius:12px;
    font-weight:600;
    transition:.2s;
}

.btn-simpan:hover{
    opacity:.9;
}

.btn-kembali{
    border-radius:12px;
    padding:11px 22px;
}

</style>

<div class="order-wrap">

    <div class="page-title">
        <h2>Tambah Order</h2>
        <p>Buat pesanan baru untuk pelanggan.</p>
    </div>

    <div class="mb-4">

        <a href="produk.php"
           class="btn btn-outline-dark btn-kembali">

            <i class="fa fa-arrow-left me-2"></i>
            Kembali

        </a>

    </div>

    <div class="order-card">

        <form method="POST" action="order_aksi.php">

                <div class="col-md-6 mb-4">
                    <input type="hidden"
                        name="user_id"
                        value="<?= $_SESSION['user_id']; ?>">
                <!-- INVOICE -->
                <div class="col-md-4 mb-4">

                    <label class="form-label">
                        Invoice
                    </label>

                    <input type="text"
                           name="invoice"
                           class="form-control"
                           value="INV-<?= rand(1000,9999); ?>"
                           readonly>

                </div>

                <!-- METODE -->\r\n                <div class=\"col-md-4 mb-4\">\r\n\r\n                    <label class=\"form-label\">\r\n                        Metode Pembayaran\r\n                    </label>\r\n\r\n                    <select name=\"metode_pembayaran\"\r\n                            id=\"metodeSelect\"\r\n                            class=\"form-select\"\r\n                            onchange=\"gantiMetode(this.value)\"\r\n                            required>\r\n\r\n                        <option value=\"\">\r\n                            -- Pilih Metode --\r\n                        </option>\r\n\r\n                        <option value=\"Cash\">\r\n                            💵 Cash\r\n                        </option>\r\n\r\n                        <option value=\"Transfer\">\r\n                            🏦 Transfer\r\n                        </option>\r\n\r\n                        <option value=\"QRIS\">\r\n                            📱 QRIS\r\n                        </option>\r\n\r\n                    </select>\r\n\r\n                </div>\r\n\r\n                <!-- BAYAR (hanya muncul saat Cash) -->\r\n                <div class=\"col-md-4 mb-4\" id=\"sectionBayar\" style=\"display:none\">\r\n                    <label class=\"form-label\">Jumlah Bayar (Rp)</label>\r\n                    <input type=\"text\"\r\n                           id=\"inputBayarView\"\r\n                           class=\"form-control\"\r\n                           placeholder=\"Contoh: 100000\"\r\n                           oninput=\"formatBayar(this)\">\r\n                    <input type=\"hidden\" name=\"bayar\" id=\"inputBayar\" value=\"0\">\r\n                </div>\r\n\r\n                <!-- INFO digital -->\r\n                <div class=\"col-md-8 mb-4\" id=\"sectionDigital\" style=\"display:none\">\r\n                    <div style=\"background:#fff8ee;border:1.5px solid #f0c97a;border-radius:12px;\r\n                                padding:14px 16px;font-size:.88rem;color:#7a5500;line-height:1.7;margin-top:32px\">\r\n                        <strong>💡 Pembayaran Digital</strong><br>\r\n                        Kasir akan diarahkan ke halaman Midtrans untuk scan QRIS atau Transfer Bank.\r\n                    </div>\r\n                </div>

            </div>

            <hr>

            <h5 class="mb-4">
                Data Produk
            </h5>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th width="20%">Qty</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $produk = mysqli_query($koneksi,
                        "SELECT * FROM produk");

                    while($p = mysqli_fetch_array($produk)){
                    ?>

                    <tr>

                        <td>

                            <div class="produk-box">

                                <img src="../gambar/<?= $p['gambar']; ?>"
                                     class="produk-img"
                                     onerror="this.src='../gambar/default.jpeg'">

                                <div>

                                    <div class="produk-nama">
                                        <?= htmlspecialchars($p['nama_produk']); ?>
                                    </div>

                                    <div class="produk-harga">
                                        Stok:
                                        <?= $p['stok']; ?>
                                    </div>

                                </div>

                            </div>

                            <input type="hidden"
                                   name="produk_id[]"
                                   value="<?= $p['produk_id']; ?>">

                        </td>

                        <td>

                            Rp <?= number_format($p['harga']); ?>

                        </td>

                        <td>

                            <input type="number"
                                   name="qty[]"
                                   class="form-control qty-input"
                                   min="0"
                                   max="<?= $p['stok']; ?>"
                                   value="0">

                        </td>

                    </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                <button type="submit"
                        class="btn-simpan">

                    <i class="fa fa-save me-2"></i>
                    Simpan Order

                </button>

            </div>

        </form>

    </div>

</div>

<script>
function gantiMetode(val) {
    const isCash = val === 'Cash';
    document.getElementById('sectionBayar').style.display   = isCash ? 'block' : 'none';
    document.getElementById('sectionDigital').style.display = (!isCash && val) ? 'block' : 'none';
}

function formatBayar(input) {
    let angka = input.value.replace(/\D/g, '');
    input.value = angka ? new Intl.NumberFormat('id-ID').format(parseInt(angka)) : '';
    document.getElementById('inputBayar').value = angka || '0';
}
</script>

<?php include 'footer.php'; ?>