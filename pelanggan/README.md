# 🍰 TOKO KUE FANDA - UPDATE SISTEM KERANJANG & KATEGORI

## 📦 ISI FOLDER

```
├── index.php                 ← File HomePage (sudah diupdate)
├── order_tambah.php          ← File Keranjang (BARU - ganti file lama)
├── order_aksi.php            ← File Proses Order (BARU - ganti file lama)
├── order_invoice.php         ← File Struk Invoice (BARU - ganti file lama)
├── kategori.php              ← File Kategori (BARU - ganti file lama)
├── get_cart_items.php        ← File API Cart (BARU - tambah file baru)
└── PANDUAN_IMPLEMENTASI.md   ← Panduan lengkap implementasi
```

## ✨ FITUR UTAMA

### 1️⃣ KERANJANG BELANJA (Cart Management)
- Klik tombol "+ Keranjang" → langsung redirect ke halaman keranjang
- Lihat semua produk yang ditambahkan
- Ubah jumlah qty dengan tombol +/-
- Hapus produk dari keranjang
- Lihat total harga otomatis (termasuk pajak 10%)
- Pilih metode pembayaran (Cash, Transfer, QRIS)
- Submit order → langsung ke struk invoice

### 2️⃣ FILTER KATEGORI
- Klik kategori di halaman utama (index.php)
- Tampil halaman kategori dengan hanya produk kategori tersebut
- Navigasi antar kategori mudah
- Support kategori:
  - Semua Menu
  - Kue Kering
  - Kue Basah
  - Cookies
  - Cake & Brownies
  - Snack Manis

### 3️⃣ STRUK INVOICE (Invoice Display)
- Desain profesional & modern
- Informasi lengkap order
- List produk dengan qty dan harga
- Total + Pajak + Grand Total
- Status order
- Tombol cetak untuk struk fisik

## 🚀 CARA INSTALL

### Option 1: Ganti File Manual
1. Backup file lama:
   ```
   order_tambah.php.backup
   order_aksi.php.backup
   order_invoice.php.backup
   kategori.php.backup
   ```

2. Hapus file lama dari folder pelanggan

3. Copy file baru dari folder ini ke folder pelanggan

4. Update bagian JavaScript di index.php (lihat PANDUAN_IMPLEMENTASI.md)

### Option 2: Menggunakan Terminal
```bash
cd /path/to/pelanggan/

# Backup
cp order_tambah.php order_tambah.php.backup
cp order_aksi.php order_aksi.php.backup
cp order_invoice.php order_invoice.php.backup
cp kategori.php kategori.php.backup

# Copy file baru
cp /path/ke/folder/output/order_tambah.php .
cp /path/ke/folder/output/order_aksi.php .
cp /path/ke/folder/output/order_invoice.php .
cp /path/ke/folder/output/kategori.php .
cp /path/ke/folder/output/get_cart_items.php .
cp /path/ke/folder/output/index.php .
```

## ⚙️ KONFIGURASI

### 1. Database
Pastikan tabel sudah ada:
```sql
-- Kolom required di tabel orders
orders_id (INT, PK)
invoice (VARCHAR)
user_id (INT, FK)
total (DECIMAL)
pajak (DECIMAL)
metode_pembayaran (VARCHAR)
status (VARCHAR) -- 'pending', 'completed', dll
created_at (TIMESTAMP) -- optional tapi recommended

-- Kolom required di tabel produk
produk_id (INT, PK)
nama_produk (VARCHAR)
harga (DECIMAL)
stok (INT)
gambar (VARCHAR)

-- Kolom required di tabel order_items
order_items_id (INT, PK)
orders_id (INT, FK)
produk_id (INT, FK)
qty (INT)
harga (DECIMAL)
subtotal (DECIMAL)
```

### 2. Session & Login
Pastikan sebelum order, user sudah login dengan role 'pelanggan':
```php
$_SESSION['role'] = 'pelanggan';
$_SESSION['user_id'] = 123; // ID user
```

### 3. Path File
Pastikan path file benar:
- Header & Footer: `include 'header.php'`
- Koneksi DB: `include '../koneksi.php'`
- Gambar produk: `../gambar/namedgambar.jpeg`

