<?php
include 'template/header.php';
include 'content/profile.php';
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
                $('#profileList').empty();

                // Looping data dan tambahkan ke elemen HTML
                $('#profileList').append(
                    `<tr>
                    <td style="width: 50px; text-align: center;">${response.username}</td>
                    <td style="text-align: center;">${response.email}</td>
                    <td style="text-align: center;">
                            <a href="profiledit.php" class="btn btn-warning btn-sm">Edit</a>
                            <a href="profilechange.php" class="btn btn-danger btn-sm">Ubah Password</a>
                    </td>
                </tr>`
                );
            },
            error: function(error) {
                alert('Gagal memuat data!');
                console.error(error);
            }
        });
    });
</script>