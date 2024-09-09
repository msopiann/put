<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    // Redirect to login page if not an admin
    header("Location: ../sign-in-admin.php");
    exit;
}

require_once __DIR__ . '/../../guard/product.php';

$id = $_GET['id'] ?? '';

// Periksa apakah ID valid
if (empty($id)) {
    // Tampilkan pesan kesalahan jika ID kosong
    echo "ID produk tidak valid.";
    exit;
}

// Fungsi hapus produk
if (deleteProduct($id)) {
    echo "Produk berhasil dihapus.";
} else {
    echo "Gagal menghapus produk.";
}

// Redirect kembali ke halaman produk setelah penghapusan
header('Location: ../products.php');
exit;