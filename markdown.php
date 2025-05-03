<?php
    $action = $_POST['action'] ?? '';

    $isi = $_POST['isi'] ?? '';

    // Teks Markdown yang ingin dikonversi
    $markdownText = $isi;

    // Mengganti # dengan <h1> untuk heading
    $htmlText = preg_replace("/^# (.*)$/m", "<h1>$1</h1>", $markdownText);
    $htmlText = preg_replace("/^## (.*)$/m", "<h2>$1</h2>", $htmlText);
    
    if ($action === 'article') {
        $htmlText = preg_replace('/style="[^"]*"/', 'width=100%; height=auto;', $htmlText);
        $htmlText = preg_replace("/!\[(.*?)\]\((.*?)\)/", "<img src=\"$2\" alt=\"$1\" width=100%; height=auto;>", $htmlText);
    }else{
        $htmlText = preg_replace('/style="[^"]*"/', 'width=300; height=200;', $htmlText);
        // Mengganti ![alt](url) dengan <img> untuk gambar
        $htmlText = preg_replace("/!\[(.*?)\]\((.*?)\)/", "<img src=\"$2\" alt=\"$1\" width=300; height=200; >", $htmlText);
    }

    // Mengganti \n dengan <p> untuk paragraf
    $htmlText = preg_replace("/\n\n/", "</p><p>", $htmlText);

    // Menambahkan tag <p> di awal danx akhir
    $htmlText = "<p>" . $htmlText . "</p>";

    echo json_encode(['success' => true, 'message' => $htmlText]);
?>