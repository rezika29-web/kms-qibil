<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageUrl = $_POST['imageUrl'];

    // Path file di server
    $filePath = str_replace('http://127.0.0.1/Project/qibil/kms-qibil/', '../../../', $imageUrl); // Sesuaikan domain Anda
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "Gambar berhasil dihapus.";
        } else {
            http_response_code(500);
            echo "Gagal menghapus gambar.";
        }
    } else {
        http_response_code(404);
        echo "File tidak ditemukan.";
    }
}
