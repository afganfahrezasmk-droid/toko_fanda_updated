<?php

session_name('KASIR_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

session_destroy();

header("location:../index.php?pesan=logout");
?>