## 🧪 TESTING

### Test Checklist:
1. ✅ Buka index.php → Lihat produk
2. ✅ Klik "+ Keranjang" → Redirect ke order_tambah.php
3. ✅ Lihat item di cart dengan qty benar
4. ✅ Ubah qty dengan +/- → Total berubah
5. ✅ Hapus item → Item hilang dari cart
6. ✅ Klik kategori → Filter produk bekerja
7. ✅ Pilih metode pembayaran → Submit berhasil
8. ✅ Invoice muncul → Struk tampil dengan benar
9. ✅ Klik cetak → Print preview muncul

## 🎨 DESIGN NOTES

- **Theme**: French Patisserie × Editorial Luxury
- **Color Scheme**: Cream, Caramel, Gold, Espresso
- **Font**: DM Sans (sans-serif), Cormorant Garamond (serif)
- **Responsive**: Mobile, Tablet, Desktop
- **Modern UI**: Smooth transitions, shadows, rounded corners

## 💾 LOCALSTORAGE

Cart disimpan di browser menggunakan localStorage:
```javascript
// Format
{
  "1": 2,      // produk_id: quantity
  "3": 1,
  "5": 3
}

// Akses
localStorage.getItem('cart')
localStorage.setItem('cart', JSON.stringify(cartData))
localStorage.removeItem('cart') // Clear cart
```

⚠️ **CATATAN**: Cart akan hilang jika user clear browser cache/cookies

## 📱 RESPONSIVE

Semua halaman sudah mobile-friendly dengan breakpoints:
- Mobile: < 600px
- Tablet: 600px - 1024px
- Desktop: > 1024px

## 🔐 SECURITY

- ✅ Check user login & role
- ✅ Input validation server-side
- ✅ HTML escape untuk output
- ✅ Query prepared (rekomendasi untuk update)
- ✅ Session validation di setiap page

## 📞 TROUBLESHOOTING

### Error: "Keranjang kosong"
- Pastikan sudah klik "+ Keranjang" terlebih dahulu
- Clear browser cache & reload

### Error: "Stok tidak mencukupi"
- Update stok di database
- Pastikan qty yang dipesan tidak lebih dari stok

### Error: "Database connection error"
- Check koneksi.php
- Pastikan database running
- Verify credentials

### Halaman blank / error
- Check PHP error log
- Verify semua file sudah di-upload
- Check file permissions (755 untuk folder, 644 untuk file)

## 📚 DOKUMENTASI LENGKAP

Baca file **PANDUAN_IMPLEMENTASI.md** untuk penjelasan detail

## 🎯 WORKFLOW ALUR

```
┌─────────────┐
│ index.php   │  User lihat produk
└──────┬──────┘
       │ Klik "+ Keranjang"
       ▼
┌─────────────────────┐
│ order_tambah.php    │  Lihat semua item di cart
│ (Cart Management)   │  Ubah qty, hapus item
└──────┬──────────────┘
       │ Pilih metode bayar & submit
       ▼
┌──────────────────┐
│ order_aksi.php   │  Proses order
│ (Processing)     │  Hitung total
└──────┬───────────┘
       │ Insert ke database
       ▼
┌────────────────────┐
│ order_invoice.php  │  Tampil struk
│ (Invoice/Receipt)  │  Bisa cetak
└────────────────────┘
```

## 📋 FILE SIZE

- order_tambah.php: ~10 KB
- order_aksi.php: ~4 KB
- order_invoice.php: ~13 KB
- kategori.php: ~11 KB
- get_cart_items.php: <1 KB
- index.php: ~48 KB (ganti JavaScript saja)

## 🆘 BANTUAN

Jika ada pertanyaan:
1. Cek PANDUAN_IMPLEMENTASI.md
2. Review error di browser console (F12)
3. Check server error log
4. Pastikan struktur database sesuai

---

**Made for: Toko Kue Fanda**  
**Date: 18 Mei 2024**  
**Version: 1.0**  
**Status: Production Ready ✅**
