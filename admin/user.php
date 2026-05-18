<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */

if (!isset($_SESSION['role'])) { header("location:../index.php?pesan=belum_login"); exit; }
if ($_SESSION['role'] != 'admin') { header("location:../index.php?pesan=bukan_admin"); exit; }
?>

<div class="page-title">
    <h2>Data User</h2>
    <p>Kelola akun pengguna sistem</p>
</div>

<div class="card">

    <div class="card-header">
        <h5>Daftar User</h5>
        <a href="user_tambah.php" class="btn btn-primary btn-sm">
            <i class="fas fa-user-plus me-1"></i>Tambah User
        </a>
    </div>

    <div class="card-body" style="padding:0 !important;">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = mysqli_query($koneksi, "SELECT * FROM user ORDER BY user_id DESC");
                $no = 1;
                while ($d = mysqli_fetch_array($data)):
                    $role = strtolower($d['role']);
                    $role_class = $role == 'admin' ? 'bg-primary' : ($role == 'kasir' ? 'bg-warning text-dark' : 'bg-success');
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td style="font-weight:600;"><?= htmlspecialchars($d['username']) ?></td>
                    <td><?= htmlspecialchars($d['nama'] ?? '-') ?></td>
                    <td style="color:var(--text-muted);font-size:.85rem;"><?= htmlspecialchars($d['email']) ?></td>
                    <td><span class="badge <?= $role_class ?>"><?= ucfirst($role) ?></span></td>
                    <td style="font-size:.82rem;color:var(--text-muted);"><?= $d['created_at'] ?></td>
                    <td>
                        <a href="user_edit.php?id=<?= $d['user_id'] ?>" class="btn btn-sm btn-info me-1">Edit</a>
                        <a href="user_hapus.php?id=<?= $d['user_id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include 'footer.php'; ?>
