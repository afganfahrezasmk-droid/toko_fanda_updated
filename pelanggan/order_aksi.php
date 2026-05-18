<?php
session_start();
include '../koneksi.php';
/** @var mysqli $koneksi */


header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if(!$data){
    echo json_encode([
        'status' => 'error',
        'message' => 'Data tidak valid'
    ]);
    exit;
}

$cart    = $data['cart'];
$metode  = $data['metode'];
$user_id = $_SESSION['user_id'] ?? 0;

$invoice = 'INV-' . date('YmdHis');

$total = 0;

foreach($cart as $item){
    $subtotal = $item['harga'] * $item['qty'];
    $total += $subtotal;
}

$pajak = round($total * 0.1);
$grand_total = $total + $pajak;

mysqli_query($koneksi, "
INSERT INTO orders(
    invoice,
    user_id,
    metode_pembayaran,
    subtotal,
    pajak,
    total,
    created_at
)
VALUES(
    '$invoice',
    '$user_id',
    '$metode',
    '$total',
    '$pajak',
    '$grand_total',
    NOW()
)
");

$order_id = mysqli_insert_id($koneksi);

foreach($cart as $id => $item){

    $produk_id = (int)$id;
    $qty       = (int)$item['qty'];
    $harga     = (int)$item['harga'];
    $subtotal  = $harga * $qty;

    mysqli_query($koneksi, "
    INSERT INTO order_detail(
        order_id,
        produk_id,
        qty,
        harga,
        subtotal
    )
    VALUES(
            '$order_id',
        '$produk_id',
        '$qty',
        '$harga',
        '$subtotal'
    )
    ");

    mysqli_query($koneksi, "
    UPDATE produk
    SET stok = stok - $qty
    WHERE produk_id = '$produk_id'
    ");
}

echo json_encode([
    'status' => 'success',
    'invoice' => $invoice
]);