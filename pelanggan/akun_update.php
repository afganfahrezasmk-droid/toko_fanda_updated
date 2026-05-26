<?php
include 'header.php';
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
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Berhasil</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f6f1ea;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:Arial;
}

.success-box{
    background:white;
    padding:45px;
    border-radius:28px;
    text-align:center;
    max-width:450px;
    width:100%;
    box-shadow:0 10px 35px rgba(0,0,0,.08);
}

.icon{
    width:95px;
    height:95px;
    margin:auto;
    border-radius:50%;
    background:#eafaf0;
    color:#27ae60;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:2.8rem;
    margin-bottom:24px;
}

h2{
    font-weight:700;
    margin-bottom:12px;
}

p{
    color:#777;
    margin-bottom:30px;
}

.btn-modern{
    background:#c5975c;
    color:white;
    border:none;
    border-radius:14px;
    padding:14px 24px;
    font-weight:600;
    text-decoration:none;
    display:inline-block;
}

</style>

</head>
<body>

<div class="success-box">

    <div class="icon">
        ✓
    </div>

    <h2>Data Berhasil Diubah</h2>

    <p>
        Informasi akun kamu berhasil diperbarui
    </p>

    <a href="akun.php"
       class="btn-modern">

        Kembali ke Akun

    </a>

</div>

</body>
</html>

<?php

} else {

    echo "

    <script>

        alert('Data gagal diubah');

        window.history.back();

    </script>

    ";

}