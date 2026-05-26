<?php
// ============================================================
//  FILE DEBUG — HAPUS FILE INI SETELAH SELESAI TESTING!
//  Akses via: http://localhost/CODINGAN/YUNA/Bu_Ana/toko_fanda_updated/debug_midtrans.php
// ============================================================

include 'midtrans_config.php';

echo "<style>
body{font-family:monospace;padding:30px;background:#f5f5f5}
.ok{color:green;font-weight:bold}
.err{color:red;font-weight:bold}
.warn{color:orange;font-weight:bold}
.box{background:#fff;padding:20px;border-radius:8px;margin-bottom:16px;border:1px solid #ddd}
pre{background:#eee;padding:12px;border-radius:6px;overflow:auto;font-size:13px}
</style>";

echo "<h2>🔍 Debug Midtrans</h2>";

// ============================================================
//  CEK 1: cURL tersedia?
// ============================================================
echo "<div class='box'><b>1. cURL Extension</b><br><br>";
if (function_exists('curl_init')) {
    echo "<span class='ok'>✅ cURL aktif</span>";
} else {
    echo "<span class='err'>❌ cURL TIDAK aktif!</span><br>";
    echo "Buka <code>php.ini</code> di XAMPP → cari <code>;extension=curl</code> → hapus titik koma → restart Apache";
}
echo "</div>";

// ============================================================
//  CEK 2: OpenSSL tersedia?
// ============================================================
echo "<div class='box'><b>2. OpenSSL Extension</b><br><br>";
if (extension_loaded('openssl')) {
    echo "<span class='ok'>✅ OpenSSL aktif</span>";
} else {
    echo "<span class='err'>❌ OpenSSL TIDAK aktif!</span><br>";
    echo "Aktifkan <code>extension=openssl</code> di php.ini";
}
echo "</div>";

// ============================================================
//  CEK 3: Key sudah diisi?
// ============================================================
echo "<div class='box'><b>3. Midtrans Keys</b><br><br>";

$sk = MIDTRANS_SERVER_KEY;
$ck = MIDTRANS_CLIENT_KEY;

if (strpos($sk, 'GANTI') !== false) {
    echo "<span class='err'>❌ SERVER_KEY masih placeholder! Belum diisi.</span>";
} elseif (!str_starts_with($sk, 'SB-Mid-server-')) {
    echo "<span class='err'>❌ SERVER_KEY formatnya salah: <code>$sk</code></span><br>";
    echo "Harus diawali <code>SB-Mid-server-</code>";
} else {
    echo "<span class='ok'>✅ Server Key format OK:</span> <code>" . substr($sk, 0, 20) . "...</code><br>";
}

echo "<br>";

if (strpos($ck, 'GANTI') !== false) {
    echo "<span class='err'>❌ CLIENT_KEY masih placeholder! Belum diisi.</span>";
} elseif (!str_starts_with($ck, 'SB-Mid-client-')) {
    echo "<span class='err'>❌ CLIENT_KEY formatnya salah: <code>$ck</code></span><br>";
    echo "Harus diawali <code>SB-Mid-client-</code>";
} else {
    echo "<span class='ok'>✅ Client Key format OK:</span> <code>" . substr($ck, 0, 20) . "...</code><br>";
}

echo "</div>";

// ============================================================
//  CEK 4: Test koneksi langsung ke Midtrans API
// ============================================================
echo "<div class='box'><b>4. Test Koneksi ke Midtrans API</b><br><br>";

if (!function_exists('curl_init')) {
    echo "<span class='warn'>⚠️ Skip — cURL tidak tersedia</span>";
} else {
    $auth    = base64_encode(MIDTRANS_SERVER_KEY . ':');
    $payload = [
        'transaction_details' => [
            'order_id'     => 'TEST-' . time(),
            'gross_amount' => 10000,
        ],
        'item_details' => [[
            'id'       => 'ITEM-1',
            'price'    => 10000,
            'quantity' => 1,
            'name'     => 'Test Item',
        ]],
        'customer_details' => [
            'first_name' => 'Test',
            'email'      => 'test@test.com',
        ],
    ];

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
        CURLOPT_TIMEOUT        => 15,
    ]);

    $response = curl_exec($ch);
    $err      = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($err) {
        echo "<span class='err'>❌ cURL Error: $err</span>";
    } else {
        $data = json_decode($response, true);
        echo "HTTP Status: <b>$httpCode</b><br><br>";

        if ($httpCode === 201 && !empty($data['token'])) {
            echo "<span class='ok'>✅ BERHASIL! Token didapat: <code>" . substr($data['token'], 0, 30) . "...</code></span><br>";
            echo "<span class='ok'>Integrasi Midtrans berjalan normal 🎉</span>";
        } elseif ($httpCode === 401) {
            echo "<span class='err'>❌ HTTP 401 — Server Key SALAH atau tidak valid!</span><br>";
            echo "Pastikan key yang di-copy dari dashboard sudah benar.";
        } elseif ($httpCode === 400) {
            echo "<span class='warn'>⚠️ HTTP 400 — Request tidak valid:</span><br>";
            echo "<pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
        } else {
            echo "<span class='warn'>Response HTTP $httpCode:</span><br>";
            echo "<pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
        }
    }
}

echo "</div>";

echo "<hr><p style='color:#aaa;font-size:12px'>⚠️ Hapus file <code>debug_midtrans.php</code> ini setelah selesai!</p>";
