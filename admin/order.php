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
   CEK ROLE ADMIN
========================= */

if ($_SESSION['role'] != 'admin') {

    header("location:../index.php?pesan=bukan_admin");
    exit;
}
?>

<div class="container">

    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Data Order</h5>

            <a href="order_tambah.php" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>Tambah Order</a>

        </div>

        <!-- BODY -->
        <div class="card-body">

            <table class="table table-bordered table-striped table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>No</th>
                        <th>Invoice</th>
                        <th>Nama User</th>
                        <th>Total</th>
                        <th>Pajak</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Opsi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php
                    $data = mysqli_query($koneksi,
                    "SELECT orders.*, user.nama
                    FROM orders
                    JOIN user ON orders.user_id = user.user_id
                    ORDER BY orders_id DESC");

                    $no = 1;

                    while($d = mysqli_fetch_array($data)){
                    ?>

                    <tr>

                        <td><?php echo $no++; ?></td>

                        <td>
                            <?php echo $d['invoice']; ?>
                        </td>

                        <td>
                            <?php echo $d['nama']; ?>
                        </td>

                        <td>
                            Rp <?php echo number_format($d['total']); ?>
                        </td>

                        <td>
                            Rp <?php echo number_format($d['pajak']); ?>
                        </td>

                        <td>
                            <?php echo $d['metode_pembayaran']; ?>
                        </td>

                        <td>

                            <?php
                            if($d['status'] == 'pending'){

                                echo "<span class='badge bg-warning text-dark'>Pending</span>";

                            }elseif($d['status'] == 'dibayar'){

                                echo "<span class='badge bg-info'>Dibayar</span>";

                            }elseif($d['status'] == 'selesai'){

                                echo "<span class='badge bg-success'>Selesai</span>";

                            }else{

                                echo "<span class='badge bg-danger'>Batal</span>";
                            }
                            ?>

                        </td>

                        <td>
                            <?php echo $d['created_at']; ?>
                        </td>

                            <!-- OPSI -->
                            <td class="text-nowrap">

                                <!-- DETAIL -->
                                <a href="order_detail.php?id=<?php echo $d['orders_id']; ?>"
                                class="btn btn-sm btn-warning">

                                    Detail

                                </a>

                                <!-- INVOICE -->
                                <a href="order_invoice.php?id=<?php echo $d['orders_id']; ?>"
                                class="btn btn-sm btn-primary">

                                    Invoice

                                </a>

                                <!-- EDIT -->
                                <a href="order_edit.php?id=<?php echo $d['orders_id']; ?>"
                                class="btn btn-sm btn-info">

                                    Edit

                                </a>

                                <!-- HAPUS -->
                                <a href="order_hapus.php?id=<?php echo $d['orders_id']; ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin menghapus order ini?')">

                                    Hapus

                                </a>

                        </td>

                    </tr>

                    <?php
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>