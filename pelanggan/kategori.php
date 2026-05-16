<?php
include 'header.php';
include '../koneksi.php';

if (!isset($_SESSION['role'])) { header("location:../index.php?pesan=belum_login"); exit; }
if ($_SESSION['role'] != 'admin') { header("location:../index.php?pesan=bukan_admin"); exit; }
?>

<div class="page-title">
    <h2>Kategori</h2>
    <p>Kelola kategori produk toko kue</p>
</div>

<div class="card">

    <div class="card-header">
        <h5>Data Kategori</h5>
        <a href="kategori_tambah.php" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Kategori
        </a>
    </div>

    <div class="card-body" style="padding:0 !important;">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Created At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_id DESC");
                $no = 1;
                while ($d = mysqli_fetch_array($data)):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td style="color:var(--text-muted);font-size:.85rem;">#<?= $d['kategori_id'] ?></td>
                    <td><span class="category-tag"><?= htmlspecialchars($d['nama_kategori']) ?></span></td>
                    <td style="font-size:.82rem;color:var(--text-muted);"><?= $d['created_at'] ?></td>
                    <td>
                        <a href="kategori_edit.php?id=<?= $d['kategori_id'] ?>" class="btn btn-sm btn-info me-1">Edit</a>
                        <a href="kategori_hapus.php?id=<?= $d['kategori_id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include 'footer.php'; ?>
