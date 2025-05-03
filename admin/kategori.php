<?php
include 'template/header.php';
include 'content/kategori.php';
include 'template/footer.php';
?>

<script>
    $(document).ready(function() {
        // Request data dari server
        $.ajax({
            url: 'http://localhost:1337/api/kategoris?populate=*', // URL API Anda
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Ambil data kategori
                let resData = response.data;

                console.log(resData); // Debug data untuk memastikan respons

                // Bersihkan daftar sebelumnya
                $('#kategoriList').empty();

                // Looping data dan tambahkan ke elemen HTML
                $.each(resData, function(index, item) {
                    // Tambahkan data ke tabel
                    $('#kategoriList').append(
                    `<tr>
                        <td style="width: 50px; text-align: center;">${index + 1}</td>
                        <td style="text-align: center;">${item.Kategori}</td>
                    </tr>`
                    );
                });
            },
            error: function(error) {
                alert('Gagal memuat data!');
                console.error(error);
            }
        });
    });
</script>