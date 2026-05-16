<?php

include '../koneksi.php';

/** @var mysqli $koneksi */

/* =========================
   AMBIL DATA
========================= */

$kategori_id   = $_POST['kategori_id'];
$nama_kategori = $_POST['nama_kategori'];

/* =========================
   UPDATE DATA
========================= */

mysqli_query($koneksi,
    "UPDATE kategori SET

    nama_kategori = '$nama_kategori'

    WHERE kategori_id = '$kategori_id'"
);

/* =========================
   ALERT
========================= */

echo "
<script>

    alert('Kategori berhasil diupdate');

    window.location.href='kategori.php';

</script>
";

?>