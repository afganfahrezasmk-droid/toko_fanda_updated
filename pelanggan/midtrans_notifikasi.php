<?php
// ============================================================
//  MIDTRANS NOTIFICATION HANDLER (Webhook)
//  URL ini di-set di dashboard Midtrans:
//  Settings → Configuration → Payment Notification URL
//  Contoh: https://domainmu.com/pelanggan/midtrans_notifikasi.php
// ============================================================

include '../koneksi.php';
include '../midtrans_config.php';

/** @var mysqli $koneksi */

// Hanya terima POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

// Ambil body JSON dari Midtrans
$body = file_get_contents('php://input');
$data = json_decode($body, true);

if (empty($data)) {
    http_response_code(400);
    exit('Invalid payload');
}

$order_id      = $data['order_id']         ?? '';
$status_code   = $data['status_code']      ?? '';
$gross_amount  = $data['gross_amount']     ?? '';
$sig_key       = $data['signature_key']    ?? '';
$trx_status    = $data['transaction_status'] ?? '';
$fraud_status  = $data['fraud_status']     ?? '';

// ============================================================
//  1. VERIFIKASI SIGNATURE
// ============================================================
$expected_sig = midtrans_verify_signature($order_id, $status_code, $gross_amount);

if ($sig_key !== $expected_sig) {
    http_response_code(403);
    exit('Invalid signature');
}

// ============================================================
//  2. TENTUKAN STATUS ORDER
// ============================================================
// Mapping status Midtrans → status internal
// Referensi: https://docs.midtrans.com/reference/transaction-status

$new_status = null;

if ($trx_status === 'capture') {
    // Kartu kredit / QRIS yang langsung dikonfirmasi
    $new_status = ($fraud_status === 'challenge') ? 'pending' : 'dibayar';

} elseif ($trx_status === 'settlement') {
    // Transfer bank / VA setelah settlement
    $new_status = 'dibayar';

} elseif (in_array($trx_status, ['deny', 'cancel', 'expire'])) {
    $new_status = 'batal';

} elseif ($trx_status === 'pending') {
    $new_status = 'pending';
}

// ============================================================
//  3. UPDATE DATABASE
// ============================================================
if ($new_status !== null) {

    $invoice_esc = mysqli_real_escape_string($koneksi, $order_id);
    $status_esc  = mysqli_real_escape_string($koneksi, $new_status);

    // Update tabel orders
    $q = mysqli_query($koneksi, "
        UPDATE orders
        SET status = '$status_esc'
        WHERE invoice = '$invoice_esc'
    ");

    // Kalau pembayaran berhasil, update tabel pembayaran
    if ($new_status === 'dibayar') {

        $gross = (int) $gross_amount;

        // Ambil orders_id dulu
        $row = mysqli_fetch_assoc(mysqli_query($koneksi, "
            SELECT orders_id FROM orders
            WHERE invoice = '$invoice_esc'
        "));

        if ($row) {
            $oid = (int) $row['orders_id'];

            mysqli_query($koneksi, "
                UPDATE pembayaran
                SET bayar     = '$gross',
                    kembalian = 0
                WHERE orders_id = '$oid'
            ");
        }
    }
}

// ============================================================
//  4. BALAS 200 OK ke Midtrans
// ============================================================
http_response_code(200);
echo 'OK';
