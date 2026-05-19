<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */

$invoice = $_GET['invoice'] ?? '';

$order = mysqli_fetch_assoc(mysqli_query($koneksi, "
SELECT * FROM orders
WHERE invoice='$invoice'
"));

if(!$order){
    echo "<h3 style='padding:40px'>Invoice tidak ditemukan</h3>";
    exit;
}

$detail = mysqli_query($koneksi, "
SELECT 
    od.*, 
    p.nama_produk,
    p.gambar,
    p.deskripsi
FROM order_items od
JOIN produk p ON od.produk_id = p.produk_id
WHERE od.orders_id = '{$order['orders_id']}'
");

function rupiah($n){
    return 'Rp ' . number_format($n,0,',','.');
}

/* =========================
   STATUS COLOR
========================= */

$status = strtolower($order['status']);

if($status == 'pending'){
    $statusClass = 'status-pending';
}
elseif($status == 'diproses'){
    $statusClass = 'status-proses';
}
elseif($status == 'selesai'){
    $statusClass = 'status-selesai';
}
elseif($status == 'dibatalkan'){
    $statusClass = 'status-batal';
}
else{
    $statusClass = 'status-default';
}
?>

<style>

body{
    background:#e5e5e5;
    font-family:Arial,sans-serif;
}

.receipt-wrap{
    width:380px;
    margin:30px auto;
}

.receipt{
    background:#fff;
    padding:25px;
    color:#000;
    box-shadow:0 3px 15px rgba(0,0,0,.1);
    position:relative;
}

/* zigzag atas bawah */
.receipt:before,
.receipt:after{
    content:"";
    position:absolute;
    left:0;
    width:100%;
    height:12px;
    background:
    linear-gradient(
        -45deg,
        transparent 75%,
        #fff 75%
    ) 0 0/15px 15px;
}

.receipt:before{
    top:-12px;
}

.receipt:after{
    bottom:-12px;
    transform:rotate(180deg);
}

.center{
    text-align:center;
}

.shop-name{
    font-size:30px;
    font-weight:bold;
}

.address{
    font-size:14px;
    margin-top:5px;
    line-height:1.5;
}

.line{
    border-top:2px dashed #777;
    margin:18px 0;
}

.row{
    display:flex;
    justify-content:space-between;
    margin:4px 0;
}

.small{
    font-size:14px;
}

.item{
    margin-bottom:18px;
}

.item-name{
    font-size:20px;
    font-weight:bold;
}

.item-detail{
    color:#444;
    margin-top:4px;
}

.total-area .row{
    margin:10px 0;
    font-size:18px;
}

.total{
    font-weight:bold;
    font-size:22px;
}

.print-btn{
    text-align:center;
    margin-top:25px;
}

.print-btn button,
.print-btn a{
    border:none;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
    text-decoration:none;
    margin:5px;
}

.btn-back{
    background:#ddd;
    color:black;
}

.btn-print{
    background:#222;
    color:white;
}

@media print{

    .print-btn,
    .navbar,
    footer{
        display:none;
    }

    body{
        background:white;
    }

    .receipt{
        box-shadow:none;
    }

}

</style>


<div class="receipt-wrap">

<div class="receipt">

<div class="center">
<br>
<div class="shop-name">
Toko Kue Fanda
</div>

<div class="address">
Semarang <br>
Invoice: <?= htmlspecialchars($order['invoice']) ?>
</div>

</div>

<div class="line"></div>

<div class="row">

<div>
<?= date('Y-m-d',strtotime($order['created_at'])) ?>
<br>
<?= date('H:i:s',strtotime($order['created_at'])) ?>
</div>

<div style="text-align:right">

<?= htmlspecialchars($order['metode_pembayaran']) ?>
<br>

<?= htmlspecialchars($order['status']) ?>

</div>

</div>

<div class="line"></div>

<?php
$subtotal=0;

while($d=mysqli_fetch_assoc($detail)):

$sub=$d['harga']*$d['qty'];
$subtotal+=$sub;
?>

<div class="item">

<div class="item-name">

<?= htmlspecialchars($d['nama_produk']) ?>

</div>

<div class="row item-detail">

<div>

<?= $d['qty'] ?> x <?= number_format($d['harga'],0,',','.') ?>

</div>

<div>

<?= rupiah($sub) ?>

</div>

</div>

</div>

<?php endwhile; ?>

<div class="line"></div>

<div class="total-area">

<div class="row">

<span>Subtotal</span>
<span><?= rupiah($subtotal) ?></span>

</div>

<div class="row">

<span>Pajak</span>
<span><?= rupiah($order['pajak']) ?></span>

</div>

<div class="row total">

<span>Total</span>
<span><?= rupiah($order['total']) ?></span>

</div>

</div>

<div class="line"></div>

<div class="center small">

Terima kasih sudah berbelanja ❤️

</div>

<div class="print-btn">

<a href="index.php" class="btn-back">
Kembali
</a>

<button onclick="window.print()"
class="btn-print">

Print

</button>

</div>

</div>
</div>

<?php include 'footer.php'; ?>