<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */

$invoice = $_GET['invoice'] ?? '';

$order = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT * FROM orders
    WHERE invoice = '" . mysqli_real_escape_string($koneksi, $invoice) . "'
"));

if (!$order) {
    echo "<h3 style='padding:40px;text-align:center'>Invoice tidak ditemukan</h3>";
    exit;
}

$detail = mysqli_query($koneksi, "
    SELECT
        oi.*,
        p.nama_produk
    FROM order_items oi
    JOIN produk p ON oi.produk_id = p.produk_id
    WHERE oi.orders_id = '{$order['orders_id']}'
");

$pembayaran = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT * FROM pembayaran
    WHERE orders_id = '{$order['orders_id']}'
"));

function rupiah($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}

$status = strtolower($order['status']);

$statusMap = [
    'pending'    => ['label' => 'Pending',    'color' => '#f39c12'],
    'diproses'   => ['label' => 'Diproses',   'color' => '#3498db'],
    'selesai'    => ['label' => 'Selesai',    'color' => '#27ae60'],
    'dibayar'    => ['label' => 'Dibayar',    'color' => '#27ae60'],
    'dibatalkan' => ['label' => 'Dibatalkan', 'color' => '#e74c3c'],
];

$statusInfo = $statusMap[$status] ?? [
    'label' => ucfirst($status),
    'color' => '#888'
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
Struk <?= htmlspecialchars($order['invoice']) ?>
</title>

<style>
@media print{

    header,
    footer{
        display:none !important;
    }

}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#f5f5f5;
    font-family:'Courier New', monospace;
    padding:25px;
}

/* ===== STRUK ===== */

.struk{
    width:340px;
    margin:auto;
    background:#fff;
    padding:20px;
    border-radius:6px;
    box-shadow:0 4px 18px rgba(0,0,0,.08);
    position:relative;
}

/* efek sobek */

.struk::before,
.struk::after{
    content:"";
    position:absolute;
    left:0;
    width:100%;
    height:12px;
    background:
        radial-gradient(circle, transparent 7px, #fff 8px);
    background-size:20px 20px;
}

.struk::before{
    top:-10px;
}

.struk::after{
    bottom:-10px;
    transform:rotate(180deg);
}

/* ===== HEADER ===== */

.header{
    text-align:center;
    border-bottom:1px dashed #999;
    padding-bottom:14px;
    margin-bottom:14px;
}

.logo{
    font-size:22px;
    font-weight:bold;
}

.tagline{
    font-size:12px;
    color:#777;
    margin-top:4px;
}

.alamat{
    font-size:12px;
    margin-top:6px;
    color:#777;
}

/* ===== INFO ===== */

.info{
    font-size:12px;
    margin-bottom:15px;
}

.info-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:5px;
}

.status{
    font-weight:bold;
    color:<?= $statusInfo['color'] ?>;
}

/* ===== ITEM ===== */

.items{
    border-top:1px dashed #999;
    border-bottom:1px dashed #999;
    padding:12px 0;
}

.item{
    margin-bottom:14px;
}

.item:last-child{
    margin-bottom:0;
}

.item-name{
    font-size:13px;
    font-weight:bold;
}

.item-detail{
    display:flex;
    justify-content:space-between;
    font-size:12px;
    margin-top:4px;
}

/* ===== TOTAL ===== */

.total-box{
    margin-top:14px;
}

.total-row{
    display:flex;
    justify-content:space-between;
    font-size:13px;
    margin-bottom:7px;
}

.grand-total{
    border-top:1px dashed #999;
    padding-top:10px;
    margin-top:8px;
    font-size:15px;
    font-weight:bold;
}

/* ===== PAYMENT ===== */

.payment{
    border-top:1px dashed #999;
    margin-top:15px;
    padding-top:12px;
}

.payment h4{
    font-size:13px;
    margin-bottom:10px;
}

.payment-row{
    display:flex;
    justify-content:space-between;
    font-size:12px;
    margin-bottom:6px;
}

.kembalian{
    font-weight:bold;
    color:green;
}

/* ===== FOOTER ===== */

.footer{
    text-align:center;
    margin-top:18px;
    border-top:1px dashed #999;
    padding-top:14px;
}

.footer p{
    font-size:12px;
    margin-bottom:4px;
}

.footer small{
    color:#777;
    font-size:11px;
}

/* ===== BUTTON ===== */

.action{
    text-align:center;
    margin-top:25px;
}

.btn{
    display:inline-block;
    padding:10px 18px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    text-decoration:none;
    font-size:13px;
    margin:5px;
}

.btn-back{
    background:#eaeaea;
    color:#333;
}

.btn-print{
    background:#2d1b10;
    color:#fff;
}

/* ===== PRINT ===== */

@media print{

    header,
    footer,
    .navbar,
    .sidebar,
    .topbar{
        display:none !important;
    }

    body{
        background:#fff;
        padding:0;
        margin:0;
    }

    .action{
        display:none;
    }

    .struk{
        width:100%;
        max-width:340px;
        box-shadow:none;
        border-radius:0;
        margin:auto;
    }

}

</style>
</head>

<body>

<div class="struk">

    <!-- HEADER -->
    <div class="header">

        <div class="logo">
            🎂 TOKO KUE FANDA
        </div>

        <div class="tagline">
            Bakery & Pastry
        </div>

        <div class="alamat">
            Semarang, Jawa Tengah
        </div>

    </div>

    <!-- INFO -->
    <div class="info">

        <div class="info-row">
            <span>Invoice</span>
            <span><?= htmlspecialchars($order['invoice']) ?></span>
        </div>

        <div class="info-row">
            <span>Tanggal</span>
            <span><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
        </div>

        <div class="info-row">
            <span>Status</span>
            <span class="status"><?= $statusInfo['label'] ?></span>
        </div>

        <div class="info-row">
            <span>Metode</span>
            <span><?= htmlspecialchars($order['metode_pembayaran']) ?></span>
        </div>

    </div>

    <!-- ITEMS -->
    <div class="items">

        <?php
        $subtotal = 0;

        while($d = mysqli_fetch_assoc($detail)) :

            $sub = $d['harga'] * $d['qty'];
            $subtotal += $sub;
        ?>

        <div class="item">

            <div class="item-name">
                <?= htmlspecialchars($d['nama_produk']) ?>
            </div>

            <div class="item-detail">

                <span>
                    <?= $d['qty'] ?> x <?= rupiah($d['harga']) ?>
                </span>

                <span>
                    <?= rupiah($sub) ?>
                </span>

            </div>

        </div>

        <?php endwhile; ?>

    </div>

    <!-- TOTAL -->
    <div class="total-box">

        <div class="total-row">
            <span>Subtotal</span>
            <span><?= rupiah($subtotal) ?></span>
        </div>

        <div class="total-row">
            <span>Pajak</span>
            <span><?= rupiah($order['pajak']) ?></span>
        </div>

        <div class="total-row grand-total">
            <span>TOTAL</span>
            <span><?= rupiah($order['total']) ?></span>
        </div>

    </div>

    <!-- PEMBAYARAN -->
    <?php if($pembayaran): ?>

    <div class="payment">

        <h4>Pembayaran</h4>

        <div class="payment-row">
            <span>Bayar</span>
            <span><?= rupiah($pembayaran['bayar']) ?></span>
        </div>

        <div class="payment-row kembalian">
            <span>Kembalian</span>
            <span><?= rupiah($pembayaran['kembalian']) ?></span>
        </div>

    </div>

    <?php endif; ?>

    <!-- FOOTER -->
    <div class="footer">

        <p>
            Terima kasih ❤️
        </p>

        <small>
            Simpan struk ini sebagai bukti pembayaran
        </small>

    </div>

</div>

<!-- BUTTON -->
<div class="action">

    <a href="akun.php" class="btn btn-back">
        ← Kembali
    </a>

    <button onclick="window.print()" class="btn btn-print">
        🖨 Cetak Struk
    </button>

</div>

<script>
localStorage.removeItem('fanda_cart');
</script>

</body>
</html>

<?php include 'footer.php'; ?>