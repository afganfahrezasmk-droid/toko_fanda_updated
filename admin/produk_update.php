<?php

include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

/* =========================
   AMBIL DATA
========================= */

$produk_id   = $_POST['produk_id'];
$nama_produk = $_POST['nama_produk'];
$kategori_id = $_POST['kategori_id'];
$harga       = $_POST['harga'];
$stok        = $_POST['stok'];
$deskripsi   = $_POST['deskripsi'];

/* =========================
   CEK ADA GAMBAR BARU?
========================= */

$gambar = $_FILES['gambar']['name'];
$tmp    = $_FILES['gambar']['tmp_name'];

/* =========================
   JIKA GANTI GAMBAR
========================= */

if ($gambar != "") {

    move_uploaded_file($tmp, "../gambar/" . $gambar);

    mysqli_query($koneksi,
        "UPDATE produk SET

        nama_produk = '$nama_produk',
        kategori_id = '$kategori_id',
        harga = '$harga',
        stok = '$stok',
        deskripsi = '$deskripsi',
        gambar = '$gambar'

        WHERE produk_id = '$produk_id'"
    );

} else {

    /* =========================
       TANPA GANTI GAMBAR
    ========================= */

    mysqli_query($koneksi,
        "UPDATE produk SET

        nama_produk = '$nama_produk',
        kategori_id = '$kategori_id',
        harga = '$harga',
        stok = '$stok',
        deskripsi = '$deskripsi'

        WHERE produk_id = '$produk_id'"
    );
}

/* =========================
   ALERT
========================= */

echo "
<script>

    alert('Data berhasil diubah');

    window.location.href='produk.php';

</script>
";

?>