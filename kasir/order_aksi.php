<?php

session_name('KASIR_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

include '../koneksi.php';
/** @var mysqli $koneksi */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Akses tidak valid!');
}

$user_id = $_POST['user_id'] ?? 0;
$invoice = $_POST['invoice'] ?? '';
$metode  = $_POST['metode_pembayaran'] ?? '';

$produk_id = $_POST['produk_id'] ?? [];
$qty       = $_POST['qty'] ?? [];

if(empty($produk_id) || empty($qty)){

    die('Keranjang kosong!');

}

$subtotal = 0;

$detailProduk = [];

for($i = 0; $i < count($produk_id); $i++){

    $idProduk = (int)$produk_id[$i];
    $jumlah   = (int)$qty[$i];

    $query = mysqli_query($koneksi, "
        SELECT *
        FROM produk
        WHERE produk_id = '$idProduk'
    ");

    $produk = mysqli_fetch_assoc($query);

    if(!$produk) continue;

    $harga = (int)$produk['harga'];

    $sub = $harga * $jumlah;

    $subtotal += $sub;

    $detailProduk[] = [
        'produk_id' => $idProduk,
        'qty'       => $jumlah,
        'harga'     => $harga,
        'subtotal'  => $sub
    ];
}

$pajak = round($subtotal * 0.1);

$total = $subtotal + $pajak;

mysqli_query($koneksi, "
INSERT INTO orders(
    invoice,
    user_id,
    metode_pembayaran,
    pajak,
    total,
    created_at
)
VALUES(
    '$invoice',
    '$user_id',
    '$metode',
    '$pajak',
    '$total',
    NOW()
)
");

$order_id = mysqli_insert_id($koneksi);

foreach($detailProduk as $item){

    $idProduk = $item['produk_id'];
    $jumlah   = $item['qty'];
    $harga    = $item['harga'];
    $sub      = $item['subtotal'];

    mysqli_query($koneksi, "
    INSERT INTO order_items(
        orders_id,
        produk_id,
        qty,
        harga,
        subtotal
    )
    VALUES(
        '$order_id',
        '$idProduk',
        '$jumlah',
        '$harga',
        '$sub'
    )
    ");

    mysqli_query($koneksi, "
    UPDATE produk
    SET stok = stok - $jumlah
    WHERE produk_id = '$idProduk'
    ");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pesanan Berhasil</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f8f8f8;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    background:white;
    padding:40px;
    border-radius:20px;
    text-align:center;
    width:420px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

h1{
    color:#27ae60;
    margin-bottom:15px;
}

p{
    color:#666;
    margin-bottom:10px;
}

.invoice{
    font-size:1.1rem;
    font-weight:bold;
    color:#222;
    margin:20px 0;
}

.btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 24px;
    border-radius:12px;
    background:#d4a25a;
    color:white;
    text-decoration:none;
    font-weight:bold;
}

.btn:hover{
    opacity:.9;
}

</style>

</head>
<body>

<div class="box">

    <h1>✅ Pesanan Berhasil!</h1>

    <p>Terima kasih telah memesan di</p>
    <p><b>Toko Kue Fanda</b></p>

    <div class="invoice">
        <?= htmlspecialchars($invoice) ?>
    </div>

    <p>Metode Pembayaran:</p>
    <p><b><?= htmlspecialchars($metode) ?></b></p>

    <p>Total pembayaran berhasil dibuat.</p>

    <a href="index.php" class="btn">
        Kembali Belanja
    </a>

</div>

<script>

localStorage.removeItem('fanda_cart');

</script>

</body>
</html>