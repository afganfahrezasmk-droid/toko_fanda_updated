<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role'])) {
    header("location:../index.php?pesan=belum_login");
    exit;
}

if ($_SESSION['role'] != 'pelanggan') {
    header("location:../index.php?pesan=bukan_pelanggan");
    exit;
}
?>

<style>

.page-title{
    font-size:2rem;
    font-weight:700;
    color:#2d1b10;
}

.page-subtitle{
    color:#888;
    margin-top:5px;
}

.produk-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:24px;
    margin-top:30px;
}

.produk-card{
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.07);
    transition:.25s;
    border:1px solid #f1f1f1;
}

.produk-card:hover{
    transform:translateY(-6px);
    box-shadow:0 18px 35px rgba(0,0,0,.12);
}

.produk-img{
    width:100%;
    height:220px;
    object-fit:cover;
    background:#fafafa;
}

.produk-body{
    padding:20px;
}

.produk-nama{
    font-size:1.15rem;
    font-weight:700;
    color:#2d1b10;
    margin-bottom:8px;
}

.produk-desc{
    font-size:.92rem;
    color:#777;
    line-height:1.6;
    height:48px;
    overflow:hidden;
}

.produk-info{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:18px;
}

.harga{
    font-size:1.1rem;
    font-weight:700;
    color:#c58a3a;
}

.stok{
    font-size:.85rem;
    color:#666;
    background:#f8f8f8;
    padding:6px 12px;
    border-radius:999px;
}

.qty-box{
    margin-top:18px;
    display:flex;
    align-items:center;
    gap:8px;
}

.qty-label{
    font-size:.9rem;
    font-weight:600;
    display:block;
    width:100%;
    margin-bottom:8px;
}

.qty-control{
    display:flex;
    align-items:center;
    gap:8px;
}

.qty-btn{
    width:32px;
    height:32px;
    border-radius:50%;
    border:1.5px solid #ddd;
    background:#fff;
    cursor:pointer;
    font-size:1rem;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:all .2s;
    font-weight:700;
}

.qty-btn:hover{
    background:#c58a3a;
    border-color:#c58a3a;
    color:#fff;
}

.qty-val{
    font-weight:600;
    font-size:1rem;
    min-width:28px;
    text-align:center;
}

.subtotal-item{
    font-weight:600;
    color:#2d1b10;
    margin-top:10px;
    font-size:1rem;
    animation:pulse-sub 0.6s ease-in-out;
}

@keyframes pulse-sub{
    0% { background-color: #fff3cd; }
    100% { background-color: transparent; }
}

.top-action{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:15px;
}

.btn-kembali{
    border-radius:999px;
    padding:10px 20px;
}

.checkout-box{
    background:#fff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
    margin-top:40px;
}

.checkout-title{
    font-size:1.2rem;
    font-weight:700;
    margin-bottom:20px;
}

.summary-section{
    background:#f8f8f8;
    padding:20px;
    border-radius:14px;
    margin-bottom:20px;
}

.summary-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:12px;
    font-size:.95rem;
}

.summary-row.total{
    font-weight:700;
    font-size:1.1rem;
    color:#2d1b10;
    border-top:2px solid #ddd;
    padding-top:12px;
    margin-top:4px;
}

.form-control,
.form-select{
    border-radius:12px;
    padding:12px;
}

.btn-order{
    background:#c58a3a;
    color:#fff;
    border:none;
    padding:14px;
    width:100%;
    border-radius:14px;
    font-weight:700;
    transition:.2s;
    font-size:1.05rem;
}

.btn-order:hover{
    opacity:.9;
}

.btn-order:disabled{
    opacity:.4;
    cursor:not-allowed;
}

.cart-empty-msg{
    text-align:center;
    padding:40px 20px;
    color:#888;
}

.cart-empty-msg .icon{
    font-size:3rem;
    margin-bottom:20px;
    color:#ddd;
}

</style>

