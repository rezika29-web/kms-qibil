<?php
include 'template/header.php';
include 'Form/profileForm.php'; 
include 'template/footer.php';
?>

<script>
    $(document).ready(function() {
        // Request data dari server
        $.ajax({
            url: 'http://localhost:1337/api/users/me', // URL API Anda
            method: 'GET',
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token'),
            },
            dataType: 'json',
            success: function(response) {
                // Ambil data kategori
                let resData = response;

                console.log("data", response); // Debug data untuk memastikan respons

                // Bersihkan daftar sebelumnya
                $('#userForm').empty();

                // Looping data dan tambahkan ke elemen HTML
                $('#userForm').append(
                    `<input type="text" class="form-control form-control-user" id="username" value="${response.username}">`
                );
            },
            error: function(error) {
                alert('Gagal memuat data!');
                console.error(error);
            }
        });
    });
</script>