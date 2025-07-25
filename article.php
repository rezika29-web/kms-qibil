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

    .contentBaru {
        transition: filter 1s ease-in;
        /* transform: translateX(-100%); */
        /* transition: transform 1s ease-out, opacity 1s ease-out; */
        filter: blur(10px) opacity(0); /* Awal: blur dan opacity 0 */
    }

    .visible {
        /* transform: translateX(0); */
        filter: blur(0) opacity(1); /* Akhir: jelas dan opacity penuh */
    }

    .sideContent {
        /* transition: filter 3s ease; */
        transform: translateX(100%);
        transition: transform 2s ease-out, opacity 2s ease-out;
        filter: opacity(0); /* Awal: blur dan opacity 0 */
    }

    .visibleSide {
        transform: translateX(0);
        filter: opacity(1); /* Akhir: jelas dan opacity penuh */
    }

    .komentar-container {
        /* max-width: 600px; */
        margin: auto;
    }
    .judul {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
    }
    .komentar {
        background: #fff;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 4px solid #ccc;
        box-shadow: 0 0 4px rgba(0,0,0,0.05);
    }
    .foto {
        float: left;
        /* margin-right: 15px; */
        width: 50px;
        height: 50px;
    }
    /* .foto img {
        border-radius: 50%;
        width: 50px;
        height: 50px;
    } */
    .nama {
        font-weight: bold;
    }
    .tanggal {
        font-size: 12px;
        color: #999;
        margin-bottom: 10px;
    }
    .isi {
        clear: both;
        margin-top: 10px;
    }
    .jawab {
        float: right;
        background: #f5f5f5;
        border: 1px solid #ccc;
        padding: 3px 10px;
        font-size: 12px;
        margin-top: -30px;
        cursor: pointer;
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
    <?php include 'content/contentarticle.php'; ?>
</div>

<div class="modal fade" id="addModalKomentar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Komentar</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <textarea name="message" id="message" class="form-control" placeholder="Isi Komentar" required></textarea>
        </div>
        <div class="modal-footer">
          <button id="btnKirim" class="btn btn-success">Simpan</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addModalReply" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Jawab Komentar</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <textarea name="messagereply" id="messagereply" class="form-control" placeholder="Isi Komentar" required></textarea>
        </div>
        <div class="modal-footer">
          <button id="btnKirimReply" class="btn btn-success">Simpan</button>
        </div>
    </div>
  </div>
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
    let user_id = localStorage.getItem('user_id');
    let idKoran = getQueryParam('id');

    function btnKirimReplyUser(id){
        localStorage.setItem("IdKomentarUser", id);
    };

    $('#btnKirim').on('click', function() {
        $('#addModalKomentar').modal('hide');
        $.post('middleware/cekauth.php', {}, function (response) {
            var data = JSON.parse(response);
            if(data.success == false){
                alert("silahkan login terlebih dahulu..")
                var win = window.open('http://127.0.0.1/Project/qibil/kms-qibil/admin/', '_blank');
                if (win) {
                    //Browser has allowed it to be opened
                    win.focus();
                } else {
                    //Browser has blocked it
                    alert('Please allow popups for this website');
                }
            }else{
                var message = $('#message').val();
                let reqBody = {
                    "data": {
                        "korans": idKoran,
                        "users_permissions_user": user_id,
                        "message": message
                    }
                }

                $.post("http://localhost:1337/api/komentars", reqBody, async function(result){
                    location.reload();
                }).fail(function (xhr, status, error) {
                    // Callback gagal
                    alert("error")
                    console.log('====================================');
                    console.log("errro ", error);
                    console.log('====================================');                    
                }); 
            }
        });
    }); 

    $('#btnKirimReply').on('click', function() {
        let IdKomentarUser = localStorage.getItem('IdKomentarUser');
        $.post('middleware/cekauth.php', {}, function (response) {
            var data = JSON.parse(response);
            if(data.success == false){
                alert("silahkan login terlebih dahulu..")
                var win = window.open('http://127.0.0.1/Project/qibil/kms-qibil/admin/', '_blank');
                if (win) {
                    //Browser has allowed it to be opened
                    win.focus();
                } else {
                    //Browser has blocked it
                    alert('Please allow popups for this website');
                }
            }else{
                let messagereply = $('#messagereply').val();
                let reqBody = {
                    "data": {
                        "komentars": IdKomentarUser,
                        "users_permissions_users": user_id,
                        "message": messagereply
                    }
                }
                $.post("http://localhost:1337/api/replis", reqBody, async function(result){
                    location.reload();
                }).fail(function (xhr, status, error) {
                    // Callback gagal
                    alert("error")
                    console.log('====================================');
                    console.log("errro ", error);
                    console.log('====================================');                    
                });
            }
        });
    }); 

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

    let msgId;
    let resDataArt;
    let dateArt;
    function lovefunc(id){
        $.ajax({
        url: 'http://localhost:1337/api/lovers?populate=*&filters[koran][documentId][$eq]='+ id,
        method: 'GET',
        dataType: 'json',
        success: async function (resDatas) {
            let lovesData = resDatas.data;
            let getIdLoves; 

            const isoDate = resDataArt.createdAt;
            const formattedDate = formatTanggal(isoDate);
            $.each(lovesData, await function(index, dtl) {
                docloversss = dtl.documentId;
                if(dtl.users_permissions_user.id == user_id){
                    getIdLoves = `<img src="heart2.svg" width=20 height=20 style="margin-left:5px;" onclick="lovers(1, ` + resDataArt.id +`, `+ dtl.id +`)"/>`
                }else{
                    getIdLoves = `<img src="heart1.svg" width=20 height=20 style="margin-left:5px;" onclick="lovers(0, ` + resDataArt.id +`)"/>`
                }   
            });

            if(lovesData.length == 0){
                getIdLoves = `<img src="heart1.svg" width=20 height=20 style="margin-left:5px;" onclick="lovers(0, ` + resDataArt.id +`)"/>`
            }

            $('#contenArticle').append(
            ` <article class="post">
                <div class="post-content">
                    <h3> `+ resDataArt.judul +`</h3>
                    <ul class="list-inline">
                    <li class="list-inline-item">
                        `+ resDataArt.users_permissions_user.username +` / `+formattedDate+ 
                        getIdLoves + ` `+ lovesData.length +` Likes
                    </li>
                    </ul>
                    <div class="contentBaru" id="targetElement">` + msgId + `</div>
                    <div class="card">
                        <div class="card-body">
                            <div class="btn btn-success" data-toggle="modal" data-target="#addModalKomentar" >Tambah Komentar</div>                                                
                        </div>
                    </div>
                </div>
                </article>`
            );
        },
        error: function(error) {
            let lovesData = resDatas.data;
            // Looping data dan tambahkan ke elemen HTML
            $('#contenArticle').append(
            ` <article class="post">
                    <div class="post-content">
                        <h3> `+ resDataArt.judul +`</h3>
                        <ul class="list-inline">
                        <li class="list-inline-item">
                            `+ resDataArt.users_permissions_user.username +` / `+formattedDate+`
                            <img src="heart1.svg" width=20 height=20 style="margin-left:5px;" onclick="lovers(0, ` + resDataArt.id +`)"/>
                            <img src="heart2.svg" width=20 height=20 style="margin-left:5px;" onclick="lovers(1 ` + resDataArt.id +`)"/>
                        </li>
                        </ul>
                        <div class="contentBaru" id="targetElement">` + msgId + `</div>
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="btn btn-success" data-toggle="modal" data-target="#addModalKomentar" >Tambah Komentar</div>                                                
                            </div>
                        </div>

                    </div>
                </article>`
            );
        }
    });
    }
    let docloversss;
    function lovers(int, idArt, idloves=0) {
        const id = getQueryParam('id');
        $('#contenArticle').empty();

        $.post('middleware/cekauth.php', {}, function (response) {
            var data = JSON.parse(response);
            if(data.success == false){
                alert("silahkan login terlebih dahulu..")
                var win = window.open('http://127.0.0.1/Project/qibil/kms-qibil/admin/', '_blank');
                if (win) {
                    //Browser has allowed it to be opened
                    win.focus();
                } else {
                    //Browser has blocked it
                    alert('Please allow popups for this website');
                }
            }else{
                let dt = new Date();
                let reqBody = {
                    "data": {
                        "koran": idArt,
                        "users_permissions_user": data.datas
                    }
                }
                
                if(int == 0){
                    $.post("http://localhost:1337/api/lovers", reqBody, async function(result){
                        lovefunc(id)
                        // location.reload();
                    }).fail(function (xhr, status, error) {
                        // Callback gagal
                        console.log('====================================');
                        console.log("errro ", error);
                        console.log('====================================');                    
                    }); 
                }else {
                    $.ajax({
                        url: 'http://localhost:1337/api/lovers/' + docloversss,
                        type: 'DELETE',
                        success: async function(result) {
                            // location.reload();
                            lovefunc(id)
                        },
                        error: async function(result) {
                            lovefunc(id)
                        }
                    }); 
                }
            }
        });
    }

    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    $(document).ready(function() {                                     
        // Ambil parameter ID
        const id = getQueryParam('id');
        // Request data dari server

        $.ajax({
            url: 'http://localhost:1337/api/korans?populate=*&filters[documentId][$eq]=' + id, // Ganti dengan URL server Anda
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let resData = data.data[0];
                // Bersihkan daftar pengguna sebelumnya
                $('#contenArticle').empty();
                $('#totalKomentar').empty();
                $('#komenArticle').empty();
                $('#replyArticle').empty();
                $('#listKomentar').empty();
                resDataArt = resData;
                const isoDate = resData.createdAt;
                const formattedDate = formatTanggal(isoDate);
                $.post('markdown.php', {
                        action: 'article',
                        isi: resData.isi
                    }, function (response) {
                        var data = JSON.parse(response);
                        
                        $.ajax({
                            url: 'http://localhost:1337/api/lovers?populate=*&filters[koran][documentId][$eq]='+ id,
                            method: 'GET',
                            dataType: 'json',
                            success: async function (resDatas) {
                                let lovesData = resDatas.data;
                                let getIdLoves; 

                                msgId = data.message;
                                $.each(lovesData, await function(index, dtl) {
                                    docloversss = dtl.documentId;
                                    if(dtl.users_permissions_user.id == user_id){
                                        // getIdLoves = `<img src="heart2.svg" width=20 height=20 style="margin-left:10px;" onclick="lovers(1 ` + resData.id +`)"/>`;
                                        getIdLoves = `<img src="heart2.svg" width=20 height=20 style="margin-left:5px;" onclick="lovers(1, ` + resData.id +`, `+ dtl.id +`)"/>`
                                    }else{
                                        getIdLoves = `<img src="heart1.svg" width=20 height=20 style="margin-left:5px;" onclick="lovers(0, ` + resData.id +`)"/>`
                                    }   
                                });

                                if(lovesData.length == 0){
                                    getIdLoves = `<img src="heart1.svg" width=20 height=20 style="margin-left:5px;" onclick="lovers(0, ` + resData.id +`)"/>`
                                }

                                // Ambil ID video dari link YouTube biasa
                                function convertYoutubeToEmbed(link) {
                                    try {
                                        const url = new URL(link);

                                        // Format pendek: https://youtu.be/VIDEO_ID
                                        if (url.hostname === "youtu.be") {
                                            return "https://www.youtube.com/embed/" + url.pathname.slice(1);
                                        }
                                        // Format biasa: https://www.youtube.com/watch?v=VIDEO_ID
                                        else if (url.hostname.includes("youtube.com")) {
                                            const videoId = url.searchParams.get("v");
                                            return "https://www.youtube.com/embed/" + videoId;
                                        }
                                    } catch (e) {
                                        return null;
                                    }
                                    return null;
                                }

                                const embedLink = convertYoutubeToEmbed(resData.link);

                                const iframeHTML = embedLink ? `
                                    <iframe width="560" height="315"
                                        src="${embedLink}"
                                        title="YouTube video player"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>` : '';

                                $('#contenArticle').append(
                                ` <article class="post">
                                            <div class="post-content">
                                                <h3> `+ resData.judul +`</h3>
                                                <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    `+ resData.users_permissions_user.username +` / `+formattedDate+ 
                                                    getIdLoves + ` `+ lovesData.length +` Likes
                                                </li>
                                                </ul>
                                                ${iframeHTML}
                                                <div class="contentBaru" id="targetElement">` + data.message + `</div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="btn btn-success" data-toggle="modal" data-target="#addModalKomentar" >Tambah Komentar</div>                                                
                                                    </div>
                                                </div>
                                            </div>
                                    </article>`
                                );
                                $('#judulArticle').append(resData.judul);
                                $('#breadcrumbArticle').append(`<li class="breadcrumb-item"><a href="index.html" class="text-white">Artikel</a></li>
                                <li class="breadcrumb-item active" aria-current="page" >`+ resData.judul +`</li>`); 

                                $.ajax({
                                    url: 'http://localhost:1337/api/komentars?populate=*&filters[korans][documentId][$eq]='+ id,
                                    method: 'GET',
                                    dataType: 'json',
                                    success: async function (resDatasKomentar) {
                                        // Looping data dan tambahkan ke elemen HTML
                                        var listresDatasKomentar = '';
                                        var listresDatasRepli = '';
                                        var allkomen = '';
                                        var totalKomen = resDatasKomentar.data.length;
                                        
                                        $('#totalKomentar').append(`<div class="judul" style="text-align: center; margin: auto;">${totalKomen} Komentar</div>`);
                                        for (let i = 0; i < resDatasKomentar.data.length; i++) {
                                            let isoDateKomen = resDatasKomentar.data[i].createdAt;
                                            let formattedDateKomen = formatTanggal(isoDateKomen); 
                                            $.ajax({
                                            url: 'http://localhost:1337/api/replis?populate=*&filters[komentars][documentId][$eq]='+ resDatasKomentar.data[i].documentId,
                                            method: 'GET',
                                            dataType: 'json',
                                            success: async function (resDatasRepli) {
                                                if(resDatasRepli.data.length != 0){
                                                    let replyKometUser = [];
                                                    for (let j = 0; j < resDatasRepli.data.length; j++) {
                                                        
                                                        if(resDatasRepli.data[j].komentars[0].documentId == resDatasKomentar.data[i].documentId){
                                                            let isoDateReply = resDatasRepli.data[j].createdAt;
                                                            let formattedDateReply = formatTanggal(isoDateReply);
                                                            replyKometUser.push(`<div class="komentar" style="margin-left: 50px;">
                                                                <div class="foto">
                                                                    <ion-icon name="person-circle" style="width: 30px; height: 30px;"></ion-icon>
                                                                </div>
                                                                <div class="nama"> `+ resDatasRepli.data[j].users_permissions_users[0].username +`</div>
                                                                <div class="tanggal">`+ formattedDateReply +`</div>
                                                                <div class="isi">`+ resDatasRepli.data[j].message +`</div>
                                                            </div>`);
                                                        }
                                                    }
                                                    $('#listKomentar').append(`<div class="komentar">
                                                                <div class="foto">
                                                                    <ion-icon name="person-circle" style="width: 30px; height: 30px;"></ion-icon>
                                                                </div>
                                                                <div class="nama"> `+ resDatasKomentar.data[i].users_permissions_user.username +`</div>
                                                                <div class="tanggal">`+ formattedDateKomen +`</div>
                                                                <div class="jawab" data-toggle="modal" data-target="#addModalReply" onclick=btnKirimReplyUser("`+resDatasKomentar.data[i].documentId+`") >JAWAB</div>                                                
                                                                <div class="isi">`+ resDatasKomentar.data[i].message +`</div>
                                                            </div>${replyKometUser}
                                                            `);
                                                }else{
                                                    $('#listKomentar').append(`<div class="komentar">
                                                        <div class="foto">
                                                            <ion-icon name="person-circle" style="width: 30px; height: 30px;"></ion-icon>
                                                        </div>
                                                        <div class="nama"> `+ resDatasKomentar.data[i].users_permissions_user.username +`</div>
                                                        <div class="tanggal">`+ formattedDateKomen +`</div>
                                                        <div class="jawab" data-toggle="modal" data-target="#addModalReply" onclick=btnKirimReplyUser("`+resDatasKomentar.data[i].documentId+`") >JAWAB</div>                                                
                                                        <div class="isi">`+ resDatasKomentar.data[i].message +`</div>
                                                    </div>`);
                                                }
                                            }
                                            });
                                        }
                                    }
                                });
                            },
                            error: function(error) {
                                let lovesData = resDatas.data;
                                // Looping data dan tambahkan ke elemen HTML
                                $('#contenArticle').append(
                                ` <article class="post">
                                            <div class="post-content">
                                                <h3> `+ resData.judul +`</h3>
                                                <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    `+ resData.users_permissions_user.username +` / `+formattedDate+`
                                                    <img src="heart1.svg" width=20 height=20 style="margin-left:5px;" onclick="lovers(0, ` + resData.id +`)"/>
                                                    <img src="heart2.svg" width=20 height=20 style="margin-left:5px;" onclick="lovers(1 ` + resData.id +`)"/>
                                                </li>
                                                </ul>
                                                <div class="contentBaru" id="targetElement">` + data.message + `</div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="btn btn-success" data-toggle="modal" data-target="#addModalKomentar" >Tambah Komentar</div>                                                
                                                    </div>
                                                </div>
                                            </div>
                                    </article>`
                                );
                                $('#judulArticle').append(resData.judul);
                                $('#breadcrumbArticle').append(`<li class="breadcrumb-item"><a href="index.html" class="text-white">Artikel</a></li>
                                <li class="breadcrumb-item active" aria-current="page" >`+ resData.judul +`</li>`); 
                            }
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
        $('#testcontent').empty();
        $("#clickme").click(function() {                                     
            $('#testcontent').append(`<p>Testing 123</p>`);
        })
    })
</script>

<script>
    // Menggunakan JavaScript untuk mendeteksi posisi scroll
    window.addEventListener('scroll', function () {
        const target = document.getElementById('targetElement');
        const rect = target.getBoundingClientRect();

        // Cek jika elemen terlihat di viewport
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            target.classList.add('visible'); // Tambahkan class untuk efek
        } else {
            target.classList.remove('visible'); // Kembalikan ke blur
        }

        const targetside = document.getElementById('targetElementSideContent');
        const rectSide = targetside.getBoundingClientRect();

        // Cek jika elemen terlihat di viewport
        if (rectSide.top < window.innerHeight && rectSide.bottom > 0) {
            targetside.classList.add('visibleSide'); // Tambahkan class untuk efek
        } else {
            targetside.classList.remove('visibleSide'); // Kembalikan ke blur
        }
    });
</script>

<script>
    $(document).ready(function () {
        $('#searchInput').on('keyup', function () {
            var searchValue = $(this).val().toLowerCase(); // Ambil nilai input dan ubah ke lowercase
            $('#kategoriListSide li').filter(function () {
                // Periksa apakah teks cocok dengan input
                $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
            });
        });
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

        // Request data dari server
        $.ajax({
            url: 'http://localhost:1337/api/korans', // Ganti dengan URL server Anda
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let resData = data.data;
                // Bersihkan daftar pengguna sebelumnya
                $('#articleList').empty();

                // Looping data dan tambahkan ke elemen HTML
                $.each(resData, function(index, dt) {
                    if(index < 3){
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
                                `<li class="widget-post-list-item">
                                    <div class="widget-post-content">
                                    <a href="article.php?id=`+ dt.documentId +`">
                                        <h5>`+ dt.judul +`</h5>
                                    </a>
                                    <h6>` + formattedDate +`</h6>
                                    <p>`+ data.message + `</p>
                                    </div>
                                </li>`
                            );
                        });
                    }   
                });
            },
            error: function(error) {
                alert('Gagal memuat data!');
                console.error(error);
            }
        });
    });
</script>