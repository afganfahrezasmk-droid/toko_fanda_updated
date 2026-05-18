# ✅ CHECKLIST IMPLEMENTASI SISTEM KERANJANG & KATEGORI

## 📋 PERSIAPAN

- [ ] Backup semua file lama
  - [ ] order_tambah.php
  - [ ] order_aksi.php
  - [ ] order_invoice.php
  - [ ] kategori.php
  - [ ] index.php

- [ ] Verifikasi struktur database
  - [ ] Tabel `user` (sudah ada)
  - [ ] Tabel `produk` (sudah ada)
  - [ ] Tabel `orders` (sudah ada + pastikan ada kolom created_at)
  - [ ] Tabel `order_items` (sudah ada)
  - [ ] Tabel `kategori` (sudah ada)

## 📁 FILE REPLACEMENT

### Phase 1: Copy File Baru
- [ ] Copy `order_tambah.php` → pelanggan/order_tambah.php
- [ ] Copy `order_aksi.php` → pelanggan/order_aksi.php
- [ ] Copy `order_invoice.php` → pelanggan/order_invoice.php
- [ ] Copy `kategori.php` → pelanggan/kategori.php
- [ ] Copy `get_cart_items.php` → pelanggan/get_cart_items.php

### Phase 2: Update index.php
- [ ] Buka `index.php` di editor
- [ ] Cari section "Add-to-cart" (sekitar line 1131)
- [ ] **GANTI** kode JavaScript dari:
```javascript
/* Add-to-cart */
document.querySelectorAll('.btn-add, .p-overlay-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        e.stopPropagation();
        btn.style.transform = 'scale(.88)';
        btn.style.background = 'var(--caramel)';
        setTimeout(() => {
            btn.style.transform = '';
            btn.style.background = '';
        }, 300);
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            badge.textContent = +badge.textContent + 1;
            badge.style.transform = 'scale(1.4)';
            setTimeout(() => badge.style.transform = '', 250);
        }
    });
});
```

Dengan kode baru dari file yang sudah disiapkan:
```javascript
/* Cart Management */
let cart = JSON.parse(localStorage.getItem('cart')) || {};

function updateCartBadge() {
    const badge = document.querySelector('.cart-badge');
    const total = Object.values(cart).reduce((sum, qty) => sum + qty, 0);
    if (badge) {
        badge.textContent = total;
        if (total > 0) {
            badge.style.display = 'block';
            badge.style.transform = 'scale(1.4)';
            setTimeout(() => badge.style.transform = '', 250);
        } else {
            badge.style.display = 'none';
        }
    }
}

function getProductData(btn) {
    const card = btn.closest('.p-card');
    if (!card) return null;
    
    return {
        id: card.dataset.productId || card.getAttribute('data-product-id'),
        name: card.querySelector('.p-name')?.textContent || '',
        price: card.querySelector('.p-price')?.textContent?.replace(/[^\d]/g, '') || '0',
        category: card.dataset.category || ''
    };
}

/* Add-to-cart dengan redirect ke keranjang */
document.querySelectorAll('.btn-add, .p-overlay-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        e.stopPropagation();
        
        const product = getProductData(btn);
        if (!product || !product.id) {
            alert('Data produk tidak lengkap');
            return;
        }
        
        // Tambah ke cart
        cart[product.id] = (cart[product.id] || 0) + 1;
        localStorage.setItem('cart', JSON.stringify(cart));
        
        // Animasi tombol
        btn.style.transform = 'scale(.88)';
        btn.style.background = 'var(--caramel)';
        setTimeout(() => {
            btn.style.transform = '';
            btn.style.background = '';
        }, 300);
        
        updateCartBadge();
        
        // Redirect ke order_tambah.php
        setTimeout(() => {
            window.location.href = 'order_tambah.php';
        }, 400);
    });
});

/* Category Filter */
document.querySelectorAll('.cat-card').forEach(card => {
    card.addEventListener('click', e => {
        e.preventDefault();
        const categoryName = card.querySelector('.cat-name')?.textContent || '';
        
        // Simpan kategori ke localStorage
        if (categoryName.toLowerCase() !== 'semua') {
            localStorage.setItem('selectedCategory', categoryName);
        } else {
            localStorage.removeItem('selectedCategory');
        }
        
        // Redirect ke kategori.php
        window.location.href = 'kategori.php?cat=' + encodeURIComponent(categoryName);
    });
});
```

- [ ] Save index.php

## 🔧 KONFIGURASI TEKNIS

### Database Updates
```sql
-- Jalankan query berikut jika belum ada kolom created_at di tabel orders:
ALTER TABLE orders ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- Pastikan semua tabel punya struktur yang sesuai:
DESC user;
DESC produk;
DESC orders;
DESC order_items;
DESC kategori;
```

- [ ] Kolom `created_at` sudah ada di tabel `orders`
- [ ] Semua kolom required ada di setiap tabel
- [ ] Foreign key sudah setup dengan benar

### File Koneksi
- [ ] File `../koneksi.php` ada dan berfungsi
- [ ] Session sudah di-start di awal file
- [ ] Variable `$koneksi` (mysqli) tersedia

### Session & User
- [ ] User harus login sebelum order
- [ ] `$_SESSION['role']` = 'pelanggan'
- [ ] `$_SESSION['user_id']` harus ada

## 🧪 TESTING PHASE 1: KERANJANG

