<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('KASIR_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);


$id = $_GET['id'];
?>

<div class="container">

    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-dark text-white">

            <h5 class="mb-0">
                Detail Order
            </h5>

        </div>

        <!-- BODY -->
        <div class="card-body">

            <a href="order.php"
            class="btn btn-sm btn-danger">

                Kembali

            </a>

            <br><br>

            <table class="table table-bordered table-striped">

                <thead class="table-dark">

                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>

                </thead>

                <tbody>

                    <?php
                    $data = mysqli_query($koneksi,
                    "SELECT order_items.*, produk.nama_produk
                    FROM order_items
                    JOIN produk ON order_items.produk_id = produk.produk_id
                    WHERE order_items.orders_id = '$id'");

                    $no = 1;

                    while($d = mysqli_fetch_array($data)){
                    ?>

                    <tr>

                        <td>
                            <?php echo $no++; ?>
                        </td>

                        <td>
                            <?php echo $d['nama_produk']; ?>
                        </td>

                        <td>
                            Rp <?php echo number_format($d['harga']); ?>
                        </td>

                        <td>
                            <?php echo $d['qty']; ?>
                        </td>

                        <td>
                            Rp <?php echo number_format($d['subtotal']); ?>
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