<div class="container py-5">

   <!-- HEADER -->
    <div class="top-action">

        <div>
            <br><br>
            <a href="index.php"
            class="btn btn-outline-dark btn-kembali">

                <i class="fa fa-arrow-left me-2"></i>
                Kembali

            </a>

        </div>

        <div class="text-center w-100">

            <h2 class="page-title">
                🛒 Pilih Produk
            </h2>

            <div class="page-subtitle">
                Pilih produk favoritmu dan tambahkan ke keranjang
            </div>

        </div>

    </div>

    <!-- PRODUK GRID -->
    <div class="produk-grid" id="produkGrid">
        <!-- Dinamis diisi dari JavaScript -->
    </div>

    <!-- CHECKOUT SECTION -->
    <div class="checkout-box">

        <div class="checkout-title">
            📋 Ringkasan Pesanan
        </div>

        <!-- SUMMARY -->
        <div class="summary-section">

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

        <!-- FORM PEMBAYARAN -->
        <form method="POST" action="proses_transaksi.php" id="formCheckout">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Invoice
                    </label>

                    <input type="text"
                           name="invoice"
                           class="form-control"
                           id="invoiceInput"
                           readonly>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Metode Pembayaran
                    </label>

                    <select name="metode_pembayaran"
                            class="form-select"
                            id="metodeSelect"
                            required>

                        <option value="">
                            -- Pilih Metode --
                        </option>

                        <option value="Cash">
                            💵 Cash
                        </option>

                        <option value="Transfer">
                            🏦 Transfer
                        </option>

                        <option value="QRIS">
                            📱 QRIS
                        </option>

                    </select>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Jumlah Bayar
                    </label>

                    <input type="text"
                        name="bayar"
                        id="inputBayar"
                        class="form-control"
                        placeholder="Contoh: 500000"
                        oninput="formatBayar(this); hitungKembalian();">

                </div>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Kembalian
                    </label>

                    <input type="text"
                        id="viewKembalian"
                        class="form-control"
                        value="Rp 0"
                        readonly
                        style="background:#f8f8f8;font-weight:700;color:green;">

                </div>

            </div>

            <!-- HIDDEN INPUTS UNTUK PRODUK -->
            <div id="inputProduk"></div>

            <!-- BUTTON SUBMIT -->
            <button type="submit"
                    class="btn-order"
                    id="btnOrder"
                    disabled>

                <i class="fa fa-cart-shopping me-2"></i>
                Buat Pesanan

            </button>

        </form>

    </div>

</div>

<!-- Data produk dari DB -->
<script>
const produkDB = <?php
$data = [];
$all = mysqli_query($koneksi, "SELECT produk_id, nama_produk, harga, stok, gambar, deskripsi FROM produk");

while($r = mysqli_fetch_assoc($all)){
    $data[$r['produk_id']] = [
        "id"     => (int)$r['produk_id'],
        "nama"   => $r['nama_produk'],
        "harga"  => (int)$r['harga'],
        "stok"   => (int)$r['stok'],
        "gambar" => $r['gambar'],
        "desc"   => $r['deskripsi']
    ];
}

echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>;

let cart = JSON.parse(localStorage.getItem('fanda_cart')) || {};
let totalBelanja = 0;

function fmt(n){ 
    return 'Rp ' + n.toLocaleString('id-ID'); 
}

function renderProduk(){
    let html = '';

    Object.keys(produkDB).forEach(id => {
        const p = produkDB[id];
        const qty = cart[id]?.qty || 0;
        const sub = p.harga * qty;

        html += `
        <div class="produk-card">
            <img src="../gambar/${p.gambar}" class="produk-img" onerror="this.src='../gambar/default.jpeg'">
            
            <div class="produk-body">
                <div class="produk-nama">${p.nama}</div>
                <div class="produk-desc">${p.desc}</div>
                
                <div class="produk-info">
                    <div class="harga">${fmt(p.harga)}</div>
                    <div class="stok">Stok ${p.stok}</div>
                </div>

                <div class="qty-box">
                    <label class="qty-label">Jumlah Pesanan</label>
                    <div class="qty-control">
                        <button type="button" class="qty-btn" onclick="ubahQty('${id}', -1)">−</button>
                        <span class="qty-val" id="qty-${id}">${qty}</span>
                        <button type="button" class="qty-btn" onclick="ubahQty('${id}', 1)">+</button>
                    </div>
                </div>

                ${qty > 0 ? `<div class="subtotal-item" id="subtotal-${id}">${qty} × ${fmt(p.harga)} = <strong>${fmt(sub)}</strong></div>` : ''}
            </div>
        </div>
        `;
    });

    document.getElementById('produkGrid').innerHTML = html;
}

