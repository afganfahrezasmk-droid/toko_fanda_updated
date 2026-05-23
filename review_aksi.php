<?php

include 'koneksi.php';

$nama     = $_POST['nama_pelanggan'];
$idProduk = $_POST['id_produk'];
$review   = $_POST['review'];
$rating   = $_POST['rating'];

mysqli_query($koneksi, "INSERT INTO review
(
    nama_pelanggan,
    produk_id,
    review,
    rating,
    status
)

VALUES
(
    '$nama',
    '$idProduk',
    '$review',
    '$rating',
    'pending'
)
");

header("Location: index.php?review=success#tentang");
?>