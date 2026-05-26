<?php
include '../koneksi.php';
include '../midtrans_config.php';

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

$invoice = mysqli_real_escape_string(
    $koneksi,
    $_POST['invoice'] ?? ''
);

$metode = mysqli_real_escape_string(
    $koneksi,
    $_POST['metode_pembayaran'] ?? ''
);

$bayar = (int)($_POST['bayar'] ?? 0);

$produk_id = $_POST['produk_id'] ?? [];
$qty       = $_POST['qty'] ?? [];

/* =========================
   VALIDASI
========================= */

if (empty($produk_id) || empty($qty)) {
    die("Keranjang kosong!");
}

$subtotal = 0;
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

    $harga = (int)$produk['harga'];
    $sub   = $harga * $jumlah;

    $subtotal += $sub;

    $detailProduk[] = [
        'produk_id'    => $idProduk,
        'qty'          => $jumlah,
        'harga'        => $harga,
        'subtotal'     => $sub,
        'nama_produk'  => $produk['nama_produk'],
    ];
}

/* =========================
   HITUNG TOTAL
========================= */

$pajak = round($subtotal * 0.10);
$total = $subtotal + $pajak;

/* ========================================================
   CABANG: CASH  vs  QRIS / TRANSFER
======================================================== */

if ($metode === 'Cash') {

    /* ----- VALIDASI CASH ----- */
    if ($bayar < $total) {
        echo "<script>alert('Uang pembayaran kurang!'); window.history.back();</script>";
        exit;
    }

    $kembalian = $bayar - $total;

    /* ----- SIMPAN ORDER ----- */
    mysqli_query($koneksi, "
        INSERT INTO orders (invoice, user_id, total, pajak, metode_pembayaran, status, created_at)
        VALUES ('$invoice', '$user_id', '$total', '$pajak', '$metode', 'dibayar', NOW())
    ");

    $orders_id = mysqli_insert_id($koneksi);

    /* ----- SIMPAN ITEMS & UPDATE STOK ----- */
    foreach ($detailProduk as $item) {
        $pid  = $item['produk_id'];
        $jml  = $item['qty'];
        $hrg  = $item['harga'];
        $sub  = $item['subtotal'];

        mysqli_query($koneksi, "
            INSERT INTO order_items (orders_id, produk_id, qty, harga, subtotal)
            VALUES ('$orders_id', '$pid', '$jml', '$hrg', '$sub')
        ");

        mysqli_query($koneksi, "UPDATE produk SET stok = stok - $jml WHERE produk_id = '$pid'");
    }

    /* ----- SIMPAN PEMBAYARAN ----- */
    mysqli_query($koneksi, "
        INSERT INTO pembayaran (orders_id, metode, bayar, kembalian, created_at)
        VALUES ('$orders_id', '$metode', '$bayar', '$kembalian', NOW())
    ");

    /* ----- TAMPILKAN HALAMAN SUKSES (Cash) ----- */
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
       QRIS / TRANSFER BANK  →  Midtrans Snap
    ======================================================== */

    /* ----- SIMPAN ORDER (status: pending, bayar nanti via Midtrans) ----- */
    mysqli_query($koneksi, "
        INSERT INTO orders (invoice, user_id, total, pajak, metode_pembayaran, status, created_at)
        VALUES ('$invoice', '$user_id', '$total', '$pajak', '$metode', 'pending', NOW())
    ");

    $orders_id = mysqli_insert_id($koneksi);

    /* ----- SIMPAN ITEMS & UPDATE STOK ----- */
    foreach ($detailProduk as $item) {
        $pid = $item['produk_id'];
        $jml = $item['qty'];
        $hrg = $item['harga'];
        $sub = $item['subtotal'];

        mysqli_query($koneksi, "
            INSERT INTO order_items (orders_id, produk_id, qty, harga, subtotal)
            VALUES ('$orders_id', '$pid', '$jml', '$hrg', '$sub')
        ");

        mysqli_query($koneksi, "UPDATE produk SET stok = stok - $jml WHERE produk_id = '$pid'");
    }

    /* ----- SIMPAN PEMBAYARAN (bayar & kembalian diisi 0 dulu, diupdate via webhook) ----- */
    mysqli_query($koneksi, "
        INSERT INTO pembayaran (orders_id, metode, bayar, kembalian, created_at)
        VALUES ('$orders_id', '$metode', '0', '0', NOW())
    ");

    /* ----- SIAPKAN PAYLOAD MIDTRANS ----- */

    // Item detail untuk Midtrans
    $items = [];
    foreach ($detailProduk as $item) {
        $items[] = [
            'id'       => 'PROD-' . $item['produk_id'],
            'price'    => $item['harga'],
            'quantity' => $item['qty'],
            'name'     => substr($item['nama_produk'], 0, 50), // maks 50 char
        ];
    }

    // Tambah pajak sebagai item tersendiri
    if ($pajak > 0) {
        $items[] = [
            'id'       => 'PAJAK',
            'price'    => $pajak,
            'quantity' => 1,
            'name'     => 'Pajak (10%)',
        ];
    }

    // Ambil data user untuk customer_details
    $user_row = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT * FROM user WHERE user_id = '$user_id'"
    ));

    $payload = [
        'transaction_details' => [
            'order_id'    => $invoice,   // pakai invoice sebagai order_id di Midtrans
            'gross_amount' => $total,
        ],
        'item_details' => $items,
        'customer_details' => [
            'first_name' => $user_row['nama']  ?? 'Pelanggan',
            'email'      => $user_row['email'] ?? 'pelanggan@tokokuefanda.com',
            'phone'      => $user_row['hp']    ?? '',
        ],
        // Batasi metode pembayaran sesuai pilihan user
        'enabled_payments' => $metode === 'QRIS'
            ? ['qris']
            : ['bca_va', 'bni_va', 'bri_va', 'permata_va', 'mandiri_bill'],
    ];

    /* ----- PANGGIL MIDTRANS API ----- */
    $snap_token = midtrans_get_snap_token($payload);

    if (!$snap_token) {
        // Kalau API gagal (misal belum set key), tampilkan error informatif
        echo "<div style='font-family:Arial;padding:40px;text-align:center'>
            <h2 style='color:#e74c3c'>⚠️ Gagal terhubung ke Midtrans</h2>
            <p>Pastikan <strong>MIDTRANS_SERVER_KEY</strong> sudah diisi di <code>midtrans_config.php</code></p>
            <p style='margin-top:10px'>Order sudah tersimpan dengan invoice: <strong>$invoice</strong></p>
            <a href='index.php' style='color:#d4a25a'>← Kembali</a>
        </div>";
        exit;
    }

    /* ----- SIMPAN TOKEN KE SESSION LALU REDIRECT ----- */
    $_SESSION['snap_token']   = $snap_token;
    $_SESSION['snap_invoice'] = $invoice;
    $_SESSION['snap_total']   = $total;
    $_SESSION['snap_metode']  = $metode;

    header('Location: bayar_midtrans.php');
    exit;
}
