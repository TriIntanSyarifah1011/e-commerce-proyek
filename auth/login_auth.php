<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"]; // Ambil role (admin/pelanggan)
    $password = $_POST["password"];

    if ($role == "admin") {
        $username = $_POST["username"];
        $sql = "SELECT * FROM admin WHERE username = ?";
    } else {
        $email = $_POST["email"];
        $sql = "SELECT * FROM pelanggan WHERE email = ?";
    }

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare($sql);
    if ($role == "admin") {
        $stmt->bind_param("s", $username);
    } else {
        $stmt->bind_param("s", $email);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $row["username"] ?? $row["email"];
            $_SESSION["name"] = $row["name"] ?? $row["nama"]; // Nama admin/pelanggan
            $_SESSION["role"] = $role;

            if ($role == "admin") {
                $_SESSION["user_id"] = $row["admin_id"]; // Ambil id admin jika role nya sebagai admin
            } else {
                $_SESSION["user_id"] = $row["pelanggan_id"]; // Ambil id admin jika rolenya sebagai pelanggan
            }
            // Set notifikasi selamat datang
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Selamat Datang Kembali!'
            ];

            // Redirect ke dashboard
            header('Location: ../dashboard.php');
            exit();
        } else {
            // Password salah
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Username atau Password salah'
            ];
        }
    } else {
        // Username/email tidak ditemukan
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Username atau Email tidak ditemukan'
        ];
    }

    // Redirect kembali ke halaman login jika gagal
    header('Location: login.php');
    exit();
}

$conn->close();
?>