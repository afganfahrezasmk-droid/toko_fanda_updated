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

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-header bg-dark text-white rounded-top-4 d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">
                        <i class="fa fa-clock-rotate-left me-2"></i>
                        Riwayat Pesanan
                    </h5>

                    <span class="badge bg-warning text-dark">
                        <?= mysqli_num_rows($order); ?> Pesanan
                    </span>

                </div>

                <div class="card-body">

                    <?php if(mysqli_num_rows($order) > 0){ ?>

                        <div class="table-responsive">

                            <table class="table align-middle table-hover">

                                <thead class="table-light">

                                    <tr>

                                        <th>Invoice</th>
                                        <th>Metode</th>
                                        <th>Pajak</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php while($o = mysqli_fetch_assoc($order)){ ?>

                                    <?php

                                    /* =========================
                                    WARNA STATUS
                                    ========================= */

                                    $status = strtolower($o['status']);

                                    if($status == 'pending'){

                                        $badge = 'warning';
                                        $icon  = 'clock';

                                    } elseif($status == 'dibayar'){

                                        $badge = 'primary';
                                        $icon  = 'spinner';

                                    } elseif($status == 'selesai'){

                                        $badge = 'success';
                                        $icon  = 'circle-check';

                                    } elseif($status == 'batal'){

                                        $badge = 'danger';
                                        $icon  = 'circle-xmark';

                                    } else {

                                        $badge = 'secondary';
                                        $icon  = 'circle-info';
                                    }

                                    ?>

                                    <tr>

                                        <!-- INVOICE -->
                                        <td>

                                            <span class="fw-bold text-dark">

                                                <?= htmlspecialchars($o['invoice']); ?>

                                            </span>

                                        </td>

                                        <!-- METODE -->
                                        <td>

                                            <span class="badge bg-light text-dark border px-3 py-2">

                                                <?= htmlspecialchars($o['metode_pembayaran']); ?>

                                            </span>

                                        </td>

                                        <!-- PAJAK -->
                                        <td>

                                            Rp <?= number_format($o['pajak'],0,',','.'); ?>

                                        </td>

                                        <!-- TOTAL -->
                                        <td>

                                            <span class="fw-bold text-success">

                                                Rp <?= number_format($o['total'],0,',','.'); ?>

                                            </span>

                                        </td>

                                        <!-- STATUS -->
                                        <td>

                                            <span class="badge bg-<?= $badge; ?> px-3 py-2">

                                                <i class="fa-solid fa-<?= $icon; ?> me-1"></i>

                                                <?= ucfirst($o['status']); ?>

                                            </span>

                                        </td>

                                        <!-- TANGGAL -->
                                        <td>

                                            <?= date('d M Y H:i', strtotime($o['created_at'])); ?>

                                        </td>

                                        <!-- AKSI -->
                                        <td>

                                            <a href="invoice.php?invoice=<?= $o['invoice']; ?>"
                                            class="btn btn-sm btn-dark rounded-pill px-3">

                                                <i class="fa fa-receipt me-1"></i>
                                                Invoice

                                            </a>

                                        </td>

                                    </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    <?php } else { ?>

                        <div class="text-center py-5">

                            <i class="fa fa-box-open fa-3x text-secondary mb-3"></i>

                            <h5 class="text-muted">
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

<?php include 'footer.php'; ?>