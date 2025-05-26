<?php
include 'template/header.php';
?>

<style>
    /* Loader */
    #loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color:rgb(177, 176, 187);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: transform 3s ease, opacity 3s ease;
    }

    .slide-load {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 100vh;
    }

    /* .slide-load div {
        width: 300px;
        height: 300px;
        z-index: 9999; */
        /* border: 2px solid rgb(96 139 168);
        border-radius: 5px;
        background-color: rgb(96 139 168 / 0.2); */
    /* } */


    @keyframes blink {
        50% {
            opacity: 0;
        }
    }

    /* Animasi setelah loader selesai */
    .loader-hidden {
        transform: translateY(-100%);
        opacity: 0;
    }
</style>

<!-- Loader -->
<div id="loader">
    <div class="slide-load">
        <div>
            <img src="test.gif" width="200" height="200"></img>
        </div>
    <!-- <div class="box"></div> -->
    </div>

</div>

<!-- Konten -->
<div class="content" style="display: none;">
    <?php include 'content/contentlistarticle.php'; ?>
</div>

<?php
include 'template/footer.php';
?>

<script>
    // Tampilkan loader selama 3 detik dan animasikan ke atas
    window.addEventListener("load", function() {
        setTimeout(function() {
            const loader = document.getElementById("loader");
            loader.classList.add("loader-hidden"); // Tambahkan kelas animasi
            setTimeout(function() {
                loader.style.display = "none"; // Sembunyikan loader setelah animasi selesai
                document.querySelector(".content").style.display = "block"; // Tampilkan konten
            }, 800); // Durasi animasi sesuai CSS (0.8s)
        }, 3000); // Durasi loader: 3000 ms
    });
</script>


<script>          
    function formatTanggal(dateString) {
        // Ubah string ISO menjadi objek Date
        const date = new Date(dateString);

        // Daftar nama bulan dalam Bahasa Indonesia
        const bulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        // Ambil bagian-bagian tanggal
        const tahun = date.getFullYear();
        const bulanNama = bulan[date.getMonth()]; // Bulan dimulai dari 0
        const hari = date.getDate();

        // Format ke Desember 31, 2024
        return `${bulanNama} ${hari}, ${tahun}`;
    }         

    $(document).ready(function() {
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Ambil parameter ID
        const id = getQueryParam('id');
        // Request data dari server
        $.ajax({
            url: 'http://localhost:1337/api/korans?populate=*&filters[kategori][documentId][$eq]=' + id, // Ganti dengan URL server Anda
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let resData = data.data;
                // Bersihkan daftar pengguna sebelumnya
                $('#articleList').empty();

                // Looping data dan tambahkan ke elemen HTML
                $.each(resData, function(index, dt) {
                    var maxLength = 150;
                    var originalText = "";
                    // Potong string jika lebih panjang dari maxLength
                    if (dt.isi.length > maxLength) {
                        originalText = dt.isi.substring(0, maxLength) + '...'; // Menambahkan ellipsis "..." di akhir
                    }else{
                        originalText = dt.isi
                    }

                    $.post('markdown.php', {
                        isi: originalText
                    }, function (response) {
                        var data = JSON.parse(response);

                        const isoDate = dt.createdAt;
                        const formattedDate = formatTanggal(isoDate);
                        $('#articleList').append(
                            `<article class="col-lg-4 col-md-6">
                                <div class="post-item">
                                    <div class="content">
                                        <h3><a href="article.php?id=`+ dt.documentId + `">`+ dt.judul + `</a></h3>
                                        <p style="font-size: 13px;">`+dt.users_permissions_user.username+` / `+formattedDate+`</p>
                                        <p>`+ data.message + `</p>
                                        <a class="btn btn-main" href="article.php?id=`+ dt.documentId + `">Read more</a>
                                    </div>
                                </div>
                            </article>`
                        );
                    });
                });
            },
            error: function(error) {
                alert('Gagal memuat data!');
                console.error(error);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
            function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Ambil parameter ID
    const id = getQueryParam('id');
        // Request data dari server
        $.ajax({
            url: 'http://localhost:1337/api/kategoris/' + id, // Ganti dengan URL server Anda
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let resData = data.data;
                // Bersihkan daftar pengguna sebelumnya
                $('#judulKategori').empty();

                // Looping data dan tambahkan ke elemen HTML
                    
                    $('#judulKategori').append(
                        `<li class="breadcrumb-item"><a href="index.html" class="text-white">Article</a></li>
					<li class="breadcrumb-item active" aria-current="page" >` + resData.Kategori + `</li>`
                    );
            },
            error: function(error) {
                alert('Gagal memuat data!');
                console.error(error);
            }
        });
    });
</script>