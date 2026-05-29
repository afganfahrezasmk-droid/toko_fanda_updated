<?php
// ============================================================
//  KASIR - HALAMAN REDIRECT KE XENDIT
//  Menggantikan kasir/bayar_midtrans.php
// ============================================================

session_name('KASIR_SESSION');
session_start();

include '../koneksi.php';
include '../xendit_config.php';

$invoice_url = $_SESSION['kasir_xendit_invoice_url'] ?? '';
$invoice     = $_SESSION['kasir_xendit_invoice']     ?? '';

if (empty($invoice_url) || empty($invoice)) {
    header('Location: index.php');
    exit;
}

unset(
    $_SESSION['kasir_xendit_invoice_url'],
    $_SESSION['kasir_xendit_invoice'],
    $_SESSION['kasir_xendit_total'],
    $_SESSION['kasir_xendit_metode']
);

// Redirect ke halaman invoice Xendit
header('Location: ' . $invoice_url);
exit;
