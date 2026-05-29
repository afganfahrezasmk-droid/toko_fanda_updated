<?php
// Bypass ngrok browser warning
header('ngrok-skip-browser-warning: true');

include '../koneksi.php';
include '../xendit_config.php';

/** @var mysqli $koneksi */

// Hanya terima POST
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

$external_id = $data['external_id'] ?? '';
$status      = $data['status']      ?? '';
$paid_amount = $data['paid_amount'] ?? 0;

// 3. MAPPING STATUS XENDIT → STATUS ENUM DATABASE
// Database ENUM: 'pending','diproses','selesai','dibatalkan'
$new_status = null;

if ($status === 'PAID') {
    $new_status = 'selesai';
} elseif ($status === 'EXPIRED' || $status === 'FAILED') {
    $new_status = 'dibatalkan';
} elseif ($status === 'PENDING') {
    $new_status = 'pending';
}

// 4. UPDATE DATABASE
if ($new_status !== null && !empty($external_id)) {

    $invoice_esc = mysqli_real_escape_string($koneksi, $external_id);
    $status_esc  = mysqli_real_escape_string($koneksi, $new_status);

    mysqli_query($koneksi, "
        UPDATE orders
        SET status = '$status_esc'
        WHERE invoice = '$invoice_esc'
    ");

    if ($new_status === 'selesai') {
        $gross = (int)$paid_amount;

        $row = mysqli_fetch_assoc(mysqli_query($koneksi, "
            SELECT orders_id FROM orders WHERE invoice = '$invoice_esc'
        "));

        if ($row) {
            $oid = (int)$row['orders_id'];
            mysqli_query($koneksi, "
                UPDATE pembayaran
                SET bayar     = '$gross',
                    kembalian = 0
                WHERE orders_id = '$oid'
            ");
        }
    }
}

// 5. BALAS 200 OK
http_response_code(200);
echo 'OK';