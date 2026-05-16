<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */
?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm">

                <!-- HEADER -->
                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        Tambah Kategori Baru
                    </h5>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <form method="POST"
                          action="kategori_aksi.php">

                        <!-- NAMA KATEGORI -->
                        <div class="mb-3">

                            <label class="form-label">
                                Nama Kategori
                            </label>

                            <input type="text"
                                   name="nama_kategori"
                                   class="form-control"
                                   placeholder="Masukkan Nama Kategori"
                                   required>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-save"></i>
                            Simpan

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