<?php

session_start();
include 'koneksi.php';

/** @var mysqli $koneksi */

// =========================
// AMBIL DATA FORM
// =========================

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$nama     = trim($_POST['nama'] ?? '');
$email    = trim($_POST['email'] ?? '');

// =========================
// VALIDASI INPUT
// =========================

if(
    empty($username) ||
    empty($password) ||
    empty($nama) ||
    empty($email)
){

    header("location:signup.php?error=Semua data wajib diisi!");
    exit;
}

// =========================
// CEK USERNAME SUDAH ADA
// =========================

$cekUsername = mysqli_query($koneksi,
    "SELECT * FROM user
     WHERE username='$username'"
);

if(mysqli_num_rows($cekUsername) > 0){

    header("location:signup.php?error=Username sudah digunakan!");
    exit;
}

// =========================
// CEK EMAIL SUDAH ADA
// =========================

$cekEmail = mysqli_query($koneksi,
    "SELECT * FROM user
     WHERE email='$email'"
);

if(mysqli_num_rows($cekEmail) > 0){

    header("location:signup.php?error=Email sudah digunakan!");
    exit;
}

// =========================
// ENKRIPSI PASSWORD
// =========================

$password = md5($password);

// =========================
// SIMPAN USER
// =========================

$query = mysqli_query($koneksi,
    "INSERT INTO user
    (username, password, nama, email, role)

    VALUES

    ('$username', '$password', '$nama', '$email', 'pelanggan')"
);

// =========================
// CEK BERHASIL
// =========================

if($query){

    // ambil data user terbaru
    $user = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT * FROM user
         WHERE username='$username'"
    ));

    // session login otomatis
    $_SESSION['user_id']  = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama']     = $user['nama'];
    $_SESSION['role']     = $user['role'];

    header("location:pelanggan/login.php");
    exit;

}else{

    header("location:signup.php?error=Gagal membuat akun!");
    exit;
}
?>