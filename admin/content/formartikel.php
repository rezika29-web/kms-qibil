
  <!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

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
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Artikel</h6>
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
        $(document).ready(function () {
            $('#summernote').summernote({
                height: 300,
                callbacks: {
                    onImageUpload: function (files) {
                        uploadImage(files[0]);
                    },
                    onMediaDelete: function ($target) {
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
                    success: function (url) {
                        console.log('====================================');
                        console.log("targetFilePath ", url);
                        console.log('====================================');
                        $('#summernote').summernote('insertImage', url);
                    },
                    error: function () {
                        alert('Upload image gagal.');
                    }
                });
            }

            function deleteImage(imageUrl) {
                $.ajax({
                    url: 'content/summernote/delete_image.php',
                    type: 'POST',
                    data: { imageUrl: imageUrl },
                    success: function (response) {
                        console.log('Gambar berhasil dihapus:', response);
                    },
                    error: function () {
                        alert('Gagal menghapus gambar.');
                    }
                });
            }

            $('#submitBtn').click(function () {
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
  
                $.post("http://localhost:1337/api/korans", reqBody, function(result){
                    alert("success add data")
                    window.location.href = "http://127.0.0.1/Project/kms-fitri/admin/artikel.php";
                }).fail(function (xhr, status, error) {
                    alert("gagal save data")
                }); 
            });
            
        });
    </script>

    
<script>
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
</script>