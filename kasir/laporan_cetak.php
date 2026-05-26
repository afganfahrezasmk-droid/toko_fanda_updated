<?php
session_start();
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('KASIR_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);


$dari   = $_GET['dari'];
$sampai = $_GET['sampai'];
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cetak Laporan Order</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body>

<div class="container mt-4">

    <!-- JUDUL -->
    <center>

        <h3>
            LAPORAN ORDER
        </h3>

        <p>
            Dari Tanggal
            <b><?php echo $dari; ?></b>

            sampai

            <b><?php echo $sampai; ?></b>
        </p>

    </center>

    <br>

    <!-- TABEL -->
    <table class="table table-bordered table-striped">

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
            ORDER BY orders.orders_id DESC
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

    <br>

    <center>

        <i>
            "Terima Kasih Sudah Order di CELINDEO"
        </i>

    </center>

</div>

<!-- AUTO PRINT -->
<script>
    window.print();
</script>

</body>
</html>