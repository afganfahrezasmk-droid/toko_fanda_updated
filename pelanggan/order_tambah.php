<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */
?>

<style>
.keranjang-wrap{
    max-width:1200px;
    margin:0 auto;
    padding:40px 24px 70px;
}
.keranjang-judul{font-size:1.6rem;font-weight:700;margin-bottom:24px;color:var(--text-dark)}
.keranjang-kosong{text-align:center;padding:60px 20px;color:#888}
.keranjang-kosong .icon{font-size:3.5rem;margin-bottom:16px}
.keranjang-kosong p{margin-bottom:20px;font-size:1rem}
.tabel-keranjang{width:100%;border-collapse:collapse;margin-bottom:24px}
.tabel-keranjang th{background:#f8f8f8;padding:12px 16px;text-align:left;font-size:.85rem;color:#555;border-bottom:2px solid #eee}
.tabel-keranjang td{padding:14px 16px;border-bottom:1px solid #f0f0f0;vertical-align:middle}
.produk-info{display:flex;align-items:center;gap:14px}
.produk-gambar{width:60px;height:60px;object-fit:cover;border-radius:10px;flex-shrink:0}
.produk-nama{font-weight:600;font-size:.95rem;color:var(--text-dark)}
.produk-harga{font-size:.82rem;color:#888;margin-top:2px}
.qty-control{display:flex;align-items:center;gap:8px}
.qty-btn{width:30px;height:30px;border-radius:50%;border:1.5px solid #ddd;background:#fff;cursor:pointer;font-size:1.1rem;display:flex;align-items:center;justify-content:center;transition:all .2s;font-weight:700}
.qty-btn:hover{background:var(--accent-gold);border-color:var(--accent-gold);color:#fff}
.qty-val{font-weight:600;font-size:1rem;min-width:28px;text-align:center}
.btn-hapus{background:none;border:none;color:#e74c3c;cursor:pointer;font-size:.82rem;padding:4px 8px;border-radius:6px;transition:background .2s}
.btn-hapus:hover{background:#ffeaea}
.subtotal{font-weight:600;color:var(--text-dark)}
.card-summary{background:#fff;border:1px solid #eee;border-radius:14px;padding:24px;margin-bottom:20px}
.card-summary h5{font-size:1rem;font-weight:700;margin-bottom:16px;color:var(--text-dark)}
.summary-row{display:flex;justify-content:space-between;margin-bottom:10px;font-size:.9rem;color:#555}
.summary-row.total{border-top:2px solid #eee;padding-top:12px;margin-top:4px;font-weight:700;font-size:1rem;color:var(--text-dark)}
.metode-wrap{margin-bottom:20px}
.metode-wrap label{display:block;font-weight:600;margin-bottom:10px;font-size:.9rem}
.metode-grid{display:flex;gap:10px;flex-wrap:wrap}
.metode-btn{padding:10px 20px;border-radius:10px;border:2px solid #ddd;background:#fff;cursor:pointer;font-size:.88rem;font-weight:500;transition:all .2s;display:flex;align-items:center;gap:8px}
.metode-btn.active,.metode-btn:hover{border-color:var(--accent-gold);background:#fff8ee;color:var(--text-dark)}
.btn-order{width:100%;padding:15px;border-radius:12px;background:var(--accent-gold);color:#fff;font-size:1rem;font-weight:700;border:none;cursor:pointer;transition:opacity .2s;letter-spacing:.02em}
.btn-order:hover{opacity:.88}
.btn-order:disabled{opacity:.4;cursor:not-allowed}
.btn-back{display:inline-flex;align-items:center;gap:6px;color:#888;font-size:.85rem;margin-bottom:20px;cursor:pointer;background:none;border:none;padding:0}
.btn-back:hover{color:var(--text-dark)}
</style>

<div class="keranjang-wrap">

   <!-- TOP HEADER -->
    <div class="mb-4">
<br>
        <!-- BUTTON BACK -->
        <div class="mb-4">

            <a href="index.php"
            class="btn btn-outline-dark rounded-pill px-4 py-2 shadow-sm">

                <i class="fa fa-arrow-left me-2"></i>
                Kembali Belanja

            </a>

        </div>
<br>
        <!-- TITLE -->
        <div class="text-center">

            <h2 class="keranjang-judul mb-2">

                <i class="fa fa-cart-shopping me-2"></i>
                Keranjang Belanja

            </h2>

            <p class="text-muted mb-0">
                Periksa kembali pesanan kamu sebelum checkout
            </p>

        </div>

    </div>

    <!-- KERANJANG KOSONG -->
    <div id="keranjangKosong" style="display:none">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center py-5">

                <!-- ICON -->
                <div style="
                    width:110px;
                    height:110px;
                    margin:auto;
                    border-radius:50%;
                    background:#fff3e4;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:2.8rem;
                    color:#d4a25a;
                    margin-bottom:25px;
                ">

                    <i class="fa fa-cart-shopping"></i>

                </div>

                <!-- TEXT -->
                <h4 class="fw-bold mb-2">
                    Keranjang Masih Kosong
                </h4>

                <p class="text-muted mb-4">
                    Yuk pilih kue favorit kamu dulu 🍰
                </p>

                <!-- BUTTON -->
                <a href="index.php"
                   class="btn btn-warning px-4 py-2 rounded-pill shadow-sm">

                    <i class="fa fa-cookie-bite me-2"></i>
                    Lihat Menu

                </a>

            </div>

        </div>

    </div>

    <!-- ISI KERANJANG -->
    <div id="keranjangIsi">
        <div class="card shadow-sm" style="border-radius:14px;overflow:hidden;margin-bottom:20px">
            <table class="tabel-keranjang" id="tabelKeranjang">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="bodyKeranjang"></tbody>
            </table>
        </div>

        <!-- SUMMARY & METODE -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
            <div>
                <div class="metode-wrap">
                    <label>Metode Pembayaran</label>
                    <div class="metode-grid">
                        <button class="metode-btn" data-metode="Cash" onclick="pilihMetode(this)">💵 Cash</button>
                        <button class="metode-btn" data-metode="Transfer" onclick="pilihMetode(this)">🏦 Transfer</button>
                        <button class="metode-btn" data-metode="QRIS" onclick="pilihMetode(this)">📱 QRIS</button>
                    </div>
                </div>
            </div>
            <div class="card-summary">

                    <h5>Ringkasan Belanja</h5>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="sumSubtotal">Rp 0</span>
                    </div>

                    <div class="summary-row">
                        <span>Pajak (10%)</span>
                        <span id="sumPajak">Rp 0</span>
                    </div>

                    <div class="summary-row total">
                        <span>Total Belanja</span>
                        <span id="sumTotal">Rp 0</span>
                    </div>

                </div>

                <!-- TOTAL BELANJA -->
                <div style="margin-top:18px">

                    <label style="
                        font-weight:600;
                        margin-bottom:8px;
                        display:block;
                    ">
                        Total Yang Harus Dibayar
                    </label>

                    <input type="text"
                        id="totalBelanjaView"
                        readonly
                        value="Rp 0"
                        style="
                        width:100%;
                        padding:12px;
                        border-radius:10px;
                        border:1px solid #ddd;
                        background:#f8f8f8;
                        font-weight:700;
                        ">

                </div>

                <!-- INPUT BAYAR -->
                <div style="margin-top:15px">

                    <label style="
                        font-weight:600;
                        margin-bottom:8px;
                        display:block;
                    ">
                        Uang Pembayaran
                    </label>

                    <input type="text"
                        id="inputBayarView"
                        placeholder="Contoh: 200000"
                        oninput="formatBayar(this); hitungKembalian();"
                        style="
                        width:100%;
                        padding:12px;
                        border-radius:10px;
                        border:1px solid #ddd;
                        ">

                </div>

                <!-- KEMBALIAN -->
                <div style="margin-top:15px">

                    <label style="
                        font-weight:600;
                        margin-bottom:8px;
                        display:block;
                    ">
                        Kembalian
                    </label>

                    <input type="text"
                        id="viewKembalian"
                        readonly
                        value="Rp 0"
                        style="
                        width:100%;
                        padding:12px;
                        border-radius:10px;
                        border:1px solid #ddd;
                        background:#f8f8f8;
                        font-weight:700;
                        color:green;
                        ">

                </div>

                <button class="btn-order" id="btnOrder" onclick="submitOrder()" disabled>Buat Pesanan</button>
            </div>
        </div>
    </div>
</div>

<!-- Form tersembunyi untuk submit ke order_aksi.php -->
<form id="formOrder" method="POST" action="proses_transaksi.php">
    <input type="hidden" name="user_id" value="<?=htmlspecialchars($_SESSION['user_id'] ?? '')?>">
    <input type="hidden" name="invoice" id="inputInvoice">
    <input type="hidden" name="metode_pembayaran" id="inputMetode">
    <input type="hidden" name="bayar" id="inputBayar">
    <div id="inputProduk"></div>
</form>

<!-- Data produk dari DB (untuk validasi stok) -->
<script>
const produkDB = <?php
$data = [];

$all = mysqli_query($koneksi, "SELECT produk_id,nama_produk,harga,stok,gambar FROM produk");

while($r = mysqli_fetch_assoc($all)){
    $data[$r['produk_id']] = [
        "id"     => (int)$r['produk_id'],
        "nama"   => $r['nama_produk'],
        "harga"  => (int)$r['harga'],
        "stok"   => (int)$r['stok'],
        "gambar" => $r['gambar']
    ];
}

echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>;


let cart      = JSON.parse(localStorage.getItem('fanda_cart')) || {};
let metodeDipilih = '';
let totalBelanja = 0;

function fmt(n){ return 'Rp ' + n.toLocaleString('id-ID'); }

function renderKeranjang(){

    const keys = Object.keys(cart).filter(k => cart[k].qty > 0);

    if(keys.length === 0){

        document.getElementById('keranjangKosong').style.display = '';
        document.getElementById('keranjangIsi').style.display = 'none';

        const badge = document.getElementById('cartBadge');

        if(badge){
            badge.textContent = '0';
        }

        return;
    }

    document.getElementById('keranjangKosong').style.display = 'none';
    document.getElementById('keranjangIsi').style.display = '';

    let html = '';
    let subtotal = 0;

    keys.forEach(id => {

        const item = cart[id];
        const db   = produkDB[id];

        if(!db) return;

        const sub = item.harga * item.qty;

        subtotal += sub;

        const gambar = `../gambar/${db.gambar}`;

        html += `
        <tr id="row-${id}">

            <td>
                <div class="produk-info">

                    <img 
                        src="${gambar}" 
                        alt="${item.nama}" 
                        class="produk-gambar"
                        onerror="this.src='../gambar/default.jpeg'"
                    >

                    <div>
                        <div class="produk-nama">
                            ${item.nama}
                        </div>

                        <div class="produk-harga">
                            ${fmt(item.harga)}
                        </div>
                    </div>

                </div>
            </td>

            <td>
                ${fmt(item.harga)}
            </td>

            <td>
                <div class="qty-control">

                    <button 
                        type="button"
                        class="qty-btn"
                        onclick="ubahQty('${id}',-1)"
                    >
                        −
                    </button>

                    <span class="qty-val">
                        ${item.qty}
                    </span>

                    <button 
                        type="button"
                        class="qty-btn"
                        onclick="ubahQty('${id}',1)"
                    >
                        +
                    </button>

                </div>
            </td>

            <td>

                <div class="subtotal">
                    ${fmt(sub)}
                </div>

                <small style="color:#888">
                    ${item.qty} x ${fmt(item.harga)}
                </small>

            </td>

            <td>

                <button
                    type="button"
                    class="btn-hapus"
                    onclick="hapusItem('${id}')"
                >
                    🗑 Hapus
                </button>

            </td>

        </tr>
        `;
    });

    document.getElementById('bodyKeranjang').innerHTML = html;

    // HITUNG TOTAL
    const pajak = Math.round(subtotal * 0.1);

    const total = subtotal + pajak;

    totalBelanja = total;

    // TAMPILKAN
    document.getElementById('sumSubtotal').textContent = fmt(subtotal);

    document.getElementById('sumPajak').textContent = fmt(pajak);

    document.getElementById('sumTotal').textContent = fmt(total);

    document.getElementById('totalBelanjaView').value = fmt(total);

    // UPDATE KEMBALIAN
    hitungKembalian();

    // UPDATE BADGE
    const totalQty = keys.reduce((s,k) => s + cart[k].qty, 0);

    const badge = document.getElementById('cartBadge');

    if(badge){
        badge.textContent = totalQty;
    }

    updateTombolOrder();
}

function ubahQty(id, delta){
    if(!cart[id]) return;
    const db   = produkDB[id];
    const maks = db ? db.stok : 99;
    cart[id].qty = Math.max(0, Math.min(cart[id].qty + delta, maks));
    if(cart[id].qty === 0){ delete cart[id]; }
    localStorage.setItem('fanda_cart', JSON.stringify(cart));
    renderKeranjang();
}

function hapusItem(id){
    delete cart[id];
    localStorage.setItem('fanda_cart', JSON.stringify(cart));
    renderKeranjang();
}

function pilihMetode(el){
    document.querySelectorAll('.metode-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    metodeDipilih = el.dataset.metode;
    updateTombolOrder();
}

function updateTombolOrder(){
    const adaItem   = Object.keys(cart).filter(k => cart[k].qty > 0).length > 0;
    const adaMetode = metodeDipilih !== '';
    document.getElementById('btnOrder').disabled = !(adaItem && adaMetode);
}

function hitungKembalian(){

    let bayar = document
        .getElementById('inputBayarView')
        .value;

    // hapus semua selain angka
    bayar = bayar.replace(/\D/g,'');

    bayar = parseInt(bayar) || 0;

    let kembali = bayar - totalBelanja;

    if(kembali < 0){

        kembali = 0;

    }

    document.getElementById('viewKembalian').value =
        fmt(kembali);
}

function formatBayar(input){

    let angka = input.value.replace(/\D/g,'');

    input.value = new Intl.NumberFormat('id-ID')
        .format(angka);

    hitungKembalian();
}

function submitOrder(){
    if(!metodeDipilih){ alert('Pilih metode pembayaran dulu!'); return; }
    const keys = Object.keys(cart).filter(k => cart[k].qty > 0);
    const bayar = parseInt(
        document.getElementById('inputBayarView')
        .value
        .replace(/\./g,'')
    ) || 0;

    if(bayar < totalBelanja){

        alert('Uang pembayaran kurang!');

        return;
    }

    document.getElementById('inputBayar').value = bayar;
    if(keys.length === 0){ alert('Keranjang kosong!'); return; }

    // Generate invoice
    const invoice = 'INV-' + Math.floor(1000 + Math.random() * 9000);
    document.getElementById('inputInvoice').value = invoice;
    document.getElementById('inputMetode').value  = metodeDipilih;

    // Build hidden inputs
    let inputHtml = '';
    keys.forEach(id => {
        inputHtml += `<input type="hidden" name="produk_id[]" value="${id}">`;
        inputHtml += `<input type="hidden" name="qty[]" value="${cart[id].qty}">`;
    });
    document.getElementById('inputProduk').innerHTML = inputHtml;

    document.getElementById('formOrder').submit();
}

renderKeranjang();
</script>

<?php include 'footer.php'; ?>