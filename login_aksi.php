<?php
session_start();

include 'koneksi.php';

$login = $_POST['login'];
$password = md5($_POST['password']);


$data = mysqli_query($koneksi,
    "SELECT * FROM user 
     WHERE (username='$login' OR email='$login')
     AND password='$password'"
);

$cek = mysqli_num_rows($data);

if($cek > 0){

    $d = mysqli_fetch_assoc($data);

    $_SESSION['user_id'] = $d['user_id'];
    $_SESSION['role'] = $d['role'];
    $_SESSION['username'] = $d['username'];
    
    switch($d['role']){

        case 'admin':
            header("location:admin/index.php");
            break;

        case 'kasir':
            header("location:kasir/index.php");
            break;

        case 'pelanggan':
            header("location:pelanggan/index.php");
            break;

        default:
            echo "Role tidak dikenali";
    }

}else{

    echo "Login gagal!";

}
?>