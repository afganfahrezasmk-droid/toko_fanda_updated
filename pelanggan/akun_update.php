<?php

include '../koneksi.php';

/** @var mysqli $koneksi */

/* =========================
   AMBIL DATA
========================= */

$user_id  = $_POST['user_id'] ?? '';
$username = $_POST['username'] ?? '';
$nama     = $_POST['nama'] ?? '';
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

/* =========================
   VALIDASI
========================= */

if (empty($user_id)) {

    die("User ID tidak ditemukan!");

}

/* =========================
   UPDATE DENGAN PASSWORD
========================= */

if (!empty($password)) {

    $password = md5($password);

    $query = mysqli_query(
        $koneksi,

        "UPDATE user SET

        username = '$username',
        password = '$password',
        nama = '$nama',
        email = '$email'

        WHERE user_id = '$user_id'"
    );

} else {

    /* =========================
       UPDATE TANPA PASSWORD
    ========================= */

    $query = mysqli_query(
        $koneksi,

        "UPDATE user SET

        username = '$username',
        nama = '$nama',
        email = '$email'

        WHERE user_id = '$user_id'"
    );
}

/* =========================
   CEK QUERY
========================= */

if ($query) {

    echo "

    <script>

        alert('Data berhasil diubah');

        window.location.href='akun.php';

    </script>

    ";

} else {

    echo "

    <script>

        alert('Data gagal diubah');

        window.history.back();

    </script>

    ";

}
?>