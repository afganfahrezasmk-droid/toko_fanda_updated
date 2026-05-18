<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */

$invoice = $_GET['invoice'] ?? '';

$order = mysqli_fetch_assoc(mysqli_query($koneksi, "
SELECT * FROM orders
WHERE invoice='$invoice'
"));

if(!$order){
    echo "<h3 style='padding:40px'>Invoice tidak ditemukan</h3>";
    exit;
}

$detail = mysqli_query($koneksi, "
SELECT 
    od.*, 
    p.nama_produk,
    p.gambar,
    p.deskripsi
FROM order_items od
JOIN produk p ON od.produk_id = p.produk_id
WHERE od.orders_id = '{$order['orders_id']}'
");

function rupiah($n){
    return 'Rp ' . number_format($n,0,',','.');
}

/* =========================
   STATUS COLOR
========================= */

$status = strtolower($order['status']);

if($status == 'pending'){
    $statusClass = 'status-pending';
}
elseif($status == 'diproses'){
    $statusClass = 'status-proses';
}
elseif($status == 'selesai'){
    $statusClass = 'status-selesai';
}
elseif($status == 'dibatalkan'){
    $statusClass = 'status-batal';
}
else{
    $statusClass = 'status-default';
}
?>

<style>

body{
    background:#f6f1ea;
    font-family:'Poppins',sans-serif;
}

/* WRAP */
.invoice-wrap{
    max-width:1000px;
    margin:50px auto;
    padding:0 15px;
}

.invoice-card{
    background:#fff;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
}

/* HEADER */
.invoice-top{
    background:linear-gradient(135deg,#4b240f,#7a4322);
    color:white;
    padding:40px;
}

.brand{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;
}

.brand-title{
    font-size:2.2rem;
    font-weight:700;
}

.brand-sub{
    margin-top:8px;
    opacity:.85;
    font-size:.95rem;
}

.invoice-badge{
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);
    padding:14px 22px;
    border-radius:18px;
    backdrop-filter:blur(8px);
    text-align:center;
}

.invoice-badge small{
    display:block;
    opacity:.8;
    margin-bottom:5px;
}

/* BODY */
.invoice-body{
    padding:35px;
}

/* INFO GRID */
.info-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
    margin-bottom:30px;
}

.info-box{
    background:#faf7f2;
    border-radius:20px;
    padding:20px;
}

.info-label{
    font-size:.85rem;
    color:#888;
    margin-bottom:6px;
}

.info-value{
    font-size:1rem;
    font-weight:700;
    color:#2c2c2c;
}

/* STATUS */
.status-badge{
    display:inline-block;
    padding:8px 16px;
    border-radius:999px;
    font-size:.82rem;
    font-weight:700;
    text-transform:capitalize;
}

.status-pending{
    background:#fff3cd;
    color:#856404;
}

.status-proses{
    background:#cfe2ff;
    color:#084298;
}

.status-selesai{
    background:#d1e7dd;
    color:#0f5132;
}

.status-batal{
    background:#f8d7da;
    color:#842029;
}

.status-default{
    background:#e2e3e5;
    color:#41464b;
}

/* TABLE */
.invoice-table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

.invoice-table thead{
    background:#f8f3eb;
}

.invoice-table th{
    padding:16px;
    color:#666;
    font-size:.9rem;
    text-align:left;
}

.invoice-table td{
    padding:18px 16px;
    border-bottom:1px solid #f1f1f1;
    vertical-align:top;
}

/* PRODUK */
.product-box{
    display:flex;
    gap:16px;
    align-items:flex-start;
}

.product-img{
    width:80px;
    height:80px;
    border-radius:16px;
    object-fit:cover;
    background:#f5f5f5;
    border:1px solid #eee;
}

.product-name{
    font-weight:700;
    color:#2c2c2c;
    margin-bottom:6px;
}

.product-desc{
    font-size:.85rem;
    color:#777;
    line-height:1.5;
    max-width:320px;
}

/* TOTAL */
.total-wrap{
    margin-top:35px;
    display:flex;
    justify-content:flex-end;
}

.total-box{
    width:360px;
    background:#faf7f2;
    border-radius:24px;
    padding:24px;
}

.total-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:14px;
    color:#555;
}

.total-final{
    border-top:2px dashed #ddd;
    padding-top:18px;
    margin-top:12px;
    font-size:1.2rem;
    font-weight:700;
    color:#222;
}

/* BUTTON */
.invoice-action{
    margin-top:35px;
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:15px;
}

.btn-modern{
    border:none;
    border-radius:16px;
    padding:13px 24px;
    font-weight:600;
    text-decoration:none;
    transition:.25s;
    display:inline-flex;
    align-items:center;
    gap:10px;
}

.btn-back{
    background:#f1ece5;
    color:#444;
}

.btn-back:hover{
    background:#e2d8ca;
    transform:translateY(-2px);
}

.btn-print{
    background:#c5975c;
    color:white;
}

.btn-print:hover{
    opacity:.92;
    transform:translateY(-2px);
}

/* PRINT */
@media print{

    .invoice-action,
    .navbar,
    footer{
        display:none !important;
    }

    body{
        background:white;
    }

    .invoice-wrap{
        margin:0;
        max-width:100%;
    }

    .invoice-card{
        box-shadow:none;
    }
}

/* MOBILE */
@media(max-width:768px){

    .invoice-top{
        padding:28px;
    }

    .invoice-body{
        padding:22px;
    }

    .brand-title{
        font-size:1.7rem;
    }

    .product-box{
        flex-direction:column;
    }

    .product-img{
        width:100%;
        max-width:120px;
        height:120px;
    }
}

</style>

<div class="invoice-wrap">

    <div class="invoice-card">

        <!-- HEADER -->
        <div class="invoice-top">

            <div class="brand">

                <div>

                    <div class="brand-title">
                        🎂 Toko Kue Fanda
                    </div>

                    <div class="brand-sub">
                        Invoice Pembelian Pelanggan
                    </div>

                </div>

                <div class="invoice-badge">

                    <small>Nomor Invoice</small>

                    <strong>
                        <?= htmlspecialchars($order['invoice']) ?>
                    </strong>

                </div>

            </div>

        </div>

        <!-- BODY -->
        <div class="invoice-body">

            <!-- INFO -->
            <div class="info-grid">

                <div class="info-box">

                    <div class="info-label">
                        Tanggal Pembelian
                    </div>

                    <div class="info-value">

                        <?= date('d M Y • H:i', strtotime($order['created_at'])) ?>

                    </div>

                </div>

                <div class="info-box">

                    <div class="info-label">
                        Metode Pembayaran
                    </div>

                    <div class="info-value">

                        <?= htmlspecialchars($order['metode_pembayaran']) ?>

                    </div>

                </div>

                <div class="info-box">

                    <div class="info-label">
                        Status Pesanan
                    </div>

                    <div class="info-value">

                        <span class="status-badge <?= $statusClass ?>">

                            <?= htmlspecialchars($order['status']) ?>

                        </span>

                    </div>

                </div>

            </div>

            <!-- TABLE -->
            <table class="invoice-table">

                <thead>

                    <tr>

                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>

                    </tr>

                </thead>

                <tbody>

                <?php
                $subtotal = 0;

                while($d = mysqli_fetch_assoc($detail)):

                    $sub = $d['harga'] * $d['qty'];
                    $subtotal += $sub;
                ?>

                    <tr>

                        <td>

                            <div class="product-box">

                                <img src="../gambar/<?= $d['gambar']; ?>"
                                     class="product-img">

                                <div>

                                    <div class="product-name">

                                        <?= htmlspecialchars($d['nama_produk']) ?>

                                    </div>

                                    <div class="product-desc">

                                        <?= htmlspecialchars($d['deskripsi']) ?>

                                    </div>

                                </div>

                            </div>

                        </td>

                        <td>

                            <?= $d['qty'] ?>

                        </td>

                        <td>

                            <?= rupiah($d['harga']) ?>

                        </td>

                        <td>

                            <strong><?= rupiah($sub) ?></strong>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

            <?php
            $pajak = $order['pajak'];
            $total = $order['total'];
            ?>

            <!-- TOTAL -->
            <div class="total-wrap">

                <div class="total-box">

                    <div class="total-row">

                        <span>Subtotal</span>
                        <span><?= rupiah($subtotal) ?></span>

                    </div>

                    <div class="total-row">

                        <span>Pajak (10%)</span>
                        <span><?= rupiah($pajak) ?></span>

                    </div>

                    <div class="total-row total-final">

                        <span>Total</span>
                        <span><?= rupiah($total) ?></span>

                    </div>

                </div>

            </div>

            <!-- BUTTON -->
            <div class="invoice-action">

                <a href="akun.php"
                   class="btn-modern btn-back">

                    ← Kembali

                </a>

                <button onclick="window.print()"
                        class="btn-modern btn-print">

                    🖨 Print Invoice

                </button>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>