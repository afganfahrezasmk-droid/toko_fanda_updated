<?php
session_start();

include '../koneksi.php';

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

if(empty($produk_id) || empty($qty)){

    die("Keranjang kosong!");

}

$subtotal = 0;
$detailProduk = [];

/* =========================
   CEK PRODUK & STOK
========================= */

for($i = 0; $i < count($produk_id); $i++){

    $idProduk = (int)$produk_id[$i];
    $jumlah   = (int)$qty[$i];

    if($jumlah <= 0){
        continue;
    }

    $query = mysqli_query(
        $koneksi,

        "SELECT *
         FROM produk
         WHERE produk_id = '$idProduk'"
    );

    $produk = mysqli_fetch_assoc($query);

    if(!$produk){

        die("Produk tidak ditemukan!");

    }

    /* =========================
       CEK STOK
    ========================= */

    if($produk['stok'] < $jumlah){

        die("Stok produk {$produk['nama_produk']} tidak mencukupi!");

    }

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

/* =========================
   HITUNG TOTAL
========================= */

$pajak = round($subtotal * 0.10);

$total = $subtotal + $pajak;

/* =========================
   VALIDASI PEMBAYARAN
========================= */

if($bayar < $total){

    echo "
    <script>

        alert('Uang pembayaran kurang!');

        window.history.back();

    </script>
    ";

    exit;
}

$kembalian = $bayar - $total;

/* =========================
   SIMPAN ORDERS
========================= */

mysqli_query(

    $koneksi,

    "INSERT INTO orders
    (
        invoice,
        user_id,
        total,
        pajak,
        metode_pembayaran,
        status,
        created_at
    )

    VALUES
    (
        '$invoice',
        '$user_id',
        '$total',
        '$pajak',
        '$metode',
        'dibayar',
        NOW()
    )"
);

$orders_id = mysqli_insert_id($koneksi);

/* =========================
   SIMPAN ORDER ITEMS
========================= */

foreach($detailProduk as $item){

    $idProduk = $item['produk_id'];
    $jumlah   = $item['qty'];
    $harga    = $item['harga'];
    $sub      = $item['subtotal'];

    mysqli_query(

        $koneksi,

        "INSERT INTO order_items
        (
            orders_id,
            produk_id,
            qty,
            harga,
            subtotal
        )

        VALUES
        (
            '$orders_id',
            '$idProduk',
            '$jumlah',
            '$harga',
            '$sub'
        )"
    );

    /* =========================
       UPDATE STOK
    ========================= */

    mysqli_query(

        $koneksi,

        "UPDATE produk
         SET stok = stok - $jumlah
         WHERE produk_id = '$idProduk'"
    );
}

/* =========================
   SIMPAN PEMBAYARAN
========================= */

mysqli_query(

    $koneksi,

    "INSERT INTO pembayaran
    (
        orders_id,
        metode,
        bayar,
        kembalian,
        created_at
    )

    VALUES
    (
        '$orders_id',
        '$metode',
        '$bayar',
        '$kembalian',
        NOW()
    )"
);

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Pembayaran Berhasil</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f5f5f5;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.box{
    background:white;
    width:430px;
    padding:40px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    text-align:center;
}

h1{
    color:#27ae60;
    margin-bottom:15px;
}

.detail{
    text-align:left;
    margin-top:25px;
    background:#fafafa;
    padding:20px;
    border-radius:14px;
}

.row{
    display:flex;
    justify-content:space-between;
    margin-bottom:12px;
}

.total{
    border-top:1px solid #ddd;
    padding-top:12px;
    font-weight:bold;
}

.btn{
    display:inline-block;
    margin-top:25px;
    padding:12px 24px;
    background:#d4a25a;
    color:white;
    text-decoration:none;
    border-radius:12px;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="box">

    <h1>✅ Pembayaran Berhasil</h1>

    <p>Pesanan berhasil diproses</p>

    <div class="detail">

        <div class="row">
            <span>Invoice</span>
            <span><?= $invoice ?></span>
        </div>

        <div class="row">
            <span>Total</span>
            <span>Rp <?= number_format($total) ?></span>
        </div>

        <div class="row">
            <span>Bayar</span>
            <span>Rp <?= number_format($bayar) ?></span>
        </div>

        <div class="row total">
            <span>Kembalian</span>
            <span>Rp <?= number_format($kembalian) ?></span>
        </div>

    </div>

    <a href="index.php" class="btn">
        Kembali Belanja
    </a>

</div>

<script>

localStorage.removeItem('fanda_cart');

</script>

</body>
</html>