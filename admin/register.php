<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .card {
            max-width: 500px;
            margin: auto;
            border-radius: 12px;
        }

        .img-fluid {
            max-height: 200px;
            object-fit: contain;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-5 text-center">
                <!-- Gambar di atas -->
                <img src="../images/about-us.jpg" class="img-fluid mb-4" style="max-width: 200px; height: auto;" />

                <!-- Judul -->
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                <p id="registerMessage"></p>

                <!-- Form -->
                <div class="text-left" id="registerForm">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-user" id="username" placeholder="Fullname">
                        </div>
                        <div class="col-sm-6">
                            <input type="email" class="form-control form-control-user" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user" id="password" placeholder="Password">
                    </div>
                    <button id="registerButton" class="btn btn-primary btn-user btn-block">Register Account</button>
                </div>

                <hr />
                <div class="text-center">
                    <a class="small" href="login.php">Already have an account? Login!</a>
                </div>
            </div>

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
                $('#registerButton').click(function() {
                    var username = $('#username').val();
                    var email = $('#email').val();
                    var password = $('#password').val();
                    let reqBody = {
                        "username": username,
                        "email": email,
                        "password": password
                    }
                    $.post("http://localhost:1337/api/auth/local/register", reqBody, function(result) {
                        $('#registerMessage').text("success register");
                        setTimeout(() => {
                            window.location.href = "http://127.0.0.1/Project/qibil/kms-qibil/admin/";
                        }, 2000);
                    }).fail(function(xhr, status, error) {
                        // Callback gagal
                        $('#registerMessage').text("Gagal Register");

                    });
                });

            });
        </script>
</body>

</html>