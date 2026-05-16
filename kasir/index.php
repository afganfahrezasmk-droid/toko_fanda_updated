<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */
 
if (!isset($_SESSION['role'])) { header("location:../index.php?pesan=belum_login"); exit; }
if ($_SESSION['role'] != 'kasir') { header("location:../index.php?pesan=bukan_kasir"); exit; }
 
$orders = mysqli_query($koneksi, "SELECT * FROM orders");
$jml_order = mysqli_num_rows($orders);
 
$user = mysqli_query($koneksi, "SELECT * FROM user WHERE role='pelanggan'");
$jml_user = mysqli_num_rows($user);
?>
 
<div class="page-title">
    <h2>Dashboard Kasir</h2>
    <p>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
</div>
 
<div class="stat-cards-row">
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-cart-shopping"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $jml_order ?></div>
            <div class="stat-label">Total Order</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= $jml_user ?></div>
            <div class="stat-label">Total Customer</div>
        </div>
    </div>
</div>
 
<div class="card">
 
    <div class="card-header">
        <h5>Data Semua Order</h5>
        <span class="live-badge">Live</span>
    </div>
 
    <div class="card-body" style="padding:0 !important;">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Pelanggan</th>
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
                    "SELECT orders.*, user.username, user.email
                     FROM orders
                     JOIN user ON orders.user_id = user.user_id
                     ORDER BY orders.orders_id DESC");
                while ($d = mysqli_fetch_array($data)):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($d['invoice']) ?></strong></td>
                    <td><?= htmlspecialchars($d['username']) ?></td>
                    <td style="font-weight:600;">Rp <?= number_format($d['total']) ?></td>
                    <td><?= htmlspecialchars($d['metode_pembayaran']) ?></td>
                    <td>
                        <?php
                        $s = $d['status'];
                        if ($s == 'pending') echo "<span class='badge bg-warning text-dark'>Menunggu</span>";
                        elseif ($s == 'selesai') echo "<span class='badge bg-success'>Selesai</span>";
                        elseif ($s == 'diproses') echo "<span class='badge bg-info'>Di proses</span>";
                        else echo "<span class='badge bg-danger'>Dibatalkan</span>";
                        ?>
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
