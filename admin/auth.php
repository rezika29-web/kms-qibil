<?php
session_start();

$action = $_POST['action'] ?? '';

if ($action === 'login') {
    $_SESSION['user_id'] = $_POST['user_id'];
    $_SESSION['documentId'] = $_POST['documentId'];
    $_SESSION['username'] = $_POST['username'];
    echo json_encode(['success' => true, 'message' => 'Login berhasil!']);
    exit();
}

