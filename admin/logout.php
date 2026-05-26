<?php

session_name('ADMIN_SESSION');
session_start();

$current = basename($_SERVER['PHP_SELF']);

session_destroy();

header("location:../index.php?pesan=logout");
?>