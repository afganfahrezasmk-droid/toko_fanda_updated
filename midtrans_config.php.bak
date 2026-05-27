<?php

// ============================================================
//  MIDTRANS CONFIG
//  Ganti kedua key di bawah dengan key dari akun kamu
//  Dashboard: https://dashboard.sandbox.midtrans.com
//  Settings → Access Keys
// ============================================================

define('MIDTRANS_SERVER_KEY', 'Mid-server-PKsxhAPPeFsiOTmUZZj_d06W');
define('MIDTRANS_CLIENT_KEY', 'Mid-client-FNieV2hGdUA8F3d3');

// false  = Sandbox (testing)
// true   = Production (live, butuh verifikasi)
define('MIDTRANS_IS_PRODUCTION', false);

// URL Snap API (jangan diubah)
define('MIDTRANS_SNAP_URL',
    MIDTRANS_IS_PRODUCTION
        ? 'https://app.midtrans.com/snap/v1/transactions'
        : 'https://app.sandbox.midtrans.com/snap/v1/transactions'
);

// URL Snap.js (jangan diubah)
define('MIDTRANS_SNAP_JS',
    MIDTRANS_IS_PRODUCTION
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js'
);

// ============================================================
//  HELPER: Request token ke Midtrans Snap API
// ============================================================
function midtrans_get_snap_token(array $payload): ?string
{
    $auth = base64_encode(MIDTRANS_SERVER_KEY . ':');

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => MIDTRANS_SNAP_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . $auth,
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT        => 30,
    ]);

    $response = curl_exec($ch);
    $err      = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($err) {
        error_log('Midtrans cURL error: ' . $err);
        return null;
    }

    // Tulis log response ke file (hapus setelah testing)
    $log = date('Y-m-d H:i:s') . " | HTTP $httpCode | " . $response . "\n";
    file_put_contents(__DIR__ . '/midtrans_log.txt', $log, FILE_APPEND);

    $data = json_decode($response, true);

    return $data['token'] ?? null;
}

// ============================================================
//  HELPER: Verifikasi signature notifikasi dari Midtrans
// ============================================================
function midtrans_verify_signature(
    string $order_id,
    string $status_code,
    string $gross_amount
): string {
    return hash('sha512',
        $order_id . $status_code . $gross_amount . MIDTRANS_SERVER_KEY
    );
}