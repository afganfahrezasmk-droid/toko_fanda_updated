<?php
session_name('KASIR_SESSION');
session_start();

include '../koneksi.php';
include '../midtrans_config.php';

/** @var mysqli $koneksi */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') die('Akses tidak valid!');

$user_id = (int)($_POST['user_id']            ?? $_SESSION['user_id'] ?? 0);
$invoice = mysqli_real_escape_string($koneksi, $_POST['invoice']             ?? '');
$metode  = mysqli_real_escape_string($koneksi, $_POST['metode_pembayaran']   ?? '');
$bayar   = (int)($_POST['bayar'] ?? 0);

$produk_id = $_POST['produk_id'] ?? [];
$qty       = $_POST['qty']       ?? [];

if (empty($produk_id) || empty($qty)) die('Keranjang kosong!');

// Hitung subtotal & kumpulkan item
$subtotal     = 0;
$detailProduk = [];

for ($i = 0; $i < count($produk_id); $i++) {
    $idProduk = (int)$produk_id[$i];
    $jumlah   = (int)$qty[$i];
    if ($jumlah <= 0) continue;

    $produk = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT * FROM produk WHERE produk_id='$idProduk'"
    ));
    if (!$produk) continue;

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

$pajak = round($subtotal * 0.10);
$total = $subtotal + $pajak;

// ================================================================
//  CABANG: CASH  vs  QRIS / TRANSFER
// ================================================================

if ($metode === 'Cash') {

    if ($bayar < $total) {
        echo "<script>alert('Uang pembayaran kurang!');window.history.back();</script>";
        exit;
    }
    $kembalian = $bayar - $total;

    mysqli_query($koneksi, "
        INSERT INTO orders(invoice,user_id,metode_pembayaran,pajak,total,status,created_at)
        VALUES('$invoice','$user_id','$metode','$pajak','$total','dibayar',NOW())
    ");
    $orders_id = mysqli_insert_id($koneksi);

    foreach ($detailProduk as $item) {
        mysqli_query($koneksi, "
            INSERT INTO order_items(orders_id,produk_id,qty,harga,subtotal)
            VALUES('$orders_id','{$item['produk_id']}','{$item['qty']}','{$item['harga']}','{$item['subtotal']}')
        ");
        mysqli_query($koneksi, "UPDATE produk SET stok=stok-{$item['qty']} WHERE produk_id='{$item['produk_id']}'");
    }

    mysqli_query($koneksi, "
        INSERT INTO pembayaran(orders_id,metode,bayar,kembalian,created_at)
        VALUES('$orders_id','$metode','$bayar','$kembalian',NOW())
    ");

    ?>
    <!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Berhasil</title>
    <style>
    body{font-family:Arial,sans-serif;background:#f8f8f8;display:flex;justify-content:center;align-items:center;height:100vh;}
    .box{background:white;padding:40px;border-radius:20px;text-align:center;width:420px;box-shadow:0 10px 30px rgba(0,0,0,.08);}
    h1{color:#27ae60;margin-bottom:15px;}
    .row-info{display:flex;justify-content:space-between;margin-bottom:10px;font-size:.95rem;}
    .total-row{border-top:1px solid #ddd;padding-top:12px;font-weight:700;}
    .btn{display:inline-block;margin-top:20px;padding:12px 24px;border-radius:12px;background:#d4a25a;color:white;text-decoration:none;font-weight:bold;}
    </style></head><body>
    <div class="box">
        <h1>✅ Pesanan Berhasil!</h1>
        <p><b>Toko Kue Fanda</b></p>
        <div style="background:#fafafa;border-radius:12px;padding:16px 20px;margin:20px 0;text-align:left">
            <div class="row-info"><span>Invoice</span><span><?= htmlspecialchars($invoice) ?></span></div>
            <div class="row-info"><span>Metode</span><span><?= $metode ?></span></div>
            <div class="row-info"><span>Total</span><span>Rp <?= number_format($total) ?></span></div>
            <div class="row-info"><span>Bayar</span><span>Rp <?= number_format($bayar) ?></span></div>
            <div class="row-info total-row"><span>Kembalian</span><span>Rp <?= number_format($kembalian) ?></span></div>
        </div>
        <a href="index.php" class="btn">Kembali</a>
    </div>
    </body></html>
    <?php

} else {

    // QRIS / Transfer → Midtrans Snap
    mysqli_query($koneksi, "
        INSERT INTO orders(invoice,user_id,metode_pembayaran,pajak,total,status,created_at)
        VALUES('$invoice','$user_id','$metode','$pajak','$total','pending',NOW())
    ");
    $orders_id = mysqli_insert_id($koneksi);

    foreach ($detailProduk as $item) {
        mysqli_query($koneksi, "
            INSERT INTO order_items(orders_id,produk_id,qty,harga,subtotal)
            VALUES('$orders_id','{$item['produk_id']}','{$item['qty']}','{$item['harga']}','{$item['subtotal']}')
        ");
        mysqli_query($koneksi, "UPDATE produk SET stok=stok-{$item['qty']} WHERE produk_id='{$item['produk_id']}'");
    }

    mysqli_query($koneksi, "
        INSERT INTO pembayaran(orders_id,metode,bayar,kembalian,created_at)
        VALUES('$orders_id','$metode','0','0',NOW())
    ");

    // Siapkan payload Midtrans
    $items = [];
    foreach ($detailProduk as $item) {
        $items[] = [
            'id'       => 'PROD-' . $item['produk_id'],
            'price'    => $item['harga'],
            'quantity' => $item['qty'],
            'name'     => substr($item['nama_produk'], 0, 50),
        ];
    }
    if ($pajak > 0) {
        $items[] = ['id' => 'PAJAK', 'price' => $pajak, 'quantity' => 1, 'name' => 'Pajak (10%)'];
    }

    $kasir_row = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT * FROM user WHERE user_id = '$user_id'"
    ));

    $payload = [
        'transaction_details' => ['order_id' => $invoice, 'gross_amount' => $total],
        'item_details'        => $items,
        'customer_details'    => [
            'first_name' => $kasir_row['nama']  ?? 'Kasir',
            'email'      => $kasir_row['email'] ?? 'kasir@tokokuefanda.com',
            'phone'      => $kasir_row['hp']    ?? '',
        ],
        'enabled_payments' => $metode === 'QRIS'
            ? ['qris']
            : ['bca_va', 'bni_va', 'bri_va', 'permata_va', 'mandiri_bill'],
    ];

    $snap_token = midtrans_get_snap_token($payload);

    if (!$snap_token) {
        echo "<div style='font-family:Arial;padding:40px;text-align:center'>
            <h2 style='color:#e74c3c'>⚠️ Gagal terhubung ke Midtrans</h2>
            <p>Pastikan <strong>MIDTRANS_SERVER_KEY</strong> sudah diisi di <code>midtrans_config.php</code></p>
            <p>Order tersimpan dengan invoice: <strong>$invoice</strong></p>
            <a href='index.php' style='color:#d4a25a'>← Kembali</a>
        </div>";
        exit;
    }

    $_SESSION['kasir_snap_token']   = $snap_token;
    $_SESSION['kasir_snap_invoice'] = $invoice;
    $_SESSION['kasir_snap_total']   = $total;
    $_SESSION['kasir_snap_metode']  = $metode;

    header('Location: bayar_midtrans.php');
    exit;
}
