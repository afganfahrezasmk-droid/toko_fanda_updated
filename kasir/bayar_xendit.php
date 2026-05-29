<?php
// ============================================================
//  HALAMAN PEMBAYARAN XENDIT - KASIR
// ============================================================

session_name('KASIR_SESSION');
session_start();

include '../koneksi.php';
include '../xendit_config.php';

$invoice_url = $_SESSION['kasir_xendit_invoice_url'] ?? '';
$invoice     = $_SESSION['kasir_xendit_invoice']     ?? '';
$total       = $_SESSION['kasir_xendit_total']       ?? 0;
$metode      = $_SESSION['kasir_xendit_metode']      ?? '';

if (empty($invoice_url) || empty($invoice)) {
    header('Location: index.php');
    exit;
}

// Hapus session setelah dipakai
unset(
    $_SESSION['kasir_xendit_invoice_url'],
    $_SESSION['kasir_xendit_invoice'],
    $_SESSION['kasir_xendit_total'],
    $_SESSION['kasir_xendit_metode']
);

// Redirect ke halaman pembayaran Xendit
header('Location: ' . $invoice_url);
exit;
