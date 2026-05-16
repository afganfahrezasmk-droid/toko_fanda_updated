<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role'])) {
    header("location:../index.php?pesan=belum_login");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("location:../index.php?pesan=bukan_admin");
    exit;
}

// Ambil data counts
$produk = mysqli_query($koneksi, "SELECT * FROM produk");
$jml_produk = mysqli_num_rows($produk);

$orders = mysqli_query($koneksi, "SELECT * FROM orders");
$jml_order = mysqli_num_rows($orders);

$user = mysqli_query($koneksi, "SELECT * FROM user");
$jml_user = mysqli_num_rows($user);

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
$jml_kategori = mysqli_num_rows($kategori);
?>

<!-- Page Title -->
<div class="page-title">
    <h2>Dashboard</h2>
    <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>! Berikut ringkasan hari ini.</p>
</div>

<!-- STAT CARDS -->
<div class="stat-cards-row">

    <div class="stat-card">
        <div class="stat-icon brown"><i class="fas fa-cart-shopping"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $jml_order ?></div>
            <div class="stat-label">Total Order</div>
            <div class="stat-change"><i class="fas fa-arrow-up"></i> Semua order</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-box-open"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $jml_produk ?></div>
            <div class="stat-label">Total Produk</div>
            <div class="stat-change"><i class="fas fa-layer-group"></i> <?= $jml_kategori ?> Kategori</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $jml_user ?></div>
            <div class="stat-label">Total Pelanggan</div>
            <div class="stat-change"><i class="fas fa-user-plus"></i> Terdaftar</div>
        </div>
    </div>

</div>

<!-- ORDER TABLE -->
<div class="card">

    <div class="card-header">
        <h5>Order Terbaru</h5>
        <span class="live-badge">Live</span>
    </div>

    <div class="card-body" style="padding:0 !important;">

        <table class="table table-hover mb-0">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Nama Pelanggan</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi,
                    "SELECT orders.*, orders.status AS status_order, user.username, user.email
                     FROM orders
                     JOIN user ON orders.user_id = user.user_id
                     ORDER BY orders.orders_id DESC");

                while ($d = mysqli_fetch_array($data)):
                    $status = trim(strtolower($d['status_order']));
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($d['invoice']) ?></strong></td>
                    <td><?= htmlspecialchars($d['username']) ?></td>
                    <td style="color:var(--text-muted);font-size:.85rem;"><?= htmlspecialchars($d['email']) ?></td>
                    <td style="font-weight:600;">Rp <?= number_format($d['total']) ?></td>
                    <td><?= htmlspecialchars($d['metode_pembayaran']) ?></td>
                    <td>
                        <?php if ($status == 'pending'): ?>
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        <?php elseif ($status == 'dibayar'): ?>
                            <span class="badge bg-primary">Dibayar</span>
                        <?php elseif ($status == 'selesai'): ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php elseif ($status == 'batal'): ?>
                            <span class="badge bg-danger">Dibatalkan</span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?= ucfirst($status) ?></span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:.82rem;color:var(--text-muted);"><?= $d['created_at'] ?></td>
                    <td>
                        <a href="order_invoice.php?id=<?= $d['orders_id'] ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-file-invoice me-1"></i>Invoice
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>

        </table>

    </div>

</div>

<?php include 'footer.php'; ?>
