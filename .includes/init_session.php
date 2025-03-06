<?php
session_start();
// Ambil data dari sesi (cek apakah admin atau pelanggan)
$role = $_SESSION["role"] ?? null;
$name = $_SESSION["name"] ?? $_SESSION["nama"] ?? null;
$userId = $_SESSION["admin_id"] ?? $_SESSION["pelanggan_id"] ?? null;
$email = $_SESSION["email"] ?? null; // Hanya untuk pelanggan

// Ambil notifikasi jika ada, kemudian hapus dari sesi
$notification = $_SESSION['notification'] ?? null;
if ($notification) {
    unset($_SESSION['notification']);
}
/* Periksa apakah sesi username dan role sudah ada,
jika tidak arahkan ke halaman login */
if (empty($_SESSION["username"]) || empty($_SESSION["role"])) {
$_SESSION['notification'] = [
    'type' => 'danger',
    'message' => 'Silahkan Login Terlebih Dahulu!'
];
header('Location: ./auth/login.php');
exit(); // Pastikan script berhenti setelah pengalihan
}