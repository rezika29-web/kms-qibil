<?php
if (isset($_GET['id'])) {
    $artikelId = $_GET['id'];
    // Gunakan $artikelId untuk melakukan query atau mengirim request ke API
} else {
    echo "ID artikel tidak ditemukan!";
}
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
         <nav class="navbar navbar-expand navbar-light text-center topbar mb-4 static-top shadow">

            
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['username']; ?></span>
                        <img class="img-profile rounded-circle"
                            src="img/undraw_profile.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="profile.php">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3" style=" display:flex; align-items: center; justify-content: space-between;">
                    <h6 class="m-0 font-weight-bold text-primary">Add / Edit Artikel</h6>
                </div>
                <div style=" margin: 20px;" id="formContent">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" placeholder="Judul Artikel...">
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Isi</label>
                        <textarea class="form-control" id="summernote" rows="3"></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="kategori">Kategori</label>
                        <select class="form-control" id="kategori">
                        </select>
                    </div>
                    <button type="submit" id="submitBtn">Save</button>

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <script>
        const artikelId = <?= json_encode($artikelId); ?>;

        // Ambil data artikel berdasarkan ID
        $.ajax({
            url: `http://localhost:1337/api/korans/${artikelId}?populate=*`,
            method: 'GET',
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token'),
            },
            success: function(response) {
                const artikel = response.data;
                console.log(artikel);


                // Isi form dengan data artikel
                $('#judul').val(artikel.judul);
                $('#summernote').summernote('code', artikel.isi);
                // $('#kategori').val(artikel.kategori.documentId);
                const kategoriId = artikel.kategori.documentId;

                // Load kategori dan pilih kategori sesuai ID
                loadKategori(kategoriId);
            },
            error: function(error) {
                alert('Gagal mengambil data artikel!');
                console.error(error);
            },
        });

        function loadKategori(selectedId) {
            $.ajax({
                url: 'http://localhost:1337/api/kategoris/', // Ganti dengan URL server Anda
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let resData = data.data;
                    console.log("kategori", resData);

                    $('#kategori').html(
                        `<option value="">Pilih kategori...</option>`
                    );
                    $.each(resData, function(index, dt) {
                        const isSelected = dt.documentId === selectedId ? 'selected' : '';
                        $('#kategori').append(
                            `<option value="${dt.documentId}" ${isSelected}>${dt.Kategori}</option>`
                        );
                    });
                },
                error: function(error) {
                    alert('Gagal memuat data kategori!');
                    console.error(error);
                }
            });
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                callbacks: {
                    onImageUpload: function(files) {
                        uploadImage(files[0]);
                    },
                    onMediaDelete: function($target) {
                        deleteImage($target[0].src);
                    }
                }
            });

            function uploadImage(file) {
                let formData = new FormData();
                formData.append("image", file);

                $.ajax({
                    url: 'content/summernote/upload_image.php', // PHP file untuk upload
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        console.log('====================================');
                        console.log("targetFilePath ", url);
                        console.log('====================================');
                        $('#summernote').summernote('insertImage', url);
                    },
                    error: function() {
                        alert('Upload image gagal.');
                    }
                });
            }

            function deleteImage(imageUrl) {
                $.ajax({
                    url: 'content/summernote/delete_image.php',
                    type: 'POST',
                    data: {
                        imageUrl: imageUrl
                    },
                    success: function(response) {
                        console.log('Gambar berhasil dihapus:', response);
                    },
                    error: function() {
                        alert('Gagal menghapus gambar.');
                    }
                });
            }

            $('#submitBtn').click(function() {
                var summernote = $('#summernote').val();
                var judul = $('#judul').val();
                var kategori = $('#kategori').val();
                var idUser = <?= $_SESSION['user_id']; ?>;
                let reqBody = {
                    "data": {
                        "judul": judul,
                        "isi": summernote,
                        "kategori": kategori,
                        "users_permissions_user": idUser
                    }
                }
                if (artikelId) {
                    // PUT request untuk update artikel
                    $.ajax({
                        url: `http://localhost:1337/api/korans/${artikelId}`,
                        method: 'PUT',
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token'),
                            'Content-Type': 'application/json',
                        },
                        data: JSON.stringify(reqBody),
                        success: function(result) {
                            alert("Data berhasil diperbarui!");
                            window.location.href = "http://127.0.0.1/Project/qibil/kms-qibil/admin/artikel.php";
                        },
                        error: function(xhr, status, error) {
                            alert("Gagal memperbarui data!");
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    alert("Artikel ID tidak ditemukan, tidak dapat memperbarui data!");
                }
            });

        });
    </script>

        $(document).ready(function() {
            function getQueryParam(param) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            // Request data dari server
            $.ajax({
                url: 'http://localhost:1337/api/kategoris/', // Ganti dengan URL server Anda
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let resData = data.data;
                    $('#kategori').append(
                        `<option value="">select kategori...</option>`
                    );
                    $.each(resData, function(index, dt) {
                        // Looping data dan tambahkan ke elemen HTML
                        $('#kategori').append(
                            `<option value="` + dt.id + `">` + dt.Kategori + `</option>`
                        );
                    })
                },
                error: function(error) {
                    alert('Gagal memuat data!');
                    console.error(error);
                }
            });
        });
    </script> -->