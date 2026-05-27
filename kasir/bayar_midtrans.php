<?php
session_name('KASIR_SESSION');
session_start();

include '../koneksi.php';
include '../midtrans_config.php';

$snap_token = $_SESSION['kasir_snap_token']   ?? '';
$invoice    = $_SESSION['kasir_snap_invoice'] ?? '';
$total      = $_SESSION['kasir_snap_total']   ?? 0;
$metode     = $_SESSION['kasir_snap_metode']  ?? '';

if (empty($snap_token) || empty($invoice)) {
    header('Location: index.php');
    exit;
}

unset(
    $_SESSION['kasir_snap_token'],
    $_SESSION['kasir_snap_invoice'],
    $_SESSION['kasir_snap_total'],
    $_SESSION['kasir_snap_metode']
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran — Kasir Toko Kue Fanda</title>
<script src="<?= MIDTRANS_SNAP_JS ?>" data-client-key="<?= MIDTRANS_CLIENT_KEY ?>"></script>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #f0f4ff 0%, #e8edf8 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,.10);
    padding: 44px 40px;
    max-width: 460px;
    width: 100%;
    text-align: center;
}
.logo { font-size: 2.4rem; margin-bottom: 10px; }
.title { font-size: 1.4rem; font-weight: 700; color: #2d2d2d; margin-bottom: 6px; }
.subtitle { color: #888; font-size: .92rem; margin-bottom: 28px; }
.info-box { background: #fafafa; border-radius: 14px; padding: 20px 24px; margin-bottom: 28px; text-align: left; }
.info-row { display: flex; justify-content: space-between; font-size: .9rem; color: #555; margin-bottom: 10px; }
.info-row:last-child { margin-bottom: 0; }
.info-row strong { color: #222; font-weight: 600; }
.badge-kasir { display:inline-block;background:#e8f0ff;color:#3a5cc7;border-radius:8px;padding:2px 10px;font-size:.8rem;font-weight:600; }
.badge-metode { display:inline-block;background:#fff3cd;color:#856404;border-radius:8px;padding:2px 10px;font-size:.8rem;font-weight:600; }
.btn-bayar {
    width: 100%; padding: 15px; border-radius: 12px;
    background: #3a5cc7; color: #fff; font-size: 1rem; font-weight: 700;
    border: none; cursor: pointer; transition: opacity .2s; letter-spacing: .02em; margin-bottom: 12px;
}
.btn-bayar:hover { opacity: .88; }
.btn-bayar:disabled { opacity: .45; cursor: not-allowed; }
.note { color: #aaa; font-size: .8rem; line-height: 1.6; }
.spinner {
    display: none; width: 20px; height: 20px;
    border: 3px solid rgba(255,255,255,.3); border-top-color: #fff;
    border-radius: 50%; animation: spin .8s linear infinite; margin: 0 auto;
}
@keyframes spin { to { transform: rotate(360deg); } }
</style>
</head>
<body>
<div class="card">
    <div class="logo">🍰</div>
    <h1 class="title">Toko Kue Fanda</h1>
    <p class="subtitle">Halaman Pembayaran Kasir</p>

    <div class="info-box">
        <div class="info-row">
            <span>Mode</span>
            <span class="badge-kasir">👤 Kasir</span>
        </div>
        <div class="info-row">
            <span>Invoice</span>
            <strong><?= htmlspecialchars($invoice) ?></strong>
        </div>
        <div class="info-row">
            <span>Metode</span>
            <span class="badge-metode"><?= htmlspecialchars($metode) ?></span>
        </div>
        <div class="info-row">
            <span>Total Bayar</span>
            <strong style="color:#3a5cc7;font-size:1.05rem">Rp <?= number_format($total, 0, ',', '.') ?></strong>
        </div>
    </div>

    <button class="btn-bayar" id="btnBayar" onclick="mulaiPembayaran()">
        <span id="btnText">
            <?= $metode === 'QRIS' ? '📱 Tampilkan QRIS' : '🏦 Tampilkan Transfer Bank' ?>
        </span>
        <div class="spinner" id="spinner"></div>
    </button>

    <p class="note">Tunjukkan halaman ini ke pelanggan atau scan QR bersama.</p>
</div>

<script>
const snapToken = <?= json_encode($snap_token) ?>;
const invoiceNo = <?= json_encode($invoice) ?>;

function mulaiPembayaran() {
    const btn   = document.getElementById('btnBayar');
    const txt   = document.getElementById('btnText');
    const spin  = document.getElementById('spinner');
    btn.disabled = true;
    txt.style.display  = 'none';
    spin.style.display = 'block';

    window.snap.pay(snapToken, {
        onSuccess: function(result) {
            window.location.href = 'order_invoice.php?invoice=' + invoiceNo + '&paid=1';
        },
        onPending: function(result) {
            window.location.href = 'order_invoice.php?invoice=' + invoiceNo + '&paid=pending';
        },
        onError: function(result) {
            alert('Pembayaran gagal. Silakan coba lagi.');
            btn.disabled = false;
            txt.style.display  = 'block';
            spin.style.display = 'none';
        },
        onClose: function() {
            btn.disabled = false;
            txt.style.display  = 'block';
            spin.style.display = 'none';
        }
    });
}

window.addEventListener('load', function() { setTimeout(mulaiPembayaran, 800); });
</script>
</body>
</html>
