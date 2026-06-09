<?php
include 'header.php';
include '../koneksi.php';
/** @var mysqli $koneksi */

session_name('ADMIN_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

/* ===============================
   FILTER STATUS
================================ */

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua';
$whereStatus = '';
if ($filter === 'pending') {
    $whereStatus = "WHERE review.status = 'pending'";
} elseif ($filter === 'tampil') {
    $whereStatus = "WHERE review.status = 'tampil'";
}

/* ===============================
   HITUNG BADGE
================================ */

$qPending = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM review WHERE status='pending'");
$dPending = mysqli_fetch_assoc($qPending);
$jmlPending = $dPending['jml'];

$qTampil = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM review WHERE status='tampil'");
$dTampil = mysqli_fetch_assoc($qTampil);
$jmlTampil = $dTampil['jml'];

$qSemua = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM review");
$dSemua = mysqli_fetch_assoc($qSemua);
$jmlSemua = $dSemua['jml'];

/* ===============================
   AMBIL DATA REVIEW
================================ */

$data = mysqli_query($koneksi, "
    SELECT
        review.*,
        produk.nama_produk
    FROM review
    LEFT JOIN produk ON review.produk_id = produk.produk_id
    $whereStatus
    ORDER BY review.id_review DESC
");

/* ===============================
   NOTIF AKSI
================================ */

$notif = '';
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] === 'tampil')   $notif = '<div class="alert alert-success alert-dismissible fade show mb-3"><i class="fas fa-check-circle me-2"></i>Review berhasil ditampilkan. <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($_GET['aksi'] === 'pending')  $notif = '<div class="alert alert-warning alert-dismissible fade show mb-3"><i class="fas fa-clock me-2"></i>Review dikembalikan ke pending. <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($_GET['aksi'] === 'hapus')    $notif = '<div class="alert alert-danger  alert-dismissible fade show mb-3"><i class="fas fa-trash me-2"></i>Review berhasil dihapus. <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}
?>

<style>
/* ── FILTER TABS ─────────────────────────────── */
.filter-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.filter-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 18px;
    border-radius: 999px;
    font-size: .82rem;
    font-weight: 500;
    text-decoration: none;
    border: 1.5px solid var(--cream-border);
    color: var(--text-muted);
    background: #fff;
    transition: all .25s;
}
.filter-tab:hover {
    border-color: var(--accent-gold);
    color: var(--espresso);
}
.filter-tab.active {
    background: var(--espresso);
    border-color: var(--espresso);
    color: #fff;
}
.filter-tab .badge-count {
    background: rgba(255,255,255,.25);
    color: inherit;
    border-radius: 999px;
    padding: 1px 8px;
    font-size: .72rem;
    font-weight: 600;
}
.filter-tab.active .badge-count { background: rgba(255,255,255,.2); }

