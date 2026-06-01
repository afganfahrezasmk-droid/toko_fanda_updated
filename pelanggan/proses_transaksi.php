<?php
include '../koneksi.php';
include '../xendit_config.php';

session_name('PELANGGAN_SESSION');
session_start();

/** @var mysqli $koneksi */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Akses tidak valid!');
}

/* =========================
   AMBIL DATA
========================= */

$user_id = $_SESSION['user_id'] ?? 0;

$invoice = mysqli_real_escape_string($koneksi, $_POST['invoice'] ?? '');
$metode  = mysqli_real_escape_string($koneksi, $_POST['metode_pembayaran'] ?? '');
$bayar   = (int)($_POST['bayar'] ?? 0);

$produk_id = $_POST['produk_id'] ?? [];
$qty       = $_POST['qty'] ?? [];

/* =========================
   VALIDASI
========================= */

if (empty($produk_id) || empty($qty)) {
    die("Keranjang kosong!");
}

$subtotal     = 0;
$detailProduk = [];

/* =========================
   CEK PRODUK & STOK
========================= */

for ($i = 0; $i < count($produk_id); $i++) {
    $idProduk = (int)$produk_id[$i];
    $jumlah   = (int)$qty[$i];
    if ($jumlah <= 0) continue;

    $query  = mysqli_query($koneksi, "SELECT * FROM produk WHERE produk_id = '$idProduk'");
    $produk = mysqli_fetch_assoc($query);

    if (!$produk) die("Produk tidak ditemukan!");
    if ($produk['stok'] < $jumlah) {
        die("Stok produk {$produk['nama_produk']} tidak mencukupi!");
    }

    $harga     = (int)$produk['harga'];
    $sub       = $harga * $jumlah;
    $subtotal += $sub;

    $detailProduk[] = [
        'produk_id'   => $idProduk,
        'qty'         => $jumlah,
        'harga'       => $harga,
        'subtotal'    => $sub,
        'nama_produk' => $produk['nama_produk'],
    ];
}

/* =========================
   HITUNG TOTAL
========================= */

$pajak = round($subtotal * 0.10);
$total = $subtotal + $pajak;

/* ========================================================
   CABANG: CASH  vs  QRIS / TRANSFER BANK
======================================================== */

