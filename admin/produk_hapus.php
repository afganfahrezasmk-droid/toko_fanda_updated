<?php
include '../koneksi.php';

/** @var mysqli $koneksi */

$id = $_GET['id'];

mysqli_query($koneksi,
    "DELETE FROM produk
     WHERE produk_id = '$id'");

echo "
<script>

    alert('Produk berhasil dihapus');

    window.location.href='produk.php';

</script>
";

?>