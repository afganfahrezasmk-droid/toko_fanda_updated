<?php

include '../koneksi.php';

/** @var mysqli $koneksi */

$username = $_POST['username'];
$password = md5($_POST['password']);
$nama     = $_POST['nama'];
$email    = $_POST['email'];
$role     = $_POST['role'];

/* =========================
   SIMPAN USER
========================= */

mysqli_query($koneksi,
    "INSERT INTO user
    (username, password, nama, email, role)

    VALUES

    ('$username', '$password', '$nama', '$email', '$role')"
);

header("location:user.php");

?>