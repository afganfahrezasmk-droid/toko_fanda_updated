<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('KASIR_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

?>

<div class="container mt-4">

<!-- FILTER -->
<div class="card shadow-sm">

<div class="card-header bg-dark text-white">
<h5 class="mb-0">Filter Laporan Order</h5>
</div>

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-3 mb-3">

<label>Dari Tanggal</label>

<input
type="date"
name="tgl_dari"
class="form-control"
value="<?= $_GET['tgl_dari'] ?? '' ?>"
required>

</div>


<div class="col-md-3 mb-3">

<label>Sampai Tanggal</label>

<input
type="date"
name="tgl_sampai"
class="form-control"
value="<?= $_GET['tgl_sampai'] ?? '' ?>"
required>

</div>


<div class="col-md-2 mb-3">

<label>Status</label>

<select
name="status"
class="form-control">

<option value="">Semua</option>

<option value="pending"
<?= (($_GET['status'] ?? '')=='pending')?'selected':'' ?>>
Pending
</option>

<option value="diproses"
<?= (($_GET['status'] ?? '')=='diproses')?'selected':'' ?>>
Diproses
</option>

<option value="selesai"
<?= (($_GET['status'] ?? '')=='selesai')?'selected':'' ?>>
Selesai
</option>

<option value="dibatalkan"
<?= (($_GET['status'] ?? '')=='dibatalkan')?'selected':'' ?>>
DiBatalkan
</option>

</select>

</div>


<div class="col-md-2 mb-3">

<label>Pembayaran</label>

<select
name="metode_pembayaran"
class="form-control">

<option value="">Semua</option>

<option value="Cash"
<?= (($_GET['metode_pembayaran'] ?? '')=='Cash')?'selected':'' ?>>
Cash
</option>

<option value="QRIS"
<?= (($_GET['metode_pembayaran'] ?? '')=='QRIS')?'selected':'' ?>>
QRIS
</option>

<option value="Transfer"
<?= (($_GET['metode_pembayaran'] ?? '')=='Transfer')?'selected':'' ?>>
Transfer
</option>

</select>

</div>


<div class="col-md-2 d-flex align-items-end mb-3">

<button
type="submit"
class="btn btn-primary w-100">

Filter

</button>

</div>

</div>

</form>

</div>
</div>


<br>

<?php

if(isset($_GET['tgl_dari']) && isset($_GET['tgl_sampai'])){

$dari=$_GET['tgl_dari'];
$sampai=$_GET['tgl_sampai'];

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

<div class="card shadow-sm">

<div class="card-header bg-success text-white d-flex justify-content-between">

<h5 class="mb-0">Laporan Order</h5>

<a
target="_blank"
href="laporan_cetak.php?dari=<?= $dari ?>&sampai=<?= $sampai ?>&status=<?= $status ?>&metode_pembayaran=<?= $metode ?>"
class="btn btn-light">

<i class="fas fa-print"></i>
Cetak

</a>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>No</th>
<th>ID Order</th>
<th>Tanggal</th>
<th>Customer</th>
<th>Total Harga</th>
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

<td>

<?php

if($d['status']=="pending"){

echo "<span class='badge bg-secondary'>Pending</span>";

}elseif($d['status']=="diproses"){

echo "<span class='badge bg-primary'>Diproses</span>";

}elseif($d['status']=="selesai"){

echo "<span class='badge bg-success'>Selesai</span>";

}elseif($d['status']=="dibatalkan"){

echo "<span class='badge bg-danger'>Batal</span>";

}

?>

</td>

<td>

<?= strtoupper($d['metode_pembayaran']) ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>
</div>

<?php } ?>

</div>

<?php include 'footer.php'; ?>