<?php
// Menghubungkan file konfigurasi database
include 'config.php';

// Memulai sesi PHP
session_start();

// Mendapatkan ID pengguna dari sesi
$adminId = $_SESSION["admin_id"];

// Menangani form untuk menambahkan Produk baru
if (isset($_POST['simpan'])) {
    // Mendapatkan data dari form
    $postProduk = $_POST["post_produk"]; // Nama produk
    $harga = $_POST["harga"]; // Harga Produk
    $stok = $_POST["stok"]; // Stok Produk
    $deskripsi = $_POST["deskripsi"]; // Konten postingan
    $kategoriId = $_POST["kategori_id"]; // ID kategori

    // Mengatur direktori penyimpanan file gambar
    $imageDir = "assets/img/uploads/";
    $imageName = $_FILES["image"]["name"]; // Nama file gambar
    $imagePath = $imageDir . basename($imageName); // Path lengkap gambar

    // Memindahkan file gambar yang di unggah ke direktori tujuan
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {

        // Jika unggahan berhasil, masukkan data postingan produk ke dalam database
        $query = "INSERT INTO produk (namaProduk, 
        harga, stok, image, kategori_id, admin_id) VALUES
        ('$postProduk', '$harga', '$stok', '$deskripsi', NOW(), $kategoriId, $adminId, '$imagePath')";

        if ($conn->query($query) === TRUE) {
            // Notifikasi berhasil jika postingan produk berhasil ditambahkan
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'post successfully added.'
            ];
        } else {
            // Notifikasi error jika gagal menambahkan postingan
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Error adding post: '. $conn->error
            ];
        }
    } else {
        // Notifikasi error jika unggahan gambar gagal
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Failed to upload image.'
        ];
    }

    // Arahkan ke halaman dashboard setelah selesai
    header('Location: dashboard.php');
    exit();
}

// Proses penghapusan postingan
if (isset($_POST['delete'])) {
    // Mengambil ID produk dari parameter URL
    $produkID = $_POST['produkID'];

    // Query untuk menghapus produk berdasarkan ID
    $exec = mysqli_query($conn, "DELETE FROM produk WHERE produk_id='$produkID'");

    // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
    if ($exec) { 
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Post successfully deleted.'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' =>'danger',
            'message' => 'Error deleting post: ' . mysqli_error($conn)
        ];
    }

    // Redirect kembali ke halaman dashboard
    header('Location: dashboard.php');
    exit();
}

// Menangani pembaruan data produk
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Mendapatkan data dari form
    $produkId = $_POST['produk_id'];
    $postProduk = $_POST["post_produk"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];
    $deskripsi = $_POST["deskripsi"]; // Konten postingan
    $kategoriId = $_POST["kategori_id"];
    $imageDir = "assets/img/uploads/"; // Direktori penyimpanan gambar

    // Periksa apakah file gambar baru diunggah
    if (!empty($_FILES["image_path"]["name"])) {
    $imageName = $_FILES["image"]["name"];
    $imagePath = $imageDir . $imageName;

    // Pindahkan file baru ke direktori tujuan
    move_uploaded_file($_FILES["image_path"]["tmp_name"], $imagePath);

    // Hapus gambar lama
    $queryOldImage = "SELECT image FROM produk WHERE produk_id = $produkId";
    $resultOldImage = $conn->query($queryOldImage);
    if ($resultOldImage->num_rows > 0) {
        $oldImage = $resultOldImage->fetch_assoc()['image'];
        if (file_exists($oldImage)) {
            unlink($oldImage); // Menghapus file lama
        }
    }
} else {
    // Jika tidak ada file baru, gunakan gambar lama
    $imagePathQuery = "SELECT image FROM produk WHERE produk_id = $produkId";
    $result = $conn->query($imagePathQuery);
    $imagePath = ($result->num_rows > 0) ? $result->fetch_assoc() ['image'] : null;
}

// Update data postingan di database
$queryUpdate = "UPDATE produk SET namaProduk = '$postProduk',
harga = '$harga', stok = '$stok', deskripsi = '$deskripsi', kategori_id = $kategoriId,
image = '$imagePath' WHERE produk_id = $produkId";

if ($conn->query($queryUpdate) === TRUE) {
    // Notifikasi berhasil
    $_SESSION['notification'] = [
        'type' => 'primary',
        'message' => 'Postingan berhasil diperbarui.'
    ];
} else {
    // Notifikasi gagal
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Gagal memperbarui postingan.'
    ];
}

// Arahkan ke halaman dashboard
header('Location: dashboard.php');
exit();
}