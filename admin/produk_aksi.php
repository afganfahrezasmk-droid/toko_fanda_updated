<?php

include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

/* =========================
   AMBIL DATA FORM
========================= */

$nama_produk = $_POST['nama_produk'];
$kategori_id = $_POST['kategori_id'];
$harga       = $_POST['harga'];
$stok        = $_POST['stok'];
$deskripsi   = $_POST['deskripsi'];

/* =========================
   UPLOAD GAMBAR
========================= */

$gambar = $_FILES['gambar']['name'];
$tmp    = $_FILES['gambar']['tmp_name'];

move_uploaded_file($tmp, "../gambar/" . $gambar);

/* =========================
   INSERT DATA
========================= */

mysqli_query($koneksi,
    "INSERT INTO produk
    (
        nama_produk,
        kategori_id,
        harga,
        stok,
        deskripsi,
        gambar
    )

    VALUES
    (
        '$nama_produk',
        '$kategori_id',
        '$harga',
        '$stok',
        '$deskripsi',
        '$gambar'
    )"
);

/* =========================
   REDIRECT
========================= */

header("Location: produk.php");

?>