### Test Homepage
- [ ] Buka index.php
- [ ] Lihat produk tampil dengan benar
- [ ] Badge cart ada di navbar (berisi angka 0 atau default)
- [ ] Semua tombol "+ Keranjang" ada

### Test Add to Cart
- [ ] Klik "+ Keranjang" pada produk pertama
- [ ] Browser redirect ke order_tambah.php
- [ ] Produk yang ditambahkan tampil di keranjang dengan qty=1
- [ ] Total dihitung dengan benar
- [ ] Klik "+ Keranjang" lagi pada produk berbeda
- [ ] Produk kedua ditambahkan ke cart
- [ ] Total updated dengan benar

### Test Cart Management
- [ ] Klik tombol + → qty naik, total updated
- [ ] Klik tombol - → qty turun, total updated
- [ ] Klik tombol Hapus → item hilang dari cart
- [ ] Jika semua item dihapus → tampil pesan "keranjang kosong"
- [ ] Clear localStorage → cart kosong (refresh page)

### Test Payment
- [ ] Dropdown metode pembayaran ada 3 pilihan
- [ ] Harga pajak = 10% dari subtotal
- [ ] Grand total = subtotal + pajak
- [ ] Bilangan uang format Indonesia (Rp X.XXX.XXX)

## 🧪 TESTING PHASE 2: KATEGORI

### Test Category Click
- [ ] Klik kategori "Kue Kering" di index.php
- [ ] Redirect ke kategori.php?cat=Kue+Kering
- [ ] Hanya produk Kue Kering tampil
- [ ] Navigation kategori muncul di halaman kategori
- [ ] Tombol "Kue Kering" terlihat active/highlighted

### Test Category Filter
- [ ] Klik "Semua Menu" → semua produk tampil
- [ ] Klik "Kue Basah" → hanya kue basah
- [ ] Klik "Cookies" → hanya cookies
- [ ] Klik "Cake & Brownies" → hanya cake & brownies
- [ ] Klik "Snack Manis" → hanya snack manis
- [ ] Tombol aktif berubah warna

### Test Category + Cart
- [ ] Di kategori, klik "+ Keranjang" pada produk
- [ ] Redirect ke order_tambah.php
- [ ] Produk dari kategori masuk ke cart dengan benar

## 🧪 TESTING PHASE 3: ORDER & INVOICE

### Test Order Processing
- [ ] Form invoice auto-filled
- [ ] User ID auto-set
- [ ] Metode pembayaran dipilih
- [ ] Klik submit order
- [ ] Database insert berhasil (cek tabel orders)
- [ ] order_items juga tersimpan

### Test Stock Update
- [ ] Sebelum order: cek stok produk di database
- [ ] Setelah order: stok berkurang sesuai qty yang dibeli
- [ ] Jika stok tidak cukup: tampil pesan error

### Test Invoice Display
- [ ] Halaman order_invoice.php tampil dengan benar
- [ ] Nomor invoice, order ID, nama pembeli muncul
- [ ] Detail produk lengkap dengan qty, harga, subtotal
- [ ] Total, Pajak, Grand Total dihitung benar
- [ ] Status order tampil
- [ ] Tampil pesan sukses

### Test Print Function
- [ ] Klik tombol "Cetak Struk"
- [ ] Print preview muncul
- [ ] Layout cetak bagus (tidak ada button)
- [ ] Data lengkap untuk dicetak

## 🔍 TESTING PHASE 4: EDGE CASES

### Test Validation
- [ ] Submit order tanpa pilih metode pembayaran → error
- [ ] Order dengan qty 0 → skip atau error
- [ ] Qty melebihi stok → tampil pesan "stok tidak cukupi"

### Test Browser Compatibility
- [ ] Chrome/Chromium ✓
- [ ] Firefox ✓
- [ ] Safari ✓
- [ ] Mobile Safari ✓
- [ ] Chrome Mobile ✓

### Test Responsive
- [ ] Desktop (1200px+) → layout bagus
- [ ] Tablet (768px-1199px) → layout responsif
- [ ] Mobile (<768px) → layout mobile-friendly

### Test Session & Auth
- [ ] Belum login → redirect ke login page
- [ ] Login sebagai admin → redirect ("bukan pelanggan")
- [ ] Login sebagai pelanggan → akses penuh

## 📊 MONITORING & LOGGING

- [ ] Setup error logging di PHP (optional)
- [ ] Monitor database untuk order baru
- [ ] Test error handling untuk DB connection error
- [ ] Test behavior saat server offline

## 🚀 DEPLOYMENT CHECKLIST

- [ ] Semua file sudah terupload ke server
- [ ] Permissions file tepat (644 file, 755 folder)
- [ ] Database sudah migrasi dengan benar
- [ ] Session berjalan dengan baik
- [ ] Email notification (optional)
- [ ] Backup database sebelum live

## 📈 POST-DEPLOYMENT

- [ ] Monitor order yang masuk
- [ ] Cek stok produk secara berkala
- [ ] Review customer feedback
- [ ] Check server logs untuk error
- [ ] Update produk/harga jika ada
- [ ] Maintain database (cleanup old orders jika perlu)

---

## ✅ FINAL VERIFICATION

- [ ] Semua checklist completed
- [ ] Testing passed untuk semua feature
- [ ] Database backup tersedia
- [ ] Documentation lengkap
- [ ] Team siap untuk support

**Status**: Ready for Production ✅  
**Date**: _____________________  
**Approved By**: ________________

---

**Jika ada yang tidak jelas, review PANDUAN_IMPLEMENTASI.md**
