<?php

include '../koneksi.php';

/** @var mysqli $koneksi */

/* =========================
   AMBIL DATA
========================= */

$nama_kategori = $_POST['nama_kategori'];

/* =========================
   INSERT DATA
========================= */

mysqli_query($koneksi,
    "INSERT INTO kategori
    (
        nama_kategori
    )

    VALUES
    (
        '$nama_kategori'
    )"
);

/* =========================
   REDIRECT
========================= */

header("Location: kategori.php");

?>