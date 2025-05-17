<?php
session_start();
session_destroy();
header("Location: http://127.0.0.1/Project/qibil/kms-qibil");
exit();
?>