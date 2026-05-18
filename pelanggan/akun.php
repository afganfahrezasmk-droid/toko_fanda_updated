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
   CEK SESSION USER ID
========================= */

if (!isset($_SESSION['user_id'])) {

    echo "

    <script>

        alert('Session user tidak ditemukan, silakan login ulang!');

        window.location.href='../index.php';

    </script>

    ";

    exit;
}

/* =========================
   AMBIL USER LOGIN
========================= */

$user_id = $_SESSION['user_id'];

$data = mysqli_query(
    $koneksi,

    "SELECT * FROM user
     WHERE user_id='$user_id'"
);

$d = mysqli_fetch_array($data);

/* =========================
   CEK DATA USER
========================= */

if (!$d) {

    echo "

    <script>

        alert('Data user tidak ditemukan!');

        window.location.href='../index.php';

    </script>

    ";

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
                        Data Akun Saya
                    </h5>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <!-- USERNAME -->
                    <div class="mb-3">

                        <label class="form-label">
                            Username
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?php echo htmlspecialchars($d['username']); ?>"
                               readonly>

                    </div>

                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nama
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?php echo htmlspecialchars($d['nama']); ?>"
                               readonly>

                    </div>

                    <!-- EMAIL -->
                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?php echo htmlspecialchars($d['email']); ?>"
                               readonly>

                    </div>

                    <!-- ROLE -->
                    <div class="mb-3">

                        <label class="form-label">
                            Role
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?php echo ucfirst($d['role']); ?>"
                               readonly>

                    </div>

                    <!-- CREATED -->
                    <div class="mb-3">

                        <label class="form-label">
                            Created At
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?php echo $d['created_at']; ?>"
                               readonly>

                    </div>

                    <!-- BUTTON -->
                    <div class="text-center mt-4">

                        <a href="akun_edit.php?id=<?php echo $d['user_id']; ?>"
                           class="btn btn-warning btn-lg me-2">

                            Ubah

                        </a>

                        <a href="index.php"
                           class="btn btn-secondary btn-lg">

                            Kembali

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>