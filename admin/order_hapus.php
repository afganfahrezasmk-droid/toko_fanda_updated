<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

/* ===============================
   AMBIL ID ORDER
================================ */

$id = $_GET['id'];

/* ===============================
   AMBIL DATA ORDER ITEMS
================================ */

$data = mysqli_query($koneksi,
    "SELECT produk_id, qty
     FROM order_items
     WHERE orders_id='$id'");

/* ===============================
   KEMBALIKAN STOK PRODUK
================================ */

while($d = mysqli_fetch_array($data)){

    mysqli_query($koneksi,
        "UPDATE produk
         SET stok = stok + $d[qty]
         WHERE produk_id = '$d[produk_id]'");
}

/* ===============================
   HAPUS ORDER ITEMS
================================ */

mysqli_query($koneksi,
    "DELETE FROM order_items
     WHERE orders_id='$id'");

/* ===============================
   HAPUS ORDERS
================================ */

mysqli_query($koneksi,
    "DELETE FROM orders
     WHERE orders_id='$id'");

/* ===============================
   REDIRECT
================================ */

echo "
<script>

    alert('Data Order Berhasil Dihapus');

    window.location.href='order.php';

</script>
";
?>