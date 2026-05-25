<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

/* =========================
   CEK LOGIN
========================= */

if (!isset($_SESSION['role'])) {

    header("location:../index.php?pesan=belum_login");
    exit;
}

/* =========================
   CEK SESSION USER ID
========================= */

if (!isset($_SESSION['user_id'])) {

    echo "

    <script>

        alert('Session user tidak ditemukan, silakan login ulang!');

        window.location.href='../index.php';

    </script>

    ";

    exit;
}

/* =========================
   AMBIL USER LOGIN
========================= */

$user_id = $_SESSION['user_id'];

$data = mysqli_query(
    $koneksi,

    "SELECT * FROM user
     WHERE user_id='$user_id'"
);

$d = mysqli_fetch_array($data);
/* =========================
   AMBIL RIWAYAT ORDER
========================= */

$order = mysqli_query(
    $koneksi,

    "SELECT *
     FROM orders
     WHERE user_id='$user_id'
     ORDER BY orders_id DESC"
);
/* =========================
   CEK DATA USER
========================= */

if (!$d) {

    echo "

    <script>

        alert('Data user tidak ditemukan!');

        window.location.href='../index.php';

    </script>

    ";

    exit;
}

?>

<div class="container mt-5 mb-5">

    <div class="row g-4">

        <!-- =========================
             CARD AKUN
        ========================== -->
        <div class="col-lg-4">

            <div class="card shadow-sm border-0 rounded-4 h-100">

                <div class="card-header bg-dark text-white rounded-top-4">

                    <h5 class="mb-0">
                        <i class="fa fa-user me-2"></i>
                        Data Akun
                    </h5>

                </div>

                <div class="card-body">

                    <!-- FOTO ICON -->
                    <div class="text-center mb-4">

                        <h5 class="mt-3 mb-0">
                            <?= htmlspecialchars($d['nama']); ?>
                        </h5>

                        <small class="text-muted">
                            @<?= htmlspecialchars($d['username']); ?>
                        </small>

                    </div>

                    <!-- USERNAME -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Username
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= htmlspecialchars($d['username']); ?>"
                               readonly>

                    </div>

                    <!-- EMAIL -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Email
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= htmlspecialchars($d['email']); ?>"
                               readonly>

                    </div>

                    <!-- ROLE -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Role
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= ucfirst($d['role']); ?>"
                               readonly>

                    </div>

                    <!-- CREATED -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Bergabung
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= $d['created_at']; ?>"
                               readonly>

                    </div>

                    <!-- BUTTON -->
                    <div class="d-grid gap-2 mt-4">

                        <a href="akun_edit.php?id=<?= $d['user_id']; ?>"
                           class="btn btn-warning">

                            <i class="fa fa-pen me-1"></i>
                            Ubah Profil

                        </a>

                        <a href="index.php"
                           class="btn btn-secondary">

                            <i class="fa fa-arrow-left me-1"></i>
                            Kembali

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <!-- =========================
                RIWAYAT PESANAN
            ========================== -->
            <div class="col-lg-8">

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

                    <!-- HEADER -->
                    <div class="card-header bg-dark text-white px-4 py-3 d-flex justify-content-between align-items-center">

                        <h5 class="mb-0 fw-bold">
                            <i class="fa fa-clock-rotate-left me-2"></i>
                            Riwayat Pesanan
                        </h5>

                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                            <?= mysqli_num_rows($order); ?> Pesanan
                        </span>

                    </div>

                    <!-- BODY -->
                    <div class="card-body p-0">

                        <?php if(mysqli_num_rows($order) > 0){ ?>

                        <div class="table-responsive">

                            <table class="table align-middle mb-0">

                                <thead style="background:#fff8f0;">

                                    <tr style="border-bottom:2px solid #f1e3d3">

                                        <th class="py-3 px-4">Invoice</th>
                                        <th class="py-3">Pembayaran</th>
                                        <th class="py-3">Total</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3">Tanggal</th>
                                        <th class="py-3 text-center">Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>

                                <?php while($o = mysqli_fetch_assoc($order)) { ?>

                                <?php

                                /*
                                =========================================
                                AMBIL DATA PEMBAYARAN DARI TABEL pembayaran
                                =========================================
                                */

                                $pay = mysqli_fetch_assoc(mysqli_query($koneksi, "
                                    SELECT *
                                    FROM pembayaran
                                    WHERE orders_id = '".$o['orders_id']."'
                                "));

                                /*
                                =========================================
                                STATUS PESANAN
                                =========================================
                                */

                                $status = strtolower($o['status'] ?? '');

                                $badge = '#888';
                                $bg    = '#f3f3f3';
                                $icon  = 'circle-info';
                                $text  = ucfirst($status);

                                if($status === 'pending'){

                                    $badge = '#f39c12';
                                    $bg    = '#fff5df';
                                    $icon  = 'clock';
                                    $text  = 'Pending';

                                } elseif($status === 'diproses'){

                                    $badge = '#3498db';
                                    $bg    = '#eaf4ff';
                                    $icon  = 'spinner';
                                    $text  = 'Diproses';

                                } elseif($status === 'dibayar'){

                                    $badge = '#2980b9';
                                    $bg    = '#eaf4ff';
                                    $icon  = 'money-bill-wave';
                                    $text  = 'Dibayar';

                                } elseif($status === 'selesai'){

                                    $badge = '#27ae60';
                                    $bg    = '#eafaf1';
                                    $icon  = 'circle-check';
                                    $text  = 'Selesai';

                                } elseif(in_array($status, ['batal','dibatalkan'])){

                                    $badge = '#e74c3c';
                                    $bg    = '#ffeaea';
                                    $icon  = 'circle-xmark';
                                    $text  = 'Dibatalkan';
                                }

                                ?>

                                <tr style="border-bottom:1px solid #f6f6f6">

                                    <!-- INVOICE -->
                                    <td class="px-4 py-3">

                                        <div style="font-weight:700;color:#2d1b10;font-size:.96rem">
                                            <?= htmlspecialchars($o['invoice']) ?>
                                        </div>

                                        <small style="color:#999">
                                            Pajak:
                                            Rp <?= number_format($o['pajak'],0,',','.') ?>
                                        </small>

                                    </td>

                                    <!-- METODE PEMBAYARAN -->
                                    <td class="py-3">

                                        <?php
                                        // ambil metode pembayaran dari tabel pembayaran
                                        $pembayaran = mysqli_fetch_assoc(mysqli_query($koneksi, "
                                            SELECT metode
                                            FROM pembayaran
                                            WHERE orders_id = '".$o['orders_id']."'
                                            LIMIT 1
                                        "));

                                        $metode = strtolower($pembayaran['metode'] ?? '-');

                                        // icon metode
                                        $iconMetode = 'wallet';

                                        if($metode == 'cash'){
                                            $iconMetode = 'money-bill-wave';
                                        } elseif($metode == 'qris'){
                                            $iconMetode = 'qrcode';
                                        } elseif($metode == 'transfer'){
                                            $iconMetode = 'building-columns';
                                        }
                                        ?>

                                        <div style="
                                            background:#fafafa;
                                            border:1px solid #eee;
                                            padding:8px 14px;
                                            border-radius:999px;
                                            display:inline-flex;
                                            align-items:center;
                                            gap:8px;
                                            font-size:.82rem;
                                            font-weight:700;
                                            color:#333;
                                        ">

                                            <i class="fa-solid fa-<?= $iconMetode ?>"></i>

                                            <?= strtoupper(htmlspecialchars($metode)) ?>

                                        </div>

                                    </td>

                                    <!-- TOTAL -->
                                    <td class="py-3">

                                        <div style="
                                            font-weight:800;
                                            color:#27ae60;
                                            font-size:1rem;
                                        ">
                                            Rp <?= number_format($o['total'],0,',','.') ?>
                                        </div>

                                    </td>

                                    <!-- STATUS -->
                                    <td class="py-3">

                                        <span style="
                                            background:<?= $bg ?>;
                                            color:<?= $badge ?>;
                                            padding:8px 15px;
                                            border-radius:999px;
                                            font-size:.82rem;
                                            font-weight:700;
                                            display:inline-flex;
                                            align-items:center;
                                            gap:7px;
                                        ">

                                            <i class="fa-solid fa-<?= $icon ?>"></i>

                                            <?= $text ?>

                                        </span>

                                    </td>

                                    <!-- TANGGAL -->
                                    <td class="py-3">

                                        <div style="font-weight:600;color:#333">
                                            <?= date('d M Y', strtotime($o['created_at'])) ?>
                                        </div>

                                        <small style="color:#999">
                                            <?= date('H:i', strtotime($o['created_at'])) ?> WIB
                                        </small>

                                    </td>

                                    <!-- AKSI -->
                                    <td class="text-center py-3">

                                        <a href="invoice.php?invoice=<?= urlencode($o['invoice']) ?>"
                                        class="btn btn-dark rounded-pill px-3 py-2"
                                        style="
                                            font-size:.82rem;
                                            font-weight:600;
                                        ">

                                            <i class="fa fa-receipt me-1"></i>
                                            Lihat Struk

                                        </a>

                                    </td>

                                </tr>

                                <?php } ?>

                                </tbody>

                            </table>

                        </div>

                        <?php } else { ?>

                        <!-- EMPTY -->
                        <div class="text-center py-5">

                            <i class="fa fa-box-open fa-3x text-secondary mb-3"></i>

                            <h5 class="text-muted fw-bold">
                                Belum ada pesanan
                            </h5>

                            <p class="text-secondary mb-0">
                                Riwayat pembelian kamu akan muncul di sini.
                            </p>

                        </div>

                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>