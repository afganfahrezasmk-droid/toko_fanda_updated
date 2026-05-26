<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */

$id = $_GET['id'];

/* HAPUS DATA ORDER ITEMS DULU */
mysqli_query($koneksi, "
DELETE order_items
FROM order_items
JOIN orders ON order_items.orders_id = orders.orders_id
WHERE orders.user_id = '$id'
");

/* HAPUS DATA ORDERS */
mysqli_query($koneksi, "
DELETE FROM orders 
WHERE user_id = '$id'
");

/* BARU HAPUS USER */
mysqli_query($koneksi, "
DELETE FROM user 
WHERE user_id = '$id'
");

echo "
<script>
alert('Data user berhasil dihapus');
window.location.href='user.php';
</script>
";
?>