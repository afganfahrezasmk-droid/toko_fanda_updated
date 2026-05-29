# Tutorial Integrasi Xendit — Toko Kue Fanda
## Estimasi waktu: 30–60 menit

---

## LANGKAH 1 — Daftar & Setup Akun Xendit

1. Buka https://dashboard.xendit.co/register
2. Daftar pakai email aktif kamu
3. Verifikasi email
4. Login ke dashboard

### Ambil API Key (Mode Development dulu)
1. Di dashboard Xendit, klik **Settings** (kiri bawah)
2. Pilih **API Keys**
3. Klik **"Generate secret key"**
4. Salin **Secret Key** (format: `xnd_development_xxxx...`)
5. Salin juga **Public Key** (format: `xnd_public_development_xxxx...`)

### Ambil Webhook Token
1. Masih di Settings, pilih **Webhooks**
2. Lihat bagian **"Verification Token"** — salin tokennya

---

## LANGKAH 2 — Tempel File Baru ke Project

Struktur file yang perlu diganti/ditambah:

```
toko_fanda/
├── xendit_config.php          ← GANTI midtrans_config.php (letakkan di root)
├── pelanggan/
│   ├── proses_transaksi.php   ← GANTI yang lama
│   ├── bayar_xendit.php       ← FILE BARU (hapus bayar_midtrans.php)
│   └── xendit_notifikasi.php  ← FILE BARU (hapus midtrans_notifikasi.php)
└── kasir/
    ├── order_aksi.php         ← GANTI yang lama (pakai kasir_order_aksi.php)
    └── bayar_xendit.php       ← FILE BARU (hapus bayar_midtrans.php)
```

### Cara rename file yang diberikan:
| File yang diberikan          | Letakkan di                          |
|------------------------------|--------------------------------------|
| xendit_config.php            | /toko_fanda/xendit_config.php        |
| proses_transaksi.php         | /toko_fanda/pelanggan/               |
| bayar_xendit.php             | /toko_fanda/pelanggan/               |
| xendit_notifikasi.php        | /toko_fanda/pelanggan/               |
| kasir_order_aksi.php         | /toko_fanda/kasir/order_aksi.php     |
| kasir_bayar_xendit.php       | /toko_fanda/kasir/bayar_xendit.php   |

---

## LANGKAH 3 — Isi API Key di xendit_config.php

Buka `xendit_config.php`, ganti 3 bagian ini:

```php
define('XENDIT_SECRET_KEY',   'xnd_development_XXXXXXXX'); // ← ganti
define('XENDIT_PUBLIC_KEY',   'xnd_public_development_XX'); // ← ganti
define('XENDIT_WEBHOOK_TOKEN', 'WEBHOOK_TOKEN_DARI_DASHBOARD'); // ← ganti
```

Untuk testing (development), biarkan:
```php
define('XENDIT_IS_PRODUCTION', false);
```

---

## LANGKAH 4 — Setup Redirect URL

Di `proses_transaksi.php` dan `kasir_order_aksi.php`, cari bagian ini dan sesuaikan
dengan path project kamu di localhost:

```php
'success_redirect_url' => 'http://localhost/toko_fanda/pelanggan/invoice.php?...',
'failure_redirect_url' => 'http://localhost/toko_fanda/pelanggan/invoice.php?...',
```

Ganti `toko_fanda` dengan nama folder project kamu di htdocs.

---

## LANGKAH 5 — Setup ngrok untuk Webhook

Xendit butuh URL publik untuk kirim notifikasi ke laptopmu saat ada pembayaran.

### Install ngrok
1. Buka https://ngrok.com/download
2. Download versi Windows
3. Extract, lalu buka `ngrok.exe`

### Jalankan ngrok
```bash
ngrok http 80
```

Nanti muncul URL seperti:
```
Forwarding  https://abc123.ngrok.io → http://localhost:80
```

Salin URL itu (yang https).

### Set webhook di Xendit Dashboard
1. Dashboard Xendit → **Settings** → **Webhooks**
2. Klik **"+ Add webhook URL"**
3. Pilih event: **Invoice** → **invoice.paid** dan **invoice.expired**
4. Isi URL: `https://abc123.ngrok.io/toko_fanda/pelanggan/xendit_notifikasi.php`
5. Klik Save

⚠️ Setiap kali ngrok dimatikan dan dijalankan lagi, URL berubah.
   Harus update lagi di dashboard Xendit.

---

## LANGKAH 6 — Testing

### Test QRIS
1. Buka web toko sebagai pelanggan
2. Tambah produk ke keranjang
3. Pilih metode pembayaran: **QRIS**
4. Klik Bayar → akan redirect ke halaman Xendit
5. Di halaman Xendit ada QR Code yang bisa di-scan pakai GoPay / OVO / Dana / m-banking apapun

### Test Transfer Bank
1. Sama seperti di atas, tapi pilih **Transfer Bank**
2. Di halaman Xendit pilih bank (BCA, BRI, dll)
3. Akan muncul nomor Virtual Account

### Cek status di dashboard Xendit
Buka https://dashboard.xendit.co → **Invoices** → lihat status transaksi

---

## LANGKAH 7 — Go Live (Untuk Demo Beneran ke Guru)

Kalau mau uang beneran masuk ke rekeningmu:

1. Di dashboard Xendit klik **"Upgrade to Production"**
2. Isi data: nama, KTP, rekening bank
3. Tunggu verifikasi (biasanya 1–4 jam, lebih cepat dari Midtrans)
4. Setelah approve, ganti di `xendit_config.php`:
   ```php
   define('XENDIT_SECRET_KEY',   'xnd_production_xxxx'); // key baru dari production
   define('XENDIT_IS_PRODUCTION', true);
   ```

---

## Troubleshooting

**Q: Redirect ke Xendit tapi muncul error "Invalid API Key"**
A: Pastikan Secret Key sudah benar di xendit_config.php. Cek juga tidak ada spasi tersembunyi.

**Q: Setelah bayar, status di DB tidak berubah**
A: Webhook belum terpasang atau ngrok mati. Pastikan ngrok jalan dan URL webhook benar.

**Q: QRIS tidak muncul di halaman Xendit**
A: Di mode development, QRIS kadang perlu diaktifkan. Coba test pakai Virtual Account dulu.
   Atau login ke dashboard Xendit → Settings → Payment Methods → aktifkan QRIS.

**Q: URL redirect setelah bayar salah**
A: Cek `success_redirect_url` di proses_transaksi.php, sesuaikan dengan path project kamu.
