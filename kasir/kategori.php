<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */

if (!isset($_SESSION['role'])) { header("location:../index.php?pesan=belum_login"); exit; }
if ($_SESSION['role'] != 'kasir') { header("location:../index.php?pesan=bukan_kasir"); exit; }
?>

<div class="page-title">
    <h2>Kategori</h2>
    <p>Kelola kategori produk toko kue</p>
</div>

<div class="card">

    <div class="card-header">
        <h5>Data Kategori</h5>
    </div>

    <div class="card-body" style="padding:0 !important;">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Created At</th>
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
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include 'footer.php'; ?>
