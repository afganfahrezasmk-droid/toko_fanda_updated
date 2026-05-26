<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('KASIR_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow-sm">

                <!-- HEADER -->
                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        Ganti Password
                    </h5>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <?php
                    // PESAN BERHASIL
                    if(isset($_GET['pesan'])){

                        if($_GET['pesan'] == 'berhasil'){

                            echo "
                            <div class='alert alert-success'>
                                Password berhasil diubah!
                            </div>
                            ";
                        }

                        if($_GET['pesan'] == 'gagal'){

                            echo "
                            <div class='alert alert-danger'>
                                Password gagal diubah!
                            </div>
                            ";
                        }
                    }
                    ?>

                    <form method="POST"
                          action="password_update.php">

                        <!-- PASSWORD BARU -->
                        <div class="mb-3">

                            <label class="form-label">
                                Password Baru
                            </label>

                            <input type="password"
                                   name="password_baru"
                                   class="form-control"
                                   placeholder="Masukkan Password Baru"
                                   required>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-key"></i>
                            Ubah Password

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>