
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Anda harus login dulu.']);
    exit();
}else{
    echo json_encode(['success' => true, 'message' => 'success', "datas" => $_SESSION['user_id'] ]);
    exit();
}
?>