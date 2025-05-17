
<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Anda sudah login";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        <p id="loginMessage"></p>
                                    </div>
                                     <!-- Form Login -->
                                    <div id="loginForm">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" placeholder="Password" required>
                                        </div>
                                        <button id="loginButton" class="btn btn-primary btn-user btn-block">Login</button>
                                        </div>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
        $(document).ready(function () {
            // Login
            localStorage.removeItem("token");

            $('#loginButton').click(function () {
                var email = $('#email').val();
                var password = $('#password').val();
                let reqBody = {
                    "identifier": email,
                    "password": password
                }
  
                $.post("http://localhost:1337/api/auth/local", reqBody, function(result){
                    $.post('auth.php', {
                        action: 'login',
                        user_id: result.user.id,
                        documentId:result.user.documentId,
                        username: result.user.username
                    }, function (response) {
                        var data = JSON.parse(response);
                        $('#loginMessage').text(data.message);
                        localStorage.setItem("token", result.jwt);
                        localStorage.setItem("user_id", result.user.id);
                        localStorage.setItem("username", result.user.username);
                        localStorage.setItem("documentId", result.user.documentId);

                        setTimeout(() => {
                            window.location.href = "http://127.0.0.1/Project/qibil/kms-qibil/admin/artikel.php";
                        }, 2000);
                    });
                }).fail(function (xhr, status, error) {
                    // Callback gagal
                    $('#loginMessage').text("Gagal Login");
                    
                }); 
            });

        });
    </script>
</body>

</html>