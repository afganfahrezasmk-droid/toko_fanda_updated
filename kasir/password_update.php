<?php

session_name('ADMIN_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

include '../koneksi.php';

/** @var mysqli $koneksi */

// AMBIL USER LOGIN
$user_id = $_SESSION['user_id'];

// AMBIL PASSWORD BARU
$password_baru = $_POST['password_baru'];

// ENKRIPSI PASSWORD
$password = md5($password_baru);

// UPDATE PASSWORD
$query = mysqli_query($koneksi,"
    UPDATE user
    SET password='$password'
    WHERE user_id='$user_id'
");

// CEK BERHASIL
if($query){

    header("location:password.php?pesan=berhasil");

}else{

    header("location:password.php?pesan=gagal");
}
?>