<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('ADMIN_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

?>

<div class="container">

    <div class="panel">

        <div class="panel-heading">
            <h4>Tambah Order</h4>
        </div>

        <div class="panel-body">

            <div class="col-md-10 col-md-offset-1">

                <!-- BUTTON KEMBALI -->
                <a href="order.php" class="btn btn-sm btn-info pull-right">
                    Kembali
                </a>

                <br><br>

                <form method="POST" action="order_aksi.php">

                    <!-- USER -->
                    <div class="form-group">

                        <label>User</label>

                        <select name="user_id" class="form-control" required>

                            <option value="">
                                -- Pilih User --
                            </option>

                            <?php
                            $user = mysqli_query($koneksi,
                                "SELECT * FROM user");

                            while($u = mysqli_fetch_array($user)){
                            ?>

                            <option value="<?php echo $u['user_id']; ?>">

                                <?php echo $u['nama']; ?>

                            </option>

                            <?php
                            }
                            ?>

                        </select>

                    </div>

                    <!-- INVOICE -->
                    <div class="form-group">

                        <label>Invoice</label>

                        <input type="text"
                               name="invoice"
                               class="form-control"
                               value="INV-<?php echo rand(1000,9999); ?>"
                               readonly>

                    </div>

                    <!-- METODE PEMBAYARAN -->
                    <div class="form-group">

                        <label>Metode Pembayaran</label>

                        <select name="metode_pembayaran"
                                class="form-control"
                                required>

                            <option value="">
                                -- Pilih Metode --
                            </option>

                            <option value="Cash">
                                Cash
                            </option>

                            <option value="Transfer">
                                Transfer
                            </option>

                            <option value="QRIS">
                                QRIS
                            </option>

                        </select>

                    </div>

                    <hr>

                    <h4>Data Produk</h4>

                    <table class="table table-bordered">

                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th width="20%">Qty</th>
                        </tr>

                        <?php
                        $produk = mysqli_query($koneksi,
                            "SELECT * FROM produk");

                        while($p = mysqli_fetch_array($produk)){
                        ?>

                        <tr>

                            <td>

                                <?php echo $p['nama_produk']; ?>

                                <input type="hidden"
                                       name="produk_id[]"
                                       value="<?php echo $p['produk_id']; ?>">

                            </td>

                            <td>
                                Rp <?php echo number_format($p['harga']); ?>
                            </td>

                            <td>

                                <input type="number"
                                       name="qty[]"
                                       class="form-control"
                                       min="0"
                                       value="0">

                            </td>

                        </tr>

                        <?php
                        }
                        ?>

                    </table>

                    <!-- BUTTON -->
                    <input type="submit"
                           class="btn btn-primary"
                           value="Simpan Order">

                </form>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>