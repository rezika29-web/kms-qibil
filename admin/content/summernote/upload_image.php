<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']['name'])) {
        $targetDir = "../../../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . time() . "_" . $fileName;

        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($fileType), $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $backPath = "http://127.0.0.1/Project/qibil/kms-qibil/uploads/" . time() . "_" . $fileName;

                echo $backPath; // Mengembalikan URL gambar
            } else {
                http_response_code(500);
                echo "Gagal mengunggah gambar.";
            }
        } else {
            http_response_code(400);
            echo "Format file tidak didukung.";
        }
    } else {
        http_response_code(400);
        echo "Tidak ada file yang diunggah.";
    }
}
