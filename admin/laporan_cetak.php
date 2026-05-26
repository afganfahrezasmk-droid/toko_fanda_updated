<?php

session_start();
include '../koneksi.php';
/** @var mysqli $koneksi */

if (!isset($_SESSION['role'])) {
header("location:../index.php");
exit;
}

$dari=$_GET['dari'];
$sampai=$_GET['sampai'];

$status=$_GET['status'] ?? '';
$metode=$_GET['metode_pembayaran'] ?? '';

$filter="";

if($status!=""){
$filter.=" AND orders.status='$status'";
}

if($metode!=""){
$filter.=" AND orders.metode_pembayaran='$metode'";
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Cetak Laporan</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<center>

<h3>LAPORAN ORDER</h3>

<p>

<?= $dari ?>
sampai
<?= $sampai ?>

</p>

</center>

<table class="table table-bordered">

<thead>

<tr>

<th>No</th>
<th>ID</th>
<th>Tanggal</th>
<th>Customer</th>
<th>Total</th>
<th>Status</th>
<th>Pembayaran</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

$data=mysqli_query($koneksi,"
SELECT orders.*,user.nama
FROM orders
JOIN user
ON orders.user_id=user.user_id
WHERE DATE(orders.created_at)
BETWEEN '$dari' AND '$sampai'
$filter
ORDER BY orders.orders_id DESC
");

while($d=mysqli_fetch_array($data)){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= $d['orders_id'] ?></td>

<td><?= $d['created_at'] ?></td>

<td><?= $d['nama'] ?></td>

<td>Rp <?= number_format($d['total']) ?></td>

<td><?= ucfirst($d['status']) ?></td>

<td><?= strtoupper($d['metode_pembayaran']) ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<script>
window.print();
</script>

</body>
</html>