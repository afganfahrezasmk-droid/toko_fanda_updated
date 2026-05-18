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
SELECT od.*, p.nama_produk
FROM order_detail od
JOIN produk p ON od.produk_id = p.produk_id
WHERE od.order_id = '{$order['id']}'
");

function rupiah($n){
    return 'Rp ' . number_format($n,0,',','.');
}
?>

<style>
.invoice-wrap{
    max-width:800px;
    margin:40px auto;
    background:#fff;
    border-radius:18px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.invoice-head{
    display:flex;
    justify-content:space-between;
    margin-bottom:30px;
    gap:20px;
}

.invoice-title{
    font-size:2rem;
    font-weight:700;
}

.invoice-info{
    color:#777;
    line-height:1.8;
}

.invoice-table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.invoice-table th,
.invoice-table td{
    padding:14px;
    border-bottom:1px solid #eee;
    text-align:left;
}

.invoice-table th{
    background:#fafafa;
}

.total-box{
    margin-top:30px;
    margin-left:auto;
    width:320px;
}

.total-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
}

.total-row.final{
    border-top:2px solid #ddd;
    padding-top:12px;
    font-size:1.2rem;
    font-weight:700;
}

.btn-print{
    margin-top:30px;
    padding:12px 24px;
    border:none;
    border-radius:12px;
    background:#c59a5d;
    color:#fff;
    cursor:pointer;
    font-weight:600;
}
</style>

<div class="invoice-wrap">

    <div class="invoice-head">

        <div>
            <div class="invoice-title">Invoice</div>

            <div class="invoice-info">
                Invoice : <?= $order['invoice'] ?><br>
                Tanggal :
                <?= date('d M Y H:i', strtotime($order['created_at'])) ?>
            </div>
        </div>

        <div class="invoice-info">
            Metode Pembayaran<br>
            <strong><?= $order['metode_pembayaran'] ?></strong>
        </div>

    </div>

    <table class="invoice-table">

        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $subtotal = 0;

        while($d = mysqli_fetch_assoc($detail)):

            $sub = $d['harga'] * $d['qty'];
            $subtotal += $sub;
        ?>

            <tr>
                <td><?= $d['nama_produk'] ?></td>
                <td><?= $d['qty'] ?></td>
                <td><?= rupiah($d['harga']) ?></td>
                <td><?= rupiah($sub) ?></td>
            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

    <?php
    $pajak = round($subtotal * 0.1);
    $total = $subtotal + $pajak;
    ?>

    <div class="total-box">

        <div class="total-row">
            <span>Subtotal</span>
            <span><?= rupiah($subtotal) ?></span>
        </div>

        <div class="total-row">
            <span>Pajak (10%)</span>
            <span><?= rupiah($pajak) ?></span>
        </div>

        <div class="total-row final">
            <span>Total</span>
            <span><?= rupiah($total) ?></span>
        </div>

    </div>

    <button onclick="window.print()" class="btn-print">
        Print Invoice
    </button>

</div>

<?php include 'footer.php'; ?>