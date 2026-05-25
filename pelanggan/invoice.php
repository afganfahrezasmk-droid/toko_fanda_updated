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
        p.nama_produk,
        p.gambar,
        p.deskripsi
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

$status     = strtolower($order['status']);
$statusMap  = [
    'pending'    => ['label' => 'Pending',    'color' => '#f39c12'],
    'diproses'   => ['label' => 'Diproses',   'color' => '#3498db'],
    'selesai'    => ['label' => 'Selesai',    'color' => '#27ae60'],
    'dibayar'    => ['label' => 'Dibayar',    'color' => '#27ae60'],
    'dibatalkan' => ['label' => 'Dibatalkan', 'color' => '#e74c3c'],
];
$statusInfo = $statusMap[$status] ?? ['label' => ucfirst($status), 'color' => '#888'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice <?= htmlspecialchars($order['invoice']) ?> — Toko Kue Fanda</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

<style>

/* ===== RESET & BASE ===== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --brown-dark:  #2d1b10;
    --brown-mid:   #7a4a2e;
    --gold:        #c58a3a;
    --gold-light:  #e8c47a;
    --cream:       #fdf6ec;
    --cream-dark:  #f3e8d0;
    --white:       #ffffff;
    --gray-soft:   #f7f3ee;
    --gray-text:   #888;
    --green:       #27ae60;
    --font-serif:  'Playfair Display', Georgia, serif;
    --font-sans:   'DM Sans', sans-serif;
}

body {
    font-family: var(--font-sans);
    background: var(--cream);
    min-height: 100vh;
    padding: 40px 20px 60px;
    color: var(--brown-dark);
}

/* ===== RECEIPT WRAPPER ===== */
.receipt-outer {
    max-width: 480px;
    margin: 0 auto;
    position: relative;
}

/* ===== PAPER EFFECT ===== */
.receipt-paper {
    background: var(--white);
    border-radius: 4px;
    box-shadow:
        0 2px 0 #e8d9c4,
        0 4px 0 #f0e4ce,
        0 20px 60px rgba(45,27,16,.15);

    position: relative;
    overflow: visible;

    font-family: 'Courier New', monospace;
}

/* Zigzag top */
.receipt-paper::before {
    content: "";
    position: absolute;
    top: -10px;
    left: 0;
    width: 100%;
    height: 10px;
    background:
        radial-gradient(circle at 50% 0%, var(--cream) 6px, transparent 6px),
        radial-gradient(circle at 0%   0%, var(--cream) 6px, transparent 6px),
        radial-gradient(circle at 100% 0%, var(--cream) 6px, transparent 6px);
    background-size: 16px 10px;
    background-position: 8px 0, 0 0, 0 0;
}

/* Zigzag bottom */
.receipt-paper::after {
    content: "";
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 10px;
    background:
        radial-gradient(circle at 50% 100%, var(--cream) 6px, transparent 6px),
        radial-gradient(circle at 0%   100%, var(--cream) 6px, transparent 6px),
        radial-gradient(circle at 100% 100%, var(--cream) 6px, transparent 6px);
    background-size: 16px 10px;
    background-position: 8px 100%, 0 100%, 0 100%;
}

/* ===== GOLD HEADER BAND ===== */
.receipt-header {
    background: linear-gradient(135deg, var(--brown-dark) 0%, var(--brown-mid) 100%);
    padding: 20px 18px;
    text-align: center;
    border-radius: 4px 4px 0 0;
    position: relative;
    overflow: hidden;
}

.receipt-header::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(circle at 10% 20%, rgba(197,138,58,.15) 0%, transparent 50%),
        radial-gradient(circle at 90% 80%, rgba(197,138,58,.10) 0%, transparent 50%);
}

.shop-logo {
    font-size: 1.4rem;
    font-weight: 900;
    color: var(--gold-light);
    letter-spacing: 1px;
    position: relative;
}

.shop-tagline {
    font-size: .78rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(255,255,255,.5);
    margin-top: 4px;
    position: relative;
}

.shop-address {
    font-size: .82rem;
    color: rgba(255,255,255,.6);
    margin-top: 8px;
    position: relative;
}

