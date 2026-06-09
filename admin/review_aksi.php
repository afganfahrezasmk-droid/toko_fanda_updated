<?php
include '../koneksi.php';
/** @var mysqli $koneksi */

session_name('ADMIN_SESSION');
session_start();

// Cek login admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php?pesan=bukan_admin");
    exit;
}

/* ===============================
   AMBIL PARAMETER
================================ */

$aksi   = isset($_GET['aksi'])   ? $_GET['aksi']   : '';
$id     = isset($_GET['id'])     ? (int)$_GET['id'] : 0;
$filter = isset($_GET['filter']) ? $_GET['filter']  : 'semua';

if (!$id) {
    header("Location: review.php?filter=$filter");
    exit;
}

/* ===============================
   PROSES AKSI
================================ */

if ($aksi === 'tampil') {

    /* ── Ubah status menjadi tampil ── */
    mysqli_query($koneksi, "
        UPDATE review
        SET status = 'tampil'
        WHERE id_review = '$id'
    ");
    header("Location: review.php?filter=$filter&aksi=tampil");
    exit;

} elseif ($aksi === 'pending') {

    /* ── Ubah status menjadi pending (sembunyikan) ── */
    mysqli_query($koneksi, "
        UPDATE review
        SET status = 'pending'
        WHERE id_review = '$id'
    ");
    header("Location: review.php?filter=$filter&aksi=pending");
    exit;

} elseif ($aksi === 'hapus') {

    /* ── Hapus review permanen ── */
    mysqli_query($koneksi, "
        DELETE FROM review
        WHERE id_review = '$id'
    ");
    header("Location: review.php?filter=$filter&aksi=hapus");
    exit;

} else {

    /* ── Aksi tidak dikenal ── */
    header("Location: review.php?filter=$filter");
    exit;
}
?>
