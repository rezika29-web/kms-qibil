<?php
include 'template/header.php';
include 'content/artikel.php';
include 'template/footer.php';
?>

<script>
    $(document).ready(function() {
        // Request data dari server
        $.ajax({
            url: 'http://localhost:1337/api/korans?populate=*&filters[users_permissions_user][id][$eq]=' + <?= $_SESSION['user_id']; ?>, // URL API Anda
            method: 'GET',
            dataType: 'json',
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token'), // Tambahkan Bearer Token
            },
            success: function(response) {
                // Ambil data kategori
                let resData = response.data;

                console.log(resData); // Debug data untuk memastikan respons

                // Bersihkan daftar sebelumnya
                $('#artikelList').empty();

                // Looping data dan tambahkan ke elemen HTML
                $.each(resData, function(index, item) {
                    // Tambahkan data ke tabel
                    $('#artikelList').append(
                        `<tr>
                        <td style="width: 50px; text-align: center;">${index + 1}</td>
                        <td style="text-align: center;">${item.judul}</td>
                        <td style="text-align: center;">${item.kategori.Kategori}</td>
                        <td style="text-align: center;">${item.Like}</td>
                        <td style="text-align: center;">
                            <a href="artikeledit.php?id=${item.documentId}" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="${item.documentId}">Hapus</button>

                        </td>
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
<script>
    $(document).on('click', '.btn-delete', function () {
  const artikelId = $(this).data('id');
  

  if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
    $.ajax({
      url: `http://localhost:1337/api/korans/${artikelId}`,
      method: 'DELETE',
      headers: {
        Authorization: 'Bearer ' + localStorage.getItem('token'),
      },
      success: function (data, textStatus, jqXHR) {
          // Cek status HTTP untuk memastikan respons berhasil
          if (jqXHR.status === 200 || jqXHR.status === 204) {
            alert('Artikel berhasil dihapus!');
            location.reload(); // Refresh halaman setelah hapus
          } else {
            alert('Proses berhasil tetapi respons tidak terduga.');
          }
        location.reload(); // Refresh halaman setelah hapus
      },
      error: function (error) {
        console.error(error);
        alert('Gagal menghapus artikel!');
      },
    });
  }
});
</script>