/* ── STAR DISPLAY ────────────────────────────── */
.stars-display { color: var(--accent-gold); font-size: .9rem; letter-spacing: 1px; }
.stars-display .star-empty { color: #ddd; }

/* ── REVIEW TEXT ─────────────────────────────── */
.review-text {
    font-style: italic;
    color: var(--text-muted);
    font-size: .88rem;
    max-width: 380px;
    line-height: 1.55;
}

/* ── STATUS BADGE ────────────────────────────── */
.badge-status-tampil  { background:#d1fae5; color:#065f46; border-radius:999px; padding:4px 12px; font-size:.75rem; font-weight:600; }
.badge-status-pending { background:#fef3c7; color:#92400e; border-radius:999px; padding:4px 12px; font-size:.75rem; font-weight:600; }

/* ── ACTION BUTTONS ──────────────────────────── */
.btn-approve {
    background: #059669; color: #fff; border: none;
    padding: 5px 13px; border-radius: 8px; font-size: .78rem;
    cursor: pointer; text-decoration: none; display: inline-flex;
    align-items: center; gap: 5px; transition: .2s;
}
.btn-approve:hover { background: #047857; color: #fff; }

.btn-unpublish {
    background: #f59e0b; color: #fff; border: none;
    padding: 5px 13px; border-radius: 8px; font-size: .78rem;
    cursor: pointer; text-decoration: none; display: inline-flex;
    align-items: center; gap: 5px; transition: .2s;
}
.btn-unpublish:hover { background: #d97706; color: #fff; }

/* ── EMPTY STATE ─────────────────────────────── */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--text-muted);
}
.empty-state i { font-size: 2.5rem; margin-bottom: 14px; opacity: .4; }
.empty-state p { font-size: .9rem; }

/* ── STAT CARDS (ringkasan kecil) ────────────── */
.review-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
.rv-stat {
    background: #fff;
    border: 1px solid var(--cream-border);
    border-radius: 14px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.rv-stat-icon {
    width: 40px; height: 40px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.rv-stat-icon.gold   { background: #fef3c7; color: #b45309; }
.rv-stat-icon.green  { background: #d1fae5; color: #065f46; }
.rv-stat-icon.amber  { background: #fff7ed; color: #c2410c; }
.rv-stat-label { font-size: .72rem; color: var(--text-muted); }
.rv-stat-val   { font-size: 1.4rem; font-weight: 700; color: var(--espresso); line-height: 1.1; }

@media(max-width:640px){
    .review-stats { grid-template-columns: 1fr 1fr; }
    .review-text  { max-width: 200px; }
}
</style>

<div class="page-title">
    <h2>Manajemen Review</h2>
    <p>Moderasi dan tampilkan ulasan dari pelanggan</p>
</div>

<?= $notif ?>

<!-- STAT CARDS -->
<div class="review-stats">
    <div class="rv-stat">
        <div class="rv-stat-icon gold"><i class="fas fa-star"></i></div>
        <div>
            <div class="rv-stat-label">Total Review</div>
            <div class="rv-stat-val"><?= $jmlSemua ?></div>
        </div>
    </div>
    <div class="rv-stat">
        <div class="rv-stat-icon green"><i class="fas fa-eye"></i></div>
        <div>
            <div class="rv-stat-label">Ditampilkan</div>
            <div class="rv-stat-val"><?= $jmlTampil ?></div>
        </div>
    </div>
    <div class="rv-stat">
        <div class="rv-stat-icon amber"><i class="fas fa-clock"></i></div>
        <div>
            <div class="rv-stat-label">Menunggu</div>
            <div class="rv-stat-val"><?= $jmlPending ?></div>
        </div>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h5><i class="fas fa-comment-dots me-2"></i>Daftar Review</h5>
    </div>

    <div class="card-body">

        <!-- FILTER TABS -->
        <div class="filter-tabs">
            <a href="review.php?filter=semua"
               class="filter-tab <?= $filter === 'semua' ? 'active' : '' ?>">
                <i class="fas fa-list-ul"></i> Semua
                <span class="badge-count"><?= $jmlSemua ?></span>
            </a>
            <a href="review.php?filter=pending"
               class="filter-tab <?= $filter === 'pending' ? 'active' : '' ?>">
                <i class="fas fa-clock"></i> Pending
                <span class="badge-count"><?= $jmlPending ?></span>
            </a>
            <a href="review.php?filter=tampil"
               class="filter-tab <?= $filter === 'tampil' ? 'active' : '' ?>">
                <i class="fas fa-eye"></i> Ditampilkan
                <span class="badge-count"><?= $jmlTampil ?></span>
            </a>
        </div>

        <!-- TABLE -->
        <div style="overflow-x:auto;">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Rating</th>
                    <th>Ulasan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($data) === 0): ?>
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-comment-slash d-block"></i>
                            <p>Tidak ada review<?= $filter !== 'semua' ? ' dengan status ini' : '' ?>.</p>
                        </div>
                    </td>
                </tr>
                <?php else: ?>
                <?php $no = 1; while ($d = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td style="font-weight:600;"><?= htmlspecialchars($d['nama_pelanggan']) ?></td>
                    <td style="font-size:.85rem;color:var(--text-muted);">
                        <?= htmlspecialchars($d['nama_produk'] ?? '—') ?>
                    </td>
                    <td>
                        <div class="stars-display">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="<?= $i <= $d['rating'] ? '' : 'star-empty' ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <div style="font-size:.72rem;color:var(--text-muted);margin-top:2px;">
                            <?= $d['rating'] ?>/5
                        </div>
                    </td>
                    <td>
                        <div class="review-text">
                            "<?= htmlspecialchars(mb_strimwidth($d['review'], 0, 100, '…')) ?>"
                        </div>
                    </td>
                    <td>
                        <?php if ($d['status'] === 'tampil'): ?>
                            <span class="badge-status-tampil"><i class="fas fa-check me-1"></i>Tampil</span>
                        <?php else: ?>
                            <span class="badge-status-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:.78rem;color:var(--text-muted);">
                        <?= date('d M Y', strtotime($d['created_at'])) ?><br>
                        <span style="font-size:.72rem;"><?= date('H:i', strtotime($d['created_at'])) ?></span>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            <?php if ($d['status'] === 'pending'): ?>
                            <a href="review_aksi.php?aksi=tampil&id=<?= $d['id_review'] ?>&filter=<?= $filter ?>"
                               class="btn-approve">
                                <i class="fas fa-check"></i> Tampilkan
                            </a>
                            <?php else: ?>
                            <a href="review_aksi.php?aksi=pending&id=<?= $d['id_review'] ?>&filter=<?= $filter ?>"
                               class="btn-unpublish">
                                <i class="fas fa-eye-slash"></i> Sembunyikan
                            </a>
                            <?php endif; ?>

                            <a href="review_aksi.php?aksi=hapus&id=<?= $d['id_review'] ?>&filter=<?= $filter ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Yakin ingin menghapus review ini?')"
                               style="font-size:.78rem;padding:5px 12px;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
        </div>

    </div><!-- /card-body -->
</div><!-- /card -->

<?php include 'footer.php'; ?>
