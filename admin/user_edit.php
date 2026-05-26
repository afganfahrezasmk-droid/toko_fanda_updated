<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

session_name('ADMIN_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);


?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm">

                <!-- HEADER -->
                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        Edit User
                    </h5>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <?php
                    $id = $_GET['id'];

                    $data = mysqli_query($koneksi,
                        "SELECT * FROM user
                         WHERE user_id='$id'");

                    while ($d = mysqli_fetch_array($data)) {
                    ?>

                    <form method="POST" action="user_update.php">

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
                                   placeholder="Masukkan Password Baru">

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

                        <!-- ROLE -->
                        <div class="mb-3">

                            <label class="form-label">
                                Role
                            </label>

                            <select name="role"
                                    class="form-select"
                                    required>

                                <option value="admin"
                                    <?php if ($d['role'] == "admin") {
                                        echo "selected";
                                    } ?>>

                                    Admin

                                </option>

                                <option value="kasir"
                                    <?php if ($d['role'] == "kasir") {
                                        echo "selected";
                                    } ?>>

                                    Kasir

                                </option>

                                <option value="pelanggan"
                                    <?php if ($d['role'] == "pelanggan") {
                                        echo "selected";
                                    } ?>>

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

                    <?php
                    }
                    ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>