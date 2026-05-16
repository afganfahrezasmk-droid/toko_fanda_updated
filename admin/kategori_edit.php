<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

/* =========================
   AMBIL ID
========================= */

$id = $_GET['id'];

/* =========================
   AMBIL DATA KATEGORI
========================= */

$data = mysqli_query($koneksi,
    "SELECT * FROM kategori
     WHERE kategori_id = '$id'");

$d = mysqli_fetch_array($data);
?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm">

                <!-- HEADER -->
                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        Edit Kategori
                    </h5>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <form method="POST"
                          action="kategori_update.php">

                        <!-- ID -->
                        <input type="hidden"
                               name="kategori_id"
                               value="<?php echo $d['kategori_id']; ?>">

                        <!-- NAMA KATEGORI -->
                        <div class="mb-3">

                            <label class="form-label">
                                Nama Kategori
                            </label>

                            <input type="text"
                                   name="nama_kategori"
                                   class="form-control"
                                   value="<?php echo $d['nama_kategori']; ?>"
                                   required>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-save"></i>
                            Update

                        </button>

                        <a href="kategori.php"
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