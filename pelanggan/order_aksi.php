<?php
include '../koneksi.php';

/** @var mysqli $koneksi */

session_start();

/* ===============================
   AMBIL DATA FORM
================================ */

$user_id           = $_POST['user_id'];
$invoice           = $_POST['invoice'];
$metode_pembayaran = $_POST['metode_pembayaran'];

$produk_id = $_POST['produk_id'];
$qty       = $_POST['qty'];

$total = 0;
$pajak = 0;

/* ===============================
   HITUNG TOTAL + CEK STOK
================================ */

for($i = 0; $i < count($produk_id); $i++){

    if($qty[$i] > 0){

        $q = mysqli_query($koneksi,
            "SELECT harga, stok
             FROM produk
             WHERE produk_id='$produk_id[$i]'");

        $p = mysqli_fetch_array($q);

        // CEK STOK
        if($p['stok'] < $qty[$i]){

            echo "
            <script>
                alert('Stok produk tidak mencukupi!');
                window.location='order_tambah.php';
            </script>
            ";

            exit;
        }

        $subtotal = $p['harga'] * $qty[$i];

        $total += $subtotal;
    }
}

/* ===============================
   HITUNG PAJAK
================================ */

$pajak = $total * 0.10;

/* ===============================
   SIMPAN KE ORDERS
================================ */

mysqli_query($koneksi,
    "INSERT INTO orders
    (invoice, user_id, total, pajak, metode_pembayaran, status)
    VALUES
    ('$invoice', '$user_id', '$total', '$pajak', '$metode_pembayaran', 'pending')");

/* ===============================
   AMBIL ID ORDER TERBARU
================================ */

$orders_id = mysqli_insert_id($koneksi);

/* ===============================
   SIMPAN ORDER ITEMS
================================ */

for($i = 0; $i < count($produk_id); $i++){

    if($qty[$i] > 0){

        $q = mysqli_query($koneksi,
            "SELECT harga, stok
             FROM produk
             WHERE produk_id='$produk_id[$i]'");

        $p = mysqli_fetch_array($q);

        $harga    = $p['harga'];
        $subtotal = $harga * $qty[$i];

        /* ===============================
           INSERT ORDER ITEMS
        ================================ */

        mysqli_query($koneksi,
            "INSERT INTO order_items
            (orders_id, produk_id, qty, harga, subtotal)
            VALUES
            ('$orders_id',
             '$produk_id[$i]',
             '$qty[$i]',
             '$harga',
             '$subtotal')");

        /* ===============================
           KURANGI STOK
        ================================ */

        mysqli_query($koneksi,
            "UPDATE produk
             SET stok = stok - $qty[$i]
             WHERE produk_id = '$produk_id[$i]'");
    }
}

/* ===============================
   REDIRECT
================================ */

header("location:index.php");
?>