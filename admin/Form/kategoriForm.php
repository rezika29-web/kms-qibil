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
                <h1 class="h3 mb-0 text-gray-800">Tambah Kategori</h1>
                <p id="kategoriMessage"></p>
            </div>

            <!-- Content Row -->

            <div class="row">
                <div class="col-xl-12 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                            <div class="user" id="kategoriForm">
                                <div class="form-group row">

                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user"
                                            id="kategori" placeholder="kategori">
                                    </div>
                                    <div class="col-sm-6">
                                    <button id="kategoriButton" class="btn btn-primary btn-user btn-block">Tambah Kategori</button>

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
        $(document).ready(function () {
            $('#kategoriButton').click(function () {
                var kategori = $('#kategori').val();
                let reqBody = {
                    "data":{

                        "Kategori": kategori,
                    }
                }
                $.post("http://localhost:1337/api/kategoris", reqBody, function(result){
                    $('#kategoriMessage').text("success tambah kategori");
                    setTimeout(() => {
                        window.location.href = "http://127.0.0.1/Project/kms-fitri/admin/kategori.php";
                    }, 2000);
                }).fail(function (xhr, status, error) {
                    // Callback gagal
                    $('#kategoriMessage').text("Gagal tambah kategori");
                    
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