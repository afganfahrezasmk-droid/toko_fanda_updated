<?php 
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('KASIR_SESSION');
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
                                class="form-select"
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
                                class="form-select"
                                required>

                            <option value="pending"
                                <?php
                                if($d['status'] == 'pending'){
                                    echo "selected";
                                }
                                ?>>
                                Pending
                            </option>

                            <option value="diproses"
                                <?php
                                if($d['status'] == 'diproses'){
                                    echo "selected";
                                }
                                ?>>
                                DiProses
                            </option>

                            <option value="selesai"
                                <?php
                                if($d['status'] == 'selesai'){
                                    echo "selected";
                                }
                                ?>>
                                Selesai
                            </option>

                            <option value="dibatalkan"
                                <?php
                                if($d['status'] == 'dibatalkan'){
                                    echo "selected";
                                }
                                ?>>
                                Dibatalkan
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

<style>
select.form-select, select.form-control {
  -webkit-appearance: none !important;
  -moz-appearance: none !important;
  appearance: none !important;
  background-color: #fff !important;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23555' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
  background-repeat: no-repeat !important;
  background-position: right 14px center !important;
  background-size: 16px !important;
  padding-right: 40px !important;
}
</style>

<?php include 'footer.php'; ?>