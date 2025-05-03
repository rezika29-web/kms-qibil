<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

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

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ubah Profil</h1>

                <p id="profilMessage"></p>
            </div>

            <!-- Content Row -->

            <div class="row">
                <div class="col-xl-12 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="user">
                                    <div class="form-group">

                                        <div class="col-sm-6 mb-3 mb-sm-0" id="userForm">

                                        </div>
                                        <div class="col-sm-6"><br>
                                            <!-- <button id="profileButton" class="btn btn-primary btn-user btn-block">Ubah Data</button> -->
                                            <button id="profileButton" class="btn btn-primary btn-user btn-block">Ubah Data</button>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
        </div>
        <!-- /.container-fluid -->

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#profileButton').click(function() {
                console.log("afbjkanfk");

                // Ambil nilai dari input
                var username = $('#username').val();

                // Validasi input (opsional)
                if (!username) {
                    $('#profileMessage').text("Username tidak boleh kosong.");
                    return;
                }

                // Buat body request
                let reqBody = {
                    username: username
                };

                // Kirim PUT request ke server
                $.ajax({
                    url: 'http://localhost:1337/api/users/' + <?= $_SESSION['user_id']; ?>, // URL API Anda
                    method: "PUT",
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("token"),
                        "Content-Type": "application/json"
                    },
                    data: JSON.stringify(reqBody),
                    success: function(result) {
                        // Tampilkan pesan sukses
                        $('#profileMessage').text("Berhasil mengubah data.");

                        // Redirect setelah beberapa detik
                        setTimeout(() => {
                            window.location.href = "http://127.0.0.1/Project/kms-fitri/admin/profile.php";
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan gagal
                        $('#profileMessage').text("Gagal mengubah data.");
                        console.error("Error:", error);
                    }
                });
            });
        });
    </script>

    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website 2021</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->