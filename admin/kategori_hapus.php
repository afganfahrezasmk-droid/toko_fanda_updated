<?php
include 'header.php';
include '../koneksi.php';

/** @var mysqli $koneksi */

$id = $_GET['id'];

mysqli_query($koneksi,
    "DELETE FROM kategori
     WHERE kategori_id = '$id'");

echo "
<script>

    alert('Kategori berhasil dihapus');

    window.location.href='kategori.php';

</script>
";

?>