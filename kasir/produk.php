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
   CEK ROLE KASIR
========================= */

if ($_SESSION['role'] != 'kasir') {

    header("location:../index.php?pesan=bukan_kasir");
    exit;
}
?>

<div class="container">

    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Data Produk
            </h5>

            <a href="order_tambah.php"
               class="btn btn-sm btn-primary">

                <i class="fas fa-plus"></i>
                Order Produk

            </a>

        </div>

        <!-- BODY -->
        <div class="card-body">

            <table class="table table-bordered table-striped table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori ID</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Created At</th>
                    </tr>

                </thead>

                <tbody>

                    <?php
                    $data = mysqli_query($koneksi,
                            "SELECT * FROM produk
                            JOIN kategori 
                            ON produk.kategori_id = kategori.kategori_id
                            ORDER BY produk.produk_id DESC");

                    $no = 1;

                    while ($d = mysqli_fetch_array($data)) {
                    ?>

                    <tr>

                        <!-- NO -->
                        <td>
                            <?php echo $no++; ?>
                        </td>

                        <!-- GAMBAR -->
                        <td width="120">

                            <img src="../gambar/<?php echo $d['gambar']; ?>"
                                 width="100"
                                 class="img-fluid rounded">

                        </td>

                        <!-- NAMA PRODUK -->
                        <td>
                            <?php echo $d['nama_produk']; ?>
                        </td>

                        <!-- KATEGORI -->
                        <td>
                            <?php echo $d['nama_kategori']; ?>
                        </td>

                        <!-- HARGA -->
                        <td>
                            Rp <?php echo number_format($d['harga']); ?>
                        </td>

                        <!-- STOK -->
                        <td>
                            <?php echo $d['stok']; ?>
                        </td>

                        <!-- DESKRIPSI -->
                        <td>
                            <?php echo $d['deskripsi']; ?>
                        </td>

                        <!-- CREATED -->
                        <td>
                            <?php echo $d['created_at']; ?>
                        </td>

                    </tr>

                    <?php
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>