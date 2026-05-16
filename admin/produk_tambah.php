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
                        Tambah Produk Baru
                    </h5>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <form method="POST"
                          action="produk_aksi.php"
                          enctype="multipart/form-data">

                        <!-- NAMA PRODUK -->
                        <div class="mb-3">

                            <label class="form-label">
                                Nama Produk
                            </label>

                            <input type="text"
                                   name="nama_produk"
                                   class="form-control"
                                   placeholder="Masukkan Nama Produk"
                                   required>

                        </div>

                        <!-- KATEGORI -->
                        <div class="mb-3">

                            <label class="form-label">
                                Kategori
                            </label>

                            <select name="kategori_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                <?php
                                $kategori = mysqli_query($koneksi,
                                    "SELECT * FROM kategori");

                                while ($k = mysqli_fetch_array($kategori)) {
                                ?>

                                <option value="<?php echo $k['kategori_id']; ?>">

                                    <?php echo $k['nama_kategori']; ?>

                                </option>

                                <?php
                                }
                                ?>

                            </select>

                        </div>

                        <!-- HARGA -->
                        <div class="mb-3">

                            <label class="form-label">
                                Harga
                            </label>

                            <input type="number"
                                   name="harga"
                                   class="form-control"
                                   placeholder="Masukkan Harga"
                                   required>

                        </div>

                        <!-- STOK -->
                        <div class="mb-3">

                            <label class="form-label">
                                Stok
                            </label>

                            <input type="number"
                                   name="stok"
                                   class="form-control"
                                   placeholder="Masukkan Stok"
                                   required>

                        </div>

                        <!-- DESKRIPSI -->
                        <div class="mb-3">

                            <label class="form-label">
                                Deskripsi
                            </label>

                            <textarea name="deskripsi"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Masukkan Deskripsi Produk"
                                      required></textarea>

                        </div>

                        <!-- GAMBAR -->
                        <div class="mb-3">

                            <label class="form-label">
                                Gambar Produk
                            </label>

                            <input type="file"
                                   name="gambar"
                                   class="form-control"
                                   required>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-save"></i>
                            Simpan

                        </button>

                        <a href="produk.php"
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