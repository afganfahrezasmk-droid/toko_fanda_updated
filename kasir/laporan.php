<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('KASIR_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

?>

<div class="container mt-4">

    <!-- FILTER -->
    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Filter Laporan Order</h5>
        </div>

        <div class="card-body">

            <form action="laporan.php" method="GET">

                <div class="row">

                    <!-- TANGGAL DARI -->
                    <div class="col-md-5 mb-3">

                        <label class="form-label">
                            Dari Tanggal
                        </label>

                        <input type="date"
                               name="tgl_dari"
                               class="form-control"
                               required>

                    </div>

                    <!-- TANGGAL SAMPAI -->
                    <div class="col-md-5 mb-3">

                        <label class="form-label">
                            Sampai Tanggal
                        </label>

                        <input type="date"
                               name="tgl_sampai"
                               class="form-control"
                               required>

                    </div>

                    <!-- BUTTON -->
                    <div class="col-md-2 d-flex align-items-end mb-3">

                        <button type="submit"
                                class="btn btn-primary w-100">

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <br>

<?php
if(isset($_GET['tgl_dari']) && isset($_GET['tgl_sampai'])){

    $dari   = $_GET['tgl_dari'];
    $sampai = $_GET['tgl_sampai'];
?>

    <!-- HASIL LAPORAN -->
    <div class="card shadow-sm">

        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Laporan Order
            </h5>

            <!-- BUTTON CETAK -->
            <a target="_blank"
               href="laporan_cetak.php?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>"
               class="btn btn-light btn-sm">

                <i class="fas fa-print"></i>
                Cetak

            </a>

        </div>

        <div class="card-body">

            <p>
                Dari Tanggal :
                <b><?php echo $dari; ?></b>

                sampai

                <b><?php echo $sampai; ?></b>
            </p>

            <table class="table table-bordered table-striped table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>No</th>
                        <th>ID Order</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                $data = mysqli_query($koneksi,"
                        SELECT orders.*, user.nama
                        FROM orders
                        JOIN user
                        ON orders.user_id = user.user_id
                        WHERE DATE(orders.created_at)
                        BETWEEN '$dari' AND '$sampai'
                        ORDER BY orders_id DESC
                    ");

                while($d = mysqli_fetch_array($data)){
                ?>

                    <tr>

                        <td>
                            <?php echo $no++; ?>
                        </td>

                        <td>
                            <?php echo $d['orders_id']; ?>
                        </td>

                        <td>
                            <?php echo $d['created_at']; ?>
                        </td>

                        <td>
                            <?php echo $d['nama']; ?>
                        </td>

                        <td>
                            Rp <?php echo number_format($d['total']); ?>
                        </td>

                        <td>

                            <?php
                            if($d['status'] == 'pending'){

                                echo "<span class='badge bg-warning text-dark'>Pending</span>";

                            }elseif($d['status'] == 'selesai'){

                                echo "<span class='badge bg-success'>Selesai</span>";

                            }else{

                                echo "<span class='badge bg-danger'>Dibatalkan</span>";
                            }
                            ?>

                        </td>

                    </tr>

                <?php
                }
                ?>

                </tbody>

            </table>

        </div>

    </div>

<?php
}
?>

</div>

<?php include 'footer.php'; ?>