<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

/* ===============================
   AMBIL DATA
================================ */

$orders_id          = $_POST['orders_id'];
$invoice            = $_POST['invoice'];
$metode_pembayaran=trim($_POST['metode_pembayaran']);
$status = strtolower(trim($_POST['status']));

/* ===============================
   UPDATE ORDER
================================ */

mysqli_query($koneksi,
    "UPDATE orders
     SET
        invoice='$invoice',
        metode_pembayaran='$metode_pembayaran',
        status='$status'
     WHERE orders_id='$orders_id'");

/* ===============================
   REDIRECT
================================ */

echo "
<script>

    alert('Data Order Berhasil Diubah');

    window.location.href='order.php';

</script>
";
?>