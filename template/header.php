
<?php
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);
if($path == '/Project/kms-fitri/'){
  $beranda = 'active';
  $artikel = '';
}else{
  $beranda = '';
  $artikel = 'active';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>Kms Fitri</title>

    <!-- Menyertakan Marked.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/marked@4.0.12/lib/marked.min.js"></script>
    <!-- Menyertakan jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="One page parallax responsive HTML Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Bingo HTML Template v1.0">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

  <!-- CSS
  ================================================== -->
  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="plugins/themefisher-font/style.css">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <!-- Lightbox.min css -->
  <link rel="stylesheet" href="plugins/lightbox2/css/lightbox.min.css">
  <!-- animation css -->
  <link rel="stylesheet" href="plugins/animate/animate.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">

</head>
<body id="body">

  <!--
  Start Preloader
  ==================================== -->
  <div id="preloader">
    <div class='preloader'>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <!--
  End Preloader
  ==================================== -->

<!--
Fixed Navigation
==================================== -->
<header class="navigation fixed-top">
  <div class="container">
    <!-- main nav -->
    <nav class="navbar navbar-expand-lg navbar-light px-0">
      <!-- logo -->
      <a class="navbar-brand logo" href="http://127.0.0.1/Project/kms-fitri/">
        <!-- <img loading="lazy" class="logo-default" src="images/logo.png" alt="logo" />
        <img loading="lazy" class="logo-white" src="images/logo-white.png" alt="logo" /> -->
        <h1 style="color: white; font-weight: bold;">KMS Fitri</h1>
      </a>
      <!-- /logo -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navigation">
        <ul class="navbar-nav ml-auto text-center">
          <li class="nav-item ">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#addModal" style="margin-left: 10px;">
              search          
            </a>
          </li>
          <!-- <li class="nav-item" id="kategoriListSide">
          </li>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown" id="kategoriList">
          </ul> -->
          <li class="nav-item <?= $beranda; ?>">
            <a class="nav-link" href="http://127.0.0.1/Project/kms-fitri/" >Beranda</a>
            </li>
              <li class="nav-item dropdown  <?= $artikel; ?>">
                <a class="nav-link dropdown-toggle" href="#!" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Artikel <i class="tf-ion-chevron-down"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown" id="kategoriList">
                </ul>
              </li>
              <li class="nav-item ">
            <a class="nav-link" href="http://127.0.0.1/Project/kms-fitri/admin/artikel.php" >Login</a>
            </li>
        </ul>
      </div>
    </nav>
    <!-- /main nav -->
  </div>
</header>
<!--
End Fixed Navigation
==================================== -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Search Artikel</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
              </button>
          </div>
            <div class="modal-body">
              <div class="widget-search widget">
                <form action="#">
                  <input type="text" id="searchArtikel" class="form-control shadow-none" placeholder="Cari judul artikel...">
                </form>
                <div class="widget-categories widget">
                  <ul class="widget-categories-list" id="artikelListSearch">
                    </ul>
                  </div>   
                </div>
          </div>
          <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal" aria-label="Close">Close</button>
          </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#searchArtikel').on('keyup', function () {
            var searchValue = $(this).val().toLowerCase(); // Ambil nilai input dan ubah ke lowercase
            $('#artikelListSearch li').filter(function () {
                // Periksa apakah teks cocok dengan input
                $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
            });
        });
    });
</script>


<script>
  $(document).ready(function() {
        // Request data dari server
        $.ajax({
            url: 'http://localhost:1337/api/korans', // Ganti dengan URL server Anda
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let resData = data.data;
                // Bersihkan daftar pengguna sebelumnya
                $('#artikelList').empty();
                $('#artikelListSearch').empty();

                // Looping data dan tambahkan ke elemen HTML
                $.each(resData, function(index, dt) {
                    $('#artikelList').append('<li><a class="dropdown-item" href="article.php?id='+ dt.documentId + '">'+ dt.judul + '</a>' +'</li>');
                    $('#artikelListSearch').append('<li><a href="article.php?id='+ dt.documentId + '">'+ dt.judul + '</a>' +'</li>');
                });
            },
            error: function(error) {
                alert('Gagal memuat data!');
                console.error(error);
            }
        });
});
</script>