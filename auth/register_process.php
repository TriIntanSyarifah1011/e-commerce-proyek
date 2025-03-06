<?php
require_once("../config.php");
// Mulai session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"]; // Ambil role (admin/pelanggan)
    $name = $_POST["name"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($role == "admin") {
        // Admin menggunakan username
        $username = $_POST["username"];
        $sql = "INSERT INTO admin (username, name, password) VALUES ('$username','$name','$hashedPassword')";
    } else {
        // Pelanggan menggunakan email dan alamat
        $email = $_POST["email"];
        $alamat = $_POST["alamat"];
        $sql = "INSERT INTO pelanggan (nama, email, password, alamat) VALUES ('$name','$email','$hashedPassword','$alamat')";
    }

    if ($conn->query($sql) === TRUE) {
        // Simpan notifikasi ke dalam session
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Registrasi Berhasil!' 
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal Registrasi: ' . mysqli_error($conn)
        ];
    }

    header('Location: login.php');
    exit();
}

$conn->close();
?>