if ($metode === 'Cash') {

    if ($bayar < $total) {
        echo "<script>alert('Uang pembayaran kurang!'); window.history.back();</script>";
        exit;
    }

    $kembalian = $bayar - $total;

    mysqli_query($koneksi, "
        INSERT INTO orders (invoice, user_id, total, pajak, metode_pembayaran, status, created_at)
        VALUES ('$invoice', '$user_id', '$total', '$pajak', '$metode', 'dibayar', NOW())
    ");
    $orders_id = mysqli_insert_id($koneksi);

    foreach ($detailProduk as $item) {
        $pid = $item['produk_id'];
        $jml = $item['qty'];
        $hrg = $item['harga'];
        $sub = $item['subtotal'];
        mysqli_query($koneksi, "INSERT INTO order_items (orders_id, produk_id, qty, harga, subtotal) VALUES ('$orders_id', '$pid', '$jml', '$hrg', '$sub')");
        mysqli_query($koneksi, "UPDATE produk SET stok = stok - $jml WHERE produk_id = '$pid'");
    }

    mysqli_query($koneksi, "
        INSERT INTO pembayaran (orders_id, metode, bayar, kembalian, created_at)
        VALUES ('$orders_id', '$metode', '$bayar', '$kembalian', NOW())
    ");

    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
    <meta charset="UTF-8">
    <title>Pembayaran Berhasil</title>
    <style>
    body { font-family:Arial,sans-serif; background:#f5f5f5; display:flex; justify-content:center; align-items:center; min-height:100vh; }
    .box { background:white; width:430px; padding:40px; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,.08); text-align:center; }
    h1 { color:#27ae60; margin-bottom:15px; }
    .detail { text-align:left; margin-top:25px; background:#fafafa; padding:20px; border-radius:14px; }
    .row { display:flex; justify-content:space-between; margin-bottom:12px; }
    .total { border-top:1px solid #ddd; padding-top:12px; font-weight:bold; }
    .btn { display:inline-block; margin-top:25px; padding:12px 24px; background:#d4a25a; color:white; text-decoration:none; border-radius:12px; font-weight:bold; }
    </style>
    </head>
    <body>
    <div class="box">
        <h1>✅ Pembayaran Berhasil</h1>
        <p>Pesanan berhasil diproses</p>
        <div class="detail">
            <div class="row"><span>Invoice</span><span><?= $invoice ?></span></div>
            <div class="row"><span>Total</span><span>Rp <?= number_format($total) ?></span></div>
            <div class="row"><span>Bayar</span><span>Rp <?= number_format($bayar) ?></span></div>
            <div class="row total"><span>Kembalian</span><span>Rp <?= number_format($kembalian) ?></span></div>
        </div>
        <a href="invoice.php?invoice=<?= urlencode($invoice) ?>" class="btn">Lihat Invoice</a>
    </div>
    <script>localStorage.removeItem('fanda_cart');</script>
    </body>
    </html>
    <?php

} else {

    /* ========================================================
       QRIS / TRANSFER BANK → Xendit Invoice
    ======================================================== */

    // Simpan order dulu dengan status pending
    mysqli_query($koneksi, "
        INSERT INTO orders (invoice, user_id, total, pajak, metode_pembayaran, status, created_at)
        VALUES ('$invoice', '$user_id', '$total', '$pajak', '$metode', 'pending', NOW())
    ");
    $orders_id = mysqli_insert_id($koneksi);

    foreach ($detailProduk as $item) {
        $pid = $item['produk_id'];
        $jml = $item['qty'];
        $hrg = $item['harga'];
        $sub = $item['subtotal'];
        mysqli_query($koneksi, "INSERT INTO order_items (orders_id, produk_id, qty, harga, subtotal) VALUES ('$orders_id', '$pid', '$jml', '$hrg', '$sub')");
        mysqli_query($koneksi, "UPDATE produk SET stok = stok - $jml WHERE produk_id = '$pid'");
    }

    mysqli_query($koneksi, "
        INSERT INTO pembayaran (orders_id, metode, bayar, kembalian, created_at)
        VALUES ('$orders_id', '$metode', '0', '0', NOW())
    ");

    // Ambil data user
    $user_row = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT * FROM user WHERE user_id = '$user_id'"
    ));

    // Siapkan item untuk Xendit
    $items = [];
    foreach ($detailProduk as $item) {
        $items[] = [
            'name'     => substr($item['nama_produk'], 0, 255),
            'quantity' => $item['qty'],
            'price'    => $item['harga'],
        ];
    }
    if ($pajak > 0) {
        $items[] = [
            'name'     => 'Pajak (10%)',
            'quantity' => 1,
            'price'    => $pajak,
        ];
    }

    // Buat customer — mobile_number hanya diisi kalau ada isinya
    $customer = [
        'given_names' => !empty($user_row['nama'])  ? $user_row['nama']  : 'Pelanggan',
        'email'       => !empty($user_row['email']) ? $user_row['email'] : 'pelanggan@tokokuefanda.com',
    ];
    if (!empty($user_row['hp'])) {
        $customer['mobile_number'] = $user_row['hp'];
    }

    // Payload Xendit — TANPA payment_methods
    // Biarkan Xendit tampilkan semua metode yang tersedia (QRIS, VA, dll)
    $payload = [
        'external_id'          => $invoice,
        'amount'               => $total,
        'description'          => 'Pembayaran Toko Kue Fanda - ' . $invoice,
        'payer_email'          => !empty($user_row['email']) ? $user_row['email'] : 'pelanggan@tokokuefanda.com',
        'customer'             => $customer,
        'items'                => $items,
        'invoice_duration'     => 86400,
        'currency'             => 'IDR',
        'success_redirect_url' => 'http://localhost/toko_fanda_updated/pelanggan/invoice.php?invoice=' . urlencode($invoice) . '&paid=1',
        'failure_redirect_url' => 'http://localhost/toko_fanda_updated/pelanggan/invoice.php?invoice=' . urlencode($invoice) . '&paid=gagal',
    ];

    // Panggil Xendit API
    $result = xendit_create_invoice($payload);

    if (!$result) {
        echo "<div style='font-family:Arial;padding:40px;text-align:center'>
            <h2 style='color:#e74c3c'>⚠️ Gagal terhubung ke Xendit</h2>
            <p>Pastikan <strong>XENDIT_SECRET_KEY</strong> sudah diisi di <code>xendit_config.php</code></p>
            <p style='margin-top:10px'>Order sudah tersimpan dengan invoice: <strong>$invoice</strong></p>
            <a href='index.php' style='color:#d4a25a'>← Kembali</a>
        </div>";
        exit;
    }

    // Simpan ke session lalu redirect ke halaman bayar
    $_SESSION['xendit_invoice_url'] = $result['invoice_url'];
    $_SESSION['xendit_invoice']     = $invoice;
    $_SESSION['xendit_total']       = $total;
    $_SESSION['xendit_metode']      = $metode;

    header('Location: bayar_xendit.php');
    exit;
}