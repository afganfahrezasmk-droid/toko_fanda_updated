<?php
header('ngrok-skip-browser-warning: true');

include '../koneksi.php';
include '../xendit_config.php';

/** @var mysqli $koneksi */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

// 1. VERIFIKASI TOKEN
$token = $_SERVER['HTTP_X_CALLBACK_TOKEN'] ?? '';

if (!xendit_verify_webhook($token)) {
    http_response_code(403);
    exit('Invalid webhook token');
}

// 2. AMBIL DATA
$body = file_get_contents('php://input');
$data = json_decode($body, true);

if (empty($data)) {
    http_response_code(400);
    exit('Invalid payload');
}

$external_id      = $data['external_id']       ?? '';
$status           = $data['status']            ?? '';
$paid_amount      = $data['paid_amount']       ?? 0;
$payment_method   = $data['payment_method']    ?? '';  // e.g. BANK_TRANSFER, QR_CODE, EWALLET
$payment_channel  = $data['payment_channel']   ?? '';  // e.g. BNI, BCA, OVO, dll

// 3. MAPPING STATUS
$order_status    = null;
$payment_status  = null;

if ($status === 'PAID') {
    $order_status   = 'selesai';
    $payment_status = 'lunas';
} elseif ($status === 'EXPIRED' || $status === 'FAILED') {
    $order_status   = 'dibatalkan';
    $payment_status = 'gagal';
} elseif ($status === 'PENDING') {
    $order_status   = 'pending';
    $payment_status = 'pending';
}

// 4. UPDATE DATABASE
if ($order_status !== null && !empty($external_id)) {

    $invoice_esc = mysqli_real_escape_string($koneksi, $external_id);
    $ostatus_esc = mysqli_real_escape_string($koneksi, $order_status);
    $pstatus_esc = mysqli_real_escape_string($koneksi, $payment_status);

    // Tentukan nama metode yang lebih deskriptif
    // Xendit kirim payment_channel berisi nama bank/dompet (BNI, BCA, OVO, dll)
    if (!empty($payment_channel)) {
        $metode_label = strtoupper($payment_channel); // BNI, BCA, DANA, dll
    } elseif (!empty($payment_method)) {
        $metode_label = $payment_method; // QR_CODE, BANK_TRANSFER, dll
    } else {
        $metode_label = '';
    }
    $metode_esc = mysqli_real_escape_string($koneksi, $metode_label);

    // Update status order
    mysqli_query($koneksi, "
        UPDATE orders
        SET status = '$ostatus_esc'
        WHERE invoice = '$invoice_esc'
    ");

    // Ambil orders_id
    $row = mysqli_fetch_assoc(mysqli_query($koneksi, "
        SELECT orders_id FROM orders WHERE invoice = '$invoice_esc'
    "));

    if ($row) {
        $oid   = (int)$row['orders_id'];
        $gross = (int)$paid_amount;

        // Update tabel pembayaran — bayar, status, dan metode (nama bank/dompet)
        $update_sql = "UPDATE pembayaran SET
            bayar              = '$gross',
            kembalian          = 0,
            status_pembayaran  = '$pstatus_esc'
            " . (!empty($metode_esc) ? ", metode = '$metode_esc'" : "") . "
        WHERE orders_id = '$oid'";

        mysqli_query($koneksi, $update_sql);
    }
}

// 5. BALAS 200 OK ke Xendit
http_response_code(200);
echo 'OK';