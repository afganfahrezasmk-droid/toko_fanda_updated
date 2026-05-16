<?php

include '../koneksi.php';

/** @var mysqli $koneksi */

$user_id = $_POST['user_id'];
$username = $_POST['username'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$role = $_POST['role'];

$password = $_POST['password'];

/* =========================
   UPDATE DENGAN PASSWORD
========================= */

if (!empty($password)) {

    $password = md5($password);

    mysqli_query($koneksi,
        "UPDATE user SET

        username = '$username',
        password = '$password',
        nama = '$nama',
        email = '$email',
        role = '$role'

        WHERE user_id = '$user_id'"
    );

} else {

    /* =========================
       UPDATE TANPA PASSWORD
    ========================= */

    mysqli_query($koneksi,
        "UPDATE user SET

        username = '$username',
        nama = '$nama',
        email = '$email',
        role = '$role'

        WHERE user_id = '$user_id'"
    );
}

echo "
<script>

    alert('Data berhasil diubah');

    window.location.href='user.php';

</script>
";

?>