/* ===== INVOICE META ===== */
.receipt-meta {
    padding: 22px 30px 18px;
    background: var(--gray-soft);
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    flex-wrap: wrap;
    border-bottom: 1.5px dashed #ddd;
}

.meta-block .label {
    font-size: .72rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--gray-text);
    margin-bottom: 4px;
}

.meta-block .value {
    font-weight: 600;
    font-size: .9rem;
    color: var(--brown-dark);
}

.meta-block .value.invoice-code {
    font-family: var(--font-serif);
    font-size: 1rem;
    color: var(--gold);
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 600;
    background: <?= $statusInfo['color'] ?>22;
    color: <?= $statusInfo['color'] ?>;
    border: 1.5px solid <?= $statusInfo['color'] ?>44;
}

/* ===== ITEMS ===== */
.receipt-body {
    padding: 22px 30px;
}

.section-title {
    font-size: .72rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--gray-text);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-title::after {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
}

.item-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px dashed #f0e8dc;
}

.item-row:last-child {
    border-bottom: none;
}

.item-info .item-name {
    font-weight: 600;
    font-size: .95rem;
    color: var(--brown-dark);
    margin-bottom: 3px;
}

.item-info .item-qty {
    font-size: .82rem;
    color: var(--gray-text);
}

.item-price {
    font-weight: 700;
    font-size: .95rem;
    color: var(--brown-dark);
    white-space: nowrap;
}

/* ===== SUMMARY ===== */
.receipt-summary {
    padding: 0 30px 22px;
    border-top: 2px dashed #e0d4c4;
    margin-top: 4px;
}

.sum-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: .9rem;
    color: var(--brown-mid);
}

.sum-row.sum-total {
    font-family: var(--font-serif);
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--brown-dark);
    border-top: 2px solid var(--cream-dark);
    margin-top: 4px;
    padding-top: 14px;
}

.sum-row.sum-total span:last-child {
    color: var(--gold);
}

/* ===== PAYMENT INFO ===== */
.payment-box {
    margin: 0 30px 24px;
    background: var(--gray-soft);
    border-radius: 14px;
    padding: 16px 20px;
    border: 1.5px solid var(--cream-dark);
}

.payment-box .pay-row {
    display: flex;
    justify-content: space-between;
    font-size: .88rem;
    padding: 5px 0;
    color: var(--brown-mid);
}

.payment-box .pay-row.kembalian-row {
    font-weight: 700;
    font-size: .95rem;
    color: var(--green);
    border-top: 1px dashed #ddd;
    margin-top: 6px;
    padding-top: 10px;
}

/* ===== FOOTER RECEIPT ===== */
.receipt-footer {
    text-align: center;
    padding: 20px 30px 28px;
    border-top: 2px dashed #e0d4c4;
}

.thanks-text {
    font-family: var(--font-serif);
    font-size: 1.1rem;
    color: var(--brown-mid);
    margin-bottom: 6px;
}

.thanks-sub {
    font-size: .78rem;
    color: var(--gray-text);
    letter-spacing: 1px;
}

/* ===== ACTION BUTTONS ===== */
.action-bar {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-top: 32px;
    flex-wrap: wrap;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 22px;
    border-radius: 12px;
    font-weight: 600;
    font-size: .9rem;
    cursor: pointer;
    text-decoration: none;
    border: none;
    transition: all .2s;
    font-family: var(--font-sans);
}

.btn-back {
    background: var(--white);
    color: var(--brown-dark);
    border: 1.5px solid #ddd;
}

.btn-back:hover {
    background: var(--cream-dark);
    border-color: var(--gold);
    color: var(--brown-dark);
}

.btn-print {
    background: linear-gradient(135deg, var(--brown-dark), var(--brown-mid));
    color: var(--white);
    box-shadow: 0 4px 14px rgba(45,27,16,.25);
}

.btn-print:hover {
    opacity: .9;
    transform: translateY(-1px);
}

/* ===== PRINT STYLES ===== */
@media print {
    body { background: white; padding: 0; }
    .action-bar { display: none; }
    .receipt-paper::before,
    .receipt-paper::after { display: none; }
    .receipt-paper { box-shadow: none; }
    .receipt-outer {max-width: 340px;}
}
</style>
</head>
<body>

