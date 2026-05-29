<?php

// ============================================================
//  XENDIT CONFIG — Toko Kue Fanda
// ============================================================

define('XENDIT_SECRET_KEY',    'xnd_development_ZBrCbdkixyyjimhihn6ue1zcrSgCWMYDLqM4Ql19qn28xf2D0RSJZUcqhqbOnpU7');
define('XENDIT_PUBLIC_KEY',    'xnd_public_development_7vT4RuHyNN2llPgHWVaESmxUPWSUB9Spy3NAhhtL5XvN2VBROUtk313E6ytyqR');
define('XENDIT_WEBHOOK_TOKEN', '4B2vO3dEzIGDUXrXRTrgL6goDcFz0YHkLUMrEzuQFkHhMStS');

// false = Test Mode (sandbox)
// true  = Production (uang beneran — ganti setelah verify bisnis)
define('XENDIT_IS_PRODUCTION', false);

define('XENDIT_API_URL', 'https://api.xendit.co');

// ============================================================
//  HELPER: Buat Invoice via Xendit API
// ============================================================
function xendit_create_invoice(array $payload): ?array
{
    $auth = base64_encode(XENDIT_SECRET_KEY . ':');

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => XENDIT_API_URL . '/v2/invoices',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
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
        error_log('Xendit cURL error: ' . $err);
        return null;
    }

    // Log untuk debugging (hapus setelah production)
    $log = date('Y-m-d H:i:s') . " | HTTP $httpCode | " . $response . "\n";
    file_put_contents(__DIR__ . '/xendit_log.txt', $log, FILE_APPEND);

    $data = json_decode($response, true);

    if (isset($data['invoice_url'])) {
        return [
            'invoice_url' => $data['invoice_url'],
            'invoice_id'  => $data['id'] ?? '',
        ];
    }

    return null;
}

// ============================================================
//  HELPER: Verifikasi webhook dari Xendit
// ============================================================
function xendit_verify_webhook(string $token): bool
{
    return hash_equals(XENDIT_WEBHOOK_TOKEN, $token);
}
