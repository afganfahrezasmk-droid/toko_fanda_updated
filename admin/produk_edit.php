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
                        Edit Produk
                    </h5>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <?php
                    $id = $_GET['id'];

                    $data = mysqli_query($koneksi,
                        "SELECT * FROM produk
                         WHERE produk_id='$id'");

                    while ($d = mysqli_fetch_array($data)) {
                    ?>

                    <form method="POST"
                          action="produk_update.php"
                          enctype="multipart/form-data">

                        <!-- ID -->
                        <input type="hidden"
                               name="produk_id"
                               value="<?php echo $d['produk_id']; ?>">

                        <!-- NAMA PRODUK -->
                        <div class="mb-3">

                            <label class="form-label">
                                Nama Produk
                            </label>

                            <input type="text"
                                   name="nama_produk"
                                   class="form-control"
                                   value="<?php echo $d['nama_produk']; ?>"
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

                                <?php
                                $kategori = mysqli_query($koneksi,
                                    "SELECT * FROM kategori");

                                while ($k = mysqli_fetch_array($kategori)) {
                                ?>

                                <option value="<?php echo $k['kategori_id']; ?>"

                                    <?php
                                    if ($d['kategori_id'] == $k['kategori_id']) {
                                        echo "selected";
                                    }
                                    ?>>

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
                                   value="<?php echo $d['harga']; ?>"
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
                                   value="<?php echo $d['stok']; ?>"
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
                                      required><?php echo $d['deskripsi']; ?></textarea>

                        </div>

                        <!-- GAMBAR LAMA -->
                        <div class="mb-3">

                            <label class="form-label">
                                Gambar Saat Ini
                            </label>

                            <br>

                            <img src="../gambar/<?php echo $d['gambar']; ?>"
                                 width="120"
                                 class="rounded border">

                        </div>

                        <!-- INPUT GAMBAR -->
                        <div class="mb-3">

                            <label class="form-label">
                                Ganti Gambar
                            </label>

                            <input type="file"
                                   name="gambar"
                                   class="form-control">

                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti gambar
                            </small>

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

                    <?php
                    }
                    ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>