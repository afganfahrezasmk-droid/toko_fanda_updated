<?php
/** @var mysqli $koneksi */

session_name('PELANGGAN_SESSION');
session_start();


/* ===============================
   AMBIL DATA FORM
================================ */

$user_id           = $_SESSION['user_id'];
$invoice           = $_POST['invoice'] ?? '';
$metode_pembayaran = $_POST['metode_pembayaran'] ?? '';

$produk_id = $_POST['produk_id'] ?? [];
$qty       = $_POST['qty'] ?? [];

$total = 0;

/* ===============================
   VALIDASI PRODUK
================================ */

$adaPesanan = false;

for($i = 0; $i < count($produk_id); $i++){

    $id_produk = intval($produk_id[$i]);
    $jumlah    = intval($qty[$i]);

    if($jumlah > 0){

        $adaPesanan = true;

        $q = mysqli_query(
            $koneksi,

            "SELECT harga, stok
             FROM produk
             WHERE produk_id='$id_produk'"
        );

        $p = mysqli_fetch_assoc($q);

        if(!$p){

            echo "
            <script>
                alert('Produk tidak ditemukan!');
                window.history.back();
            </script>
            ";

            exit;
        }

        /* ===============================
           CEK STOK
        ================================ */

        if($p['stok'] < $jumlah){

            echo "
            <script>
                alert('Stok produk tidak mencukupi!');
                window.history.back();
            </script>
            ";

            exit;
        }

        $subtotal = $p['harga'] * $jumlah;

        $total += $subtotal;
    }
}

/* ===============================
   CEK JIKA TIDAK ADA PESANAN
================================ */

if(!$adaPesanan){

    echo "
    <script>
        alert('Silakan pilih minimal 1 produk!');
        window.history.back();
    </script>
    ";

    exit;
}

/* ===============================
   HITUNG PAJAK
================================ */

$pajak = $total * 0.10;

/* ===============================
   SIMPAN ORDER
================================ */

$simpanOrder = mysqli_query(

    $koneksi,

    "INSERT INTO orders
    (
        invoice,
        user_id,
        total,
        pajak,
        metode_pembayaran,
        status
    )

    VALUES
    (
        '$invoice',
        '$user_id',
        '$total',
        '$pajak',
        '$metode_pembayaran',
        'pending'
    )"
);

if(!$simpanOrder){

    die("Gagal menyimpan order!");
}

/* ===============================
   AMBIL ID ORDER
================================ */

$orders_id = mysqli_insert_id($koneksi);

/* ===============================
   SIMPAN DETAIL ORDER
================================ */

for($i = 0; $i < count($produk_id); $i++){

    $id_produk = intval($produk_id[$i]);
    $jumlah    = intval($qty[$i]);

    if($jumlah > 0){

        $q = mysqli_query(
            $koneksi,

            "SELECT harga, stok
             FROM produk
             WHERE produk_id='$id_produk'"
        );

        $p = mysqli_fetch_assoc($q);

        $harga    = $p['harga'];
        $subtotal = $harga * $jumlah;

        /* ===============================
           INSERT ORDER ITEMS
        ================================ */

        mysqli_query(

            $koneksi,

            "INSERT INTO order_items
            (
                orders_id,
                produk_id,
                qty,
                harga,
                subtotal
            )

            VALUES
            (
                '$orders_id',
                '$id_produk',
                '$jumlah',
                '$harga',
                '$subtotal'
            )"
        );

        /* ===============================
           UPDATE STOK
        ================================ */

        mysqli_query(

            $koneksi,

            "UPDATE produk
             SET stok = stok - $jumlah
             WHERE produk_id = '$id_produk'"
        );
    }
}

/* ===============================
   HAPUS CART LOCAL STORAGE
================================ */

echo "
<script>

    alert('Pesanan berhasil dibuat!');

    window.location='akun.php';

</script>
";
?>