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

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm">

                <!-- HEADER -->
                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        Tambah User Baru
                    </h5>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <form method="POST" action="user_aksi.php">

                        <!-- USERNAME -->
                        <div class="mb-3">

                            <label class="form-label">
                                Username
                            </label>

                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   placeholder="Masukkan Username"
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
                                   placeholder="Masukkan Password"
                                   required>

                        </div>

                        <!-- NAMA -->
                        <div class="mb-3">

                            <label class="form-label">
                                Nama
                            </label>

                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   placeholder="Masukkan Nama"
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
                                   placeholder="Masukkan Email"
                                   required>

                        </div>

                        <!-- ROLE -->
                        <div class="mb-3">

                            <label class="form-label">
                                Role
                            </label>

                            <select name="role"
                                    class="form-select"
                                    required>

                                <option value="">
                                    -- Pilih Role --
                                </option>

                                <option value="admin">
                                    Admin
                                </option>

                                <option value="kasir">
                                    Kasir
                                </option>

                                <option value="pelanggan">
                                    Pelanggan
                                </option>

                            </select>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-save"></i>
                            Simpan

                        </button>

                        <a href="user.php"
                           class="btn btn-secondary">

                            Kembali

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>