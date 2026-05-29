<?php
// ============================================================
//  HALAMAN PEMBAYARAN XENDIT (QRIS / Transfer Bank)
//  Menggantikan bayar_midtrans.php di folder pelanggan
// ============================================================

session_name('PELANGGAN_SESSION');
session_start();

include '../koneksi.php';
include '../xendit_config.php';

$invoice_url = $_SESSION['xendit_invoice_url'] ?? '';
$invoice     = $_SESSION['xendit_invoice']     ?? '';
$total       = $_SESSION['xendit_total']       ?? 0;
$metode      = $_SESSION['xendit_metode']      ?? '';

if (empty($invoice_url) || empty($invoice)) {
    header('Location: index.php');
    exit;
}

// Hapus session setelah dipakai (single-use)
unset(
    $_SESSION['xendit_invoice_url'],
    $_SESSION['xendit_invoice'],
    $_SESSION['xendit_total'],
    $_SESSION['xendit_metode']
);

// Xendit pakai redirect — langsung arahkan ke halaman invoice Xendit
// Pelanggan bayar di sana, lalu Xendit redirect balik ke success_redirect_url
header('Location: ' . $invoice_url);
exit;
