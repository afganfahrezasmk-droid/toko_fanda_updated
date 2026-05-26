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
            <h4>Edit Order</h4>
        </div>

        <div class="panel-body">

            <div class="col-md-8 col-md-offset-2">

                <!-- BUTTON KEMBALI -->
                <a href="produk.php"
                   class="btn btn-sm btn-info pull-right">

                    Kembali

                </a>

                <br><br>

                <?php
                $id = $_GET['id'];

                $data = mysqli_query($koneksi,
                    "SELECT * FROM orders
                     WHERE orders_id='$id'");

                while($d = mysqli_fetch_array($data)){
                ?>

                <form method="POST"
                      action="order_update.php">

                    <!-- ID ORDER -->
                    <input type="hidden"
                           name="orders_id"
                           value="<?php echo $d['orders_id']; ?>">

                    <!-- INVOICE -->
                    <div class="form-group">

                        <label>Invoice</label>

                        <input type="text"
                               name="invoice"
                               class="form-control"
                               required
                               value="<?php echo $d['invoice']; ?>">

                    </div>

                    <!-- METODE PEMBAYARAN -->
                    <div class="form-group">

                        <label>Metode Pembayaran</label>

                        <select name="metode_pembayaran"
                                class="form-control"
                                required>

                            <option value="Cash"
                                <?php
                                if($d['metode_pembayaran'] == 'Cash'){
                                    echo "selected";
                                }
                                ?>>
                                Cash
                            </option>

                            <option value="Transfer"
                                <?php
                                if($d['metode_pembayaran'] == 'Transfer'){
                                    echo "selected";
                                }
                                ?>>
                                Transfer
                            </option>

                            <option value="QRIS"
                                <?php
                                if($d['metode_pembayaran'] == 'QRIS'){
                                    echo "selected";
                                }
                                ?>>
                                QRIS
                            </option>

                        </select>

                    </div>

                    <!-- STATUS -->
                    <div class="form-group">

                        <label>Status Order</label>

                        <select name="status"
                                class="form-control"
                                required>

                            <option value="pending"
                                <?php
                                if($d['status'] == 'pending'){
                                    echo "selected";
                                }
                                ?>>
                                Pending
                            </option>

                            <option value="dibayar"
                                <?php
                                if($d['status'] == 'dibayar'){
                                    echo "selected";
                                }
                                ?>>
                                Dibayar
                            </option>

                            <option value="selesai"
                                <?php
                                if($d['status'] == 'selesai'){
                                    echo "selected";
                                }
                                ?>>
                                Selesai
                            </option>

                            <option value="batal"
                                <?php
                                if($d['status'] == 'batal'){
                                    echo "selected";
                                }
                                ?>>
                                Batal
                            </option>

                        </select>

                    </div>

                    <!-- TOTAL -->
                    <div class="form-group">

                        <label>Total</label>

                        <input type="text"
                               class="form-control"
                               value="Rp <?php echo number_format($d['total']); ?>"
                               readonly>

                    </div>

                    <br>

                    <!-- BUTTON -->
                    <input type="submit"
                           class="btn btn-primary"
                           value="Simpan">

                </form>

                <?php } ?>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>