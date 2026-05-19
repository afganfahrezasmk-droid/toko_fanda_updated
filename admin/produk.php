<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role'])) { header("location:../index.php?pesan=belum_login"); exit; }
if ($_SESSION['role'] != 'admin') { header("location:../index.php?pesan=bukan_admin"); exit; }
?>

<div class="page-title">
    <h2>Kelola Produk</h2>
    <p>Tambah, Edit, atau Hapus Produk</p>
</div>

<div class="card">

    <div class="card-header">
        <h5>Daftar Produk</h5>
        <a href="produk_tambah.php" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambahkan Produk
        </a>
    </div>

    <div class="card-body" style="padding:0 !important;">

        <table class="table table-hover mb-0">

            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $data = mysqli_query($koneksi,
                    "SELECT * FROM produk
                     JOIN kategori ON produk.kategori_id = kategori.kategori_id
                     ORDER BY produk.produk_id DESC");
                $no = 1;
                while ($d = mysqli_fetch_array($data)):
                ?>
                <tr>
                    <td>
                        <img src="../gambar/<?= htmlspecialchars($d['gambar']) ?>"
                             class="img-fluid rounded" style="width:60px;height:60px;object-fit:cover;border-radius:10px;border:2px solid var(--cream-border);">
                    </td>
                    <td style="font-weight:600;"><?= htmlspecialchars($d['nama_produk']) ?></td>
                    <td><span class="category-tag"><?= htmlspecialchars($d['nama_kategori']) ?></span></td>
                    <td style="font-weight:600;">Rp <?= number_format($d['harga']) ?></td>
                    <td><?= $d['stok'] ?></td>
                    <td style="font-size:.84rem;color:var(--text-muted);max-width:200px;"><?= htmlspecialchars($d['deskripsi']) ?></td>
                    <td class="text-nowrap">
                        <a href="produk_edit.php?id=<?= $d['produk_id'] ?>" class="btn btn-sm btn-info me-1">Edit</a>
                        <a href="produk_hapus.php?id=<?= $d['produk_id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>

        </table>

    </div>

</div>

<?php include 'footer.php'; ?>