function ubahQty(id, delta){
    const db = produkDB[id];
    const maks = db.stok;
    
    if(!cart[id]) cart[id] = { nama: db.nama, harga: db.harga, qty: 0 };
    
    const qtyBaru = Math.max(0, Math.min(cart[id].qty + delta, maks));
    cart[id].qty = qtyBaru;
    
    if(cart[id].qty === 0) delete cart[id];
    
    localStorage.setItem('fanda_cart', JSON.stringify(cart));
    
    renderProduk();
    hitungTotal();
    updateBtnOrder();
}

function hitungTotal(){
    let subtotal = 0;
    
    Object.keys(cart).forEach(id => {
        const item = cart[id];
        subtotal += (item.harga * item.qty);
    });
    
    const pajak = Math.round(subtotal * 0.1);
    const total = subtotal + pajak;
    totalBelanja = total;
    
    document.getElementById('sumSubtotal').textContent = fmt(subtotal);
    document.getElementById('sumPajak').textContent = fmt(pajak);
    document.getElementById('sumTotal').textContent = fmt(total);
    
    hitungKembalian();
}

function formatBayar(input){
    let angka = input.value.replace(/\D/g,'');
    input.value = new Intl.NumberFormat('id-ID').format(angka);
    hitungKembalian();
}

function hitungKembalian(){
    let bayar = document.getElementById('inputBayar').value;
    bayar = parseInt(bayar.replace(/\D/g,'')) || 0;
    
    let kembali = bayar - totalBelanja;
    if(kembali < 0) kembali = 0;
    
    document.getElementById('viewKembalian').value = fmt(kembali);
    updateBtnOrder();
}

function updateBtnOrder(){
    const adaItem = Object.keys(cart).length > 0;
    const metodeSelected = document.getElementById('metodeSelect').value !== '';
    const bayarValid = parseInt(document.getElementById('inputBayar').value.replace(/\D/g,'') || 0) >= totalBelanja;
    
    document.getElementById('btnOrder').disabled = !(adaItem && metodeSelected && bayarValid);
}

function generateInvoice(){
    return 'INV-' + new Date().getTime().toString().slice(-10);
}

// Submit form
document.getElementById('formCheckout').addEventListener('submit', function(e){
    e.preventDefault();
    
    if(Object.keys(cart).length === 0){
        alert('Keranjang kosong! Pilih produk dulu');
        return;
    }
    
    const invoice = generateInvoice();
    document.getElementById('invoiceInput').value = invoice;
    
    // Build hidden inputs
    let inputHtml = '';
    Object.keys(cart).forEach(id => {
        inputHtml += `<input type="hidden" name="produk_id[]" value="${id}">`;
        inputHtml += `<input type="hidden" name="qty[]" value="${cart[id].qty}">`;
    });
    document.getElementById('inputProduk').innerHTML = inputHtml;
    
    const bayar = parseInt(document.getElementById('inputBayar').value.replace(/\D/g,''));
    document.getElementById('formCheckout').innerHTML += `<input type="hidden" name="bayar" value="${bayar}">`;
    
    this.submit();
});

// Event listener untuk update tombol
document.getElementById('metodeSelect').addEventListener('change', updateBtnOrder);
document.getElementById('inputBayar').addEventListener('input', updateBtnOrder);

// Inisialisasi
document.addEventListener('DOMContentLoaded', function(){
    renderProduk();
    hitungTotal();
    document.getElementById('invoiceInput').value = generateInvoice();
});

</script>

<?php include 'footer.php'; ?>