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

$q_pending = mysqli_fetch_assoc(mysqli_query(
    $koneksi,
    "SELECT COUNT(*) as total FROM orders WHERE status='pending'"
));

$q_diproses = mysqli_fetch_assoc(mysqli_query(
    $koneksi,
    "SELECT COUNT(*) as total FROM orders WHERE status='diproses'"
));

$q_selesai = mysqli_fetch_assoc(mysqli_query(
    $koneksi,
    "SELECT COUNT(*) as total FROM orders WHERE status='selesai'"
));

$q_batal = mysqli_fetch_assoc(mysqli_query(
    $koneksi,
    "SELECT COUNT(*) as total FROM orders WHERE status='dibatalkan'"
));

?>

<!-- Page Title -->
<div class="page-title">
    <h2>Dashboard</h2>
    <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>! Berikut ringkasan hari ini.</p>
</div>

<!-- STAT CARDS -->
<div class="stat-cards-row">

    <!-- TOTAL ORDER -->
    <div class="stat-card">
        <div class="stat-icon brown">
            <i class="fas fa-cart-shopping"></i>
        </div>

        <div class="stat-info">
            <div class="stat-value"><?= $jml_order ?></div>
            <div class="stat-label">Total Order</div>
            <div class="stat-change">
                <i class="fas fa-arrow-up"></i>
                Semua order
            </div>
        </div>
    </div>

    <!-- TOTAL PRODUK -->
    <div class="stat-card">
        <div class="stat-icon gold">
            <i class="fas fa-box-open"></i>
        </div>

        <div class="stat-info">
            <div class="stat-value"><?= $jml_produk ?></div>
            <div class="stat-label">Total Produk</div>
            <div class="stat-change">
                <i class="fas fa-layer-group"></i>
                <?= $jml_kategori ?> Kategori
            </div>
        </div>
    </div>

    <!-- TOTAL CUSTOMER -->
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-users"></i>
        </div>

        <div class="stat-info">
            <div class="stat-value"><?= $jml_user ?></div>
            <div class="stat-label">Total User</div>
            <div class="stat-change">
                <i class="fas fa-user-plus"></i>
                Terdaftar
            </div>
        </div>
    </div>

    <!-- PENDING -->
    <div class="stat-card">
        <div class="stat-icon yellow">
            <i class="fas fa-clock"></i>
        </div>

        <div class="stat-info">
            <div class="stat-value"><?= $q_pending['total'] ?></div>
            <div class="stat-label">Status Pemesanan Pending</div>
            <div class="stat-change">
                <i class="fas fa-hourglass-half"></i>
                Menunggu proses
            </div>
        </div>
    </div>

    <!-- DIPROSES -->
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-spinner"></i>
        </div>

        <div class="stat-info">
            <div class="stat-value"><?= $q_diproses['total'] ?></div>
            <div class="stat-label">Status Pemesanan Diproses</div>
            <div class="stat-change">
                <i class="fas fa-fire"></i>
                Sedang dibuat
            </div>
        </div>
    </div>

    <!-- SELESAI -->
    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-circle-check"></i>
        </div>

        <div class="stat-info">
            <div class="stat-value"><?= $q_selesai['total'] ?></div>
            <div class="stat-label">Status Pemesanan Selesai</div>
            <div class="stat-change">
                <i class="fas fa-check"></i>
                Pesanan selesai
            </div>
        </div>
    </div>

    <!-- DIBATALKAN -->
    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="fas fa-circle-xmark"></i>
        </div>

        <div class="stat-info">
            <div class="stat-value"><?= $q_batal['total'] ?></div>
            <div class="stat-label">Status Pemesanan Dibatalkan</div>
            <div class="stat-change">
                <i class="fas fa-ban"></i>
                Order dibatalkan
            </div>
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
                    <th>Status Pesanan</th>
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

                            <?php
                            if($d['status']=="pending"){

                                echo "<span class='badge bg-warning text-dark'>Pending</span>";

                            }elseif($d['status']=="diproses"){

                                echo "<span class='badge bg-info'>DiProses</span>";

                            }elseif($d['status']=="selesai"){

                                echo "<span class='badge bg-success'>Selesai</span>";

                            }elseif($d['status']=="dibatalkan"){

                                echo "<span class='badge bg-danger'>DiBatalkan</span>";

                            }else{

                                echo "<span class='badge bg-dark'>Unknown</span>";

                            }
                            ?>

                        </td>
                    <td style="font-size:.82rem;color:var(--text-muted);"><?= $d['created_at'] ?></td>
                    <!-- DETAIL -->
                                <td><a href="order_detail.php?id=<?php echo $d['orders_id']; ?>"
                                class="btn btn-sm btn-warning">

                                    Detail

                                </a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>

        </table>

    </div>

</div>

<?php include 'footer.php'; ?>
