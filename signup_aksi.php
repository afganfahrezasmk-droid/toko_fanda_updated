<?php

session_start();
include 'koneksi.php';

/** @var mysqli $koneksi */

$username = $_POST['username'];
$password = md5($_POST['password']);
$nama     = $_POST['nama'];
$email    = $_POST['email'];

/* =========================
   SIMPAN USER
========================= */

$query = mysqli_query($koneksi,
    "INSERT INTO user
    (username, password, nama, email, role)

    VALUES

    ('$username', '$password', '$nama', '$email')"
);

/* =========================
   CEK BERHASIL
========================= */

if($query){

    // simpan session login otomatis
    $_SESSION['username'] = $username;
    $_SESSION['nama']     = $nama;
    $_SESSION['status']   = "login";



    header("location:pelanggan/index.php");

}

?>