<div class="receipt-outer">

    <!-- PAPER -->
    <div class="receipt-paper">

        <!-- HEADER -->
        <div class="receipt-header">
            <div class="shop-logo">🎂 Toko Kue Fanda</div>
            <div class="shop-tagline">Bakery & Pastry</div>
            <div class="shop-address">Semarang, Jawa Tengah</div>
        </div>

        <!-- META / INVOICE INFO -->
        <div class="receipt-meta">

            <div class="meta-block">
                <div class="label">No. Invoice</div>
                <div class="value invoice-code"><?= htmlspecialchars($order['invoice']) ?></div>
            </div>

            <div class="meta-block" style="text-align:center">
                <div class="label">Tanggal</div>
                <div class="value"><?= date('d M Y', strtotime($order['created_at'])) ?></div>
                <div class="value" style="font-size:.82rem;color:var(--gray-text)"><?= date('H:i', strtotime($order['created_at'])) ?> WIB</div>
            </div>

            <div class="meta-block" style="text-align:right">
                <div class="label">Status</div>
                <div class="status-badge"><?= $statusInfo['label'] ?></div>
                <div class="value" style="margin-top:6px;font-size:.82rem;color:var(--gray-text)"><?= htmlspecialchars($order['metode_pembayaran']) ?></div>
            </div>

        </div>

        <!-- ITEMS -->
        <div class="receipt-body">

            <div class="section-title">Detail Pesanan</div>

            <?php
            $subtotal = 0;
            while ($d = mysqli_fetch_assoc($detail)) :
                $sub = $d['harga'] * $d['qty'];
                $subtotal += $sub;
            ?>
            <div class="item-row">
                <div class="item-info">
                    <div class="item-name"><?= htmlspecialchars($d['nama_produk']) ?></div>
                    <div class="item-qty"><?= $d['qty'] ?> × <?= rupiah($d['harga']) ?></div>
                </div>
                <div class="item-price"><?= rupiah($sub) ?></div>
            </div>
            <?php endwhile; ?>

        </div>

        <!-- SUMMARY -->
        <div class="receipt-summary">

            <div class="sum-row">
                <span>Subtotal</span>
                <span><?= rupiah($subtotal) ?></span>
            </div>

            <div class="sum-row">
                <span>Pajak (10%)</span>
                <span><?= rupiah($order['pajak']) ?></span>
            </div>

            <div class="sum-row sum-total">
                <span>Total</span>
                <span><?= rupiah($order['total']) ?></span>
            </div>

        </div>

        <!-- PAYMENT INFO -->
        <?php if ($pembayaran) : ?>
        <div class="payment-box">

            <div class="section-title" style="margin-bottom:10px">Info Pembayaran</div>

            <div class="pay-row">
                <span>Metode</span>
                <span><?= htmlspecialchars($pembayaran['metode']) ?></span>
            </div>

            <div class="pay-row">
                <span>Jumlah Bayar</span>
                <span><?= rupiah($pembayaran['bayar']) ?></span>
            </div>

            <div class="pay-row kembalian-row">
                <span>💵 Kembalian</span>
                <span><?= rupiah($pembayaran['kembalian']) ?></span>
            </div>

        </div>
        <?php endif; ?>

        <!-- RECEIPT FOOTER -->
        <div class="receipt-footer">
            <div class="thanks-text">Terima kasih sudah berbelanja! ❤️</div>
            <div class="thanks-sub">Simpan struk ini sebagai bukti transaksi</div>
        </div>

    </div>
    <!-- /receipt-paper -->

    <!-- ACTION BUTTONS -->
    <div class="action-bar">
        <a href="akun.php" class="btn-action btn-back">
            ← Kembali
        </a>
        <button onclick="window.print()" class="btn-action btn-print">
            🖨 Cetak Invoice
        </button>
    </div>

</div>

<script>
// Bersihkan localStorage setelah invoice tampil
localStorage.removeItem('fanda_cart');
</script>

</body>
</html>

<?php include 'footer.php'; ?>