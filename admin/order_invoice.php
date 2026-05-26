<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('ADMIN_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);


$id = $_GET['id'];

$order = mysqli_query($koneksi,
    "SELECT orders.*, user.nama
     FROM orders
     JOIN user
     ON orders.user_id = user.user_id
     WHERE orders.orders_id='$id'");

$t = mysqli_fetch_array($order);
?>

<div class="container">

    <div class="col-md-10 col-md-offset-1">

        <center>
            <h2>INVOICE ORDER</h2>
        </center>

        <div class="d-flex justify-content-between">

            <!-- BUTTON KEMBALI -->
            <a href="order.php"
            class="btn btn-secondary">

                ← Kembali

            </a>

            <!-- BUTTON CETAK -->
            <a href="order_invoice_cetak.php?id=<?php echo $id; ?>"
            target="_blank"
            class="btn btn-primary">

                <i class="glyphicon glyphicon-print"></i>
                Cetak

            </a>

        </div>

        <br><br>

        <!-- DATA ORDER -->
        <table class="table">

            <tr>
                <th>ID Order</th>
                <th>:</th>
                <th><?php echo $t['orders_id']; ?></th>
            </tr>

            <tr>
                <th>Invoice</th>
                <th>:</th>
                <th><?php echo $t['invoice']; ?></th>
            </tr>

            <tr>
                <th>Nama User</th>
                <th>:</th>
                <th><?php echo $t['nama']; ?></th>
            </tr>

            <tr>
                <th>Metode Pembayaran</th>
                <th>:</th>
                <th><?php echo $t['metode_pembayaran']; ?></th>
            </tr>

            <tr>
                <th>Status</th>
                <th>:</th>
                <th><?php echo $t['status']; ?></th>
            </tr>

        </table>

        <!-- DETAIL ORDER -->
        <table class="table table-bordered">

            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>

            <?php
            $no = 1;

            $detail = mysqli_query($koneksi,
                "SELECT order_items.*, produk.nama_produk
                 FROM order_items
                 JOIN produk
                 ON order_items.produk_id = produk.produk_id
                 WHERE order_items.orders_id='$id'");

            while ($d = mysqli_fetch_array($detail)) {
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

            <?php } ?>

            <!-- TOTAL -->
            <tr>

                <th colspan="4" class="text-right">
                    Total
                </th>

                <th>
                    Rp <?php echo number_format($t['total']); ?>
                </th>

            </tr>

            <!-- PAJAK -->
            <tr>

                <th colspan="4" class="text-right">
                    Pajak
                </th>

                <th>
                    Rp <?php echo number_format($t['pajak']); ?>
                </th>

            </tr>

            <!-- GRAND TOTAL -->
            <tr>

                <th colspan="4" class="text-right">
                    Grand Total
                </th>

                <th>
                    Rp <?php echo number_format($t['total'] + $t['pajak']); ?>
                </th>

            </tr>

        </table>

        <p class="text-center">
            <i>
                "Terima Kasih Sudah Memesan di Toko Kue Fanda 🍰"
            </i>
        </p>

    </div>

</div>

<?php include 'footer.php'; ?>