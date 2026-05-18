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
   CEK ROLE PELANGGAN
========================= */

if ($_SESSION['role'] != 'pelanggan') {

    header("location:../index.php?pesan=bukan_pelanggan");
    exit;
}
?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm">

                <!-- HEADER -->
                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        Edit Akun Saya
                    </h5>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <?php

                    $id = $_GET['id'];

                    $data = mysqli_query(
                        $koneksi,
                        "SELECT * FROM user
                         WHERE user_id='$id'"
                    );

                    $d = mysqli_fetch_array($data);

                    ?>

                    <form method="POST"
                          action="akun_update.php">

                        <!-- ID -->
                        <input type="hidden"
                               name="user_id"
                               value="<?php echo $d['user_id']; ?>">

                        <!-- USERNAME -->
                        <div class="mb-3">

                            <label class="form-label">
                                Username
                            </label>

                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   value="<?php echo $d['username']; ?>"
                                   required>

                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Kosongkan jika tidak diubah">

                            <small class="text-muted">

                                Kosongkan jika password tidak diubah

                            </small>

                        </div>

                        <!-- NAMA -->
                        <div class="mb-3">

                            <label class="form-label">
                                Nama
                            </label>

                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   value="<?php echo $d['nama']; ?>"
                                   required>

                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="<?php echo $d['email']; ?>"
                                   required>

                        </div>

                        <!-- BUTTON -->
                        <div class="text-center mt-4">

                            <button type="submit"
                                    class="btn btn-warning btn-lg me-2">

                                <i class="fas fa-save"></i>
                                Simpan

                            </button>

                            <a href="akun.php"
                               class="btn btn-secondary btn-lg">

                                Kembali

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>